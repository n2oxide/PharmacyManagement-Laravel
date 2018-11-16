//modifyMedicine
//test had medicine when entry orderForm
function hasMedicine() {
    $('#mname').val('');
    $('#mmode').val('');
    $('#mefficacy').val('');
    $('#mnum').val('');
    $('#mouttime').val('');
    if ($('#mno').val() === '') {
        $('#retrieveStatus').html('请输入药物内部编号');
        return;
    }
    $.ajax({
        type: 'post',
        url: '/retrieve/medicine',
        data: new FormData($('#medicineInformation-Form')[0]),
        contentType: false,
        processData: false,
        header: {
            'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
        },
        beforeSend: function () {
            $('#retrieveStatus').html('请稍后');
        },
        success: function (data) {
            console.log(data);
            if (data[0] !== undefined) {
                $('#retrieveStatus').html('');
                $('#mno').val(data[0].mno);
                $('#mname').val(data[0].mname);
                $('#mmode').val(data[0].mmode);
                $('#mefficacy').val(data[0].mefficacy);
                $('#mnum').val(data[0].mnum);
                $('#mouttime').val(data[0].mouttime);
            }
            else {
                $('#retrieveStatus').html('请先录入药物信息');
            }
        },
        error: function (data) {
            showWarningAfterNav(data);
            console.log(data);
        }
    });
}

function submitModifyMedicine() {
    if (!AllNotNull('medicineInformation')) {
        $('#retrieveStatus').html('缺少信息');
        return;
    }

    $.ajax({
        type: 'post',
        url: '/modify/medicine',
        data: new FormData($('#medicineInformation-Form')[0]),
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#retrieveStatus').html('请稍后');
            $('#ajaxErrorInfo').remove();
        },
        success: function (data) {
            console.log(data);
            if (data.mname !== undefined) {
                //提示成功
                $('#retrieveStatus').html('修改成功');
		$('.medicineInformation').each(function (index) {
                    if (index !== 0)
                        $(this).attr('disabled', true);
                });
                slideUpSomething([submitModifyButton, cancelModifyButton]);
                $('#retrieveButton').slideDown();
                //显示数据
                $('#mno').val(data[0].mno);
                $('#mname').val(data[0].mname);
                $('#mmode').val(data[0].mmode);
                $('#mefficacy').val(data[0].mefficacy);
                $('#mnum').val(data[0].mnum);
                $('#mouttime').val(data[0].mouttime);
            }
            else {
                var warning = '修改失败,';
                if (data.warning !== undefined)
                    warning += data.warning;
                $('#retrieveStatus').html(warning);
                showWarningAfterNav(data);
            }
        },
        error: function (data) {
            $('#retrieveStatus').html('传输错误');
            showWarningAfterNav(data);
            console.log(data);
        }
    });
}

$(document).ready(function () {
    $('.medicineInformation').each(function (index) {
        if (index !== 0)
            $(this).attr('disabled', true);
    });
    $('#retrieveButton').click(function () {
        hasMedicine();
    });
    var $oldInputValues;
    $('#beginModifyButton').click(function () {
        $oldInputValues = beginModify('medicineInformation');
    });
    $('#cancelModifyButton').click(function () {
        cancelModify('medicineInformation', $oldInputValues);
        $('#submitPhone').remove();
    });
    $('#submitModifyButton').click(function () {
        submitModifyMedicine();
    });
    $('#deleteButton').click(function () {
        submitDeleteForm('mno',"medicineInformation-Form",'medicine');
    });
});
