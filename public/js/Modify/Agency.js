//test had client when entry orderForm
function hasAgency() {
    $('#id').val('');
    $('#name').val('');
    $('#sex').val('');
    $('#remark').val();
    if ($('#phone').val() === '') {
        $('#retrieveStatus').html('请输入经办人手机号码');
        return;
    }
    $.ajax({
        type: 'post',
        url: '/retrieve/agency',
        data: new FormData($('#agencyInformation-Form')[0]),
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
                $('#id').val(data[0].id);
                $('#phone').val(data[0].phone);
                $('#name').val(data[0].name);
                $('#sex').val(data[0].sex);
                $('#remark').val(data[0].remark);
            }
            else {
                $('#retrieveStatus').html('请先录入经办人信息');
            }
        },
        error: function (data) {
            showWarningAfterNav(data);
            console.log(data);
        }
    });
}
//modifyClient
function submitModifyClient() {
    if (!AllNotNull('agencyInformation')) {
        $('#retrieveStatus').html('缺少信息');
        return;
    }
    /*$("#phone").each(function () {
        $(this).after("<input id='submitPhone' type='text' style='display: none' name='phone' value='" + $(this).val() + "' >");
    });*/

    $.ajax({
        type: 'post',
        url: '/modify/agency',
        data: new FormData($('#agencyInformation-Form')[0]),
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
                $('.agencyInformation').each(function (index) {
                    if (index !== 0)
                        $(this).attr('disabled', true);
                });
                slideUpSomething([submitModifyButton, cancelModifyButton]);
		$('#retrieveButton').slideDown();
                //显示数据
                $('#phone').val(data.phone);
                $('#name').val(data.name);
                $('#sex').val(data.sex);
                $('#remark').val(data.remark);
            }
            else {
                var warning = '修改失败,';
                if (data.warning !== undefined)
                    warning += data.warning;
                $('#retrieveStatus').html(warning);
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
        hasAgency();
    });
    var $oldInputValues;
    $('#beginModifyButton').click(function () {
        $oldInputValues = beginModify('agencyInformation');
    });
    $('#cancelModifyButton').click(function () {
        cancelModify('agencyInformation', $oldInputValues);
        $('#submitPhone').remove();
    });
    $('#submitModifyButton').click(function () {
        submitModifyClient('agencyInformation-Form');
    });
    $('#deleteButton').click(function () {
        submitDeleteForm('id',"agencyInformation-Form",'agency');
    });
});
