"use strict";

//sure lessOne input have not null value
function lessOneNotNull(className) {
    var bool = false;
    $('.' + className).each(function (index, value) {
        if ($(this).val() !== '') {
            bool = true;
            return;
        }
    });
    return bool;
}

function lessOneNotNullInRetrievePage() {
    if (!lessOneNotNull('retrieveCriteria')) {
        alert('至少输入一个搜索条件');
        return false;
    }
    return true;
}

//sure all input hve value
function AllNotNull(className) {
    var bool = true;
    $('.' + className).each(function (index, value) {
        if ($(this).val() === '' && $(this).attr('name') !== 'remark') {
            bool = false;
            return;
        }
    });
    return bool;
}

//show/hidden something display:none element with slide
function slideUpSomething(hiddenElements) {
    if (hiddenElements.length > 1) {
        for (var i = 0, n = hiddenElements.length; i < n; i++)
            $(hiddenElements[i]).slideUp();
    }
    else if (typeof(hiddenElements) === 'string')
        $(hiddenElements).slideUp();
}

function slideDownSomething(hiddenElements) {
    if (hiddenElements.length > 1) {
        for (var i = 0, n = hiddenElements.length; i < n; i++)
            $(hiddenElements[i]).slideDown();
    }
    else if (typeof(hiddenElements) === 'string')
        $(hiddenElements).slideDown();
}

//开始修改、取消修改顾客、经办人、药物等信息。
function beginModify(className) {
    $('#retrieveButton').slideUp();
    $('#deleteButton').slideUp();
    var inputValues = [];
    slideDownSomething(['#submitModifyButton', '#cancelModifyButton']);
    className = '.' + className;
    $(className).each(function (index) {
        inputValues[index] = $(this).val();
        if (index !== 0)
            $(this).attr('disabled', false);
    });
    return inputValues;
}

function cancelModify(className, oldInputValue) {
    $('#retrieveButton').slideDown();
    $('#deleteButton').slideDown();
    slideUpSomething(['#submitModifyButton', '#cancelModifyButton']);
    className = '.' + className;
    $(className).each(function (index) {
        if (index !== 0)
            $(this).attr('disabled', true);
        $(this).val(oldInputValue[index]);
    });
    $('#retrieveStatus').html('');
}

//显示ajax返回的validatorJson格式错误信息
function showWarningAfterNav(data) {
    if (data.status === 422) {
        $('.row').before("<div class='warningAfterNav' id='ajaxErrorInfo'></div>");
        data.responseText = $.parseJSON(data.responseText);
        for (var errorsKey in data.responseText.errors)
            $('#ajaxErrorInfo').append("<p class='alert alert-danger'>" + data.responseText.errors[errorsKey] + "</p>");
    }
}

/*show retrieve medicine information with table*/
function retrieveMedicine() {
    if (!lessOneNotNullInRetrievePage())
        return;
    var retrieveMedicineForm = new FormData(document.getElementById('medicine-property'));
    $.ajax({
        type: 'post',
        url: '/retrieve/medicine',
        data: retrieveMedicineForm,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
        },
        beforeSend: function () {
            $('#ajaxErrorInfo').remove();
		$('tbody').children().each(function(index){
			if(index!=0)
				$(this).remove();
		});
        },
        success: function (data) {
            console.log(data);
            var outPutDiv = $('#retrieve-result-table');
            var innerHTML = "";

            for (var i = 0; i < data.length; i++) {
                var mId = '"' + data[i].mno + '"';
                innerHTML += "<tr>" +
                             "<td>" + data[i].mname + "</td>" +
                             "<td>" + data[i].mmode + "</td>" +
                             "<td class='mnum'>" + data[i].mnum + "</td>" +
                             "<td>" + data[i].mouttime + "</td>" +
                             "<td><a href='/modify/medicine/page/"+data[i].mno+"'>" + "详情/管理" + "</a></td>" +
                             "</tr>";//medicine base information
                innerHTML += "<tr><td colspan='5' height='80px' style='display: none' id='" + data[i].mno + "'>" + "药物编号：" + data[i].mno + "<br/>经办人编号：" + data[i].ano + "<br/>药效：" + data[i].mefficacy + "</td></tr>"//hide medicine efficacy
            }
            outPutDiv.append(innerHTML);
            $("td.mnum").each(function () {
                if($(this).html()<1000)
                    $(this).css('color','red');
            });
        },
        error: function (data, json, errorThrown) {
            showWarningAfterNav(data);
            console.log(data);
        }
    });
}

