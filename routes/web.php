<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// 系统菜单
Route::group(['namespace' => 'Admin'], function () {
    // 登录
    Route::get('login', 'AuthorityController@getLogin')->name('admin_login');
    // 提交登录
    Route::post('login', 'AuthorityController@postLogin')->name('admin_post_login');
    // 退出登录
    Route::get('loginOut', 'AuthorityController@getLogout')->name('admin_login_out');

    Route::group(['prefix' => '', 'middleware' => ['auth']], function () {

        // 首页
        Route::get('main', 'HomeController@base')->name('admin_main');

        // 主框架
        Route::get('/', 'HomeController@home')->name('admin_home');
        Route::get('index', 'HomeController@home')->name('admin_home');

        // 切换主题
        Route::get('system/switchSkin', 'HomeController@switchSkin');

        // 用户
        Route::get('system/user', 'UserController@show');
        Route::post('system/user/list', 'UserController@lists');
        Route::get('system/user/deptTreeData', 'UserController@deptTreeData');
        Route::get('system/user/add', 'UserController@add');
        Route::post('system/user/add', 'UserController@addPost');
        Route::get('system/user/edit/{id}', 'UserController@edit')->where('id', '[0-9]+');
        Route::post('system/user/edit', 'UserController@editPost');
        Route::post('system/user/changeStatus', 'UserController@changeStatus');
        Route::post('system/user/remove', 'UserController@remove');
        Route::get('system/user/resetPwd/{id}', 'UserController@resetPwd')->where('id', '[0-9]+');
        Route::post('system/user/resetPwd', 'UserController@resetPwdPost');
        Route::get('system/user/authRole/{id}', 'UserController@authRole')->where('id', '[0-9]+');
        Route::post('system/user/authRole', 'UserController@authRolePost');
        Route::post('system/user/checkEmailUnique', 'UserController@checkEmailUnique');
        Route::post('system/user/checkPhoneUnique', 'UserController@checkPhoneUnique');
        Route::post('system/user/checkLoginNameUnique', 'UserController@checkLoginNameUnique');
        // 用户个人中心
        Route::get('system/user/profile', 'UserController@profile');
        Route::get('system/user/profile/avatar', 'UserController@profileAvatar');
        Route::post('system/user/profile/update', 'UserController@update');
        Route::get('system/user/profile/resetPwd', 'UserController@passRet');
        Route::post('system/user/profile/resetPwd', 'UserController@resetPassword');
        Route::post('system/user/profile/updateAvatar', 'UserController@updateAvatar');
        Route::get('system/user/profile/checkPassword', 'UserController@checkPassword');

        // 角色
        Route::get('system/role', 'RoleController@show');
        Route::post('system/role/list', 'RoleController@lists');
        Route::get('system/role/add', 'RoleController@add');
        Route::post('system/role/add', 'RoleController@addPost');
        Route::get('system/role/edit/{id}', 'RoleController@edit')->where('id', '[0-9]+');
        Route::post('system/role/edit', 'RoleController@editPost');
        Route::post('system/role/remove', 'RoleController@remove');
        Route::get('system/role/authDataScope/{id}', 'RoleController@authData')->where('id', '[0-9]+');
        Route::get('system/role/authUser/{id}', 'RoleController@authUser')->where('id', '[0-9]+');
        Route::post('system/role/authUser/selectAll', 'RoleController@selectAll');
        Route::post('system/role/authUser/cancel', 'RoleController@cancel');
        Route::post('system/role/authUser/cancelAll', 'RoleController@cancelAll');
        Route::post('system/role/authUser/allocatedList', 'RoleController@allocatedList');
        Route::post('system/role/authUser/unallocatedList', 'RoleController@unAllocatedList');
        Route::get('system/role/authUser/selectUser/{id}', 'RoleController@selectUser')->where('id', '[0-9]+');
        Route::post('system/role/changeStatus', 'RoleController@changeStatus');
        Route::post('system/role/checkRoleNameUnique', 'RoleController@checkRoleNameUnique');
        Route::post('system/role/checkRoleKeyUnique', 'RoleController@checkRoleKeyUnique');
        Route::get('system/role/deptTreeData', 'RoleController@deptTreeData');
        Route::post('system/role/authDataScope', 'RoleController@authDataScope');


        // 部门
        Route::get('system/dept', 'DeptController@show');
        Route::post('system/dept/list', 'DeptController@lists');
        Route::get('system/dept/add/{id}', 'DeptController@add')->where('id', '[0-9]+');
        Route::post('system/dept/add', 'DeptController@addPost');
        Route::get('system/dept/edit/{id}', 'DeptController@edit')->where('id', '[0-9]+');
        Route::post('system/dept/edit', 'DeptController@editPost');
        Route::get('system/dept/remove/{id}', 'DeptController@remove')->where('id', '[0-9]+');
        Route::get('system/dept/selectDeptTree/{id}/{excludeId?}', 'DeptController@selectDeptTree')->where('id',
            '[0-9]+');
        Route::get('system/dept/treeData/{id}', 'DeptController@treeData')->where('id', '[0-9]+');
        Route::post('system/dept/checkDeptNameUnique', 'DeptController@checkDeptNameUnique');

        // 岗位
        Route::get('system/post', 'PostController@show');
        Route::post('system/post/list', 'PostController@lists');
        Route::get('system/post/add', 'PostController@add');
        Route::post('system/post/add', 'PostController@addPost');
        Route::get('system/post/edit/{id}', 'PostController@edit')->where('id', '[0-9]+');
        Route::post('system/post/edit', 'PostController@editPost');
        Route::post('system/post/remove', 'PostController@remove');
        Route::post('system/post/checkPostNameUnique', 'PostController@checkPostNameUnique');
        Route::post('system/post/checkPostCodeUnique', 'PostController@checkPostCodeUnique');

        // 字典
        Route::get('system/dict', 'DictController@show');
        Route::post('system/dict/list', 'DictController@lists');
        Route::get('system/dict/add', 'DictController@add');
        Route::post('system/dict/add', 'DictController@addPost');
        Route::get('system/dict/edit/{id}', 'DictController@edit')->where('id', '[0-9]+');
        Route::post('system/dict/edit', 'DictController@editPost');
        Route::post('system/dict/remove', 'DictController@remove');
        Route::post('system/dict/checkDictTypeUnique', 'DictController@checkDictTypeUnique');
        // 字典数据
        Route::get('system/dict/detail/{id}', 'DictController@showDetail')->where('id', '[0-9]+');
        Route::post('system/dict/data/list', 'DictController@listsDetail');
        Route::get('system/dict/data/add/{dictType}', 'DictController@addDetail');
        Route::post('system/dict/data/add', 'DictController@addPostDetail');
        Route::get('system/dict/data/edit/{id}', 'DictController@editDetail')->where('id', '[0-9]+');
        Route::post('system/dict/data/edit', 'DictController@editPostDetail');
        Route::post('system/dict/data/remove', 'DictController@removeDetail');

        // 系统参数
        Route::get('system/config', 'ConfigController@show');
        Route::post('system/config/list', 'ConfigController@lists');
        Route::get('system/config/deptTreeData', 'ConfigController@deptTreeData');
        Route::get('system/config/add', 'ConfigController@add');
        Route::get('system/config/edit/{id}', 'ConfigController@edit')->where('id', '[0-9]+');
        Route::post('system/config/edit', 'ConfigController@editPost');

        // 菜单
        Route::get('system/menu', 'MenuController@show');
        Route::post('system/menu/list', 'MenuController@lists');
        Route::get('system/menu/add/{id}', 'MenuController@add')->where('id', '[0-9]+');
        Route::post('system/menu/add', 'MenuController@addPost');
        Route::get('system/menu/edit/{id}', 'MenuController@edit')->where('id', '[0-9]+');
        Route::post('system/menu/edit', 'MenuController@editPost');
        Route::get('system/menu/remove/{id}', 'MenuController@remove')->where('id', '[0-9]+');
        Route::get('system/menu/selectMenuTree/{id}', 'MenuController@selectMenuTree')->where('id', '[0-9]+');
        Route::get('system/menu/menuTreeData', 'MenuController@menuTreeData');
        Route::get('system/menu/roleMenuTreeData', 'MenuController@roleMenuTreeData');
        Route::post('system/menu/checkMenuNameUnique', 'MenuController@checkMenuNameUnique');
        Route::get('system/menu/icon', 'MenuController@icon');

        // 工具
        Route::get('tool/gen', 'GenController@show');
        Route::post('tool/gen/list', 'GenController@getLists');
        Route::post('tool/gen/tableLists', 'GenController@tableLists');
        Route::get('tool/gen/createTable', 'GenController@createTable');
        Route::post('tool/gen/createTable', 'GenController@createTablePost');
        Route::get('tool/gen/importTable', 'GenController@importTable');
        Route::post('tool/gen/importTable', 'GenController@importTablePost');
        Route::post('tool/gen/remove', 'GenController@remove');
        Route::get('tool/gen/synchDb/{table}', 'GenController@synchDb');
        Route::get('tool/gen/batchGenCode', 'GenController@batchGenCode');

        // 系统监控
        Route::get('monitor/server', 'MonitorController@server');

        // 日志列表
        Route::get('log/login', 'LogController@login');
        Route::post('log/login/list', 'LogController@loginList');
    });
});

