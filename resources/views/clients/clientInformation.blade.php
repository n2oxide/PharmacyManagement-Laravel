<ul class="col-md-6" type="none" id="clientInformationUl">
    <li><label for="">手机号码</label><input type="text" name="clientPhone" id="phone" autocomplete="on"
                                         class="clientInformation"
                                         value={{ isset($client)?$client->phone:old('phone') }}>

    <li><label for="">用户名</label><input type="text" name="clientName" id="name" disabled="disabled"
                                        class="clientInformation"
                                        value={{ isset($client)?$client->name:'' }}>
    </li>

    <li><label for="">性别</label>
        <select name="sex" id="sex" disabled="disabled" class="clientInformation">
            <option value="男">男</option>
            <option value="女">女</option>
        </select>
        <input type="hidden" id="sexInput" value={{ isset($client)?$client->sex:'' }}>
    </li>
    <script>
        $('option').each(function () {
            if ($(this).val() == $('#sexInput').val() && $('#sexInput').val() !== '')
                $(this).attr('selected', 'selected');
        });
    </script>
    <li><label for="">生日</label><input type="text" name="cbirthday" id="cbirthday" disabled="disabled"
                                       class="clientInformation"
                                       value={{ isset($client)?$client->cbirthday:'' }}>
    </li>

    <li><label for="">省份</label><select type="text" name="clientProvince" id="clientProvince"
                                        disabled="disabled" class="clientInformation"
                                        value={{ isset($client)?$client->province:'' }}></select></li>

    <li><label for="">城市</label><select type="text" name="clientCity" id="clientCity"
                                        disabled="disabled" class="clientInformation"
                                        value={{ isset($client)?$client->city:'' }}></select></li>

    <li><label for="">区</label><select type="text" name="clientArea" id="clientArea" disabled="disabled"
                                       class="clientInformation" value={{ isset($client)?$client->area:'' }}></select>
    </li>

    <li><label for="">街道</label><input type="text" name="clientStreet" id="clientStreet"
                                       disabled="disabled" class="clientInformation"
                                       value={{ isset($client)?$client->street:'' }}></li>

    <li><label for="">症状</label><input type="text" name="clientSymptom" id="csymptom"
                                       disabled="disabled" class="clientInformation"
                                       value={{ isset($client)?$client->csymptom:'' }}></li>
    <script src="/js/areaSelect.js"></script>
    <script>addressSelect('clientProvince', 'clientCity', 'clientArea');</script>
    @if(isset($client))
        <script>
            $(document).ready(function(){
                var makeSelected = function (_value) {
                    $('option').each(function (index,value) {
                        if(_value==$(this).val())
                        {
                            $(this).attr('selected','selected').parent().trigger('change');
                            return;
                        }
                    });
                };
                makeSelected("{{ $client->province }}");
                makeSelected('{{ $client->city }}');
                makeSelected("{{ $client->area }}");
            });
        </script>
    @endif

    <script src="/js/lyz.calendar.min.js"></script>
    <script>$("#cbirthday").calendar();</script>

