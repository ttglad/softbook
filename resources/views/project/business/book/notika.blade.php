<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>系统首页 - {{ $project->project_title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="/vendors/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="/vendors/font-awesome/5.15.4/css/fontawesome.min.css">
    <link rel="stylesheet" href="/theme/notika/css/owl.carousel.css">
    <link rel="stylesheet" href="/theme/notika/css/owl.theme.css">
    <link rel="stylesheet" href="/theme/notika/css/owl.transitions.css">
    <link rel="stylesheet" href="/theme/notika/css/meanmenu/meanmenu.min.css">
    <link rel="stylesheet" href="/theme/notika/css/animate.css">
    <link rel="stylesheet" href="/theme/notika/css/normalize.css">
    <link rel="stylesheet" href="/theme/notika/css/notika-custom-icon.css">
    <link rel="stylesheet" href="/theme/notika/css/wave/waves.min.css">
    <link rel="stylesheet" href="/theme/notika/css/main.css">
    <link rel="stylesheet" href="/theme/notika/css/style.css">
    <link rel="stylesheet" href="/theme/notika/css/responsive.css">
</head>
<body>
<!-- Start Header Top Area -->
<div class="header-top-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="logo-area">
                    <h3>{{ $project->project_title }}</h3>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="header-top-menu">
                    <ul class="nav navbar-nav notika-top-nav">
                        <li class="nav-item dropdown">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                               class="nav-link dropdown-toggle"><span><i
                                        class="notika-icon notika-search"></i></span></a>
                            <div role="menu" class="dropdown-menu search-dd animated flipInX">
                                <div class="search-input">
                                    <i class="notika-icon notika-left-arrow"></i>
                                    <input type="text"/>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                               class="nav-link dropdown-toggle"><span><i class="notika-icon notika-mail"></i></span></a>
                            <div role="menu" class="dropdown-menu message-dd animated zoomIn">
                                <div class="hd-mg-tt">
                                    <h2>Messages</h2>
                                </div>
                                <div class="hd-message-info">
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="" alt=""/>
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>David Belle</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="" alt=""/>
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>Jonathan Morris</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="" alt=""/>
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>Fredric Mitchell</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="" alt=""/>
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>David Belle</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="" alt=""/>
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>Glenn Jecobs</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="hd-mg-va">
                                    <a href="#">View All</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item nc-al"><a href="#" data-toggle="dropdown" role="button"
                                                      aria-expanded="false" class="nav-link dropdown-toggle"><span><i
                                        class="notika-icon notika-alarm"></i></span>
                                <div class="spinner4 spinner-4"></div>
                                <div class="ntd-ctn"><span>{{ rand(1, 10) }}</span></div>
                            </a>
                            <div role="menu" class="dropdown-menu message-dd notification-dd animated zoomIn">
                                <div class="hd-mg-tt">
                                    <h2>Notification</h2>
                                </div>
                                <div class="hd-message-info">
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="" alt=""/>
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>David Belle</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="" alt=""/>
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>Jonathan Morris</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="" alt=""/>
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>Fredric Mitchell</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="" alt=""/>
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>David Belle</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="" alt=""/>
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>Glenn Jecobs</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="hd-mg-va">
                                    <a href="#">View All</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                                                class="nav-link dropdown-toggle"><span><i
                                        class="notika-icon notika-menus"></i></span>
                                <div class="spinner4 spinner-4"></div>
                                <div class="ntd-ctn"><span>2</span></div>
                            </a>
                            <div role="menu" class="dropdown-menu message-dd task-dd animated zoomIn">
                                <div class="hd-mg-tt">
                                    <h2>Tasks</h2>
                                </div>
                                <div class="hd-message-info hd-task-info">
                                    <div class="skill">
                                        <div class="progress">
                                            <div class="lead-content">
                                                <p>HTML5 Validation Report</p>
                                            </div>
                                            <div class="progress-bar wow fadeInLeft" data-progress="95%"
                                                 style="width: 95%;" data-wow-duration="1.5s" data-wow-delay="1.2s">
                                                <span>95%</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="lead-content">
                                                <p>Google Chrome Extension</p>
                                            </div>
                                            <div class="progress-bar wow fadeInLeft" data-progress="85%"
                                                 style="width: 85%;" data-wow-duration="1.5s" data-wow-delay="1.2s">
                                                <span>85%</span></div>
                                        </div>
                                        <div class="progress">
                                            <div class="lead-content">
                                                <p>Social Internet Projects</p>
                                            </div>
                                            <div class="progress-bar wow fadeInLeft" data-progress="75%"
                                                 style="width: 75%;" data-wow-duration="1.5s" data-wow-delay="1.2s">
                                                <span>75%</span></div>
                                        </div>
                                        <div class="progress">
                                            <div class="lead-content">
                                                <p>Bootstrap Admin</p>
                                            </div>
                                            <div class="progress-bar wow fadeInLeft" data-progress="93%"
                                                 style="width: 65%;" data-wow-duration="1.5s" data-wow-delay="1.2s">
                                                <span>65%</span></div>
                                        </div>
                                        <div class="progress progress-bt">
                                            <div class="lead-content">
                                                <p>Youtube App</p>
                                            </div>
                                            <div class="progress-bar wow fadeInLeft" data-progress="55%"
                                                 style="width: 55%;" data-wow-duration="1.5s" data-wow-delay="1.2s">
                                                <span>55%</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hd-mg-va">
                                    <a href="#">View All</a>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                                                class="nav-link dropdown-toggle"><span><i
                                        class="notika-icon notika-chat"></i></span></a>
                            <div role="menu" class="dropdown-menu message-dd chat-dd animated zoomIn">
                                <div class="hd-mg-tt">
                                    <h2>Chat</h2>
                                </div>
                                <div class="search-people">
                                    <i class="notika-icon notika-left-arrow"></i>
                                    <input type="text" placeholder="Search People"/>
                                </div>
                                <div class="hd-message-info">
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img chat-img">
                                                <img src="" alt=""/>
                                                <div class="chat-avaible"><i class="notika-icon notika-dot"></i></div>
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>David Belle</h3>
                                                <p>Available</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img chat-img">
                                                <img src="" alt=""/>
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>Jonathan Morris</h3>
                                                <p>Last seen 3 hours ago</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img chat-img">
                                                <img src="" alt=""/>
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>Fredric Mitchell</h3>
                                                <p>Last seen 2 minutes ago</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img chat-img">
                                                <img src="" alt=""/>
                                                <div class="chat-avaible"><i class="notika-icon notika-dot"></i></div>
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>David Belle</h3>
                                                <p>Available</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img chat-img">
                                                <img src="" alt=""/>
                                                <div class="chat-avaible"><i class="notika-icon notika-dot"></i></div>
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>Glenn Jecobs</h3>
                                                <p>Available</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="hd-mg-va">
                                    <a href="#">View All</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Header Top Area -->
<!-- Main Menu area start-->
<div class="main-menu-area mg-tb-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                    <li>
                        <a data-toggle="tab" href="#home-base">
                            <i class="notika-icon notika-house"></i> 系统首页
                        </a>
                    </li>
                    @foreach($menus as $firstMenu)
                        <li @isset($firstMenu['check']) class="active" @endisset>
                            <a data-toggle="tab" href="#home-{{ $firstMenu['menu_id'] }}">
                                @if ($firstMenu['menu_id'] == 1)
                                    <i class="notika-icon notika-settings"></i>
                                @elseif ($firstMenu['menu_id'] == 2)
                                    <i class="notika-icon notika-eye"></i>
                                @elseif (!empty($firstMenu['icon']))
                                    <i class="notika-icon notika-{{ $firstMenu['icon'] }}"></i>
                                @else
                                    <i class="notika-icon notika-menus"></i>
                                @endif
                                {{ $firstMenu['menu_name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content custom-menu-content">
                    <div id="home-base" class="tab-pane notika-tab-menu-bg animated flipInX">
                        <ul class="notika-main-menu-dropdown">
                            <li class="nav-item">
                                <a class="nav-link" href="/">
                                    <span class="menu-title">系统首页</span>
                                    <i class="mdi mdi-home menu-icon"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    @foreach($menus as $firstMenu)
                        @if(isset($firstMenu['children']) && count($firstMenu['children']) > 0)
                            <div id="home-{{ $firstMenu['menu_id'] }}" class="tab-pane @isset($firstMenu['check']) in active @endif notika-tab-menu-bg animated flipInX">
                                <ul class="notika-main-menu-dropdown">
                                    @foreach($firstMenu['children'] as $secondMenu)
                                        <li class="nav-item">
                                            <a href="/project/book/{{ $secondMenu['menu_id'] }}" class="nav-link">
                                                <span class="menu-title">{{ $secondMenu['menu_name'] }}</span>
                                                <i class="mdi menu-icon"></i>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div id="home-{{ $firstMenu['menu_id'] }}" class="tab-pane @isset($firstMenu['check']) in active @endif notika-tab-menu-bg animated flipInX">
                                <ul class="notika-main-menu-dropdown">
                                    <li class="nav-item">
                                        <a class="nav-link" href="/">
                                            <span class="menu-title">{{ $firstMenu['menu_name'] }}</span>
                                            <i class="mdi menu-icon"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Menu area End-->
<!-- Normal Table area Start-->
<div class="normal-table-area">
    <div class="container">
        @if(in_array($business->data_type, ['chart-01', 'chart-02', 'chart-03']))
            @include('project.business.chart.base-' . $business->data_type, compact('business', 'businessColumn'))
        @else
            @include('project.business.list.notika', compact('business', 'businessColumn'))
        @endif
    </div>
</div>
<!-- Normal Table area End-->
<!-- Start Footer area-->
<div class="footer-copyright-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="footer-copy-right">
                    <p>Copyright © {{ date('Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Footer area-->
<!-- jquery
    ============================================ -->
<script src="/vendors/jquery/1.12.4/jquery.min.js"></script>
<!-- bootstrap JS
    ============================================ -->
<script src="/vendors/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- wow JS
    ============================================ -->
<script src="/theme/notika/js/wow.min.js"></script>
<!-- price-slider JS
    ============================================ -->
<script src="/theme/notika/js/jquery-price-slider.js"></script>
<!-- owl.carousel JS
    ============================================ -->
<script src="/theme/notika/js/owl.carousel.min.js"></script>
<!-- scrollUp JS
    ============================================ -->
<script src="/theme/notika/js/jquery.scrollUp.min.js"></script>
<!-- meanmenu JS
    ============================================ -->
<script src="/theme/notika/js/meanmenu/jquery.meanmenu.js"></script>
<!-- counterup JS
    ============================================ -->
<script src="/theme/notika/js/counterup/jquery.counterup.min.js"></script>
<script src="/theme/notika/js/counterup/waypoints.min.js"></script>
<script src="/theme/notika/js/counterup/counterup-active.js"></script>
<!-- mCustomScrollbar JS
    ============================================ -->
<script src="/theme/notika/js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<!-- jvectormap JS
    ============================================ -->
<script src="/theme/notika/js/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="/theme/notika/js/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="/theme/notika/js/jvectormap/jvectormap-active.js"></script>
<!-- sparkline JS
    ============================================ -->
<script src="/theme/notika/js/sparkline/jquery.sparkline.min.js"></script>
<script src="/theme/notika/js/sparkline/sparkline-active.js"></script>
<!-- sparkline JS
    ============================================ -->
<script src="/theme/notika/js/flot/jquery.flot.js"></script>
<script src="/theme/notika/js/flot/jquery.flot.resize.js"></script>
<script src="/theme/notika/js/flot/curvedLines.js"></script>
<script src="/theme/notika/js/flot/flot-active.js"></script>
<!--  wave JS
    ============================================ -->
<script src="/theme/notika/js/wave/waves.min.js"></script>
<script src="/theme/notika/js/wave/wave-active.js"></script>
<!--
    ============================================ -->
{{--<script src="js/todo/jquery.todo.js"></script>--}}
<!-- plugins JS
    ============================================ -->
{{--<script src="js/plugins.js"></script>--}}
<!--  Chat JS
    ============================================ -->
{{--<script src="js/chat/moment.min.js"></script>--}}
{{--<script src="js/chat/jquery.chat.js"></script>--}}
<!-- main JS
    ============================================ -->
<script src="/theme/notika/js/main.js"></script>
<!-- tawk chat JS
    ============================================ -->
{{--<script src="js/tawk-chat.js"></script>--}}

<!-- endinject -->
<!-- Custom js for this page -->
<!-- End custom js for this page -->
<script src="/static/softbook/js/home.js"></script>

<!-- endinject -->
<!-- Custom js for this page -->
<!-- End custom js for this page -->

@include('project.business.include.modal-notika', compact('business', 'businessColumn'))

</body>
</html>
