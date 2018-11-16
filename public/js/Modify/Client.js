//modifyClient
//test had client when entry orderForm
function hasClient() {
    $('.cno').val('');
    $('#name').val('');
    $('#sex').val('');
    $('#cbirthday').val('');
    $('#clientProvince').val('');
    $('#clientCity').val('');
    $('#clientArea').val('');
    $('#clientStreet').val('');
    $('#csymptom').val('');
    $('#remark').val('');
    if ($('#phone').val() === '') {
        $('#retrieveStatus').html('请输入购药顾客手机号码');
        return;
    }
    $.ajax({
        type: 'post',
        url: '/retrieve/client',
        data: new FormData($('#clientInformation-Form')[0]),
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
                $('.cno').val(data[0].cno);
                $('#name').val(data[0].name);
                $('#sex').val(data[0].sex);
                $('#cbirthday').val(data[0].cbirthday);
                $('#clientProvince').val(data[0].province).trigger('change');
                $('#clientCity').val(data[0].city).trigger('change');
                $('#clientArea').val(data[0].area).trigger('change');
                $('#clientStreet').val(data[0].street);
                $('#csymptom').val(data[0].csymptom);
                $('#remark').val(data[0].remark);
            }
            else {
                $('#retrieveStatus').html('请先录入顾客信息');
            }
        },
        error: function (data) {
            showWarningAfterNav(data);
            console.log(data);
        }
    });
}

function submitModifyClient() {
    if (!AllNotNull('clientInformation')) {
        $('#retrieveStatus').html('缺少信息');
        return;
    }
    $("#phone").each(function(){
       $(this).after("<input id='submitPhone' type='text' style='display: none' name='phone' value='" + $(this).val() + "' >");
    });

    $.ajax({
        type: 'post',
        url: '/modify/client',
        data: new FormData($('#clientInformation-Form')[0]),
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#retrieveStatus').html('请稍后');
            $('#ajaxErrorInfo').remove();
        },
        success: function (data) {
            console.log(data);
            if (data.name !== undefined) {
                //提示成功
                $('#retrieveStatus').html('修改成功');
                $('.clientInformation').each(function (index) {
                    if (index !== 0)
                        $(this).attr('disabled', true);
                });
                slideUpSomething([submitModifyButton, cancelModifyButton]);
                $('#retrieveButton').slideDown();
                //显示数据
                $('#phone').val(data.phone);
                $('.cno').val(data.cno);
                $('#name').val(data.name);
                $('#sex').val(data.sex);
                $('#cbirthday').val(data.cbirthday);
                $('#clientProvince').val(data.province);
                $('#clientCity').val(data.city);
                $('#clientArea').val(data.area);
                $('#clientStreet').val(data.street);
                $('#csymptom').val(data.csymptom);
                $('#remark').val(data.remark);
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
    $('#retrieveButton').click(function () {
        hasClient();
    });
    var $oldInputValues;
    $('#beginModifyButton').click(function () {
        $oldInputValues = beginModify('clientInformation');
    });
    $('#cancelModifyButton').click(function () {
        cancelModify('clientInformation', $oldInputValues);
        $('#submitPhone').remove();
    });
    $('#submitModifyButton').click(function () {
        submitModifyClient('clientInformation-Form');
    });
    $('#deleteButton').click(function () {
        submitDeleteForm('cno',"clientInformation-Form",'client');
    });
});
