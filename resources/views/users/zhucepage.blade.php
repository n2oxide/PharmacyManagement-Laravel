@extends('layouts._default')
@section('content')
<form class="" action="{{route('register')}}" method="post">
  {{ csrf_field() }}
 <div class="">
   <span>电话号码：</span><input type="text" name="phone" value="{{ old('phone') }}"/>
 </div>
 <div class="">
   <span>名字：</span><input type="text" name="name" value="{{ old('name') }}"/>
 </div>
 <div class="">
   <span>性别：</span><input type="text" name="sex" value="{{ old('sex') }}"/>
 </div>
 <div class="">
   <span>密码：</span><input type="password" name="password" />
 </div>
 <div class="">
   <span>确认密码：</span><input type="password" name="password_confirmation" />
 </div>
 <button type="submit" name="btn">注册</button>
</form>
@endsection
