@extends('layouts._sideNav',['item'=>'agency'],['itemChinese'=>[
'client' => '顾客',
'medicine' => '药物',
'agency' => '经办人',
'orderForm' => '订单'
]])
@section('rightContent')
    <div class="col-md-10">
        <nav class="col-md-12" style="height: 200%">
            <form action="{{ route('agency.retrieve') }}" method="post" id="agency-property">
                {{ csrf_field() }}
                <div class="col-md-6">
                    <label for="agency-phone" style="width: 105px">经办人手机号：</label>
                    <input type="text" name="agencyPhone" class="retrieveCriteria">
                </div>

                <div class="col-md-6">
                    <label for="agency-name">经办人名字：</label>
                    <input type="text" name="agencyName" class="retrieveCriteria">
                </div>

                <div class="col-md-6">
                    <label for="agency-ano">经办人编号：</label>
                    <input type="text" name="agencyAno" class="retrieveCriteria">
                </div>

                <button style="width: 132px;float: right;" onclick="event.preventDefault();retrieveAgency();" class="btn btn-default">搜索
                </button>
            </form>
        </nav>
        <div class="col-md-12" id="retrieve-result">
            <table id="retrieve-result-table" style='margin:15px auto;' border='2' class='col-md-12 table table-hover table-condensed'>
                <tr>
                    <th class='col-md-3'>经办人编号</th>
                    <th class='col-md-3'>经办人电话号码</th>
                    <th class='col-md-3'>经办人名字</th>
                    <th class='col-md-2'>性别</th>
                    <th class='col-md-1'>详情</th>
                </tr>
            </table>
        </div>
    </div>
@endsection