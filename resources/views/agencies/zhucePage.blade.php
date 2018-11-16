@extends('layouts._sideNav',['item'=>'agency'],['itemChinese'=>[
'client' => '顾客',
'medicine' => '药物',
'agency' => '经办人',
'orderForm' => '订单'
]])
@section('rightContent')
    <div class="col-md-10">
        <fieldset>
            <legend>经办人基本信息</legend>
            <form class="col-md-12" action="{{route('agency.entry')}}" method="post" id="user">
                {{ csrf_field() }}
                @include('agencies.agencyInformation')
                <li>
                    <label>密码：</label><input type="password" name="password" id="password"
                                                                class="agencyInformation"/>
                </li>

                <li>
                    <label>确认密码：</label><input type="password" name="password_confirmation" id="password_confirmation"
                                               class="agencyInformation"/>
                </li>

                <li class="col-md-12">
                    <button type="submit" name="button" class="btn btn-danger">录入经办人信息</button>
                </li>
            </ul>
            </form>
        </fieldset>
    </div>
    <script>
        $(document).ready(function () {
            $('.agencyInformation').each(function () {
                $(this).attr('disabled',false);
            });
        });
    </script>
@endsection
