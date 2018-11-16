@extends('layouts._sideNav',['item'=>'client'],['itemChinese'=>[
'client' => '顾客',
'medicine' => '药物',
'agency' => '经办人',
'orderForm' => '订单'
]])
@section('rightContent')
    <div class="col-md-10">
        <fieldset>
            <legend>顾客基本信息</legend>
            <form class="col-md-12" action="{{route('client.entry')}}" method="post" id="user">
                {{ csrf_field() }}
                @include('clients.clientInformation')
                <li>
                    <label>密码：</label><input type="password" name="password"
                                                                class="clientInformation"/>
                </li>

                <li>
                    <label>确认密码：</label><input type="password" name="password_confirmation" class="clientInformation"/>
                </li>
                <li><label for="">备注</label><textarea type="text" name="remark" id="remark"
                                                      disabled="disabled" class="clientInformation" rows="4" cols="80" maxlength="50"></textarea></li>
                </ul>
                <div class="col-md-6">
                    <button type="submit" name="button" class="btn btn-danger">录入顾客信息</button>
                </div>
            </form>
        </fieldset>
    </div>
    <script>
        $('.clientInformation').each(function () {
            $(this).attr('disabled',false);
        });
    </script>
@endsection
