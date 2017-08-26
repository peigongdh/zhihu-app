<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Api Token -->
    <meta name="api-token" content="{{ Auth::check() ? 'Bearer ' . Auth::user()->api_token : 'Bearer ' }}">

    <title>{{ config('app.name', 'Zhihu') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            padding-top: 70px;
        }
    </style>

    <script>
        @if (Auth::check())
            window.Zhihu = {
            name: "{{ Auth::user()->name }}",
            avatar: "{{ Auth::user()->avatar }}"
        };
        @endif
    </script>
</head>
<body>
<div id="app">
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{ route('timeline') }}">时间线</a>
                    </li>
                    <li>
                        <a href="{{ url('question') }}">提问</a>
                    </li>
                </ul>

                <form class="navbar-form navbar-left" style="margin-top: 10px;">
                    <div class="form-group input-group-sm">
                        <input type="text" class="form-control" name="search" placeholder="搜索">
                    </div>
                </form>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::check())
                        <li><a href="{{ route('notification') }}"><span class="glyphicon glyphicon-bell"></span></a>
                        </li>
                        <li><a href="{{ route('message') }}"><span class="glyphicon glyphicon-comment"></span></a></li>
                    @endif
                    @if (Auth::guest())
                        <li><a href="{{ route('login') }}">登录</a></li>
                        <li><a href="{{ route('register') }}">注册</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('user', ['id' => Auth::id() ]) }}">主页</a>
                                    <a href="{{ route('setting_info') }}">设置</a>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        退出
                                    </a>

                                    <form id="logout-form" action="{{ url('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @include('flash::message')
    </div>

    @yield('content')
</div>

<footer class="main">
    <div class="container">
        <p>
            Power by
            <a href="https://github.com/peigongDH/zhihu-app">zhihu-app</a>
        </p>
    </div>
</footer>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
<script>
    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
</script>
</body>
</html>
