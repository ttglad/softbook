<?php

namespace App\Jobs;

use App\Models\Project\ProjectBusiness;
use App\Models\Project\ProjectColumn;
use App\Models\Project\ProjectInfo;
use App\Models\Project\ProjectMenu;
use App\Services\SysMenuService;
use Faker\Factory;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Arr;

class ProjectDataInit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    public $timeout = 60;
    public $projectId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $project = ProjectInfo::findOrFail($this->projectId);

            ProjectBusiness::where('project_id', $this->projectId)->delete();

            $menuService = new SysMenuService();
            $projectMenu = ProjectMenu::where('project_id', $project->project_id)
                ->where('visible', '0')
                ->orderBy('order_num')
                ->orderBy('menu_id')
                ->get()
                ->toArray();
            $menus = $menuService->getChildPerms($projectMenu, 0);

            foreach ($menus as $menu) {
                if (isset($menu['children']) && !empty($menu['children'])) {
                    foreach ($menu['children'] as $child) {
                        // 获取该菜单的列数
                        $businessColumnList = ProjectColumn::where('project_id', $project->project_id)
                            ->where('menu_id', $child['menu_id'])
                            ->orderBy('sort')
                            ->get();

                        // 生成初始化 10条 数据
                        for ($i = 0; $i < 10; $i++) {
                            $businessData = new ProjectBusiness();
                            $businessData->project_id = $project->project_id;
                            $businessData->menu_id = $child['menu_id'];
                            $businessData->create_by = 'softbook';
                            $columnNums = 0;
                            foreach ($businessColumnList as $column) {
                                if ($columnNums >= 10) {
                                    throw new \Exception('业务参数过多', 1002);
                                }
                                $columnNums++;
                                $key = 'column_' . $columnNums;
                                $value = 'value_' . $columnNums;
                                $businessData->$key = $column->dict_value;
                                $businessData->$value = $this->getFakerValue($column->dict_name);
                            }
                            $businessData->save();
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }
    }


    /**
     * @param $dictName
     * @return \DateTime|string
     */
    private function getFakerValue($dictName)
    {
        $faker = Factory::create('zh_CN');
        if (strpos($dictName, '时间') !== false) {
            $value = $faker->dateTime;
        } elseif (strpos($dictName, '性别') !== false) {
            $value = Arr::random(['男', '女']);
        } elseif (strpos($dictName, '年龄') !== false) {
            $value = $faker->randomNumber(2, true);
        } elseif (strpos($dictName, '编号') !== false || strpos(strtoupper($dictName), 'ID') !== false) {
            $value = $faker->randomNumber(5, true);
        } elseif (strpos($dictName, '参数值') !== false) {
            $value = $faker->randomFloat(2, 0, 100);
        } elseif (strpos($dictName, '状态') !== false) {
            $value = Arr::random(['成功', '失败']);
        } elseif (strpos($dictName, '日期') !== false) {
            $value = $faker->date('Y-m-d', 'now');
        } elseif (strpos($dictName, '用户名') !== false || strpos($dictName, '姓名') !== false || strpos($dictName, '人员') !== false) {
            $value = $faker->unique()->name;
        } elseif (strpos($dictName, '邮箱') !== false) {
            $value = $faker->email;
        } elseif (strpos($dictName, '公司名') !== false) {
            $value = $faker->company;
        } elseif (strpos($dictName, '职称') !== false || strpos($dictName, '岗位') !== false) {
            $value = $faker->jobTitle;
        } elseif (strpos($dictName, '手机号') !== false || strpos($dictName, '联系方式') !== false) {
            $value = $faker->phoneNumber;
        } elseif (strpos(strtoupper($dictName), 'IP') !== false) {
            $value = $faker->localIpv4;
        } elseif (strpos($dictName, '地址') !== false || strpos($dictName, '住址') !== false) {
            $value = $faker->address;
        } else {
            $value = $faker->text(rand(16, 32));
        }

        $maxLength = 64;
        if (is_string($value) && strlen($value) > $maxLength) {
            $value = mb_substr($value, 0, $maxLength);
        }
        return $value;
    }
}
