@extends('layouts._sideNav',['item'=>'client'],['itemChinese'=>[
'client' => '顾客',
'medicine' => '药物',
'agency' => '经办人',
'orderForm' => '订单'
]])
@section('rightContent')
    <div class="col-md-10">
        <div style="color:red;" id="retrieveStatus"></div>
        <fieldset>
            <legend>顾客基本信息</legend>
            <form action="" method="post" id="clientInformation-Form">
                {{ csrf_field() }}
                <input type="hidden" name="ajax" value="true"/>
                <input type="number" name="cno" class="cno" style="display: none">
                @include('clients.clientInformation')
                <li><label for="">备注</label><textarea type="text" name="remark" id="remark"
                                                      disabled="disabled" class="clientInformation" rows="4" cols="80" maxlength="50"></textarea></li>
                </ul>
                @include('layouts._modifyButton',['object'=>'顾客','deleteButton'=>true])

            </form>
        </fieldset>
    </div>
    <script src="/js/Modify/Client.js"></script>
@endsection()