// 软著项目编辑
Route::group(['namespace' => 'Project', 'middleware' => ['auth']], function () {

    // 软著项目
    Route::get('project', 'InfoController@show');
    Route::get('project/add', 'InfoController@add');
    Route::post('project/add', 'InfoController@addPost');
    Route::post('project/list', 'InfoController@lists');
    Route::get('project/edit/{id}', 'InfoController@edit')->where('id', '[0-9]+');
    Route::post('project/edit', 'InfoController@editPost');
    Route::post('project/remove', 'InfoController@remove');
    Route::get('project/switchSkin', 'InfoController@switchSkin');
    Route::get('project/switchImage', 'InfoController@switchImage');
    Route::get('project/download/{id}', 'InfoController@download');
    Route::get('project/batchDownload', 'InfoController@batchDownload');
    Route::post('project/uploadImage', 'InfoController@uploadImage');
    Route::get('project/submit', 'InfoController@submit');


    // 项目菜单
    Route::get('project/menu/{id}', 'MenuController@show')->where('id', '[0-9]+');
    Route::get('project/menu/{id}/add/{mid}', 'MenuController@add')->where('id', '[0-9]+')->where('mid', '[0-9]+');
    Route::post('project/menu/{id}/add', 'MenuController@addPost')->where('id', '[0-9]+');
    Route::post('project/menu/{id}/list', 'MenuController@lists')->where('id', '[0-9]+');
    Route::get('project/menu/{id}/edit/{mid}', 'MenuController@edit')->where('id', '[0-9]+')->where('mid', '[0-9]+');
    Route::post('project/menu/{id}/edit', 'MenuController@editPost');
    Route::get('project/menu/{id}/remove/{mid}', 'MenuController@remove')->where('id', '[0-9]+')->where('mid',
        '[0-9]+');
    Route::get('project/menu/{id}/tree/{mid}', 'MenuController@tree')->where('id', '[0-9]+')->where('mid', '[0-9]+');
    Route::get('project/menu/{id}/treeLists', 'MenuController@treeLists')->where('id', '[0-9]+');
    Route::get('project/menu/{id}/batchAdd', 'MenuController@batchAdd')->where('id', '[0-9]+');
    Route::post('project/menu/{id}/batchAdd', 'MenuController@batchAddPost')->where('id', '[0-9]+');


    // 项目菜单字段
    Route::get('project/menu/column/{id}', 'ColumnController@show')->where('id', '[0-9]+');
    Route::get('project/menu/column/{id}/add', 'ColumnController@add')->where('id', '[0-9]+');
    Route::post('project/menu/column/{id}/add', 'ColumnController@addPost')->where('id', '[0-9]+');
    Route::post('project/menu/column/{id}/list', 'ColumnController@lists')->where('id', '[0-9]+');
    Route::get('project/menu/column/{id}/edit/{mid}', 'ColumnController@edit')->where('id', '[0-9]+')->where('mid', '[0-9]+');
    Route::post('project/menu/column/{id}/edit', 'ColumnController@editPost');
    Route::post('project/menu/column/{id}/remove', 'ColumnController@remove')->where('id', '[0-9]+');

    // 项目字典
    Route::get('project/dict', 'DictController@show');
    Route::post('project/dict/list', 'DictController@lists');
    Route::get('project/dict/add', 'DictController@add');
    Route::post('project/dict/add', 'DictController@addPost');
    Route::get('project/dict/edit/{id}', 'DictController@edit')->where('id', '[0-9]+');
    Route::post('project/dict/edit', 'DictController@editPost');
    Route::post('project/dict/remove', 'DictController@remove');

    // 项目预览
    Route::get('project/login/{id}', 'PreviewController@login')->where('id', '[0-9]+');
    Route::post('project/preview/{id}/login', 'PreviewController@loginPost')->where('id', '[0-9]+');
    Route::get('project/preview/{id}/index', 'PreviewController@index')->where('id', '[0-9]+');

    // 项目业务
    Route::get('project/business/{id}', 'BusinessController@show');
    Route::get('project/business/{id}/add', 'BusinessController@add');
    Route::post('project/business/{id}/add', 'BusinessController@addPost');
    Route::get('project/business/{id}/edit/{did}', 'BusinessController@edit');
    Route::post('project/business/{id}/edit', 'BusinessController@editPost');
    Route::post('project/business/{id}/list', 'BusinessController@lists');
    Route::post('project/business/{id}/export', 'BusinessController@export');
    Route::post('project/business/{id}/remove', 'BusinessController@remove');
    Route::post('project/business/{id}/download', 'BusinessController@download');

});

// 业务菜单统一处理
Route::group(['namespace' => 'Business', 'middleware' => ['auth']], function () {

    // 下载文件页面
    Route::get('business/download', 'SoftBookController@download');

    // 业务具体处理逻辑
//    Route::get('business/{table}', 'SoftBookController@show');
//    Route::get('business/{table}/add', 'SoftBookController@add');
//    Route::post('business/{table}/add', 'SoftBookController@addPost');
//    Route::get('business/{table}/edit/{id}', 'SoftBookController@edit');
//    Route::post('business/{table}/edit', 'SoftBookController@editPost');
//    Route::post('business/{table}/list', 'SoftBookController@lists');
//    Route::post('business/{table}/export', 'SoftBookController@export');
//    Route::post('business/{table}/remove', 'SoftBookController@remove');
});

