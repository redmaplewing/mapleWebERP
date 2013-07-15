$(function() {

    //定義showRecruitmentRequest的Dialog	
    $("#showattRecordInterface").dialog({
        width: 800
                , autoOpen: false
                , closeText: "close"
    });
    var dialogDiv = $("#showattRecordInterface");

    $("#attForm").find('.date').each(function() {
        //alert($(this).attr('name'));
        $(this).datetimepicker();
        //$(this).datepicker("option","dateFormat","yy-mm-dd");
        $(this).datetimepicker("option", "dateFormat", "yy-mm-dd");
        $(this).datetimepicker("option", "timeFormat", "hh:mm");
    });
    //清空表單
    function clearFormData(tar) {
        //$(tar).get(0).reset();
        var inputName = '';
        tar.find('input').each(function() {
            if ($(this).attr('type') != 'submit' && $(this).attr('type') != 'reset'
                    && $(this).attr('name') != 'type' && $(this).attr('name') != 'managerID'
                    && $(this).attr('id') != 'print' && $(this).attr('type') != 'button') {
                $(this).attr('value', ' ');
                //inputName += $(this).attr('name')+"\n";//將清空欄位寫入驗證訊息
            }
        });
        //alert(inputName);//驗證表單清空的執行
        tar.find('select').each(function() {
            //取消所有select的option的選取
            $(this).find('option').each(function() {
                $(this).attr('selected', false);
            });
            $(this).find('option').first().attr('selected', true);
        });
        //將select的第一項option設定預設選取
        tar.find('textarea').each(function() {
            $(this).text('');
        });
    }

    //取得表單資料
    function getFormData(tar, id) {
        //alert(id);
        var obj = null;//定義空的資料儲存陣列
        var tarID = id;
        $.ajax({
            url: base_url + '/getEmployeeLeaveData/'
                    , type: 'POST'
                    , data: "ID=" + tarID
                    , dataType: 'json'
                    , async: false//非同步處理設定
                    //,beforeSend://驗證資料
                    , success: function(e) {
                obj = e;
                var form = tar;
                //設定功能的slider
                form.find('.ui-slider').each(function() {
                    textBox = $(this).prev('input');
                    if (obj[textBox.attr('name')] != 'undefined') {
                        $(this).slider('value', obj[textBox.attr('name')]);
                    }
                    ;
                });

                form.find('input').each(function() {
                    //alert($(this).attr('name'));
                    if (obj[$(this).attr('name')] != 'undefined') {
                        $(this).attr('value', obj[$(this).attr('name')]);
                    }
                });

                var selectBox = form.find('select');


                selectBox.each(function() {
                    var key = $(this).attr('name');
                    $(this).find('option').each(function() {
                        $(this).attr('selected', false);
                        if ($(this).attr('value') == obj[key]) {
                            $(this).attr('selected', true);
                        }
                    });
                });


                form.find('textarea').each(function() {
                    if (obj[$(this).attr('name')] != 'undefined') {
                        $(this).text('');
                        $(this).text(obj[$(this).attr('name')]);
                    }
                })
                form.find("#id").attr('value', tarID);

            }
            /*,error:
             ,data:tar*/
        })
    }

    //顯示表單資料
    function showFormDetail(type, ids, tar) {
        if (typeof ids == 'undefined') {
            ids = 0;
        }
        if (typeof tar == 'undefined') {
            tar = dialogDiv;
        }
        var receiveType = "";
        mainForm = tar.find('form');
        switch (type) {
            case 'edit':
                clearFormData(mainForm);
                mainForm.find('#oper').attr('value', 'edit');
                mainForm.find('#id').attr('value', ids);
                getFormData(mainForm, ids);
                checkUser(mainForm);
                mainForm.get(0).reset();
                mainForm.find("#showCDate").html(mainForm.find("#cDate").val());
                tar.dialog("open");
                break;
            case 'add':
            default:
                clearFormData(mainForm);
                mainForm.find('#oper').attr('value', 'add');
                mainForm.find('#cDate').datepicker('setDate', new Date());//建立時間
                mainForm.find("#showCDate").html(mainForm.find("#cDate").val());
                checkUser(mainForm);
                mainForm.get(0).reset();
                tar.dialog("open");
                break;
        }
    }
    ;

    //依Attendance Summary取得employeeID
    function checkUser(tarForm) {
        var gr = $("#attendanceTable").jqGrid('getGridParam', 'selrow');
        if (gr != null) {
            var tarSelect = tarForm.find('#employeeID');
            tarSelect.find('option').each(function() {
                if ($(this).val() == gr) {
                    $(this).attr('selected', true);
                }
            })
        }


    }

    //新增Employee Leave
    $("#addAttRecord").click(function() {
        showFormDetail('add');
    })

    //編輯Employee Leave
    $("#editAttRecord").click(function() {
        var gr = jQuery("#employeeLeaveTable").jqGrid('getGridParam', 'selrow');
        if (gr != null) {
            showFormDetail('edit', gr);
        } else {
            alert("Please Select Row")
        }
        ;
    })

    //刪除Employee Leave
    $("#delAttRecord").click(function() {
        var gr = jQuery("#employeeLeaveTable").jqGrid('getGridParam', 'selrow');
        if (gr != null)
            jQuery("#employeeLeaveTable").jqGrid('delGridRow', gr, {reloadAfterSubmit: false});
        else
            alert("Please Select Row to delete!");
    });

    //表單控制
    $("#attForm").ajaxForm({
        success: function() {
            //$("#rRepairTable").trigger("reloadGrid");
            $("#attendanceTable").jqGrid("clearGridData", true);
            $("#employeeLeaveTable").jqGrid("clearGridData", true);
            $("#attendanceTable").trigger("reloadGrid");
            $("#employeeLeaveTable").trigger("reloadGrid");
            dialogDiv.dialog("close");
            clearFormData($(this));
        }
    });

    //定義主表格欄位
    var gridColName = [
        'No.'
                , 'Employee No.'
                , 'Name'
                , 'Position'
                , 'Employment Date'
                , 'Employment Working Days'
                , 'Days Worked'
                , 'Unpaid'
                , 'Sick'
                , 'Holiday'
                , 'Annual'
                , 'BL'
                , 'ML'
                , 'Off'
                , 'Others'
    ];
    //定義主表格各欄位屬性設定
    var gridColModel = [
        {name: 'no', index: 'no', align: "left"}
        , {name: 'employeeNo', index: 'employeeNo', align: "left"}
        , {name: 'name', index: 'name', align: "left"}
        , {name: 'position', index: 'position', align: "left"}
        , {name: 'employmentDate', index: 'employmentDate', align: "left"}
        , {name: 'employmentWorkDay', index: 'employmentWorkDay', align: "left"}
        , {name: 'employmentDayWork', index: 'employmentDayWork', align: "left"}
        , {name: 'unpaid', index: 'unpaid', align: "left"}
        , {name: 'sick', index: 'sick', align: "left"}
        , {name: 'holiday', index: 'holiday', align: "left"}
        , {name: 'annual', index: 'annual', align: "left"}
        , {name: 'bl', index: 'bl', align: "left"}
        , {name: 'ml', index: 'ml', align: "left"}
        , {name: 'off', index: 'off', align: "left"}
        , {name: 'other', index: 'other', align: "left"}
    ];
    //定義employeeLeaveTable欄位
    var leaveGridColName = [
        'Month'
                , 'Day'
                , 'Hours'
                , 'Day off'
                , 'Employee Signature'
                , 'Admin/HR Dept'
                , 'Checked by'
                , 'Approved by'
    ];
    //定義主表格各欄位屬性設定
    var leaveGridColModel = [
        {name: 'month', index: 'month', align: "left"}
        , {name: 'day', index: 'day', align: "left"}
        , {name: 'hour', index: 'hour', align: "left"}
        , {name: 'dayOff', index: 'dayOff', align: "left"}
        , {name: 'signCheck', index: 'signCheck', align: "left"}
        , {name: 'hrDeptCheck', index: 'hrDeptCheck', align: "left"}
        , {name: 'check', index: 'check', align: "left"}
        , {name: 'approved', index: 'approve', align: "left"}
    ];

    //定義介面基本Tabs,Employee List
    $("#employeeListInterface").tabs();

    makeGrid($("#attendanceTable"), "attendanceList", '1');//
    makeGrid($("#employeeLeaveTable"), "employeeLeaveList", '2', leaveGridColName, leaveGridColModel);

    //Request主頁面jqGrid
    function makeGrid(tarTable, tarDiv, type, colName, colModel) {
        var targetUrl = "";
        if (typeof colName == 'undefined') {
            colName = gridColName;
        }
        ;
        if (typeof colModel == 'undefined') {
            colModel = gridColModel;
        }
        ;
        if (typeof type == 'undefined') {
            type = '1';
        }
        switch (type) {
            case '2':
                if (id != '') {
                    targetUrl = '';
                }
                break;
            case '1':
            default:
                targetUrl = base_url + '/sendAttRecordData/';
                break;
        }
        tarTable.jqGrid({
            url: targetUrl,
            datatype: "json",
            colNames: colName,
            colModel: colModel,
            rowNum: 20,
            rowList: [20, 40, 60],
            pager: tarDiv,
            sortname: 'code',
            viewrecords: true,
            sortorder: "asc",
            width: 765,
            height: 250,
            onSelectRow: function(id) {
                if (type == '1') {
                    $("#employeeLeaveTable").jqGrid("clearGridData", true);
                    var employeeData = "";
                    var gender = "";
                    employeeData = getEmployeeData(id);
                    //console.log(employeeData);
                    $("#employeeName").html(employeeData['nameFirst'] + employeeData['nameLast']);
                    switch (employeeData['Gender']) {
                        case '2':
                            gender = 'Female';
                            break;
                        case '1':
                            gender = 'Male';
                            break;
                        default:
                            gender = '';
                            break;
                    }
                    $("#employeeGender").html(gender);
                    $("#employeeNo").html(employeeData['emplyoeeNo']);
                    //$("#employeeDepartment").html(employeeData['name']);
                    $("#employeePosition").html(employeeData['position']);
                    $("#employeeEmploymentDate").html(employeeData['employmentDate']);
                    showEmployeeLeave({employeeID: id});
                }
            },
            editurl: base_url + "/modify/"
        });
    }

    //展示員工出缺勤記錄Employee Leave
    function showEmployeeLeave(param) {
        //console.log(param);
        var targetUrl = base_url + '/sendEmployeeLeaveData/' + param['employeeID'] + '/' + param['month'];
        $("#employeeLeaveTable").jqGrid("clearGridData", true);
        $("#employeeLeaveTable").jqGrid('setGridParam', {url: targetUrl});
        $("#employeeLeaveTable").trigger('reloadGrid');
    }

    function getEmployeeData(id) {
        var result = ""
        $.ajax({
            url: base_url + '/getEmployeeData'
                    , type: 'POST'
                    , data: 'ID=' + id
                    , dataType: 'json'
                    , async: false
                    , success: function(e) {
                //console.log(e);
                result = e;
            }
        })
        //console.log(result);
        return result;
    }

    //群組化RECRUITMENT DATABASE
    jQuery("#attendanceTable").jqGrid('setGroupHeaders', {
        useColSpanStyle: true,
        groupHeaders: [
            {startColumnName: 'employmentWorkDay', numberOfColumns: 10, titleText: 'Total'},
        ]
    });
    //群組化Employee Leave
    jQuery("#employeeLeaveTable").jqGrid('setGroupHeaders', {
        useColSpanStyle: true,
        groupHeaders: [
            {startColumnName: 'month', numberOfColumns: 3, titleText: 'Total'},
        ]
    });

    //設定Employee Leave的字表格
    function setSubGrid(id) {
        var targetUrl = base_url + '/getEmployeeLeaveSubData/' + id;
        $("#employeeLeaveTable").jqGrid("setGridParam", {subGrid: true});
        $("#employeeLeaveTable").jqGrid("setGridParam", {subGridUrl: targetUrl});
        $("#employeeLeaveTable").jaGrid("setGridParam", {subGridModel: [{
                    name: {}
                }]
        });
    }


})