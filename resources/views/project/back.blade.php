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

        .list-unstyled {
            overflow-y: scroll;
            height: 400px;
        }
    </style>
</head>
<body class="gray-bg">
<ul class="list-unstyled clearfix">
    @foreach($loginImages as $image)
        <li style="float:left; width: 33.33333%; padding: 5px;" data-image="{{ $image['value'] }}">
            <image src="{{ $image['value'] }}" style="width: 100%; height: 120px;"/>
            <p class="text-center">{{ $image['name'] }}</p>
        </li>
    @endforeach
</ul>
</body>
<script src="/static/js/jquery.min.js"></script>
<script src="/static/ruoyi/js/common.js?v=4.7.7"></script>
<script type="text/javascript">
    $("[data-image]").off('click').on('click',
        function (e) {
            var image = $(this).data('image');
            parent.$("input[name=loginImage]").val(image);
            index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
        });
</script>
</html>
