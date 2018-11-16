@extends('layouts._sideNav',['item'=>'medicine'],['itemChinese'=>[
'client' => '顾客',
'medicine' => '药物',
'agency' => '经办人',
'orderForm' => '订单'
]])
@section('rightContent')
    <div class="col-md-10">
        <nav class="col-md-12" style="height: 200%;">
            <form action="{{ route('medicine.retrieve') }}" method="post" id="medicine-property">
                {{ csrf_field() }}
                <label for="medicine-no">药物编号：</label>
                <input type="text" name="mno" class="retrieveCriteria">

                <label for="medicine-name">药物名称：</label>
                <input type="text" name="mname" class="retrieveCriteria">

                <label for="medicine-efficacy">药物功效：</label>
                <input type="text" name="mefficacy" class="retrieveCriteria">

                <div>
                    <label for="agency-ano">经办人编号：</label>
                    <input type="text" name="ano" class="retrieveCriteria">
                </div>

                <button style="width: 132px;float: right;" onclick="event.preventDefault();retrieveMedicine();" class="btn btn-default">搜索
                </button>
            </form>
        </nav>
        <div class="col-md-12" id="retrieve-result">
            <table id="retrieve-result-table" style='margin:15px auto;' border='2' class='col-md-12 table table-hover table-condensed'>
                <tr>
                    <th class='col-md-5'>药物名称</th>
                    <th class='col-md-2'>服用方法</th>
                    <th class='col-md-2'>数量</th>
                    <th class='col-md-2'>有效期至</th>
                    <th class='col-md-1'>详情</th>
                </tr>
            </table>
        </div>
    </div>
@endsection