/*show more medicine information*/
function moreInformation(no) {
    var detailDiv = document.getElementById(no);
    if (detailDiv.style.display === 'table-cell')
        detailDiv.style.display = 'none';
    else
        detailDiv.style.display = 'table-cell';
    //$('#'+no).slideToggle(300);
}

// show retrieve client information with table
function retrieveClient() {
    if (!lessOneNotNullInRetrievePage())
        return;
    var object = $('#client-property')[0];
    var retrieveClientForm = new FormData(object);
    $.ajax({
        type: 'post',
        url: '/retrieve/client',
        data: retrieveClientForm,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
        },
        beforeSend: function () {
            $('tr').each(function (index) {
                if (index !== 0)
                    $(this).remove();
            });
            $('#ajaxErrorInfo').remove();
        },
        success: function (data) {
            console.log(data);
            var outPutDiv = $('#retrieve-result-table');
            var innerHTML;
            innerHTML = "";
            for (var i = 0; i < data.length; i++) {
                var cId = '"' + data[i].cno + '"';
                var cPhone = '"' + data[i].phone + '"';
                var manageObject = "client";
                var manageObject = '"' + manageObject + '"';
                innerHTML += "<tr>" +
                                "<td>" + data[i].name + "</td>" +
                                "<td>" + data[i].phone + "</td>" +
                                "<td>" + data[i].cage + "</td>" +
                                "<td>" + data[i].sex + "</td>" +
                                "<td><a href='/modify/client/page/"+data[i].cno+"'>" + "详情/管理" + "</a></td>" +
                            "</tr>";//medicine base information
                /*innerHTML += "<tr>" +
                                    "<td colspan='5' height='80px' style='display: none' id='" + data[i].cno + "'>" + "顾客编号：" + data[i].cno + "<br/>症状：" + data[i].csymptom + "<br/>地址：" + data[i].province + data[i].city + data[i].area + data[i].street + "<br/>备注：" + data[i].remark + "</td>" +
                             "</tr>"//hide medicine efficacy*/
            }
            outPutDiv.append(innerHTML);
        },
        error: function (data) {
            showWarningAfterNav(data);
            console.log(data);
        }
    });
}

// show retrieve agency information with table
function retrieveAgency() {
    if (!lessOneNotNullInRetrievePage())
        return;
    var object = $('#agency-property')[0];
    var retrieveAgencyForm = new FormData(object);
    $.ajax({
        type: 'post',
        url: '/retrieve/agency',
        data: retrieveAgencyForm,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#ajaxErrorInfo').remove()
	    $('tbody').children().each(function(index){
			if(index!=0)
				$(this).remove();
		});
        },
        success: function (data) {
            console.log(data);
            var outPutDiv = $('#retrieve-result-table');
            var innerHTML = "";
            for (var i = 0; i < data.length; i++) {
                var aId = '"' + data[i].ano + '"';
                innerHTML += "<tr>" +
                             "<td>" + data[i].ano + "</td>" +
                             "<td>" + data[i].phone + "</td>" +
                             "<td>" + data[i].name + "</td>" +
                             "<td>" + data[i].sex + "</td>" +
                             "<td><a href='/modify/agency/page/"+data[i].ano+ "'>" + "详情/管理" + "</a></td>" +
                             "</tr>";//agency base information
                innerHTML += "<tr><td colspan='5' height='80px' style='display: none' id='" + data[i].ano + "'>" + "入职时间：" + data[i].created_at + "<br/>备注：" + data[i].remark + "</td></tr>"//hide agency efficacy
            }
	    if(innerHTML==='')
		innerHTML = '<tr><td colspan="5" style="font-size:1.5em">无结果</td></tr>';
            outPutDiv.append(innerHTML);
        },
        error: function (data) {
            showWarningAfterNav(data);
            console.log(data);
        }
    });
}

