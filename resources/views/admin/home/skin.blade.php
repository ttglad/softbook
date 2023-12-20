<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title>主题选择</title>
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html"/>
    <![endif]-->
    <link rel="shortcut icon" href="/static/favicon.ico"/>
    <link href="/static/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="/static/css/style.min.css" rel="stylesheet"/>
    <style type="text/css">
        .list-unstyled {
            margin: 10px;
        }

        .full-opacity-hover {
            opacity: 1;
            filter: alpha(opacity=1);
            border: 1px solid #fff
        }

        .full-opacity-hover:hover {
            border: 1px solid #f00;
        }
    </style>
</head>
<body class="gray-bg">
<ul class="list-unstyled clearfix">
    <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:" data-skin="skin-blue|theme-dark"
           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
            <span style="width: 20%; float: left; height: 13px; background: #367fa9"></span>
            <span style="width: 80%; float: left; height: 13px; background: #3c8dbc"></span>
            <span style="width: 20%; float: left; height: 30px; background: #2f4050"></span>
            <span style="width: 80%; float: left; height: 30px; background: #f4f5f7"></span>
        </a>
        <p class="text-center">蓝</p>
    </li>

    <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:" data-skin="skin-green|theme-dark"
           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
            <span style="width: 20%; float: left; height: 13px; background: #008d4c"></span>
            <span style="width: 80%; float: left; height: 13px; background: #00a65a"></span>
            <span style="width: 20%; float: left; height: 30px; background: #222d32"></span>
            <span style="width: 80%; float: left; height: 30px; background: #f4f5f7"></span>
        </a>
        <p class="text-center">绿</p>
    </li>

    <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:" data-skin="skin-purple|theme-dark"
           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
            <span style="width: 20%; float: left; height: 13px; background: #555299"></span>
            <span style="width: 80%; float: left; height: 13px; background: #605ca8"></span>
            <span style="width: 20%; float: left; height: 30px; background: #222d32"></span>
            <span style="width: 80%; float: left; height: 30px; background: #f4f5f7"></span>
        </a>
        <p class="text-center">紫</p>
    </li>

    <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:" data-skin="skin-red|theme-dark"
           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
            <span style="width: 20%; float: left; height: 13px; background: #dd4b39"></span>
            <span style="width: 80%; float: left; height: 13px; background: #d73925"></span>
            <span style="width: 20%; float: left; height: 30px; background: #222d32"></span>
            <span style="width: 80%; float: left; height: 30px; background: #f4f5f7"></span>
        </a>
        <p class="text-center">红</p>
    </li>

    <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:" data-skin="skin-yellow|theme-dark"
           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
            <span style="width: 20%; float: left; height: 13px; background: #f39c12"></span>
            <span style="width: 80%; float: left; height: 13px; background: #e08e0b"></span>
            <span style="width: 20%; float: left; height: 30px; background: #222d32"></span>
            <span style="width: 80%; float: left; height: 30px; background: #f4f5f7"></span>
        </a>
        <p class="text-center">黄</p>
    </li>

    <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:" data-skin="skin-blue|theme-light"
           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
            <span style="width: 20%; float: left; height: 13px; background: #367fa9"></span>
            <span style="width: 80%; float: left; height: 13px; background: #3c8dbc"></span>
            <span style="width: 20%; float: left; height: 30px; background: #f9fafc"></span>
            <span style="width: 80%; float: left; height: 30px; background: #f4f5f7"></span>
        </a>
        <p class="text-center">蓝灰</p>
    </li>

    <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:" data-skin="skin-green|theme-light"
           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
            <span style="width: 20%; float: left; height: 13px; background: #008d4c"></span>
            <span style="width: 80%; float: left; height: 13px; background: #00a65a"></span>
            <span style="width: 20%; float: left; height: 30px; background: #f9fafc"></span>
            <span style="width: 80%; float: left; height: 30px; background: #f4f5f7"></span>
        </a>
        <p class="text-center">绿灰</p>
    </li>

    <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:" data-skin="skin-purple|theme-light"
           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
            <span style="width: 20%; float: left; height: 13px; background: #555299"></span>
            <span style="width: 80%; float: left; height: 13px; background: #605ca8"></span>
            <span style="width: 20%; float: left; height: 30px; background: #f9fafc"></span>
            <span style="width: 80%; float: left; height: 30px; background: #f4f5f7"></span>
        </a>
        <p class="text-center">紫灰</p>
    </li>

    <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:" data-skin="skin-red|theme-light"
           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
            <span style="width: 20%; float: left; height: 13px; background: #dd4b39"></span>
            <span style="width: 80%; float: left; height: 13px; background: #d73925"></span>
            <span style="width: 20%; float: left; height: 30px; background: #f9fafc"></span>
            <span style="width: 80%; float: left; height: 30px; background: #f4f5f7"></span>
        </a>
        <p class="text-center">红灰</p>
    </li>

    <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:" data-skin="skin-yellow|theme-light"
           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
            <span style="width: 20%; float: left; height: 13px; background: #f39c12"></span>
            <span style="width: 80%; float: left; height: 13px; background: #e08e0b"></span>
            <span style="width: 20%; float: left; height: 30px; background: #f9fafc"></span>
            <span style="width: 80%; float: left; height: 30px; background: #f4f5f7"></span>
        </a>
        <p class="text-center">黄灰</p>
    </li>

    <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:" data-skin="skin-blue|theme-blue"
           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
            <span style="width: 20%; float: left; height: 13px; background: #367fa9"></span>
            <span style="width: 80%; float: left; height: 13px; background: #3c8dbc"></span>
            <span style="width: 20%; float: left; height: 30px; background: rgba(15,41,80,1)"></span>
            <span style="width: 80%; float: left; height: 30px; background: #f4f5f7"></span>
        </a>
        <p class="text-center">蓝浅（新）</p>
    </li>
    <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:" data-skin="skin-green|theme-blue"
           style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
            <span style="width: 20%; float: left; height: 13px; background: #008d4c"></span>
            <span style="width: 80%; float: left; height: 13px; background: #00a65a"></span>
            <span style="width: 20%; float: left; height: 30px; background: rgba(15,41,80,1)"></span>
            <span style="width: 80%; float: left; height: 30px; background: #f4f5f7"></span>
        </a>
        <p class="text-center">绿浅（新）</p>
    </li>
</ul>
</body>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/ruoyi/js/common.js?v=4.7.7"></script>
<script type="text/javascript">
    //皮肤样式列表
    var skins = ["skin-blue", "skin-green", "skin-purple", "skin-red", "skin-yellow"];

    // 主题样式列表
    var themes = ["theme-dark", "theme-light", "theme-blue"];

    $("[data-skin]").on('click',
        function (e) {
            var skin = $(this).data('skin');
            $.each(skins, function (i) {
                parent.$("body").removeClass(skins[i]);
            });
            $.each(themes, function (i) {
                parent.$("body").removeClass(themes[i]);
            });
            parent.$("body").addClass(skin.split('|')[0]);
            parent.$("body").addClass(skin.split('|')[1]);
            storage.set('skin', skin);
        });
</script>
</html>
