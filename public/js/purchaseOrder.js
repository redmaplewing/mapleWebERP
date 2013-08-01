$(function() {
    //alert('purchaseRequest');
    var securityCode = "";
    //定義PR基本Tabs
    $("#purOrderMainInterface").tabs();
    $("#poTabs").tabs();
    $("#poLocal").tabs();
    $("#poOverseas").tabs();
    $("#poDetailForm").find('.date').each(function() {
        //alert($(this).attr('name'));
        $(this).datepicker();
        $(this).datepicker("option", "dateFormat", "yy-mm-dd");
    });
    //定義New Purchase Order Interface
    $("#showPODetail").dialog({
        width: 800
                , autoOpen: false
                , closeText: "close"
    });
    //新增po
    $("#addLocalPo").click(function() {
        $("#mode").html('Local Purchase Order Detail');
        $("#type").attr('value', "0");
        showPODetail('add');
    });
    $("#addOverPo").click(function() {
        $("#mode").html('Overseas Purchase Order Detail');
        $("#type").attr('value', "1")
        showPODetail('add');
    });

    $("#purchaseRequestID").change(function() {
        showPurchaseOrderData($(this).val());
    })

    function showPurchaseOrderData(val) {
        $.ajax({
            url: base_url + '/getPurchaseRequestData/'
                    , type: 'POST'
                    , data: 'id=' + val
                    , dataType: 'json'
                    , async: false
                    , success: function(e) {
                $("#planNo").html(e['planName']);
                $("#projectName").html(e['projectName']);
                $("#projectID").val(e['projectID']);
                if ($("#oper").val() == 'add') {
                    $("#tabPoDetail").jqGrid().setGridParam({url: base_url + '/sendPoDetail/' + e['securityCode']});//依識別碼取得pr項目列表		
                    $("#tabPoDetail").trigger("reloadGrid");//重置項目表單
                }
                $("#securityCode").val(e['securityCode']);
                $("#supplierID").attr('disabled', false);
            }
        });
    }
    $("#supplierID").change(function() {
        showSupplierAndItem($(this));
    })
    function showSupplierAndItem(target) {
        var dataUrl = base_url + '/sendPoDetail/' + $("#securityCode").val() + "/" + target.val();
        //alert(dataUrl);
        $("#tabPoDetail").jqGrid("clearGridData", true);
        $("#tabPoDetail").jqGrid().setGridParam({url: dataUrl});//依識別碼取得pr項目列表
        $("#tabPoDetail").trigger("reloadGrid");//重置項目表單
        var supplierName = target.find(":selected").attr('supplierName');
        $("#supplierName").val(supplierName);
    }

    //新增、編輯請購單
    $("#poDetailForm").ajaxForm({
        success: function() {
            $("#poLocal").find(".localPOTab").each(function() {
                $(this).jqGrid("clearGridData", true);
                $(this).trigger("reloadGrid");
            });
            $("#tabPOOverseas").trigger("reloadGrid");
            $.ajax({
                url: base_url + '/groupItemToPo/'
                        , type: 'POST'
                        , data: 'securityCode=' + $("#securityCode").val() + '&supplierID=' + $("#supplierID").val()
                        , dataType: 'json'
            });
            $("#showPODetail").dialog("close");
            clearFormData($("#poDetailForm"));
        }
    });

    //清空表單
    function clearFormData(tar) {
        //$(tar).get(0).reset();
        var inputName = '';
        tar.find('input').each(function() {
            if ($(this).attr('type') != 'submit' && $(this).attr('type') != 'reset' && $(this).attr('name') != 'type' && $(this).attr('type') != 'button') {
                $(this).attr('value', '');
                inputName += $(this).attr('name') + "\n";
            }
        });
        //alert(inputName);
        tar.find('select').find('option').each(function() {
            $(this).attr('selected', false);
        });
        tar.find('select').find('option').first().attr('selected', true);
        tar.find('textarea').each(function() {
            $(this).text('');
        });
    }

    //取得表單資料
    function getItemData(tar) {
        var obj = null;
        $.ajax({
            url: base_url + '/getPRData/'
                    , type: 'POST'
                    , data: "ID=" + tar
                    , dataType: 'json'
                    , async: false//非同步處理設定
                    //,beforeSend://驗證資料
                    , success: function(e) {
                obj = e;
                var form = $("#poDetailForm");
                var table = 'purchaseOrder';
                //設定基本庫存、最小訂量的slider
                form.find('.ui-slider').each(function() {
                    //alert($(this).attr('name'));
                    textBox = $(this).prev('input');
                    //alert(textBox.attr('name'));
                    if (obj[textBox.attr('name')] != 'undefined') {
                        $(this).slider('value', obj[textBox.attr('name')]);
                    }
                    ;
                });
                //$("#levelSlider").slider('value',obj['minimumLevel']);
                //$("#QtySlider").slider('value',obj['defaultQty']);

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
                form.find("#id").attr('value', obj[table + 'ID']);

            }
            /*,error:
             ,data:tar*/
        })
    }

    //顯示PR詳細資料
    function showPODetail(type, ids) {
        if (typeof ids == 'undefined') {
            ids = 0;
        }
        switch (type) {
            case 'edit':

                clearFormData($("#poDetailForm"));
                $("#tabPoDetail").jqGrid("clearGridData", true);
                $("#planNo").html(' ');
                $("#projectName").html(' ');
                $("#showSubmitDate").html(' ');
                $("#oper").attr('value', 'edit');
                $("#id").attr('value', ids)
                getItemData(ids, $("#poDetailForm"), 'item');
                $("#showCDate").html($("#cDate").val());
                $("#showSubmitDate").html($("#submitDate").val());
                $("#poDetailForm").get(0).reset();
                $("#tabPoProcess").jqGrid("clearGridData", true);
                $("#tabPOReceiving").jqGrid().setGridParam({url: base_url + '/sendPOReceiving/' + $("#poDetailForm").find("#id").attr('value')});
                $("#tabPOReceiving").trigger("reloadGrid");//重置項目表單
                $("#outputPO").show();
                showPurchaseOrderData($("#purchaseRequestID").val());
                showSupplierAndItem($("#supplierID"));
                $("#showPODetail").dialog("open");
                break;
            case 'add':
            default:
                clearFormData($("#poDetailForm"));
                $("#planNo").html(' ');
                $("#projectName").html(' ');
                $("#showSubmitDate").html(' ');
                $("#tabPoDetail").jqGrid("clearGridData", true);
                //設定並讀取項目列表
                $("#tabPRDetail").jqGrid().setGridParam({url: base_url + '/sendPRDetail/' + securityCode});
                $("#tabPRDetail").trigger("reloadGrid");
                $("#oper").attr('value', 'add');
                $("#cDate").datepicker('setDate', new Date());//建立時間
                $("#showCDate").html($("#cDate").val());
                $("#poDetailForm").find('#managerName').html(userName);//建立者資訊
                $("#poDetailForm").find('#managerID').attr('value', userID);
                $("#poDetailForm").get(0).reset();
                $("#outputPO").hide();
                $("#showPODetail").dialog("open");
                break;
        }
    }
    ;

    //輸出採購單
    $("#outputPO").click(function() {
        //打開pdf輸出視窗
        var targetID = $(this).parent().find('#id').val();
        //alert(targetID);
        window.open(localhost+'index.php/pdfOutput/index/po/'+targetID,
                'Output Purchase Order', 'width=850,height=1200');
        ev.preventDefault();
        return false;
    });
    //發送請購單
    $("#submit").click(function() {
        $("#submitDate").datepicker('setDate', new Date());//建立時間
        var data = {
            'id': $("#id").val()
                    , 'submitDate': $("#submitDate").val()
                    , 'oper': 'edit'
        };
        $.post(base_url + '/modify/purchaseOrder', data, function() {
            $("#showSubmitDate").html($("#submitDate").val());
            $("#poLocal").find(".localPOTab").each(function() {
                $(this).jqGrid("clearGridData", true);
                $(this).trigger("reloadGrid");
            });
            $("#showPODetail").dialog("close");
        })
    })
    //國內採購單編輯、刪除
    $("#editLocalPo").click(function() {
        var gr = jQuery("#tabPOLocal").jqGrid('getGridParam', 'selrow');
        if (gr != null) {
            //alert(gr);
            showPODetail('edit', gr);
        } else {
            alert("Please Select Row")
        }
        ;
    });
    $("#delLocalPo").click(function() {
        var gr = jQuery("#tabPOLocal").jqGrid('getGridParam', 'selrow');
        if (gr != null)
            jQuery("#tabPOLocal").jqGrid('delGridRow', gr, {reloadAfterSubmit: false});
        else
            alert("Please Select Row to delete!");
    });

    //海外採購單編輯、刪除
    $("#editOverPo").click(function() {
        var gr = jQuery("#tabPOOverseas").jqGrid('getGridParam', 'selrow');
        if (gr != null) {
            //alert(gr);
            showPODetail('edit', gr);
        } else {
            alert("Please Select Row")
        }
        ;
    });
    $("#delOverPo").click(function() {
        var gr = jQuery("#tabPOOverseas").jqGrid('getGridParam', 'selrow');
        if (gr != null)
            jQuery("#tabPOOverseas").jqGrid('delGridRow', gr, {reloadAfterSubmit: false});
        else
            alert("Please Select Row to delete!");
    });


    //P.O. Detail
    jQuery("#tabPoDetail").jqGrid({
        //url:base_url+'/sendServiceData',
        datatype: "json",
        colNames: [
            'No.'
                    , 'Code'
                    , 'Product/Service Name'
                    , 'Category'
                    , 'Description'
                    , 'Qty'
                    , 'UoM.'
                    , 'Unit Cost'
                    , 'Total Amt.'
        ],
        colModel: [
            {name: 'prno', index: 'prno', align: "left"}
            , {name: 'code', index: 'code', align: "left"}
            , {name: 'name', index: 'name', align: "left"}
            , {name: 'category', index: 'category', align: "left"}
            , {name: 'description', index: 'description', align: "left"}
            , {name: 'Qty', index: 'Qty', align: "left"}
            , {name: 'UoM', index: 'UoM', align: "left"}
            , {name: 'unitCost', index: 'unitCost', align: "left"}
            , {name: 'totalAmt.', index: 'totalAmt', align: "left"}
        ],
        rowNum: 20,
        rowList: [20, 40, 60],
        pager: '#PoDetailList',
        sortname: 'code',
        viewrecords: true,
        sortorder: "asc",
        width: 765,
        height: 250,
        onSelectRow: function(id) {
            $("#tabPoProcess").jqGrid('setGridParam', {url: base_url + '/sendPRProcess/' + $("#id").val() + '?id=' + id, page: 1});
            $("#tabPoProcess").trigger('reloadGrid');
        },
        editurl: base_url + "/modify/"
    });
    $("#tabPoDetail").jqGrid('navGrid', '#PoDetailList',
            {edit: false, add: false, del: false, search: false, view: false},
    {}, //edit options
            {}, // add options
            {reloadAfterSubmit: true}, // del options
    {}
    );

    //P.O Local Processes
    jQuery("#tabPoProcess").jqGrid({
        //url:base_url+'/sendPRDetail/'+securityCode,
        datatype: "json",
        colNames: [
            'Processes1'
                    , 'Processes2'
                    , 'Processes3'
                    , 'Processes4'
        ],
        colModel: [
            {name: 'processes1', index: 'processes1', align: "left", editable: true, sorttype: "date"}
            , {name: 'processes2', index: 'processes2', align: "left", editable: true, sorttype: "date"}
            , {name: 'processes3', index: 'processes3', align: "left", editable: true, sorttype: "date"}
            , {name: 'processes4', index: 'processes4', align: "left", editable: true, sorttype: "date"}
        ],
        rowNum: 20,
        rowList: [20, 40, 60],
        pager: '#poProcessesList',
        sortname: 'code',
        viewrecords: true,
        sortorder: "asc",
        caption: "Purchase Request Processes",
        width: 765,
        height: 60,
    });

    //確認流程完成
    $(document).on('click', '.checkProcess', function() {
        //alert($(this).attr('id'));
        $.ajax({
            url: base_url + '/changeProcess/'
                    , type: 'POST'
                    , data: "target=" + $(this).attr('id')
                    , dataType: 'json'
                    , async: false
                    , success: function(e) {
                if (e) {
                    $("#tabPoProcess").trigger("reloadGrid");
                }
            }
        })
    })

    //確認接收
    $(document).on('click', '.checkReceiving', function() {
        //alert($(this).attr('id'));
        $.ajax({
            url: base_url + '/changeReceiving/'
                    , type: 'POST'
                    , data: "target=" + $(this).attr('id')
                    , dataType: 'json'
                    , async: false
                    , success: function(e) {
                if (e) {
                    $("#tabPRReceiving").trigger("reloadGrid");
                }
            }
        })
    })

    //將資料移至倉儲
    $(document).on('click', '.inventoryPost', function() {
        $.ajax({
            url: base_url + '/postToInventory/'
                    , type: 'POST'
                    , data: 'id=' + $(this).attr('itemID')
                    , dataType: 'json'
                    , async: false
                    , success: function(e) {
                if (e) {
                    $("#tabPRReceiving").trigger("reloadGrid");
                }
            }
        })
    });

    //輸入發票號碼
    var inforDiv = $("#invoceInformation");
    function showInvoce(target, id) {
        var ret = target.jqGrid('getRowData', id);
        //alert(ret.code);		
        inforDiv.find("#showItemCode").html(ret.code);
        inforDiv.find("#itemID").attr('value', id);
        inforDiv.show();
    }

    $("#sendInvoceNo").click(function() {
        /*svar invoceData = [];
         invoceData['itemID'] = inforDiv.find("#itemID").attr('value');
         invoceData['invoceNo'] = inforDiv.find("#invoceNo").attr('value');
         invoceData['oper'] = 'edit';*/
        var invoceData = {
            "id": inforDiv.find("#itemID").attr('value')
                    , "invoceNo": inforDiv.find("#invoceNo").val()
                    , "oper": 'edit'
        };
        $.ajax({
            url: base_url + '/sendInvoceNo/'
                    , type: 'POST'
                    , data: invoceData
                    , dataType: 'json'
                    , async: false
                    , success: function(e) {
                //alert('success');
                $("#tabPOReceiving").trigger("reloadGrid");
            }
        })
    })

    //P.O. Receiving
    jQuery("#tabPOReceiving").jqGrid({
        //url:base_url+'/sendServiceData',
        datatype: "json",
        colNames: [
            'No.'
                    , 'Code'
                    , 'Product/Service Name'
                    , 'Qty'
                    , 'UoM'
                    , 'Date Received.'
                    , 'Received'
                    , 'Invoice No./Delivery'
        ],
        colModel: [
            {name: 'prno', index: 'prno', align: "left"}
            , {name: 'code', index: 'code', align: "left"}
            , {name: 'name', index: 'name', align: "left"}
            , {name: 'Qty', index: 'Qty', align: "left"}
            , {name: 'UoM', index: 'UoM', align: "left"}
            , {name: 'receivedDate', index: 'receivedDate', align: "left"}
            , {name: 'received.', index: 'received', align: "left"}
            , {name: 'invoceNo.', index: 'invoceNo', align: "left"}
        ],
        rowNum: 20,
        rowList: [20, 40, 60],
        pager: '#poReceivingList',
        sortname: 'code',
        viewrecords: true,
        sortorder: "asc",
        width: 765,
        height: 250,
        onSelectRow: function(id) {
            //alert(id);
            //showServDetail('edit',id);
            showInvoce($(this), id);
        },
        editurl: base_url + "/modify/"
    });
    $("#tabPOReceiving").jqGrid('navGrid', '#poReceivingList',
            {edit: false, add: false, del: false, search: false, view: false},
    {}, //edit options
            {}, // add options
            {reloadAfterSubmit: true}, // del options
    {}
    );

    //P.O. Local
    jQuery("#tabPOLocal").jqGrid({
        url: base_url + '/sendServiceData/0/',
        datatype: "json",
        colNames: [
            'P.O. No.'
                    , 'Creation Date'
                    , 'Prepared By'
                    , 'status'
                    , 'Supplier'
                    , 'Purchased By'
                    , 'Payment Date'
                    , 'Total Amount'
        ],
        colModel: [
            {name: 'purchaseOrderNo', index: 'purchaseOrderNo', align: "left"}
            , {name: 'cDate', index: 'cDate', align: "left"}
            , {name: 'managerID', index: 'managerID', align: "left"}
            , {name: 'status', index: 'status', align: "left"}
            , {name: 'supplierID', index: 'supplierID', align: "left"}
            , {name: 'purchaseID', index: 'purchaseID', align: "left"}
            , {name: 'paymentDate', index: 'paymentDate', align: "left"}
            , {name: 'totalAmt', index: 'totalAmt', align: "left"}
        ],
        rowNum: 20,
        rowList: [20, 40, 60],
        pager: '#poLocalList',
        sortname: 'code',
        viewrecords: true,
        sortorder: "asc",
        width: 765,
        height: 500,
        onSelectRow: function(id) {
            //alert(id);
            //showPODetail('edit',id);
        },
        editurl: base_url + "/modify/"
    });
    $("#tabPOLocal").jqGrid('navGrid', '#poLocalList',
            {edit: false, add: false, del: false, search: false, view: false},
    {}, //edit options
            {}, // add options
            {reloadAfterSubmit: true}, // del options
    {}
    );
    //P.O. Local Waitting for Approval Local
    jQuery("#tabLocalApproval").jqGrid({
        url: base_url + '/sendServiceData/0/1/',
        datatype: "json",
        colNames: [
            'P.O. No.'
                    , 'Creation Date'
                    , 'Prepared By'
                    , 'status'
                    , 'Supplier'
                    , 'Purchased By'
                    , 'Payment Date'
                    , 'Total Amount'
        ],
        colModel: [
            {name: 'purchaseOrderNo', index: 'purchaseOrderNo', align: "left"}
            , {name: 'cDate', index: 'cDate', align: "left"}
            , {name: 'managerID', index: 'managerID', align: "left"}
            , {name: 'status', index: 'status', align: "left"}
            , {name: 'supplierID', index: 'supplierID', align: "left"}
            , {name: 'purchaseID', index: 'purchaseID', align: "left"}
            , {name: 'paymentDate', index: 'paymentDate', align: "left"}
            , {name: 'totalAmt', index: 'totalAmt', align: "left"}
        ],
        rowNum: 20,
        rowList: [20, 40, 60],
        pager: '#localApprovalList',
        sortname: 'code',
        viewrecords: true,
        sortorder: "asc",
        width: 765,
        height: 500,
        onSelectRow: function(id) {
            //alert(id);
            showPODetail('edit', id);
        },
        editurl: base_url + "/modify/"
    });
    //P.O. Local Arriving/In-progress
    jQuery("#tabLocalArriving").jqGrid({
        url: base_url + '/sendServiceData/0/2/',
        datatype: "json",
        colNames: [
            'P.O. No.'
                    , 'Creation Date'
                    , 'Prepared By'
                    , 'status'
                    , 'Supplier'
                    , 'Purchased By'
                    , 'Payment Date'
                    , 'Total Amount'
        ],
        colModel: [
            {name: 'purchaseOrderNo', index: 'purchaseOrderNo', align: "left"}
            , {name: 'cDate', index: 'cDate', align: "left"}
            , {name: 'managerID', index: 'managerID', align: "left"}
            , {name: 'status', index: 'status', align: "left"}
            , {name: 'supplierID', index: 'supplierID', align: "left"}
            , {name: 'purchaseID', index: 'purchaseID', align: "left"}
            , {name: 'paymentDate', index: 'paymentDate', align: "left"}
            , {name: 'totalAmt', index: 'totalAmt', align: "left"}
        ],
        rowNum: 20,
        rowList: [20, 40, 60],
        pager: '#localArrivingList',
        sortname: 'code',
        viewrecords: true,
        sortorder: "asc",
        width: 765,
        height: 500,
        onSelectRow: function(id) {
            //alert(id);
            showPODetail('edit', id);
        },
        editurl: base_url + "/modify/"
    });
    //P.O. Local Completed
    jQuery("#tabLocalComplete").jqGrid({
        url: base_url + '/sendServiceData/0/3/',
        datatype: "json",
        colNames: [
            'P.O. No.'
                    , 'Creation Date'
                    , 'Prepared By'
                    , 'status'
                    , 'Supplier'
                    , 'Purchased By'
                    , 'Payment Date'
                    , 'Total Amount'
        ],
        colModel: [
            {name: 'purchaseOrderNo', index: 'purchaseOrderNo', align: "left"}
            , {name: 'cDate', index: 'cDate', align: "left"}
            , {name: 'managerID', index: 'managerID', align: "left"}
            , {name: 'status', index: 'status', align: "left"}
            , {name: 'supplierID', index: 'supplierID', align: "left"}
            , {name: 'purchaseID', index: 'purchaseID', align: "left"}
            , {name: 'paymentDate', index: 'paymentDate', align: "left"}
            , {name: 'totalAmt', index: 'totalAmt', align: "left"}
        ],
        rowNum: 20,
        rowList: [20, 40, 60],
        pager: '#localCompleteList',
        sortname: 'code',
        viewrecords: true,
        sortorder: "asc",
        width: 765,
        height: 500,
        onSelectRow: function(id) {
            //alert(id);
            showPODetail('edit', id);
        },
        editurl: base_url + "/modify/"
    });

    //P.O. Overseas
    jQuery("#tabPOOverseas").jqGrid({
        url: base_url + '/sendServiceData/1/',
        datatype: "json",
        colNames: [
            'P.O. No.'
                    , 'Creation Date'
                    , 'Prepared By'
                    , 'status'
                    , 'Supplier'
                    , 'Purchased By'
                    , 'Payment Date'
                    , 'Total Amount'
        ],
        colModel: [
            {name: 'prno', index: 'prno', align: "left"}
            , {name: 'cDate', index: 'cDate', align: "left"}
            , {name: 'managerID', index: 'managerID', align: "left"}
            , {name: 'status', index: 'status', align: "left"}
            , {name: 'supplierID', index: 'supplierID', align: "left"}
            , {name: 'purchaseID', index: 'purchaseID', align: "left"}
            , {name: 'paymentDate', index: 'paymentDate', align: "left"}
            , {name: 'totalAmt', index: 'totalAmt', align: "left"}
        ],
        rowNum: 20,
        rowList: [20, 40, 60],
        pager: '#poOverseasList',
        sortname: 'code',
        viewrecords: true,
        sortorder: "asc",
        width: 765,
        height: 500,
        onSelectRow: function(id) {
            //alert(id);
            //showPODetail('edit',id);
        },
        editurl: base_url + "/modify/"
    });
    $("#tabPOOverseas").jqGrid('navGrid', '#poOverseasList',
            {edit: false, add: false, del: false, search: false, view: false},
    {}, //edit options
            {}, // add options
            {reloadAfterSubmit: true}, // del options
    {}
    );
    //P.O. Overseas Waitting for Approval
    jQuery("#taboverseasApproval").jqGrid({
        url: base_url + '/sendServiceData/1/1/',
        datatype: "json",
        colNames: [
            'P.O. No.'
                    , 'Creation Date'
                    , 'Prepared By'
                    , 'status'
                    , 'Supplier'
                    , 'Purchased By'
                    , 'Payment Date'
                    , 'Total Amount'
        ],
        colModel: [
            {name: 'purchaseOrderNo', index: 'purchaseOrderNo', align: "left"}
            , {name: 'cDate', index: 'cDate', align: "left"}
            , {name: 'managerID', index: 'managerID', align: "left"}
            , {name: 'status', index: 'status', align: "left"}
            , {name: 'supplierID', index: 'supplierID', align: "left"}
            , {name: 'purchaseID', index: 'purchaseID', align: "left"}
            , {name: 'paymentDate', index: 'paymentDate', align: "left"}
            , {name: 'totalAmt', index: 'totalAmt', align: "left"}
        ],
        rowNum: 20,
        rowList: [20, 40, 60],
        pager: '#overseasApprovalList',
        sortname: 'code',
        viewrecords: true,
        sortorder: "asc",
        width: 765,
        height: 500,
        onSelectRow: function(id) {
            //alert(id);
            showPODetail('edit', id);
        },
        editurl: base_url + "/modify/"
    });
    //P.O. Local Arriving/In-progress
    jQuery("#taboverseasArriving").jqGrid({
        url: base_url + '/sendServiceData/1/2/',
        datatype: "json",
        colNames: [
            'P.O. No.'
                    , 'Creation Date'
                    , 'Prepared By'
                    , 'status'
                    , 'Supplier'
                    , 'Purchased By'
                    , 'Payment Date'
                    , 'Total Amount'
        ],
        colModel: [
            {name: 'purchaseOrderNo', index: 'purchaseOrderNo', align: "left"}
            , {name: 'cDate', index: 'cDate', align: "left"}
            , {name: 'managerID', index: 'managerID', align: "left"}
            , {name: 'status', index: 'status', align: "left"}
            , {name: 'supplierID', index: 'supplierID', align: "left"}
            , {name: 'purchaseID', index: 'purchaseID', align: "left"}
            , {name: 'paymentDate', index: 'paymentDate', align: "left"}
            , {name: 'totalAmt', index: 'totalAmt', align: "left"}
        ],
        rowNum: 20,
        rowList: [20, 40, 60],
        pager: '#overseasArrivingList',
        sortname: 'code',
        viewrecords: true,
        sortorder: "asc",
        width: 765,
        height: 500,
        onSelectRow: function(id) {
            //alert(id);
            showPODetail('edit', id);
        },
        editurl: base_url + "/modify/"
    });
    //P.O. Local Completed
    jQuery("#taboverseasComplete").jqGrid({
        url: base_url + '/sendServiceData/1/3/',
        datatype: "json",
        colNames: [
            'P.O. No.'
                    , 'Creation Date'
                    , 'Prepared By'
                    , 'status'
                    , 'Supplier'
                    , 'Purchased By'
                    , 'Payment Date'
                    , 'Total Amount'
        ],
        colModel: [
            {name: 'purchaseOrderNo', index: 'purchaseOrderNo', align: "left"}
            , {name: 'cDate', index: 'cDate', align: "left"}
            , {name: 'managerID', index: 'managerID', align: "left"}
            , {name: 'status', index: 'status', align: "left"}
            , {name: 'supplierID', index: 'supplierID', align: "left"}
            , {name: 'purchaseID', index: 'purchaseID', align: "left"}
            , {name: 'paymentDate', index: 'paymentDate', align: "left"}
            , {name: 'totalAmt', index: 'totalAmt', align: "left"}
        ],
        rowNum: 20,
        rowList: [20, 40, 60],
        pager: '#overseasCompleteList',
        sortname: 'code',
        viewrecords: true,
        sortorder: "asc",
        width: 765,
        height: 500,
        onSelectRow: function(id) {
            //alert(id);
            showPODetail('edit', id);
        },
        editurl: base_url + "/modify/"
    });
})