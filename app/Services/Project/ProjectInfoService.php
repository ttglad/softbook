<?php

namespace App\Services\Project;

use App\Models\Project\ProjectBusiness;
use App\Models\Project\ProjectColumn;
use App\Models\Project\ProjectInfo;
use App\Models\Project\ProjectMenu;
use App\Services\GeminiService;
use App\Services\SysMenuService;
use App\Services\XfyunService;
use Illuminate\Support\Facades\Log;

class ProjectInfoService extends ProjectService
{
    /**
     * 初始化菜单数据
     * @param $projectId
     * @return void
     * @throws \Exception
     */
    public function projectDataInit($projectId)
    {
        $project = ProjectInfo::findOrFail($projectId);

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
                    if ($child['data_type'] != 'list') {
                        continue;
                    }
                    // 判断是否生成数据
                    $count = ProjectBusiness::where('project_id', $projectId)
                        ->where('menu_id', $child['menu_id'])
                        ->count();
                    if ($count >= 2) {
                        continue;
                    }

                    // 获取该菜单的列数
                    $businessColumnList = ProjectColumn::where('project_id', $project->project_id)
                        ->where('menu_id', $child['menu_id'])
                        ->orderBy('sort')
                        ->get();
                    // ，该菜单下的字段有(`风险名称`,`风险类型`,`影响程度`,`风险状态`,`风险描述`)，请枚举出10条此菜单的测试数据
                    $questionDesc = '系统为`' . $project->project_title . '`,菜单为';
                    $questionDesc .= '`' . $child['menu_name'] . '`,';
                    $questionDesc .= '该菜单下的字段有(';
                    foreach ($businessColumnList as $column) {
                        $questionDesc .= '`' . $column->dict_name . '`,';
                    }
                    $questionDesc = substr($questionDesc, 0, -1);
                    $questionDesc .= '),请枚举出6条此菜单的测试数据,测试数据用|分隔,6条数据分6行展示,去除数据前的序号,去除菜单的字段名.';
                    $answer = $this->getMenuRemark($questionDesc);
                    Log::info('answer' . $answer);
                    $answerArray = explode("\n", $answer);
                    Log::info('answer arr' . print_r($answerArray, true));
                    if (!empty($answerArray)) {
                        foreach ($answerArray as $itemNum => $item) {
                            // 默认丢弃第一行数据
                            if ($itemNum == 0 || strpos($item, '---') || empty($item)) {
                                continue;
                            }
                            $item = trim($item, '|');
                            $item = trim($item, ',');
                            Log::info('item:' . $item);
                            $itemArr = explode('|', $item);
                            Log::info('itemArr:' . print_r($itemArr, true));
                            // 如何根据'|'解析的数据太少，则更换分隔符为','
                            if (sizeof($itemArr) <= 1) {
                                $itemArr = explode(',', $item);
                            }
                            // 如果itemArr数据过少，则退出
                            if (sizeof($itemArr) <= 1) {
                                continue;
                            }
                            if (isset($itemArr[0])) {
                                if (preg_match('/^\d+\./', $itemArr[0], $matches)) {
                                    // 如果匹配成功，$matches[0] 将包含整个匹配到的字符串（即数字和点号开头的部分）
                                    // 我们需要截取点号之后的字符串，所以使用 str_replace 函数去除掉匹配到的部分
                                    $itemArr[0] = str_replace($matches[0], '', $itemArr[0]);
                                }
                            }
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
                                $businessData->$value = isset($itemArr[$columnNums - 1]) ? $itemArr[$columnNums - 1] : ('测试' . $column->dict_name . $columnNums);
                            }
                            $businessData->save();
                        }
                    }
                }
            }
        }
    }

    /**
     * 初始化备注字段
     * @param $projectId
     * @return void
     */
    public function projectMenuDescInit($projectId)
    {
        $project = ProjectInfo::findOrFail($projectId);

        $menuService = new SysMenuService();
        $projectMenu = ProjectMenu::where('project_id', $project->project_id)
            ->where('visible', '0')
            ->orderBy('order_num')
            ->orderBy('menu_id')
            ->get()
            ->toArray();
        $menus = $menuService->getChildPerms($projectMenu, 0);

        foreach ($menus as $menu) {
            $firstMenu = '根据功能菜单名称为:`' . $menu['menu_name'] . '`,';
            if (isset($menu['children']) && !empty($menu['children'])) {
                $firstMenu .= '包含功能(';
                foreach ($menu['children'] as $child) {

                    // 获取该菜单的列数
                    $businessColumnList = ProjectColumn::where('project_id', $project->project_id)
                        ->where('menu_id', $child['menu_id'])
                        ->orderBy('sort')
                        ->get();

                    $firstMenu .= '`' . $child['menu_name'] . '`,';
                    $childMenu = '根据菜单名:' . $child['menu_name'];

                    if (!empty($businessColumnList)) {
//                        $firstMenu .= '包含字段(';
                        $childMenu .= ',包含字段(';
                        foreach ($businessColumnList as $column) {
//                            $firstMenu .= $column->dict_name . ',';
                            $childMenu .= $column->dict_name . ',';
                        }
//                        $firstMenu = substr($firstMenu, 0, -1);
                        $childMenu = substr($childMenu, 0, -1);
//                        $firstMenu .= ');';
                        $childMenu .= ')';
                    }
                    if (empty($child['remark'])) {
                        $childAnswer = $this->getMenuRemark($childMenu . ',生成200字数左右的菜单功能说明.内容贴合菜单及字段说明.');
                        Log::info(sprintf('二级菜单:%s,返回的菜单说明为:%s', $child['menu_name'], $childAnswer));
                        if ($childAnswer) {
                            ProjectMenu::where('menu_id', $child['menu_id'])->update([
                                'remark' => $childAnswer,
                            ]);
                        }
                    }
                }
                $firstMenu = substr($firstMenu, 0, -1);
                $firstMenu .= ')';
            }

            if (empty($menu['remark'])) {
                $firstAnswer = $this->getMenuRemark($firstMenu . ',生成300字数左右的此菜单功能说明.无需按照模块分开展示,汇总功能模块展示一个段落的功能说明.');
                Log::info(sprintf('一级菜单:%s,返回的菜单说明为:%s', $child['menu_name'], $firstAnswer));
                if ($firstAnswer) {
                    ProjectMenu::where('menu_id', $menu['menu_id'])->update([
                        'remark' => $firstAnswer,
                    ]);
                }
            }
        }
    }

    /**
     * @param $menuDesc
     * @return string
     */
    private function getMenuRemark($menuDesc)
    {
        if (env('GOOGLE_GEMINI_KEY')) {
            $gemini = new GeminiService();
            $remark = $gemini->getMessage($menuDesc);
            $remark = str_replace(['*'], '', $remark);
            usleep(100);
        } else {
            $xf = new XfyunService();
            $remark = $xf->getMessage($menuDesc);
            sleep(1);
        }

        if (mb_strlen($remark) > 500) {
            $remark = mb_substr($remark, 0, 500);
        }
        return $remark;
    }
}
