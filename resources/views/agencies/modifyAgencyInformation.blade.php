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
            <div style="color:red;" id="retrieveStatus"></div>
            <form class="col-md-12" action="" method="post" id="agencyInformation-Form">
                {{ csrf_field() }}
                <input type="hidden" name="ajax" value="true"/>
                <input type="number" name="id" id='id' style="display: none" value={{ isset($agency)?$agency->id:'' }}/>
                @if(isset($agency))
                    @include('agencies.agencyInformation',['agency'=>$agency])
                @else
                    @include('agencies.agencyInformation')
                @endif
                <li>
                    <label>备注：</label>
                    <textarea name="remark" id="remark" disabled="disabled" class="agencyInformation" rows="4" cols="80"
                              maxlength="50"{{ isset($agency)?$agency->remark:'' }}></textarea>
                </li>
                </ul>
                @include('layouts._modifyButton',['object'=>'经办人','deleteButton'=>true])
            </form>
        </fieldset>
        @if(isset($medicines)&&Auth::check()&&Auth::user()->permission_token<2)
            <fieldset>
                <legend>购入药物</legend>
                <table class="col-md-12 table table-hover table-condensed" border="2">
                    <thead>
                    <tr>
                        <th>药物编号</th>
                        <th>过期时间</th>
                        <th>详情</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($medicines as $medicine)
                        <tr>
                            <td>{{ $medicine->mno }}</td>
                            <td>{{ $medicine->mouttime }}</td>
                            <td><a href="/modify/medicine/page/{{ $medicine->mno}}">详情</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $medicines->links() }}
            </fieldset>
            <fieldset>
                <legend>销售记录</legend>
                <table class="col-md-12 table table-hover table-condensed" border="2">
                    <thead>
                    <tr>
                        <th>销售单编号</th>
                        <th>顾客编号</th>
                        <th>销售日期</th>
                        <th>药物编号</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orderForms as $orderForm)
                        <tr>
                            <td>{{ $orderForm->ono }}</td>
                            <td><a href="/modify/client/page/{{ $orderForm->cno }}">{{ $orderForm->cno }}</a></td>
                            <td>{{ $orderForm->created_at }}</td>
                            <td>
                                @for($i=0;$i<count($sellMedicines);$i++)
                                    @foreach($sellMedicines[$i] as $sellMedicine)
                                        @if($orderForm->ono === $sellMedicine->ono)
                                            <p><a href="/modify/medicine/page/{{ $sellMedicine->mno }}">{{ $sellMedicine->mno }}</a></p>
                                        @endif
                                    @endforeach
                                @endfor
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $orderForms->links() }}
            </fieldset>
        @endif
    </div>
    <script src="/js/Modify/Agency.js"></script>
@endsection
