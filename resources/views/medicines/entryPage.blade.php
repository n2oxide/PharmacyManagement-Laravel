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
            <form class="col-md-12" action="{{ route('medicine.entry') }}" method="post">
                {{ csrf_field() }}
                @include('medicines.medicineInformation')
                <br/>

                <div class="col-md-12" style="margin-top: 15px">
                    <button type="submit" name="button" class="btn btn-danger">录入药物信息</button>
                </div>

            </form>
        </fieldset>
    </div>
@endsection
