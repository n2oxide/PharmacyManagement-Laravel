<div class="col-md-6">
    <label for="mno">药物编号：</label><input type="text" name="mno" id="mno" class="medicineInformation" value="{{ isset($medicine)?$medicine->mno:old("mno")  }}" >
</div>

<!-- 50 -->
<div class="col-md-12">
    <label for="mname">药物名字：</label><input type="text" style="width:450px;" name="mname" id="mname" class="medicineInformation" value="{{ isset($medicine)?$medicine->mname:old("mname") }}">
</div>

<div class="col-md-6">
    <label for="mmode">服用方式：</label><input type="text" name="mmode" id="mmode" class="medicineInformation" value="{{ isset($medicine)?$medicine->mmode:old('mmode') }}">
</div>

<!-- 50 -->
<div class="col-md-12">
    <label for="mefficacy">药效：</label><input type="text" style="width:450px;" name="mefficacy" id="mefficacy" class="medicineInformation"
                                                                 value="{{ isset($medicine)?$medicine->mefficacy:old("mefficacy") }}">
</div>

<div class="col-md-6">
    <label for="mnum">数量：</label><input type="text" name="mnum" id="mnum" class="medicineInformation" value="{{ isset($medicine)?$medicine->mnum:old ('mnum') }}">
</div>

<!-- date -->
<div class="col-md-6">
    <label for="mouttime">有效至：</label><input type="text" name="mouttime" id="mouttime" class="medicineInformation" value="{{ isset($medicine)?$medicine->mouttime:old('mouttime') }}">
</div>

<script src="/js/lyz.calendar.min.js"></script>
<script>$("#mouttime").calendar();</script>