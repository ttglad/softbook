<?php

namespace App\Http\Controllers\Admin;

use App\Models\SysDictData;
use App\Models\SysMenu;
use App\Models\SysRole;
use App\Services\SysMenuService;
use Illuminate\Http\Request;

/**
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class MenuController extends AdminController
{

    /**
     * 图标
     */
    public function icon()
    {
        return view('admin.menu.icon');
    }

    /**
     * 图标
     */
    public function checkMenuNameUnique(Request $request)
    {
        $menu = SysMenu::where('parent_id', $request->post('parentId'))
            ->where('menu_name', $request->post('menuName'))
            ->first();
        if (is_null($menu)) {
            exit('true');
        } else {
            if ($request->post('menuId') && $request->post('menuId') == $menu['menu_id']) {
                exit('true');
            }
            exit('false');
        }
    }

    /**
     * main页
     */
    public function show()
    {

        // 获取菜单展示名称
        $sysShowList = SysDictData::where('dict_type', 'sys_show_hide')->get();

        return view('admin.menu.show', [
            'sysShowList' => $sysShowList,
        ]);
    }

    /**
     * 查询数据页
     */
    public function lists(Request $request)
    {
        // 获取菜单
        $menuService = new SysMenuService();
        $menuName = $request->post('menuName');
        if (!$request->exists('visible')) {
            $visible = 0;
        } else {
            $visible = $request->post('visible');
        }
        return $menuService->getMenusLists(auth()->user(), $menuName, $visible);
    }

    /**
     * 查询数据页
     */
    public function selectMenuTree(Request $request, $id)
    {
        return view('admin.menu.tree');
    }

    /**
     * 查询数据页
     */
    public function menuTreeData(Request $request)
    {
        // 获取菜单
        $menuService = new SysMenuService();
        $menus = $menuService->menuTreeData(auth()->user());
        $treeData = [];
        foreach ($menus as $menu) {
            $treeData[] = [
                'id' => $menu['menu_id'],
                'pId' => $menu['parent_id'],
                'name' => $menu['menu_name'],
                'title' => $menu['menu_name'],
                'checked' => false,
                'open' => false,
                'nocheck' => false,
            ];
        }
        return $treeData;
    }

    /**
     * main页
     */
    public function add(Request $request, $id)
    {
        if ($id <= 0) {
            $menu['menu_id'] = $id;
            $menu['menu_name'] = '主目录';
        } else {
            $menu = SysMenu::find($id)->toArray();
        }

        // 获取菜单展示名称
        $sysShowList = SysDictData::where('dict_type', 'sys_show_hide')->get();

        return view('admin.menu.add', [
            'menu' => $menu,
            'sysShowList' => $sysShowList,
        ]);
    }

    /**
     * main页
     * parentId: 1760
     * menuType: C
     * menuName: 系统工具
     * url: /system/111
     * target: menuBlank
     * perms:
     * orderNum: 1
     * icon: fa fa-address-book-o
     * visible: 0
     * isRefresh: 0
     */
    public function addPost(Request $request)
    {
        $return = $this->ajaxReturn;

        try {

            $menu = new SysMenu();
            $menu->parent_id = $request->post('parentId');
            $menu->menu_type = $request->post('menuType');
            $menu->menu_name = $request->post('menuName');
            $menu->url = $request->post('url');
            $menu->target = $request->post('target');
            $menu->class = $request->post('class');
            $menu->perms = $request->post('perms');
            $menu->order_num = $request->post('orderNum');
            $menu->icon = $request->post('icon');
            $menu->visible = $request->post('visible');
            $menu->is_refresh = $request->post('isRefresh');
            $menu->create_by = auth()->user()->login_name;

            if (!$menu->save()) {
                $return['code'] = '1001';
                $return['msg'] = '操作失败';
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 编辑页
     */
    public function edit(Request $request, $id)
    {
        $menu = SysMenu::find($id)->toArray();
        if ($menu['parent_id'] == 0) {
            $menu['parent_name'] = '主目录';
        } else {
            $menuParent = SysMenu::find($menu['parent_id']);
            $menu['parent_name'] = $menuParent->menu_name;
        }

        // 获取菜单展示名称
        $sysShowList = SysDictData::where('dict_type', 'sys_show_hide')->get();

        return view('admin.menu.edit', [
            'menu' => $menu,
            'sysShowList' => $sysShowList,
        ]);
    }

    /**
     * @param Request $request
     * @return array
     * menuId: 1769
     * parentId: 1760
     * menuType: C
     * menuName: 系统工具1
     * url: /system/1112
     * target: menuItem
     * perms: 23
     * orderNum: 11
     * icon: fa fa-address-book-o1
     * visible: 1
     * isRefresh: 1
     */
    public function editPost(Request $request)
    {
        $return = $this->ajaxReturn;

        try {
            $menu = SysMenu::findOrFail($request->post('menuId'));
            $menu->parent_id = $request->post('parentId');
            $menu->menu_type = $request->post('menuType');
            $menu->menu_name = $request->post('menuName');
            $menu->url = $request->post('url');
            $menu->target = $request->post('target');
            $menu->class = $request->post('class');
            $menu->perms = $request->post('perms');
            $menu->order_num = $request->post('orderNum');
            $menu->icon = $request->post('icon');
            $menu->visible = $request->post('visible');
            $menu->is_refresh = $request->post('isRefresh');
            $menu->update_by = auth()->user()->login_name;

            if (!$menu->save()) {
                $return['code'] = '1001';
                $return['msg'] = '操作失败';
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 菜单删除
     * @param Request $request
     * @return array
     */
    public function remove(Request $request, $id)
    {
        $return = $this->ajaxReturn;

        try {
            $menu = SysMenu::findOrFail($id);

            if (!$menu->delete()) {
                $return['code'] = '1001';
                $return['msg'] = '操作失败';
            }
        } catch (\Exception $e) {
            $return['code'] = $e->getCode();
            $return['msg'] = $e->getMessage();
        }

        return $return;
    }

    /**
     * 获取角色树
     * @param Request $request
     * @return array
     */
    public function roleMenuTreeData(Request $request)
    {
        $roleMenuIds = [];
        if ($request->get('roleId')) {
            $role = SysRole::with('menus')->findOrFail($request->get('roleId'));
            foreach ($role->menus as $menu) {
                $roleMenuIds[] = $menu['menu_id'];
            }
        }
        // 获取菜单
        $menuService = new SysMenuService();
        $menus = $menuService->menuTreeData(auth()->user());
        $treeData = [];
        foreach ($menus as $menu) {
            $checked = false;
            if (in_array($menu['menu_id'], $roleMenuIds)) {
                $checked = true;
            }
            $treeData[] = [
                'id' => $menu['menu_id'],
                'pId' => $menu['parent_id'],
                'name' => $menu['menu_name'],
                'title' => $menu['menu_name'],
                'checked' => $checked,
                'open' => false,
                'nocheck' => false,
            ];
        }
        return $treeData;
    }
}
