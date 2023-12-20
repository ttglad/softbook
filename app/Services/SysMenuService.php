<?php

namespace App\Services;


use App\Models\SysMenu;
use App\Models\SysUser;

class SysMenuService extends Service
{


    /**
     * 获取用户菜单
     * @param $user
     * @return mixed
     */
    public function getUserMenus($user): array
    {
        return $this->getChildPerms($this->getMenusByUser($user), 0);
    }

    public function menuTreeData($user) {
        $menus = $this->getMenusByUser($user);

        return $menus;
    }

    /**
     * 获取用户菜单
     * @param $user
     * @return mixed
     */
    public function getMenusLists($user, $menuName, $visible): array
    {
        $menus = new SysMenu();
        if (!$user->isAdmin()) {
            $menuIds = [];
            $user = SysUser::with('roles.menus')->find($user->user_id);
            foreach ($user->roles as $role) {
                foreach ($role->menus as $menu) {
                    $menuIds[] = $menu->menu_id;
                }
            }
            $menus = $menus->whereIn('menu_id', $menuIds);
        }
        if (!empty($menuName)) {
            $menus = $menus->whereLike('menu_name', '%' . $menuName . '%');
        }
        if (strlen($visible) > 0) {
            $menus = $menus->where('visible', $visible);
        }

        return $menus->get()->toArray();
    }

    /**
     * 获取用户菜单集合
     * @param $user
     * @return array
     */
    public function getMenusByUser($user): array
    {
        $menus = new SysMenu();
        if (!$user->isAdmin()) {
            $menuIds = [];
            $user = SysUser::with('roles.menus')->find($user->user_id);
            foreach ($user->roles as $role) {
                foreach ($role->menus as $menu) {
                    $menuIds[] = $menu->menu_id;
                }
            }
            $menus = $menus->whereIn('menu_id', $menuIds);
        }
        $menus = $menus->where('visible', 0)
            ->whereIn('menu_type', ['M', 'C'])
            ->orderBy('parent_id')
            ->orderBy('order_num')
            ->get()
            ->toArray();
        return $menus;
    }

    /**
     * @param $menus
     * @param $parentId
     * @return array
     */
    private function getChildPerms($menus, $parentId): array
    {
        $tree = [];
        foreach ($menus as $item) {
            if ($item['parent_id'] == $parentId) {
                $children = $this->getChildPerms($menus, $item['menu_id']);
                if (!empty($children)) {
                    $item['children'] = $children;
                }
                $tree[] = $item;
            }
        }
        return $tree;
    }
}
