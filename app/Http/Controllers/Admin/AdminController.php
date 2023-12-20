<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * 管理后台共用控制器
 * AdminController
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class AdminController extends Controller
{
    // ajax返回值
    protected $ajaxReturn = [];
    // ajax分页返回值
    protected $ajaxReturnWithPage = [];

    public function __construct()
    {
        $this->ajaxReturn = [
            'code' => 0,
            'msg' => '成功',
        ];

        $this->ajaxReturnWithPage = [
            'code' => 0,
            'msg' => '成功',
            'total' => 0,
            'rows' => [],
        ];
    }
}
