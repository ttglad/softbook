<?php

namespace App\Console\Commands;

use App\Jobs\ProjectDataInit;
use App\Jobs\ProjectMenuDescInit;
use App\Models\Project\ProjectColumn;
use App\Models\Project\ProjectInfo;
use App\Models\Project\ProjectMenu;
use App\Services\Project\ProjectDictService;
use Faker\Factory;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;


class SoftbookProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'softbook:project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'softbook project tool';

    /**
     * @return mixed
     */
    public function handle()
    {
        $author = 'taoyulong';
        $file = resource_path('softbook/import-demo.csv');

        $handle = fopen($file, 'rb');

        while (($row = fgetcsv($handle)) !== false) {
            if (empty($row)) {
                continue;
            }
            $info = array_map(function ($value) {
                // 去除特殊字符和空格（可以根据需求进行修改）
//                $cleanedValue = preg_replace('/[^\p{L}\p{N}\s]/u', '', $value);
                return trim($value);
            }, $row);

            if ($info[1] == '项目简称') {
//                $this->info('首行跳过');
                continue;
            }

            $this->info('begin: ' . $info[0]);

            try {
                $project = $this->checkInfo($info, $author);
                $menu = $this->checkMenu($info);

                // 检验项目是否存在
                $projectExistModel = new ProjectInfo();
                $projectExistModel = $projectExistModel->where('project_title', $project->project_title);
                $projectExistModel = $projectExistModel->where('project_code', $project->project_code);
                // 判断作者
                if (!empty($project->project_author)) {
                    $projectExistModel = $projectExistModel->where('project_author', $project->project_author);
                }
                if ($projectExistModel->count() > 0) {
                    $this->info('project is exist!');
                    continue;
                }

//                $this->info(print_r($project->toArray(), true));
//                $this->info(print_r($menu, true));

                if ($project->save()) {
                    // 获取字段明细
                    $keys = [];
                    foreach ($menu as $itemMenu) {
                        foreach ($itemMenu['child'] as $item) {
                            if (!empty($item['name'])) {
                                $keys = array_merge($keys, [$item['name']]);
                            }
                            if (!empty($item['keys'])) {
                                $keys = array_merge($keys, $item['keys']);
                            }
                        }
                    }
//                    $this->info(print_r($keys, true));
                    $dictArr = ProjectDictService::getDictArray(array_unique($keys));

                    foreach ($menu as $itemMenu) {
                        // 防止为空则跳出
                        if (empty($itemMenu['name'])) {
                            continue;
                        }
                        // 父菜单创建
                        $menu = new ProjectMenu();
                        $menu->project_id = $project->project_id;
                        $menu->parent_id = 0;
                        $menu->menu_name = $itemMenu['name'];
                        $menu->menu_code = '';
                        $menu->order_num = $itemMenu['sort'];
                        $menu->visible = 0;
                        $menu->create_by = $author;
                        $menu->url = '#';
                        $menu->class = '';
                        $menu->menu_type = 'M';
                        if ($menu->save()) {
                            // 创建子菜单
                            foreach ($itemMenu['child'] as $item) {
                                $childMenu = new ProjectMenu();
                                $childMenu->project_id = $project->project_id;
                                $childMenu->parent_id = $menu->menu_id;
                                $childMenu->menu_name = $item['name'];
                                $childMenu->menu_code = isset($dictArr[$item['name']]) ? $dictArr[$item['name']]['dict_value'] : '';
                                $childMenu->order_num = $item['sort'];
                                $childMenu->visible = 0;
                                $childMenu->create_by = $author;
                                $childMenu->class = 'menuItemShot';
                                $childMenu->menu_type = 'C';

                                if ($childMenu->save()) {
                                    $childMenu->url = '/project/business/' . $childMenu->menu_id;
                                    $childMenu->save();

                                    // 新建菜单列
                                    foreach ($item['keys'] as $sort => $itemKey) {
                                        if (!isset($dictArr[$itemKey])) {
                                            $this->info('不存在该列' . $itemKey);
                                        }
                                        $dict = $dictArr[$itemKey];
                                        $projectColumn = new ProjectColumn();
                                        $projectColumn->project_id = $project->project_id;
                                        $projectColumn->menu_id = $childMenu->menu_id;
                                        $projectColumn->dict_id = $dict['dict_id'];
                                        $projectColumn->dict_name = $dict['dict_name'];
                                        $projectColumn->dict_value = $dict['dict_value'];
                                        $projectColumn->query_type = 'LIKE';
                                        $projectColumn->sort = $sort;
                                        $projectColumn->create_by = $author;
                                        $projectColumn->save();
                                    }
                                }
                            }
                        }
                    }
                }

                $message = 'success';

                // 加入队列
                ProjectDataInit::dispatch($project->project_id);
                ProjectMenuDescInit::dispatch($project->project_id);

            } catch (\Exception $e) {
                $message = $e->getMessage();
                $this->error($e->getMessage());
            }
            $this->info('end: ' . $message);
        }

        fclose($handle);
    }

    /**
     * @return void
     *
     */
    private function checkInfo($info, $author)
    {
        $skins = ['skin-blue', 'skin-green', 'skin-purple', 'skin-red', 'skin-yellow'];
        $themes = ['theme-dark', 'theme-light', 'theme-blue'];

        $model = new ProjectInfo();
        $model->project_title = $info[0];
        if (empty($model->project_title)) {
            throw new \Exception('项目名称不能为空', 1000);
        }
        $model->project_name = $info[1];
        if (empty($model->project_name)) {
            throw new \Exception('项目简称不能为空', 1000);
        }
        $model->project_sector = $info[3];
        if (empty($model->project_sector)) {
            throw new \Exception('项目行业不能为空', 1000);
        }
        $model->project_code = $info[2];
        if (empty($model->project_code)) {
            $code = ProjectDictService::getDictValue($model->project_sector);
            if (empty($code)) {
                throw new \Exception('项目编码获取失败', 1002);
            }
            $model->project_code = $code;
        }
        $model->project_author = $info[4];
        $model->project_version = $info[5] ?: 'V1.0';
        $model->project_category = $info[6] ?: '应用软件';
        $model->code_line = $info[7] ?: rand(61000, 69000);
        $model->status = 0;
        $model->menu_type = Arr::random([3, 4, 5]);
        $model->project_skin = Arr::random($skins);
        $model->project_theme = Arr::random($themes);
        if (in_array($info[8], $skins)) {
            $model->project_skin = $info[8];
        }
        if (in_array($info[9], $themes)) {
            $model->project_theme = $info[9];
        }
        $model->login_image = '/static/back/login-back00.jpg';
        $model->develop_purpose = $info[11];
        if (empty($model->develop_purpose)) {
            throw new \Exception('开发目的不能为空', 1000);
        }
        $model->project_feature = $info[12];
        if (empty($model->project_feature)) {
            throw new \Exception('主要功能不能为空', 1000);
        }
        $model->project_skill = $info[13];
        if (empty($model->project_skill)) {
            throw new \Exception('技术特点不能为空', 1000);
        }
        $model->remark = $info[14];
        $model->create_by = $author;

        // 新增管理员
        $faker = Factory::create('zh_CN');
        $model->project_admin = $faker->name;
        $model->project_admin_image = '/faces/' . rand(1, 21551) . '.png';


        return $model;
    }


    /**
     * 获取菜单
     * @param $info
     * @return array
     * @throws \Exception
     */
    private function checkMenu($info): array
    {
        $menu = [];
        // 一级菜单
        $menu_1 = $info[15];
        if (empty($menu_1)) {
            throw new \Exception('一级目录1不能为空', 1001);
        }
        $menu_1_1 = $info[16];
        if (empty($menu_1_1)) {
            throw new \Exception('二级目录1.1不能为空', 1001);
        }
        $menu_1_2 = $info[18];
        if (empty($menu_1_2)) {
            throw new \Exception('二级目录1.2不能为空', 1001);
        }
        $key_1_1 = $info[17] ? explode('|', $info[17]) : [];
        if (empty($key_1_1) || sizeof($key_1_1) < 5) {
            throw new \Exception('二级目录1.1字段为空或者数量小于5个', 1001);
        }
        $key_1_2 = $info[19] ? explode('|', $info[19]) : [];
        if (empty($key_1_2) || sizeof($key_1_2) < 5) {
            throw new \Exception('二级目录1.2字段为空或者数量小于5个', 1001);
        }
        $menu[] = [
            'name' => $menu_1,
            'sort' => 1,
            'child' => [
                [
                    'name' => $menu_1_1,
                    'sort' => 1,
                    'keys' => array_map('trim', $key_1_1),
                ],
                [
                    'name' => $menu_1_2,
                    'sort' => 2,
                    'keys' => array_map('trim', $key_1_2),
                ]
            ]
        ];

        $menu_2 = $info[20];
        if (empty($menu_2)) {
            throw new \Exception('一级目录2不能为空', 1001);
        }
        $menu_2_1 = $info[21];
        if (empty($menu_2_1)) {
            throw new \Exception('二级目录2.1不能为空', 1001);
        }
        $menu_2_2 = $info[23];
        if (empty($menu_2_2)) {
            throw new \Exception('二级目录2.2不能为空', 1001);
        }
        $key_2_1 = $info[22] ? explode('|', $info[22]) : [];
        if (empty($key_2_1) || sizeof($key_2_1) < 5) {
            throw new \Exception('二级目录2.1字段为空或者数量小于5个', 1001);
        }
        $key_2_2 = $info[24] ? explode('|', $info[24]) : [];
        if (empty($key_2_2) || sizeof($key_2_2) < 5) {
            throw new \Exception('二级目录2.2字段为空或者数量小于5个', 1001);
        }
        $menu[] = [
            'name' => $menu_2,
            'sort' => 2,
            'child' => [
                [
                    'name' => $menu_2_1,
                    'sort' => 1,
                    'keys' => array_map('trim', $key_2_1),
                ],
                [
                    'name' => $menu_2_2,
                    'sort' => 2,
                    'keys' => array_map('trim', $key_2_2),
                ]
            ]
        ];

        $menu_3 = $info[25];
        if (empty($menu_3)) {
            throw new \Exception('一级目录3不能为空', 1001);
        }
        $menu_3_1 = $info[26];
        if (empty($menu_3_1)) {
            throw new \Exception('二级目录3.1不能为空', 1001);
        }
        $menu_3_2 = $info[28];
        if (empty($menu_3_2)) {
            throw new \Exception('二级目录3.2不能为空', 1001);
        }
        $key_3_1 = $info[27] ? explode('|', $info[27]) : [];
        if (empty($key_3_1) || sizeof($key_3_1) < 5) {
            throw new \Exception('二级目录3.1字段为空或者数量小于5个', 1001);
        }
        $key_3_2 = $info[29] ? explode('|', $info[29]) : [];
        if (empty($key_3_2) || sizeof($key_3_2) < 5) {
            throw new \Exception('二级目录3.2字段为空或者数量小于5个', 1001);
        }
        $menu[] = [
            'name' => $menu_3,
            'sort' => 3,
            'child' => [
                [
                    'name' => $menu_3_1,
                    'sort' => 1,
                    'keys' => array_map('trim', $key_3_1),
                ],
                [
                    'name' => $menu_3_2,
                    'sort' => 2,
                    'keys' => array_map('trim', $key_3_2),
                ]
            ]
        ];

        if (isset($info[30])) {
            // 目录4
            $menu_4 = $info[30];
            $menu_4_1 = $info[31];
            if (!empty($menu_4) && empty($menu_4_1)) {
                throw new \Exception('二级目录4.1不能为空', 1001);
            }
            $menu_4_2 = $info[33];
            if (!empty($menu_4) && empty($menu_4_2)) {
                throw new \Exception('二级目录4.2不能为空', 1001);
            }
            $key_4_1 = $info[32] ? explode('|', $info[32]) : [];
            if (!empty($menu_4_1) && (empty($key_4_1) || sizeof($key_4_1) < 5)) {
                throw new \Exception('二级目录4.1字段为空或者数量小于5个', 1001);
            }
            $key_4_2 = $info[34] ? explode('|', $info[34]) : [];
            if (!empty($menu_4_2) && (empty($key_4_2) || sizeof($key_4_2) < 5)) {
                throw new \Exception('二级目录4.2字段为空或者数量小于5个', 1001);
            }
            $menu[] = [
                'name' => $menu_4,
                'sort' => 3,
                'child' => [
                    [
                        'name' => $menu_4_1,
                        'sort' => 1,
                        'keys' => array_map('trim', $key_4_1),
                    ],
                    [
                        'name' => $menu_4_2,
                        'sort' => 2,
                        'keys' => array_map('trim', $key_4_2),
                    ]
                ]
            ];
        }

        if (isset($info[35])) {
            // 目录5
            $menu_5 = isset($info[35]) ? $info[35] : '';
            $menu_5_1 = $info[36];
            if (!empty($menu_5) && empty($menu_5_1)) {
                throw new \Exception('二级目录5.1不能为空', 1001);
            }
            $menu_5_2 = $info[38];
            if (!empty($menu_5) && empty($menu_5_2)) {
                throw new \Exception('二级目录5.2不能为空', 1001);
            }
            $key_5_1 = $info[37] ? explode('|', $info[37]) : [];
            if (!empty($menu_5_1) && (empty($key_5_1) || sizeof($key_5_1) < 5)) {
                throw new \Exception('二级目录5.1字段为空或者数量小于5个', 1001);
            }
            $key_5_2 = $info[39] ? explode('|', $info[39]) : [];
            if (!empty($menu_5_2) && (empty($key_5_2) || sizeof($key_5_2) < 5)) {
                throw new \Exception('二级目录5.2字段为空或者数量小于5个', 1001);
            }
            $menu[] = [
                'name' => $menu_5,
                'sort' => 3,
                'child' => [
                    [
                        'name' => $menu_5_1,
                        'sort' => 1,
                        'keys' => array_map('trim', $key_5_1),
                    ],
                    [
                        'name' => $menu_5_2,
                        'sort' => 2,
                        'keys' => array_map('trim', $key_5_2),
                    ]
                ]
            ];

        }

        return $menu;
    }
}
