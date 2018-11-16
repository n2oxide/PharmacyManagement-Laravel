@extends('layouts._sideNav',['item'=>'medicine'],['itemChinese'=>[
'client' => '顾客',
'medicine' => '药物',
'agency' => '经办人',
'orderForm' => '订单'
]])
@section('rightContent')
    <div class="col-md-10">
        <fieldset>
            <legend>药物信息</legend>
            <p>药物编号不允许修改</p>
            <div style="color:red;" id="retrieveStatus"></div>
            <form class="col-md-12" action="" method="post" id="medicineInformation-Form">
                {{ csrf_field() }}
                <input type="hidden" name="ajax" value="true">
                <div class="col-md-9">
                @include('medicines.medicineInformation')
                <!-- add input in here-->
                </div>


                @include('layouts._modifyButton',['object'=>'药物','deleteButton'=>true])
            </form>
        </fieldset>
    </div>
    <script src="/js/Modify/Medicine.js">
    </script>
@endsection
