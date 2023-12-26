<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;

/**
 * 业务共用控制器
 *
 * @author TaoYl <tonneylon@gmail.com>
 */
class ProjectController extends Controller
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
