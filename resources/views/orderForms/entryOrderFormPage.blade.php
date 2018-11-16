@extends('layouts._sideNav',['item'=>'client'],['itemChinese'=>[
'client' => '顾客',
'medicine' => '药物',
'agency' => '经办人',
'orderForm' => '订单'
]])
@section('rightContent')
    <div class="col-md-10">
        <form class="col-md-12" action="" method="" id="clientInformation-Form">
            <fieldset id="clientFieldset">
                {{ csrf_field() }}
                <input type="hidden" name="ajax" value="true"/>
                <input type="number" name="cno" class="cno" style="display: none">
                <legend>顾客信息</legend>
                <div style="color:red;" id="retrieveStatus"></div>
                @include('clients.clientInformation')
                </ul>
                @include('layouts._modifyButton',['object'=>'顾客','deleteButton'=>false])
            </fieldset>
        </form>

        <form id="orderForm-Medicine" action="{{ route('orderForm.entry') }}" method="post" class="col-md-12">
            {{ csrf_field() }}
            <input type="number" name="cno" id="cno" class="cno" style="display: none">
            <fieldset id="medicineFieldset">
                <legend style="padding-bottom: 7px;">购入药物清单
                    <span style="float:right;font-size:15px">
                    <label for="addNum" style="width:auto">添加<input type="text" id="addNum">个药物</label>
                    <button type="button" onclick="moreMedicines($('#addNum').val());"
                            class="btn btn-info">确认添加</button>
                    </span>
                </legend>
                <p id="retrieveMedicineStatus"></p>
                <ul type="none" class="medicine-list col-md-8">
                    <li class="buyMedicine-input-li"><label for="">药物编号：</label><input type="text" name="mno[]"
                                                                                       id="mno1"
                                                                                       class="buyMedicine-input">
                        <br/>
                        <label for="sellNum">购入数量：</label><input type="text" name="sellNum[]" id="sellNum1" class="buyMedicine-sellNum">
                    </li>
                </ul>

                <div class="col-md-3" style="float:right">
                    <ul class="col-md-12 entryOrderFormButton" type="none">
                        <li>
                            <button type="button" onclick="hasMedicines()" style="width:115px" class="btn btn-default">
                                确认药物信息
                            </button>
                        </li>
                        <li>
                            <button type="submit" style="width: 115px;" class="btn btn-danger"
                                    onclick="event.preventDefault();checkCanBuy(document.getElementById('orderForm-Medicine'))">
                                提交订单
                            </button>
                        </li>
                    </ul>
                </div>

            </fieldset>
        </form>
    </div>
    <script src="/js/Modify/Client.js"></script>
@endsection
