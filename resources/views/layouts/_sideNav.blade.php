@extends('layouts._default')
@section('content')
    <div class="col-md-2 sideNav">
        <ul type="none" class="nav nav-pills nav-stacked">
            <li><a href="{{ route($item.'.retrieve'.'Page',$item) }}"><img src="/retrieve_24.ico" alt="查询"
                                                                           class="navbar-ico">查询{{ $itemChinese[$item] }}
                    信息</a></li>
            @if(Auth::check()&&Auth::user()->permission_token<2)
                <li><a href="{{ route($item.'.entry'.'Page',$item) }}"><img src="/plus_24px.ico" alt="录入"
                                                                            class="navbar-ico">录入{{$itemChinese[$item]}}
                        信息</a></li>
                @if($item=='agency')
                    @if(Auth::check()&&Auth::user()->permission_token<1)
                        <li><a href="{{ route($item.'.modify'.'Page',$item) }}"><img src="/Gear_24px.ico" alt="删改"
                                                                                     class="navbar-ico">删改{{$itemChinese[$item]}}
                                信息</a></li>
                    @endif
                @else
                    <li><a href="{{ route($item.'.modify'.'Page',$item) }}"><img src="/Gear_24px.ico" alt="删改"
                                                                                 class="navbar-ico">删改{{$itemChinese[$item]}}
                            信息</a></li>
                @endif
            @endif
            <li><a href="{{ route($item.'.browse'.'Page',$item) }}">{{ $itemChinese[$item] }}信息瀏覽</a></li>
            @if($item=='medicinefalse')
                <li><a href="{{ route('medicine.total') }}">近30天销量最高的3种药物</a></li>
            @endif
        </ul>
    </div>
    @yield('rightContent')
@endsection
