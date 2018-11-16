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
                <input type="number" name="cno" class="cno" style="display: none"
                       value={{ isset($client)?(int)$client->cno:'' }}>
                @include('clients.clientInformation')
                <li><label for="">备注</label>
                    <textarea type="text" name="remark" id="remark" disabled="disabled" class="clientInformation"
                              rows="4" cols="80" maxlength="50"
                              placeholder={{ isset($client)?$client->remark:'' }}></textarea>
                </li>
                </ul>
                @if((Auth::check()&&Auth::user()->cno===$client->cno)||Auth::user()->permission_token<1);
                @include('layouts._modifyButton',['object'=>'顾客','deleteButton'=>true])
                @endif
            </form>
        </fieldset>
        <fieldset>
            <legend>曾购药</legend>
            @if(isset($medicines)&&isset($orderForms))
                <table class="col-md-12 table table-hover table-condensed" border="2">
                    <thead>
                    <tr>
                        <th>销售单编号</th>
                        <th>经办人编号</th>
                        <th>销售日期</th>
                        <th>药物编号</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orderForms as $orderForm)
                        <tr>
                            <td>{{ $orderForm->ono }}</td>
                            <td><a href="/modify/agency/page/{{ $orderForm->ano }}">{{ $orderForm->ano }}</a></td>
                            <td>{{ $orderForm->created_at }}</td>
                            <td>
                                @for($i=0;$i<count($medicines);$i++)
                                    @foreach($medicines[$i] as $medicine)	
                                        @if($orderForm->ono === $medicine->ono)
                                            <p>
                                                <a href="/modify/medicine/page/{{ $medicine->mno }}">{{ $medicine->mno }}</a>
                                            </p>
                                        @endif
                                    @endforeach
                                @endfor
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $orderForms->links() }}
            @else
                <h2>无</h2>
            @endif
        </fieldset>
    </div>
    <script src="/js/Modify/Client.js"></script>
@endsection()
