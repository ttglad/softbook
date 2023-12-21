<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('admin.include.header', ['title' => '服务器监控'])
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content">
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-microchip"></i> CPU</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-hover no-margins">
                            <thead>
                            <tr>
                                <th>属性</th>
                                <th>值</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>核心数</td>
                                <td>{{ sizeof($cpu) }}个</td>
                            </tr>
                            @foreach($cpu as $i => $item)
                                <tr>
                                    <td>cpu-{{ $i }}</td>
                                    <td>{{ $item['Model'] }} - {{ @$item['MHz'] }}HZ</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-ticket"></i> 内存</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            <a class="close-link"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-hover no-margins">
                            <thead>
                            <tr>
                                <th>属性</th>
                                <th>内存</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>总内存</td>
                                <td>{{ $ram['totalSize'] }}</td>
                            </tr>
                            <tr>
                                <td>已用内存</td>
                                <td>{{ $ram['useSize'] }}</td>
                            </tr>
                            <tr>
                                <td>剩余内存</td>
                                <td>{{ $ram['freeSize'] }}</td>
                            </tr>
                            <tr>
                                <td>使用率</td>
                                <td>{{ number_format(($ram['total'] - $ram['free']) * 100 / $ram['total'], 2) }}%</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-windows"></i> 服务器信息</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover margin bottom">
                                    <tbody>
                                    <tr>
                                        <td>服务器名称</td>
                                        <td>{{ $hostName }}</td>
                                        <td>操作系统</td>
                                        <td>{{ $os }}</td>
                                    </tr>
                                    <tr>
                                        <td>服务器IP</td>
                                        <td>{{ $accessedIp }}</td>
                                        <td>系统架构</td>
                                        <td>{{ $cpuArchitecture }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-coffee"></i> 项目信息</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-hover margin bottom" style="table-layout:fixed;">
                                    <tbody>
                                    <tr>
                                        <td>语言名称</td>
                                        <td>PHP</td>
                                        <td>PHP版本</td>
                                        <td>{{ $phpVersion }}</td>
                                    </tr>
                                    <tr>
                                        <td>启动时间</td>
                                        <td>{{ date('Y-m-d H:i:s', $upTime['bootedTimestamp']) }}</td>
                                        <td>运行时长</td>
                                        <td>{{ $upTime['text'] }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">web服务器</td>
                                        <td colspan="3">{{ $webService }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="1">项目路径</td>
                                        <td colspan="3">{{ $documentRoot }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

@include("admin.include.footer")

<script>
    $(".modal").appendTo("body"), $("[data-toggle=popover]").popover(), $(".collapse-link").click(function() {
        var div_ibox = $(this).closest("div.ibox"),
            e = $(this).find("i"),
            i = div_ibox.find("div.ibox-content");
        i.slideToggle(200),
            e.toggleClass("fa-chevron-up").toggleClass("fa-chevron-down"),
            div_ibox.toggleClass("").toggleClass("border-bottom"),
            setTimeout(function() {
                div_ibox.resize();
            }, 50);
    }), $(".close-link").click(function () {
        var div_ibox = $(this).closest("div.ibox");
        div_ibox.remove()
    });
</script>
</html>
