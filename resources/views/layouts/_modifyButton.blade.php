<div class="col-md-3" style="float:right">
    <ul class="col-md-12 deleteModifyButtonUl" type="none">
        @if(!(isset($agency)||isset($client)||isset($medicine)))
        <li>
            <button type="button" id="retrieveButton" style="width:115px"
                    class="btn btn-default">
                查询{{ $object }}信息
            </button>
        </li>
        @endif
        <li>
            <button type="button" id="beginModifyButton" style="width: 115px;" class="btn btn-primary">
                修改{{ $object }}信息
            </button>
        </li>
        <li>
            <button type="button" id="submitModifyButton" style="display:none;margin-top: 10px;"
                    class="btn btn-danger">提交修改
            </button>
        </li>
        <li>
            <button type="button" id="cancelModifyButton" style="display: none;" class="btn btn-default">取消</button>
        </li>
        @if($deleteButton===true)
        <li>
            <button type="submit" id="deleteButton" class="btn btn-danger" onclick="event.preventDefault()">删除</button>
        </li>
        @endif
    </ul>
</div>