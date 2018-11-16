<!DOCTYPE HTML>
<head>
    <title>药店管理系统</title>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="/css/newApp.css"><!-- default folder in public/ -->
    <link rel="stylesheet" href="/css/myapp.css">
    <link rel="stylesheet" href="/css/lyz.calendar.css">
    <script src="/js/app.js"></script>
    <script src="/js/ydAjax.js"></script>
</head>
<body>
<div class="overCurtain"></div>
<nav class="navbar navbar-default head-nav" id="NAV">
    <span class="head-nav-ico">
        <img src="/medicine.gif" width="60;height=60;">
        <span>药物管理系统</span>
    </span>
    <div class="navbar-text navbar-right">
        <a href="{{ route('home') }}">主页</a>
        @if(Auth::check())
            @switch(Auth::user()->permission_token)
                @case (0) <a href="/client"><img src="/user_24px.ico" alt="管理用户信息" class="navbar-ico">管理用户信息</a>
                <a href="/medicine"><img src="/Pill_24px.ico" alt="管理药物信息" class="navbar-ico">管理药物信息</a>
                <a href="/agency"><img src="/agency_24px.ico" alt="管理经办人信息" class="navbar-ico">管理经办人信息</a>
                <a href="#">数据报表</a>
                @break
                @case (1) <a href="/entry/orderForm/page"><img src="/plus_24px.ico" alt="录入购药信息" class="navbar-ico">录入购药信息</a>
                <a href="{{ route('client.entryPage') }}"><img src="/plus_24px.ico" alt="录入顾客信息" class="navbar-ico">录入顾客信息</a>
                <a href="/client"><img src="/user_24px.ico" alt="管理用户信息" class="navbar-ico">管理用户信息</a>
                <a href="/medicine"><img src="/Pill_24px.ico" alt="管理药物信息" class="navbar-ico">管理药物信息</a>
                <a href="#">数据报表</a>
                @break
                @default <a href="{{ route('medicine.retrievePage') }}"><img src="/retrieve_24.ico" alt="查询药物" class="navbar-ico">查询药物</a>
                @break
            @endswitch
        @else
            <a href="{{ route('medicine.retrievePage') }}"><img src="/retrieve_24.ico" alt="查询药物" class="navbar-ico">查询药物</a>
        @endif
        @if(!Auth::check())
            <a id="login">登录</a>
        @else
            @if(isset(Auth::user()->ano)&&Auth::user()->ano!='')
                <span><a href="/modify/agency/page/{{ Auth::user()->ano }}">{{ Auth::user()->name }}<span style="font-size: 0.5em">个人页面</span></a></span>
            @else
                <span><a href="/modify/client/page/{{ Auth::user()->cno }}">{{ Auth::user()->name }}<span style="font-size: 0.5em">个人页面</span></a></span>
            @endif
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">退出</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        @endif
    </div>
</nav>
<div class="container">

    <div class="row">
        @if(!Auth::check())
            @include('layouts._loginForm',['display'=>'none'])
        @endif
        @include('layouts._messageBox')
        @yield('content')
    </div>
</div>
</body>
