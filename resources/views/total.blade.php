@extends('layouts._sideNav',['item'=>'medicine'],['itemChinese'=>[
'client' => '顾客',
'medicine' => '药物',
'agency' => '经办人',
'orderForm' => '订单'
]])
@if(count($medicines)>0)
    <table class="col-xs-10">
        <thead>
        <tr>
            <th>药物编号</th>
            <th>药物近30天销量</th>
        </tr>
        </thead>
        <tbody>
        @foreach($medicines as $medicine)
            <tr>
                <td><a href="/modify/medicine/page/{{ $medicine->mno }}"></a>{{ $medicine->mno }}</td>
                <td>{{ $medicine->sellSum  }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <h1>无销售记录</h1>
@endif