//test had medicines when entry orderForm
function hasMedicines() {
    if (!lessOneNotNull('buyMedicine-input')) {
        $('#retrieveMedicineStatus').html('请输入药物编号');
        return;
    }
    $.ajax({
        type: 'post',
        url: '/retrieve/medicine',
        data: new FormData($('#orderForm-Medicine')[0]),
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('#retrieveMedicineStatus').html('请稍后');
            $('.medicineNameSpan').each(function () {
                $(this).remove();
            });
            $('.sureBuyMnos').each(function () {
                $(this).remove();
            });
        },
        success: function (data) {
            console.log(data);
            if (data[0] !== undefined) {
                $('#retrieveMedicineStatus').html('');
                $('.buyMedicine-input').each(function (index, value) {
                    if (data[index] != undefined) {
                        $(this).after("<span class='medicineNameSpan'> &nbsp药物名称：" + data[index].mname + "</span>");
                        $(this).after("<input value='" + data[index].mno + "' type='hidden' name='sureBuyMnos[]' class='sureBuyMnos'>");
                    }
                    else {
                        $(this).after("<span class='medicineNameSpan'> &nbsp未找到药物</span>");
                    }
                });
            }
            else {
                $('#retrieveMedicineStatus').html('查询失败');
            }
        },
        error: function (data) {
            showWarningAfterNav(data);
            $('#retrieveMedicineStatus').html('查询失败');
            console.log(data);
        }
    });
}

//buy more medicine in entry orderForm
function moreMedicines(addNum) {
    var nowNum = ('.buyMedicine-input').length;
    var addNum = parseInt(addNum);
    for (var i = nowNum + 1; i <= nowNum + addNum; i++) {
        $('.buyMedicine-input-li').last().after(
            '<li class="buyMedicine-input-li">' +
            '<label for="">药物编号：</label>' +
            '<input type="text" name="mno[]" id="mno' + i + '" class="buyMedicine-input">' +
            '<br/>'+
            '<label for="sellNum">购入数量：</label>' +
            '<input type="text" name="sellNum[]" id="sellNum' + i + '" class="buyMedicine-sellNum">'+
            '</li>'
        );
    }
}

//确认购药信息已填写
function checkCanBuy(object) {
    $('.flash-message').each(function () {
        $(this).remove();
    });
    var lostWarning = '';
    var bool = false;
    if ($('#orderForm-Medicine .cno').val() === '') {
        lostWarning = "<div class='flash-message'><p class='alert alert-danger'>" + "缺少用户信息" + "</p></div>";
        bool = true;
    }
    if (!lessOneNotNull('buyMedicine-input')) {
        $('#retrieveMedicineStatus').html('请输入药物编号');
        bool = true;
    }
    else if (!lessOneNotNull('sureBuyMnos')) {
        lostWarning += "<div class='flash-message'><p class='alert alert-danger'>" + "未确认药物信息" + "</p></div>";
        bool = true;
    }
    //warning or submit
    if (bool) {
        $('.row').before(lostWarning);
    }
    else {
        object.submit();
    }
}

//delete
function submitDeleteForm(tokenName, formId, object) {
    var token = '';
    switch (tokenName) {
        case 'cno':
            token = $("[name='cno']").first().val();
            break;
        case  'id' :
            token = $("[name='id']").first().val();
            break;
        case  'ano' :
            token = $("[name='ano']").first().val();
            break;
        case  'mno' :
            token = $("[name='mno']").first().val();
            break;
    }

    if (token === '') {
        $('#retrieveStatus').html('请先搜索');
        return;
    }
    $('#' + formId).append("<input type='hidden' name='_method' value='DELETE'>")
        .attr('action', 'http://101.132.141.27/delete/' + object + '/' + token)
        .submit();
}

$(document).ready(function () {
    //show nav status
    var nowUrl = window.location.href;
    $('.nav li a').each(function () {
        if ($(this).attr('href') === nowUrl) {
            $(this).parent().addClass('active');
        }
    });
    $('#login').click(function () {
        if (nowUrl !== "http://101.132.141.27/users/dlp") {
            $('.overCurtain').fadeIn('slow');
            $('#loginForm').fadeIn('slow');
        }
    });
    $('.overCurtain').click(function () {
        $(this).fadeOut('slow');
        $('#loginForm').fadeOut('slow');
    });
});
