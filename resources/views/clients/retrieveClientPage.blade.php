@extends('layouts._sideNav',['item'=>'client'],['itemChinese'=>[
'client' => '顾客',
'medicine' => '药物',
'agency' => '经办人',
'orderForm' => '订单'
]])
@section('rightContent')
    <div class="col-md-10">
        <nav class="col-md-12" style="height: 200%">
            <form action="{{ route('client.retrieve') }}" method="post" id="client-property">
                {{ csrf_field() }}
                <div class="col-md-6">
                    <label for="client-phone">顾客手机号：</label>
                    <input type="text" name="clientPhone" class="retrieveCriteria">
                </div>

                <div class="col-md-6">
                    <label for="client-name">顾客名字：</label>
                    <input type="text" name="clientName" class="retrieveCriteria">
                </div>

                <div class="col-md-6">
                    <label for="client-address">顾客地址：</label>
                    <input type="text" name="clientProvince" class="retrieveCriteria"><span>省</span>
                    <input type="text" name="clientCity" class="retrieveCriteria"><span>市</span>
                    <input type="text" name="clientArea" class="retrieveCriteria"><span>区</span>
                    <input type="text" name="clientStreet" class="retrieveCriteria"><span>街道</span>
                </div>

                <div class="col-md-6">
                    <label for="client-symptom">顾客症状：</label>
                    <input type="text" name="clientSymptom" class="retrieveCriteria">
                </div>

                <button style="width: 132px;float: right;" onclick="event.preventDefault();retrieveClient();" class="btn btn-default">搜索
                </button>
            </form>
        </nav>
        <div class="col-md-12" id="retrieve-result">
            <table id="retrieve-result-table" style='margin:15px auto;' border='2' class='col-md-12 table table-hover table-condensed'>
                <tr>
                    <th class='col-md-5'>顾客名字：</th>
                    <th class='col-md-2'>电话号码：</th>
                    <th class='col-md-2'>年龄</th>
                    <th class='col-md-2'>性别</th>
                    <th class='col-md-1'>详情</th>
                </tr>
            </table>
        </div>
    </div>
@endsection