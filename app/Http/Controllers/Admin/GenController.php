<?php

namespace App\Http\Controllers\Admin;

use App\Models\GenTable;
use App\Models\GenTableColumn;
use App\Models\SysConfig;
use App\Models\SysDictData;
use App\Models\SysMenu;
use App\Services\GenTableService;
use App\Services\ResourceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GenController extends AdminController
{
    /**
     * @return void
     */
    public function show()
    {
        return view('admin.gen.gen');
    }

    /**
     * 建表页面
     */
    public function createTable()
    {
        return view('admin.gen.createTable');
    }

    /**
     * 建表提交
     * @return void
     */
    public function createTablePost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $sqls = explode(';', $request->post('sql'));
            foreach ($sqls as $sql) {
                if (!empty($sql)) {
                    DB::statement($sql);
                }
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 建表页面
     */
    public function importTable()
    {
        return view('admin.gen.importTable');
    }

    /**
     * 建表提交
     * @return void
     */
    public function importTablePost(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            if ($request->post('tables')) {
                $genService = new GenTableService();
                // [table_name] => data_analysis_2 [table_comment] => 数据分析
                $tables = $genService->getTableListByNames(explode(',', trim($request->post('tables'))));
                $i = 0;
                foreach ($tables as $table) {

                    $gen = $genService->initGenTable($table->table_name, $table->table_comment);

                    // 查询表名字，是否存在，存在则备份表名字
                    $hisTables = GenTable::where('table_name', $gen->table_name)->get();
                    if (!empty($hisTables)) {
                        foreach ($hisTables as $hisTable) {
                            $hisTable->table_name = $hisTable->table_name . '_' . date('Ymd',
                                    strtotime($hisTable->create_time));
                            $hisTable->save();
                        }
                    }

                    $gen->create_by = auth()->user()->login_name;
                    if ($gen->save()) {
                        $tableColumns = $genService->getTableColumnByName($table->table_name);
                        if (!empty($tableColumns)) {
                            foreach ($tableColumns as $tableColumn) {
                                $genColumn = $genService->initGenTableColumn($tableColumn, $gen);
                                $genColumn->save();
                            }
                        }
                    }

                    // 没有此二级菜单则添加个二级菜单
                    $existMenu = SysMenu::where('url', '/business/' . $gen->table_name)
                        ->where('menu_type', 'C')
                        ->where('visible', 0)
                        ->first();
                    if (is_null($existMenu)) {
                        // 添加二级菜单
                        $menu = new SysMenu();
                        $menu->menu_name = $table->table_comment;
                        $menu->parent_id = 5;
                        $menu->order_num = ++$i;
                        $menu->url = '/business/' . $gen->table_name;
                        $menu->target = 'menuItem';
                        $menu->class = 'menuItemShot';
                        $menu->menu_type = 'C';
                        $menu->visible = '0';
                        $menu->is_refresh = '1';
                        $menu->icon = '#';
                        $menu->create_by = auth()->user()->login_name;
                        $menu->is_refresh = '1';
                        $menu->save();
                    }

                    // 删除此表
                    Schema::dropIfExists($table->table_name);
                }
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 查询表数量
     * @return void
     */
    public function tableLists(Request $request)
    {
        $return = $this->ajaxReturnWithPage;
        try {
            $genService = new GenTableService();
            $tables = $genService->getNotGenTables($request->post('tableName'), $request->post('tableComment'));

            $return['rows'] = $tables;
            $return['total'] = count($tables);
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }


    /**
     * @return void
     * pageSize: 10
     * pageNum: 1
     * orderByColumn: createTime
     * isAsc: desc
     * tableName:
     * tableComment:
     * params[beginTime]:
     * params[endTime]:
     */
    public function getLists(Request $request)
    {
        $return = $this->ajaxReturnWithPage;
        try {
            $gen = new GenTable();
            if ($request->post('tableName')) {
                $gen = $gen->whereLike('table_name', '%' . trim($request->post('tableName')) . '%');
            }
            if ($request->post('tableComment')) {
                $gen = $gen->whereLike('table_comment', '%' . trim($request->post('tableComment')) . '%');
            }
            $genLists = $gen->orderByDesc('table_id')
                ->paginate($request->post('pageSize') ?? 10)
                ->toArray();

            $return['rows'] = $genLists['data'];
            $return['total'] = $genLists['total'];
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 删除数据类
     * @return void
     */
    public function remove(Request $request)
    {
        $return = $this->ajaxReturn;
        try {
            $ids = explode(',', trim($request->post('ids')));
            if (empty($ids)) {
                throw new \Exception('选中的记录不能为空', 1001);
            }
            foreach ($ids as $id) {
                try {
                    $genTable = GenTable::findOrFail($id);
                    $genTable->delete();
                    GenTableColumn::where('table_id', $id)->delete();
                } catch (\Exception $e) {

                }
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 删除数据类
     * @return void
     */
    public function synchDb(Request $request, $table)
    {
        $return = $this->ajaxReturn;
        try {
            $genService = new GenTableService();
            $genTable = GenTable::where('table_name', $table)->first();
            if (is_null($genTable)) {
                throw new \Exception('不选在选中的记录数据', 1001);
            }
            // 获取列
            $tableColumns = $genService->getTableColumnByName($genTable->table_name);
            if (empty($tableColumns)) {
                throw new \Exception('不存在该表的数据列', 1001);
            }
            GenTableColumn::where('table_id', $genTable->table_id)->delete();
            foreach ($tableColumns as $tableColumn) {
                $genColumn = $genService->initGenTableColumn($tableColumn, $genTable);
                $genColumn->save();
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }
        return $return;
    }

    /**
     * 下载代码
     * @return void
     */
    public function batchDownloadCode(Request $request)
    {
        $content = '';
        if (empty($request->get('tables'))) {
            abort(404);
        }
        try {
            $resourceService = new ResourceService();

            // 获取登录页面 ######
            $sysConfig = SysConfig::where('config_key', 'sys.account.registerUser')->first();
            $registerValue = is_null($sysConfig) ? false : $sysConfig->config_value;
            $rememberMe = true;
            $captchaEnabled = false;
            // 软件名称
            $sysConfig = SysConfig::where('config_key', 'sys.soft.name')->first();
            $softName = $sysConfig->config_value;

            $content .= view('admin.auth.login', [
                'registerValue' => $registerValue,
                'rememberMe' => $rememberMe,
                'captchaEnabled' => $captchaEnabled,
                'softName' => $softName,
            ])->render();

            // 获取用户页 ######
            // 获取菜单展示名称
            $sysNormalDisable = SysDictData::where('dict_type', 'sys_normal_disable')->get();
            $content .= view('admin.user.user', [
                'sysNormalDisable' => $sysNormalDisable,
            ])->render();

            // 菜单业务列表
            $tables = explode(',', $request->get('tables'));
            // 获取页面代码 ######
            foreach ($tables as $table) {
                // 获取业务表名称
                $business = GenTable::where('table_name', $table)->first();
                if (is_null($business)) {
                    throw new \Exception('业务不存在', 1001);
                }
                // 业务列名称
                $businessColumn = GenTableColumn::where('table_id', $business->table_id)->orderBy('sort')->get();

                // 获取业务展示页面
                $content .= view('business.show', [
                    'business' => $business,
                    'businessColumn' => $businessColumn,
                ])->render();
                // 获取业务添加页面
//                $content .= view('business.add', [
//                    'business' => $business,
//                    'businessColumn' => $businessColumn,
//                ])->render();
            }

            // 获取登录+用户服务
            $content .= file_get_contents(app_path('Http/Controllers/Admin/AuthorityController.php'));
            $content .= file_get_contents(app_path('Http/Controllers/Admin/UserController.php'));
            $content .= file_get_contents(app_path('Models/SysUser.php'));

            // 获取服务代码
            foreach ($tables as $table) {
                // 获取业务表名称
                $business = GenTable::where('table_name', $table)->first();
                if (is_null($business)) {
                    throw new \Exception('业务不存在', 1001);
                }
                // 业务列名称
                $businessColumn = GenTableColumn::where('table_id', $business->table_id)->orderBy('sort')->get();

                // 获取model代码
                $content .= $resourceService->getControllerContent($business, $businessColumn);
                $content .= $resourceService->getModelContent($business, $businessColumn);
                $content .= $resourceService->getServiceContent($business, $businessColumn);
            }
        } catch (\Exception $e) {
            abort(404);
        }

        // 替换软件代码
        $sysConfig = SysConfig::where('config_key', 'sys.soft.code')->first();
        if (!is_null($sysConfig) && !empty($sysConfig->config_value)) {
            $content = str_replace('ruoyi', $sysConfig->config_value, $content);
        }

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, 'softbook.txt');
    }
}
