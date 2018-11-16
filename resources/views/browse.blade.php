@extends('layouts._sideNav',['item'=>$item],['itemChinese'=>[
'client' => '顾客',
'medicine' => '药物',
'agency' => '经办人',
'orderForm' => '订单'
]])
@section('rightContent')
    <div class="col-md-10">
        @if( count($browseResults)>0 )
            <table border="2">
                <tr>
                    @foreach($ths as $th)
                        <th class="col-md-2">{{ $th }}</th>
                    @endforeach
                </tr>
                @foreach($browseResults as $browseResult)
                    <tr>
                        @foreach($browseResult as $browseResultTd)
                            @if(is_integer($browseResultTd)&&$browseResultTd<1000)
                                <td class="col-md-2" style="color: red">{{ $browseResultTd }}</td>
                            @else
                                <td class="col-md-2">{{ $browseResultTd }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </table>
            {{ $browseResults->links() }}
    </div>
    @else
        <p>暂无数据</p>
    @endif
@endsection
