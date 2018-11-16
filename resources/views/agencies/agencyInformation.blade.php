<ul class="col-md-6" type="none" id="agencyInformationUl">
    <li>
        <label>电话号码：</label><input type="text" name="agencyPhone" id="phone" class="agencyInformation"
                                   value="{{ isset($agency)?$agency->phone:old('agencyPhone') }}"/>
    </li>

    <li>
        <label>名字：</label><input type="text" name="agencyName" id="name" class="agencyInformation"
                                 value="{{ isset($agency)?$agency->name:old('agencyName') }}" disabled="disabled"/>
    </li>

    <li>
        <label>性别：</label>
        <select name="sex" id="sex" disabled="disabled" class="agencyInformation">
            <option value="男">男</option>
            <option value="女">女</option>
        </select>
        <input type="hidden" id="sexInput" value={{ isset($agency)?$agency->sex:'' }}>
    </li>
    <script>
        $('option').each(function () {
            if ($(this).val() == $('#sexInput').val() && $('#sexInput').val() !== '')
                $(this).attr('selected', 'selected');
        });
    </script>
