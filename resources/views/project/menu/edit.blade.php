<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '编辑项目菜单'])
    <style type="text/css">
        .ico-list .fa {
            margin: 5px;
            padding: 5px;
            cursor: pointer;
            font-size: 18px;
            width: 28px;
            border-radius: 3px;
        }

        .ico-list .fa:hover {
            background-color: #1d9d74;
            color: #ffffff;
        }
    </style>
</head>
<body class="white-bg">
	<div class="wrapper wrapper-content animated fadeInRight ibox-content">
		<form class="form-horizontal m" id="form-menu-edit">
			<input id="projectId" name="projectId" type="hidden" value="{{ $project->project_id }}" />
			<input id="treeId" name="parentId" type="hidden" value="{{ $menuParent->menu_id }}" />
			<input id="menuId" name="menuId" type="hidden" value="{{ $menu->menu_id }}" />
			<div class="form-group">
				<label class="col-sm-3 control-label">上级菜单：</label>
				<div class="col-sm-8">
				    <div class="input-group">
					    <input class="form-control" type="text" onclick="selectMenuTree()" id="treeName" readonly="true" value="{{ $menuParent->menu_name }}">
				        <span class="input-group-addon"><i class="fa fa-search"></i></span>
				    </div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label is-required">菜单类型：</label>
				<div class="col-sm-8">
					<label class="radio-box"> <input type="radio" name="menuType" value="M" @if('M' == $menu->menu_type) checked @endif/> 目录 </label>
					<label class="radio-box"> <input type="radio" name="menuType" value="C" @if('C' == $menu->menu_type) checked @endif/> 菜单 </label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label is-required">菜单名称：</label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="menuName" id="menuName" required value="{{ $menu->menu_name }}">
				</div>
			</div>
{{--			<div class="form-group">--}}
{{--				<label class="col-sm-3 control-label" title="访问的请求地址，如：`/business/user`，如外网地址需内链访问则以`http(s)://`开头">请求地址：<i class="fa fa-question-circle-o"></i></label>--}}
{{--				<div class="col-sm-8">--}}
{{--					<input id="url" name="url" class="form-control" type="text" value="">--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="form-group">--}}
{{--				<label class="col-sm-3 control-label">打开方式：</label>--}}
{{--				<div class="col-sm-8">--}}
{{--					<select id="target" name="target" class="form-control m-b">--}}
{{--	                    <option value="menuItem">页签</option>--}}
{{--	                    <option value="menuBlank">新窗口</option>--}}
{{--	                </select>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="form-group">--}}
{{--				<label class="col-sm-3 control-label">权限标识：</label>--}}
{{--				<div class="col-sm-8">--}}
{{--					<input id="perms" name="perms" class="form-control" type="text">--}}
{{--					<span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 控制器中定义的权限标识，如：@RequiresPermissions("")</span>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--            <div class="form-group">--}}
{{--                <label class="col-sm-3 control-label">样式(class)：</label>--}}
{{--                <div class="col-sm-8">--}}
{{--                    <input id="class" name="class" class="form-control" type="text" value="">--}}
{{--                    <span class="help-block m-b-none"><i class="fa fa-info-circle"></i> 默认样式 menuItemShot</span>--}}
{{--                </div>--}}
{{--            </div>--}}
			<div class="form-group">
				<label class="col-sm-3 control-label is-required" title="数字越小越靠前">显示排序：<i class="fa fa-question-circle-o"></i></label>
				<div class="col-sm-8">
					<input class="form-control" type="text" name="orderNum" required value="{{ $menu->order_num }}">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label" title="单击选择需要使用的FontAwesome图标">图标：<i class="fa fa-question-circle-o"></i></label>
				<div class="col-sm-8">
					<input id="icon" name="icon" class="form-control" type="text" placeholder="选择图标" value="{{ $menu->icon }}">
                    <div class="ms-parent" style="width: 100%;">
                        <div class="icon-drop animated flipInX" style="display: none;max-height:200px;overflow-y:auto">
                            <div id="data-icon">
                                <div class="ico-list">
                                    <i class="fa fa-address-book" aria-hidden="true"></i>

                                    <i class="fa fa-address-book-o" aria-hidden="true"></i>

                                    <i class="fa fa-address-card" aria-hidden="true"></i>

                                    <i class="fa fa-address-card-o" aria-hidden="true"></i>

                                    <i class="fa fa-adjust" aria-hidden="true"></i>

                                    <i class="fa fa-american-sign-language-interpreting" aria-hidden="true"></i>

                                    <i class="fa fa-anchor" aria-hidden="true"></i>

                                    <i class="fa fa-archive" aria-hidden="true"></i>

                                    <i class="fa fa-area-chart" aria-hidden="true"></i>

                                    <i class="fa fa-arrows" aria-hidden="true"></i>

                                    <i class="fa fa-arrows-h" aria-hidden="true"></i>

                                    <i class="fa fa-arrows-v" aria-hidden="true"></i>

                                    <i class="fa fa-asl-interpreting" aria-hidden="true"></i>

                                    <i class="fa fa-assistive-listening-systems" aria-hidden="true"></i>

                                    <i class="fa fa-asterisk" aria-hidden="true"></i>

                                    <i class="fa fa-at" aria-hidden="true"></i>

                                    <i class="fa fa-audio-description" aria-hidden="true"></i>

                                    <i class="fa fa-automobile" aria-hidden="true"></i>

                                    <i class="fa fa-balance-scale" aria-hidden="true"></i>

                                    <i class="fa fa-ban" aria-hidden="true"></i>

                                    <i class="fa fa-bank" aria-hidden="true"></i>

                                    <i class="fa fa-bar-chart" aria-hidden="true"></i>

                                    <i class="fa fa-bar-chart-o" aria-hidden="true"></i>

                                    <i class="fa fa-barcode" aria-hidden="true"></i>

                                    <i class="fa fa-bars" aria-hidden="true"></i>

                                    <i class="fa fa-bath" aria-hidden="true"></i>

                                    <i class="fa fa-bathtub" aria-hidden="true"></i>

                                    <i class="fa fa-battery" aria-hidden="true"></i>

                                    <i class="fa fa-battery-0" aria-hidden="true"></i>

                                    <i class="fa fa-battery-1" aria-hidden="true"></i>

                                    <i class="fa fa-battery-2" aria-hidden="true"></i>

                                    <i class="fa fa-battery-3" aria-hidden="true"></i>

                                    <i class="fa fa-battery-4" aria-hidden="true"></i>

                                    <i class="fa fa-battery-empty" aria-hidden="true"></i>

                                    <i class="fa fa-battery-full" aria-hidden="true"></i>

                                    <i class="fa fa-battery-half" aria-hidden="true"></i>

                                    <i class="fa fa-battery-quarter" aria-hidden="true"></i>

                                    <i class="fa fa-battery-three-quarters" aria-hidden="true"></i>

                                    <i class="fa fa-bed" aria-hidden="true"></i>

                                    <i class="fa fa-beer" aria-hidden="true"></i>

                                    <i class="fa fa-bell" aria-hidden="true"></i>

                                    <i class="fa fa-bell-o" aria-hidden="true"></i>

                                    <i class="fa fa-bell-slash" aria-hidden="true"></i>

                                    <i class="fa fa-bell-slash-o" aria-hidden="true"></i>

                                    <i class="fa fa-bicycle" aria-hidden="true"></i>

                                    <i class="fa fa-binoculars" aria-hidden="true"></i>

                                    <i class="fa fa-birthday-cake" aria-hidden="true"></i>

                                    <i class="fa fa-blind" aria-hidden="true"></i>

                                    <i class="fa fa-bluetooth" aria-hidden="true"></i>

                                    <i class="fa fa-bluetooth-b" aria-hidden="true"></i>

                                    <i class="fa fa-bolt" aria-hidden="true"></i>

                                    <i class="fa fa-bomb" aria-hidden="true"></i>

                                    <i class="fa fa-book" aria-hidden="true"></i>

                                    <i class="fa fa-bookmark" aria-hidden="true"></i>

                                    <i class="fa fa-bookmark-o" aria-hidden="true"></i>

                                    <i class="fa fa-braille" aria-hidden="true"></i>

                                    <i class="fa fa-briefcase" aria-hidden="true"></i>

                                    <i class="fa fa-bug" aria-hidden="true"></i>

                                    <i class="fa fa-building" aria-hidden="true"></i>

                                    <i class="fa fa-building-o" aria-hidden="true"></i>

                                    <i class="fa fa-bullhorn" aria-hidden="true"></i>

                                    <i class="fa fa-bullseye" aria-hidden="true"></i>

                                    <i class="fa fa-bus" aria-hidden="true"></i>

                                    <i class="fa fa-cab" aria-hidden="true"></i>

                                    <i class="fa fa-calculator" aria-hidden="true"></i>

                                    <i class="fa fa-calendar" aria-hidden="true"></i>

                                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>

                                    <i class="fa fa-calendar-minus-o" aria-hidden="true"></i>

                                    <i class="fa fa-calendar-o" aria-hidden="true"></i>

                                    <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>

                                    <i class="fa fa-calendar-times-o" aria-hidden="true"></i>

                                    <i class="fa fa-camera" aria-hidden="true"></i>

                                    <i class="fa fa-camera-retro" aria-hidden="true"></i>

                                    <i class="fa fa-car" aria-hidden="true"></i>

                                    <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>

                                    <i class="fa fa-caret-square-o-left" aria-hidden="true"></i>

                                    <i class="fa fa-caret-square-o-right" aria-hidden="true"></i>

                                    <i class="fa fa-caret-square-o-up" aria-hidden="true"></i>

                                    <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>

                                    <i class="fa fa-cart-plus" aria-hidden="true"></i>

                                    <i class="fa fa-cc" aria-hidden="true"></i>

                                    <i class="fa fa-certificate" aria-hidden="true"></i>

                                    <i class="fa fa-check" aria-hidden="true"></i>

                                    <i class="fa fa-check-circle" aria-hidden="true"></i>

                                    <i class="fa fa-check-circle-o" aria-hidden="true"></i>

                                    <i class="fa fa-check-square" aria-hidden="true"></i>

                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>

                                    <i class="fa fa-child" aria-hidden="true"></i>

                                    <i class="fa fa-circle" aria-hidden="true"></i>

                                    <i class="fa fa-circle-o" aria-hidden="true"></i>

                                    <i class="fa fa-circle-o-notch" aria-hidden="true"></i>

                                    <i class="fa fa-circle-thin" aria-hidden="true"></i>

                                    <i class="fa fa-clock-o" aria-hidden="true"></i>

                                    <i class="fa fa-clone" aria-hidden="true"></i>

                                    <i class="fa fa-close" aria-hidden="true"></i>

                                    <i class="fa fa-cloud" aria-hidden="true"></i>

                                    <i class="fa fa-cloud-download" aria-hidden="true"></i>

                                    <i class="fa fa-cloud-upload" aria-hidden="true"></i>

                                    <i class="fa fa-code" aria-hidden="true"></i>

                                    <i class="fa fa-code-fork" aria-hidden="true"></i>

                                    <i class="fa fa-coffee" aria-hidden="true"></i>

                                    <i class="fa fa-cog" aria-hidden="true"></i>

                                    <i class="fa fa-cogs" aria-hidden="true"></i>

                                    <i class="fa fa-comment" aria-hidden="true"></i>

                                    <i class="fa fa-comment-o" aria-hidden="true"></i>

                                    <i class="fa fa-commenting" aria-hidden="true"></i>

                                    <i class="fa fa-commenting-o" aria-hidden="true"></i>

                                    <i class="fa fa-comments" aria-hidden="true"></i>

                                    <i class="fa fa-comments-o" aria-hidden="true"></i>

                                    <i class="fa fa-compass" aria-hidden="true"></i>

                                    <i class="fa fa-copyright" aria-hidden="true"></i>

                                    <i class="fa fa-creative-commons" aria-hidden="true"></i>

                                    <i class="fa fa-credit-card" aria-hidden="true"></i>

                                    <i class="fa fa-credit-card-alt" aria-hidden="true"></i>

                                    <i class="fa fa-crop" aria-hidden="true"></i>

                                    <i class="fa fa-crosshairs" aria-hidden="true"></i>

                                    <i class="fa fa-cube" aria-hidden="true"></i>

                                    <i class="fa fa-cubes" aria-hidden="true"></i>

                                    <i class="fa fa-cutlery" aria-hidden="true"></i>

                                    <i class="fa fa-dashboard" aria-hidden="true"></i>

                                    <i class="fa fa-database" aria-hidden="true"></i>

                                    <i class="fa fa-deaf" aria-hidden="true"></i>

                                    <i class="fa fa-deafness" aria-hidden="true"></i>

                                    <i class="fa fa-desktop" aria-hidden="true"></i>

                                    <i class="fa fa-diamond" aria-hidden="true"></i>

                                    <i class="fa fa-dot-circle-o" aria-hidden="true"></i>

                                    <i class="fa fa-download" aria-hidden="true"></i>

                                    <i class="fa fa-drivers-license" aria-hidden="true"></i>

                                    <i class="fa fa-drivers-license-o" aria-hidden="true"></i>

                                    <i class="fa fa-edit" aria-hidden="true"></i>

                                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>

                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>

                                    <i class="fa fa-envelope" aria-hidden="true"></i>

                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>

                                    <i class="fa fa-envelope-open" aria-hidden="true"></i>

                                    <i class="fa fa-envelope-open-o" aria-hidden="true"></i>

                                    <i class="fa fa-envelope-square" aria-hidden="true"></i>

                                    <i class="fa fa-eraser" aria-hidden="true"></i>

                                    <i class="fa fa-exchange" aria-hidden="true"></i>

                                    <i class="fa fa-exclamation" aria-hidden="true"></i>

                                    <i class="fa fa-exclamation-circle" aria-hidden="true"></i>

                                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>

                                    <i class="fa fa-external-link" aria-hidden="true"></i>

                                    <i class="fa fa-external-link-square" aria-hidden="true"></i>

                                    <i class="fa fa-eye" aria-hidden="true"></i>

                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>

                                    <i class="fa fa-eyedropper" aria-hidden="true"></i>

                                    <i class="fa fa-fax" aria-hidden="true"></i>

                                    <i class="fa fa-feed" aria-hidden="true"></i>

                                    <i class="fa fa-female" aria-hidden="true"></i>

                                    <i class="fa fa-fighter-jet" aria-hidden="true"></i>

                                    <i class="fa fa-file-archive-o" aria-hidden="true"></i>

                                    <i class="fa fa-file-audio-o" aria-hidden="true"></i>

                                    <i class="fa fa-file-code-o" aria-hidden="true"></i>

                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>

                                    <i class="fa fa-file-image-o" aria-hidden="true"></i>

                                    <i class="fa fa-file-movie-o" aria-hidden="true"></i>

                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>

                                    <i class="fa fa-file-photo-o" aria-hidden="true"></i>

                                    <i class="fa fa-file-picture-o" aria-hidden="true"></i>

                                    <i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>

                                    <i class="fa fa-file-sound-o" aria-hidden="true"></i>

                                    <i class="fa fa-file-video-o" aria-hidden="true"></i>

                                    <i class="fa fa-file-word-o" aria-hidden="true"></i>

                                    <i class="fa fa-file-zip-o" aria-hidden="true"></i>

                                    <i class="fa fa-film" aria-hidden="true"></i>

                                    <i class="fa fa-filter" aria-hidden="true"></i>

                                    <i class="fa fa-fire" aria-hidden="true"></i>

                                    <i class="fa fa-fire-extinguisher" aria-hidden="true"></i>

                                    <i class="fa fa-flag" aria-hidden="true"></i>

                                    <i class="fa fa-flag-checkered" aria-hidden="true"></i>

                                    <i class="fa fa-flag-o" aria-hidden="true"></i>

                                    <i class="fa fa-flash" aria-hidden="true"></i>

                                    <i class="fa fa-flask" aria-hidden="true"></i>

                                    <i class="fa fa-folder" aria-hidden="true"></i>

                                    <i class="fa fa-folder-o" aria-hidden="true"></i>

                                    <i class="fa fa-folder-open" aria-hidden="true"></i>

                                    <i class="fa fa-folder-open-o" aria-hidden="true"></i>

                                    <i class="fa fa-frown-o" aria-hidden="true"></i>

                                    <i class="fa fa-futbol-o" aria-hidden="true"></i>

                                    <i class="fa fa-gamepad" aria-hidden="true"></i>

                                    <i class="fa fa-gavel" aria-hidden="true"></i>

                                    <i class="fa fa-gear" aria-hidden="true"></i>

                                    <i class="fa fa-gears" aria-hidden="true"></i>

                                    <i class="fa fa-gift" aria-hidden="true"></i>

                                    <i class="fa fa-glass" aria-hidden="true"></i>

                                    <i class="fa fa-globe" aria-hidden="true"></i>

                                    <i class="fa fa-graduation-cap" aria-hidden="true"></i>

                                    <i class="fa fa-group" aria-hidden="true"></i>

                                    <i class="fa fa-hand-grab-o" aria-hidden="true"></i>

                                    <i class="fa fa-hand-lizard-o" aria-hidden="true"></i>

                                    <i class="fa fa-hand-paper-o" aria-hidden="true"></i>

                                    <i class="fa fa-hand-peace-o" aria-hidden="true"></i>

                                    <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>

                                    <i class="fa fa-hand-rock-o" aria-hidden="true"></i>

                                    <i class="fa fa-hand-scissors-o" aria-hidden="true"></i>

                                    <i class="fa fa-hand-spock-o" aria-hidden="true"></i>

                                    <i class="fa fa-hand-stop-o" aria-hidden="true"></i>

                                    <i class="fa fa-handshake-o" aria-hidden="true"></i>

                                    <i class="fa fa-hard-of-hearing" aria-hidden="true"></i>

                                    <i class="fa fa-hashtag" aria-hidden="true"></i>

                                    <i class="fa fa-hdd-o" aria-hidden="true"></i>

                                    <i class="fa fa-headphones" aria-hidden="true"></i>

                                    <i class="fa fa-heart" aria-hidden="true"></i>

                                    <i class="fa fa-heart-o" aria-hidden="true"></i>

                                    <i class="fa fa-heartbeat" aria-hidden="true"></i>

                                    <i class="fa fa-history" aria-hidden="true"></i>

                                    <i class="fa fa-home" aria-hidden="true"></i>

                                    <i class="fa fa-hotel" aria-hidden="true"></i>

                                    <i class="fa fa-hourglass" aria-hidden="true"></i>

                                    <i class="fa fa-hourglass-1" aria-hidden="true"></i>

                                    <i class="fa fa-hourglass-2" aria-hidden="true"></i>

                                    <i class="fa fa-hourglass-3" aria-hidden="true"></i>

                                    <i class="fa fa-hourglass-end" aria-hidden="true"></i>

                                    <i class="fa fa-hourglass-half" aria-hidden="true"></i>

                                    <i class="fa fa-hourglass-o" aria-hidden="true"></i>

                                    <i class="fa fa-hourglass-start" aria-hidden="true"></i>

                                    <i class="fa fa-i-cursor" aria-hidden="true"></i>

                                    <i class="fa fa-id-badge" aria-hidden="true"></i>

                                    <i class="fa fa-id-card" aria-hidden="true"></i>

                                    <i class="fa fa-id-card-o" aria-hidden="true"></i>

                                    <i class="fa fa-image" aria-hidden="true"></i>

                                    <i class="fa fa-inbox" aria-hidden="true"></i>

                                    <i class="fa fa-industry" aria-hidden="true"></i>

                                    <i class="fa fa-info" aria-hidden="true"></i>

                                    <i class="fa fa-info-circle" aria-hidden="true"></i>

                                    <i class="fa fa-institution" aria-hidden="true"></i>

                                    <i class="fa fa-key" aria-hidden="true"></i>

                                    <i class="fa fa-keyboard-o" aria-hidden="true"></i>

                                    <i class="fa fa-language" aria-hidden="true"></i>

                                    <i class="fa fa-laptop" aria-hidden="true"></i>

                                    <i class="fa fa-leaf" aria-hidden="true"></i>

                                    <i class="fa fa-legal" aria-hidden="true"></i>

                                    <i class="fa fa-lemon-o" aria-hidden="true"></i>

                                    <i class="fa fa-level-down" aria-hidden="true"></i>

                                    <i class="fa fa-level-up" aria-hidden="true"></i>

                                    <i class="fa fa-life-bouy" aria-hidden="true"></i>

                                    <i class="fa fa-life-buoy" aria-hidden="true"></i>

                                    <i class="fa fa-life-ring" aria-hidden="true"></i>

                                    <i class="fa fa-life-saver" aria-hidden="true"></i>

                                    <i class="fa fa-lightbulb-o" aria-hidden="true"></i>

                                    <i class="fa fa-line-chart" aria-hidden="true"></i>

                                    <i class="fa fa-location-arrow" aria-hidden="true"></i>

                                    <i class="fa fa-lock" aria-hidden="true"></i>

                                    <i class="fa fa-low-vision" aria-hidden="true"></i>

                                    <i class="fa fa-magic" aria-hidden="true"></i>

                                    <i class="fa fa-magnet" aria-hidden="true"></i>

                                    <i class="fa fa-mail-forward" aria-hidden="true"></i>

                                    <i class="fa fa-mail-reply" aria-hidden="true"></i>

                                    <i class="fa fa-mail-reply-all" aria-hidden="true"></i>

                                    <i class="fa fa-male" aria-hidden="true"></i>

                                    <i class="fa fa-map" aria-hidden="true"></i>

                                    <i class="fa fa-map-marker" aria-hidden="true"></i>

                                    <i class="fa fa-map-o" aria-hidden="true"></i>

                                    <i class="fa fa-map-pin" aria-hidden="true"></i>

                                    <i class="fa fa-map-signs" aria-hidden="true"></i>

                                    <i class="fa fa-meh-o" aria-hidden="true"></i>

                                    <i class="fa fa-microchip" aria-hidden="true"></i>

                                    <i class="fa fa-microphone" aria-hidden="true"></i>

                                    <i class="fa fa-microphone-slash" aria-hidden="true"></i>

                                    <i class="fa fa-minus" aria-hidden="true"></i>

                                    <i class="fa fa-minus-circle" aria-hidden="true"></i>

                                    <i class="fa fa-minus-square" aria-hidden="true"></i>

                                    <i class="fa fa-minus-square-o" aria-hidden="true"></i>

                                    <i class="fa fa-mobile" aria-hidden="true"></i>

                                    <i class="fa fa-mobile-phone" aria-hidden="true"></i>

                                    <i class="fa fa-money" aria-hidden="true"></i>

                                    <i class="fa fa-moon-o" aria-hidden="true"></i>

                                    <i class="fa fa-mortar-board" aria-hidden="true"></i>

                                    <i class="fa fa-motorcycle" aria-hidden="true"></i>

                                    <i class="fa fa-mouse-pointer" aria-hidden="true"></i>

                                    <i class="fa fa-music" aria-hidden="true"></i>

                                    <i class="fa fa-navicon" aria-hidden="true"></i>

                                    <i class="fa fa-newspaper-o" aria-hidden="true"></i>

                                    <i class="fa fa-object-group" aria-hidden="true"></i>

                                    <i class="fa fa-object-ungroup" aria-hidden="true"></i>

                                    <i class="fa fa-paint-brush" aria-hidden="true"></i>

                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>

                                    <i class="fa fa-paper-plane-o" aria-hidden="true"></i>

                                    <i class="fa fa-paw" aria-hidden="true"></i>

                                    <i class="fa fa-pencil" aria-hidden="true"></i>

                                    <i class="fa fa-pencil-square" aria-hidden="true"></i>

                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>

                                    <i class="fa fa-percent" aria-hidden="true"></i>

                                    <i class="fa fa-phone" aria-hidden="true"></i>

                                    <i class="fa fa-phone-square" aria-hidden="true"></i>

                                    <i class="fa fa-photo" aria-hidden="true"></i>

                                    <i class="fa fa-picture-o" aria-hidden="true"></i>

                                    <i class="fa fa-pie-chart" aria-hidden="true"></i>

                                    <i class="fa fa-plane" aria-hidden="true"></i>

                                    <i class="fa fa-plug" aria-hidden="true"></i>

                                    <i class="fa fa-plus" aria-hidden="true"></i>

                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>

                                    <i class="fa fa-plus-square" aria-hidden="true"></i>

                                    <i class="fa fa-plus-square-o" aria-hidden="true"></i>

                                    <i class="fa fa-podcast" aria-hidden="true"></i>

                                    <i class="fa fa-power-off" aria-hidden="true"></i>

                                    <i class="fa fa-print" aria-hidden="true"></i>

                                    <i class="fa fa-puzzle-piece" aria-hidden="true"></i>

                                    <i class="fa fa-qrcode" aria-hidden="true"></i>

                                    <i class="fa fa-question" aria-hidden="true"></i>

                                    <i class="fa fa-question-circle" aria-hidden="true"></i>

                                    <i class="fa fa-question-circle-o" aria-hidden="true"></i>

                                    <i class="fa fa-quote-left" aria-hidden="true"></i>

                                    <i class="fa fa-quote-right" aria-hidden="true"></i>

                                    <i class="fa fa-random" aria-hidden="true"></i>

                                    <i class="fa fa-recycle" aria-hidden="true"></i>

                                    <i class="fa fa-refresh" aria-hidden="true"></i>

                                    <i class="fa fa-registered" aria-hidden="true"></i>

                                    <i class="fa fa-remove" aria-hidden="true"></i>

                                    <i class="fa fa-reorder" aria-hidden="true"></i>

                                    <i class="fa fa-reply" aria-hidden="true"></i>

                                    <i class="fa fa-reply-all" aria-hidden="true"></i>

                                    <i class="fa fa-retweet" aria-hidden="true"></i>

                                    <i class="fa fa-road" aria-hidden="true"></i>

                                    <i class="fa fa-rocket" aria-hidden="true"></i>

                                    <i class="fa fa-rss" aria-hidden="true"></i>

                                    <i class="fa fa-rss-square" aria-hidden="true"></i>

                                    <i class="fa fa-s15" aria-hidden="true"></i>

                                    <i class="fa fa-search" aria-hidden="true"></i>

                                    <i class="fa fa-search-minus" aria-hidden="true"></i>

                                    <i class="fa fa-search-plus" aria-hidden="true"></i>

                                    <i class="fa fa-send" aria-hidden="true"></i>

                                    <i class="fa fa-send-o" aria-hidden="true"></i>

                                    <i class="fa fa-server" aria-hidden="true"></i>

                                    <i class="fa fa-share" aria-hidden="true"></i>

                                    <i class="fa fa-share-alt" aria-hidden="true"></i>

                                    <i class="fa fa-share-alt-square" aria-hidden="true"></i>

                                    <i class="fa fa-share-square" aria-hidden="true"></i>

                                    <i class="fa fa-share-square-o" aria-hidden="true"></i>

                                    <i class="fa fa-shield" aria-hidden="true"></i>

                                    <i class="fa fa-ship" aria-hidden="true"></i>

                                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>

                                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>

                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>

                                    <i class="fa fa-shower" aria-hidden="true"></i>

                                    <i class="fa fa-sign-in" aria-hidden="true"></i>

                                    <i class="fa fa-sign-language" aria-hidden="true"></i>

                                    <i class="fa fa-sign-out" aria-hidden="true"></i>

                                    <i class="fa fa-signal" aria-hidden="true"></i>

                                    <i class="fa fa-signing" aria-hidden="true"></i>

                                    <i class="fa fa-sitemap" aria-hidden="true"></i>

                                    <i class="fa fa-sliders" aria-hidden="true"></i>

                                    <i class="fa fa-smile-o" aria-hidden="true"></i>

                                    <i class="fa fa-snowflake-o" aria-hidden="true"></i>

                                    <i class="fa fa-soccer-ball-o" aria-hidden="true"></i>

                                    <i class="fa fa-sort" aria-hidden="true"></i>

                                    <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>

                                    <i class="fa fa-sort-alpha-desc" aria-hidden="true"></i>

                                    <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>

                                    <i class="fa fa-sort-amount-desc" aria-hidden="true"></i>

                                    <i class="fa fa-sort-asc" aria-hidden="true"></i>

                                    <i class="fa fa-sort-desc" aria-hidden="true"></i>

                                    <i class="fa fa-sort-down" aria-hidden="true"></i>

                                    <i class="fa fa-sort-numeric-asc" aria-hidden="true"></i>

                                    <i class="fa fa-sort-numeric-desc" aria-hidden="true"></i>

                                    <i class="fa fa-sort-up" aria-hidden="true"></i>

                                    <i class="fa fa-space-shuttle" aria-hidden="true"></i>

                                    <i class="fa fa-spinner" aria-hidden="true"></i>

                                    <i class="fa fa-spoon" aria-hidden="true"></i>

                                    <i class="fa fa-square" aria-hidden="true"></i>

                                    <i class="fa fa-square-o" aria-hidden="true"></i>

                                    <i class="fa fa-star" aria-hidden="true"></i>

                                    <i class="fa fa-star-half" aria-hidden="true"></i>

                                    <i class="fa fa-star-half-empty" aria-hidden="true"></i>

                                    <i class="fa fa-star-half-full" aria-hidden="true"></i>

                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>

                                    <i class="fa fa-star-o" aria-hidden="true"></i>

                                    <i class="fa fa-sticky-note" aria-hidden="true"></i>

                                    <i class="fa fa-sticky-note-o" aria-hidden="true"></i>

                                    <i class="fa fa-street-view" aria-hidden="true"></i>

                                    <i class="fa fa-suitcase" aria-hidden="true"></i>

                                    <i class="fa fa-sun-o" aria-hidden="true"></i>

                                    <i class="fa fa-support" aria-hidden="true"></i>

                                    <i class="fa fa-tablet" aria-hidden="true"></i>

                                    <i class="fa fa-tachometer" aria-hidden="true"></i>

                                    <i class="fa fa-tag" aria-hidden="true"></i>

                                    <i class="fa fa-tags" aria-hidden="true"></i>

                                    <i class="fa fa-tasks" aria-hidden="true"></i>

                                    <i class="fa fa-taxi" aria-hidden="true"></i>

                                    <i class="fa fa-television" aria-hidden="true"></i>

                                    <i class="fa fa-terminal" aria-hidden="true"></i>

                                    <i class="fa fa-thermometer" aria-hidden="true"></i>

                                    <i class="fa fa-thermometer-0" aria-hidden="true"></i>

                                    <i class="fa fa-thermometer-1" aria-hidden="true"></i>

                                    <i class="fa fa-thermometer-2" aria-hidden="true"></i>

                                    <i class="fa fa-thermometer-3" aria-hidden="true"></i>

                                    <i class="fa fa-thermometer-4" aria-hidden="true"></i>

                                    <i class="fa fa-thermometer-empty" aria-hidden="true"></i>

                                    <i class="fa fa-thermometer-full" aria-hidden="true"></i>

                                    <i class="fa fa-thermometer-half" aria-hidden="true"></i>

                                    <i class="fa fa-thermometer-quarter" aria-hidden="true"></i>

                                    <i class="fa fa-thermometer-three-quarters" aria-hidden="true"></i>

                                    <i class="fa fa-thumb-tack" aria-hidden="true"></i>

                                    <i class="fa fa-thumbs-down" aria-hidden="true"></i>

                                    <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>

                                    <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>

                                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>

                                    <i class="fa fa-ticket" aria-hidden="true"></i>

                                    <i class="fa fa-times" aria-hidden="true"></i>

                                    <i class="fa fa-times-circle" aria-hidden="true"></i>

                                    <i class="fa fa-times-circle-o" aria-hidden="true"></i>

                                    <i class="fa fa-times-rectangle" aria-hidden="true"></i>

                                    <i class="fa fa-times-rectangle-o" aria-hidden="true"></i>

                                    <i class="fa fa-tint" aria-hidden="true"></i>

                                    <i class="fa fa-toggle-down" aria-hidden="true"></i>

                                    <i class="fa fa-toggle-left" aria-hidden="true"></i>

                                    <i class="fa fa-toggle-off" aria-hidden="true"></i>

                                    <i class="fa fa-toggle-on" aria-hidden="true"></i>

                                    <i class="fa fa-toggle-right" aria-hidden="true"></i>

                                    <i class="fa fa-toggle-up" aria-hidden="true"></i>

                                    <i class="fa fa-trademark" aria-hidden="true"></i>

                                    <i class="fa fa-trash" aria-hidden="true"></i>

                                    <i class="fa fa-trash-o" aria-hidden="true"></i>

                                    <i class="fa fa-tree" aria-hidden="true"></i>

                                    <i class="fa fa-trophy" aria-hidden="true"></i>

                                    <i class="fa fa-truck" aria-hidden="true"></i>

                                    <i class="fa fa-tty" aria-hidden="true"></i>

                                    <i class="fa fa-tv" aria-hidden="true"></i>

                                    <i class="fa fa-umbrella" aria-hidden="true"></i>

                                    <i class="fa fa-universal-access" aria-hidden="true"></i>

                                    <i class="fa fa-university" aria-hidden="true"></i>

                                    <i class="fa fa-unlock" aria-hidden="true"></i>

                                    <i class="fa fa-unlock-alt" aria-hidden="true"></i>

                                    <i class="fa fa-unsorted" aria-hidden="true"></i>

                                    <i class="fa fa-upload" aria-hidden="true"></i>

                                    <i class="fa fa-user" aria-hidden="true"></i>

                                    <i class="fa fa-user-circle" aria-hidden="true"></i>

                                    <i class="fa fa-user-circle-o" aria-hidden="true"></i>

                                    <i class="fa fa-user-o" aria-hidden="true"></i>

                                    <i class="fa fa-user-plus" aria-hidden="true"></i>

                                    <i class="fa fa-user-secret" aria-hidden="true"></i>

                                    <i class="fa fa-user-times" aria-hidden="true"></i>

                                    <i class="fa fa-users" aria-hidden="true"></i>

                                    <i class="fa fa-vcard" aria-hidden="true"></i>

                                    <i class="fa fa-vcard-o" aria-hidden="true"></i>

                                    <i class="fa fa-video-camera" aria-hidden="true"></i>

                                    <i class="fa fa-volume-control-phone" aria-hidden="true"></i>

                                    <i class="fa fa-volume-down" aria-hidden="true"></i>

                                    <i class="fa fa-volume-off" aria-hidden="true"></i>

                                    <i class="fa fa-volume-up" aria-hidden="true"></i>

                                    <i class="fa fa-warning" aria-hidden="true"></i>

                                    <i class="fa fa-wheelchair" aria-hidden="true"></i>

                                    <i class="fa fa-wheelchair-alt" aria-hidden="true"></i>

                                    <i class="fa fa-wifi" aria-hidden="true"></i>

                                    <i class="fa fa-window-close" aria-hidden="true"></i>

                                    <i class="fa fa-window-close-o" aria-hidden="true"></i>

                                    <i class="fa fa-window-maximize" aria-hidden="true"></i>

                                    <i class="fa fa-window-minimize" aria-hidden="true"></i>

                                    <i class="fa fa-window-restore" aria-hidden="true"></i>

                                    <i class="fa fa-wrench" aria-hidden="true"></i>

                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label" title="选择隐藏则菜单将不会出现在侧边栏，也没有权限被访问">菜单状态：<i class="fa fa-question-circle-o"></i></label>
				<div class="col-sm-3">
                    @foreach($sysShowList as $type)
                        <div class="radio-box">
                            <input type="radio" id="{{ $type->dict_code }}" name="visible" value="{{ $type->dict_value }}" @if($type->dict_value == $menu->visible) checked @endif>
                            <label for="{{ $type->dict_code }}">{{ $type->dict_label }}</label>
                        </div>
                    @endforeach
				</div>
{{--				<label class="col-sm-2 control-label is-refresh" title="打开菜单选项卡是否刷新页面">是否刷新：<i class="fa fa-question-circle-o"></i></label>--}}
{{--				<div class="col-sm-3 is-refresh">--}}
{{--				    <div class="radio-box">--}}
{{--						<input type="radio" id="refresh-no" name="isRefresh" value="1" checked>--}}
{{--						<label for="refresh-no">否</label>--}}
{{--					</div>--}}
{{--					<div class="radio-box">--}}
{{--						<input type="radio" id="refresh-yes" name="isRefresh" value="0">--}}
{{--						<label for="refresh-yes">是</label>--}}
{{--					</div>--}}
{{--				</div>--}}
			</div>
            <div class="form-group">
                <label class="col-sm-3 control-label is-required" title="字段管理，按照','隔开">字段管理：<i class="fa fa-question-circle-o"></i></label>
                <div class="col-sm-8">
                    <textarea id="projectKey" name="projectKey" maxlength="500" class="form-control" rows="3" placeholder="字段管理，按照英文','隔开，最少需要5个，例如 设备编号,设备名称,设备状态">{{ $columnsText }}</textarea>
                </div>
            </div>
		</form>
	</div>

    @include("admin.include.footer")

    <script>
        var prefix = ctx + "project/menu/{{ $project->project_id }}";

        function submitHandler() {
	        if ($.validate.form()) {
	            $.operate.save(prefix + "/edit", $('#form-menu-edit').serialize());
	        }
	    }

        $(function() {

        	$("input[name='icon']").focus(function() {
                $(".icon-drop").show();
            });

        	$("#form-menu-edit").click(function(event) {
        	    var obj = event.srcElement || event.target;
        	    if (!$(obj).is("input[name='icon']")) {
        	    	$(".icon-drop").hide();
        	    }
        	});

            $(".icon-drop").find(".ico-list i").off("click").on("click", function () {
                $('#icon').val($(this).attr('class'));
            });

            var menuType = $('input[name="menuType"]:checked').val();
            menuVisible(menuType);

        	$('input').on('ifChecked', function(event){
        		var menuType = $(event.target).val();
                menuVisible(menuType);
        	});
        });

        function menuVisible(menuType) {
            if (menuType == "M") {
                $("#url").parents(".form-group").hide();
                $("#perms").parents(".form-group").hide();
                $("#icon").parents(".form-group").show();
                $("#target").parents(".form-group").hide();
                $("#projectKey").parents(".form-group").hide();
                $("input[name='url']").val("#");
                $("input[name='class']").val("");
                $("input[name='visible']").parents(".form-group").show();
                $(".is-refresh").hide();
            } else if (menuType == "C") {
                $("#url").parents(".form-group").show();
                $("#perms").parents(".form-group").show();
                $("#icon").parents(".form-group").hide();
                $("#target").parents(".form-group").show();
                $("#projectKey").parents(".form-group").show();
                $("input[name='url']").val("#");
                $("input[name='class']").val("menuItemShot");
                $("input[name='visible']").parents(".form-group").show();
                $(".is-refresh").show();
            } else if (menuType == "F") {
                $("#url").parents(".form-group").hide();
                $("#perms").parents(".form-group").show();
                $("#icon").parents(".form-group").hide();
                $("#target").parents(".form-group").hide();
                $("#projectKey").parents(".form-group").hide();
                $("input[name='url']").val("#");
                $("input[name='class']").val("");
                $("input[name='visible']").parents(".form-group").hide();
                $(".is-refresh").hide();
            }
        }

        /*菜单管理-新增-选择菜单树*/
        function selectMenuTree() {
        	var treeId = $("#treeId").val();
        	var menuId = treeId > 0 ? treeId : 0;
        	var url = prefix + "/tree/" + menuId;
			var options = {
				title: '菜单选择',
				width: "380",
				url: url,
				callBack: doSubmit
			};
			$.modal.openOptions(options);
		}

		function doSubmit(index, layero){
			var body = $.modal.getChildFrame(index);
   			$("#treeId").val(body.find('#treeId').val());
   			$("#treeName").val(body.find('#treeName').val());
   			$.modal.close(index);
		}
    </script>
</body>
</html>
