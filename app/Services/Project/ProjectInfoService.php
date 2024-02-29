<?php

namespace App\Services\Project;

use App\Models\Project\ProjectColumn;
use App\Models\Project\ProjectInfo;
use App\Models\Project\ProjectMenu;
use App\Services\GeminiService;
use App\Services\SysMenuService;
use App\Services\XfyunService;
use Illuminate\Support\Facades\Log;

class ProjectInfoService extends ProjectService
{
    public function projectInit($projectId)
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
            $firstMenu = '根据菜单名`' . $menu['menu_name'] . '`,';
            if (isset($menu['children']) && !empty($menu['children'])) {
                $firstMenu .= '包含子菜单,';
                foreach ($menu['children'] as $child) {

                    // 获取该菜单的列数
                    $businessColumnList = ProjectColumn::where('project_id', $project->project_id)
                        ->where('menu_id', $child['menu_id'])
                        ->orderBy('sort')
                        ->get();

                    $firstMenu .= '`' . $child['menu_name'] . '`';
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
//                $firstMenu = substr($firstMenu, 0, -1);
            }

            if (empty($menu['remark'])) {
                $firstAnswer = $this->getMenuRemark($firstMenu . ',生成300字数左右的菜单功能说明.内容需要贴合一级菜单和二级菜单.');
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
        return $remark;
    }
}
