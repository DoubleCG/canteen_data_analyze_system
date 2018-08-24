<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>戈子餐饮管理系统</title>

    <link rel="icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/icono.min.css">
  <script src="js/app.js" defer></script>
    <link href="css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    戈子餐饮管理系统
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    @guest
                    @else
                    <!-- TOP-left NAV -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown" style='cursor:pointer'>
                            <a class="nav-link" data-route='client' @click='viewRouter'>
                                客流
                            </a>
                        </li>

                        <li class="nav-item dropdown" style='cursor:pointer'>
                            <a class="nav-link" data-route='finance' @click='viewRouter'>
                                经济
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                查询<span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a style='cursor:pointer' class="dropdown-item" data-route='orderCheck' @click='viewRouter'>订单查询</a>
                                <a style='cursor:pointer' class="dropdown-item" data-route='orderDetail' @click='viewRouter'>详单查询</a>
                                <a style='cursor:pointer' class="dropdown-item" data-route='popular' @click='viewRouter'>热度查询</a>
                                <a style='cursor:pointer' class="dropdown-item" data-route='sales' @click='viewRouter'>销量查询</a>
                            </div>
                        </li>







                        <!-- 暂不开放 -->
                        <li class="nav-item dropdown" style='display: none'>
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                售卖<span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a style='hover:pointer' class="dropdown-item" data-route='foodDetail' @click='viewRouter'>食材数据</a>
                                <a style='hover:pointer' class="dropdown-item" data-route='meatAndVege' @click='viewRouter'>肉类蔬菜</a>
                                <a style='hover:pointer' class="dropdown-item" data-route='platePrice' @click='viewRouter'>餐盘定价</a>
                                <a style='hover:pointer' class="dropdown-item" data-route='popularTop5' @click='viewRouter'>热度前五</a>
                                <a style='hover:pointer' class="dropdown-item" data-route='salesAnal' @click='viewRouter'>售卖分析</a>
                                 <div class="dropdown-divider"></div>
                                <a style='hover:pointer' class="dropdown-item" data-route='basicInfo' @click='viewRouter'>基本信息</a>
                                <a style='hover:pointer' class="dropdown-item" data-route='bestPartner' @click='viewRouter'>最佳套餐</a>
                                <a style='hover:pointer' class="dropdown-item" data-route='history' @click='viewRouter'>历史记录</a>
                                <a style='hover:pointer' class="dropdown-item" data-route='historyDetail' @click='viewRouter'>历史细节</a>
                                <a style='hover:pointer' class="dropdown-item" data-route='salesSearch' @click='viewRouter'>售卖查询</a>
                            </div>
                        </li>


                    </ul>
                    @endguest

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item" style='display:none'>
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item" style='display:none'>
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        登出
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
