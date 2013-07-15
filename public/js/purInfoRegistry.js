$(function(){
	var id = 0;//定義目標序號變數
	//定義彈跳視窗
	//產品項目
	$("#detailWindow").dialog({
		width:700
		,autoOpen:false
		,closeText:"close"
		//,modal:true
	});
	//供應商
	$("#supDetailWindow").dialog({
		width:700
		,autoOpen:false
		,closeText:"close"
	});
	//Service 服務
	$("#ServiceDetailWindow").dialog({
		width:700
		,autoOpen:false
		,closeText:"close"
	});
	//定義頁籤視窗
	$("#pureMainInterface").tabs();//主視窗
	$("#tab-product").tabs();//產品項目
	$("#tabs").tabs();//產品細節
	$("#supTabs").tabs();
	$("#servTabs").tabs();
	//新增product
	$("#showDetail").click(function(){
		//alert('product');
		showDetail('add');
	});
	//新增供應商
	$("#showSupDetail").click(function(){
		//alert('supplier');
		supShowDetail('add');
	});
	//新增服務
	$("#addServiceDetail").click(function(){
		//alert('service');
		showServDetail('add');
	});
	//定義單位成本為spinner
	$("#ServFodifyForm").find("#unitCost").spinner({
		step:0.01
		,numberFormat:"n"
	});
	//定義單位成本為spinner
	$("#unitCost").spinner({
		step:0.01
		,numberFormat:"n"
	});
/* 	//定義基本庫存、最小訂量的slider
	$("#levelSlider").slider({
		range:"min"
		,value:5
		,min:1
		,max:30
		,slide:function(event,ui){
			$("#minimumLevel").val(ui.value);
		}
	});	
	$("#minimumLevel").val($("#levelSLider").slider("value"));		
	$("#QtySlider").slider({
		range:"min"
		,value:5
		,min:1
		,max:30
		,slide:function(event,ui){
			$("#defaultQty").val(ui.value);
		}
	});
	$("#defaultQty").val($("#QtySlider").slider("value")); */
	
	//清空表單
	function clearFormData(tar){
		$(tar).get(0).reset();
		var inputName = '';
		tar.find('input').each(function(){
			if($(this).attr('type') != 'submit' && $(this).attr('type') != 'reset'  && $(this).attr('name') != 'type'){
				$(this).attr('value','');
				inputName += $(this).attr('name')+"\n";
			}
			if($(this).attr('type') == 'file' && $(this).attr('name') == 'photo'){
				$(this).prev('img').attr('src',localhost+'/images/unknown-person.jpg')
			}
		});
		//alert(inputName);
		tar.find('select').find('option').each(function(){$(this).attr('selected',false);});
		tar.find('select').find('option').first().attr('selected',true);
		tar.find('textarea').each(function(){
			$(this).text('');
		});
	}
	
	//編輯時post資料
	function getItemData(tar,form,table){
		var obj=null;
		$.ajax({
			url:base_url+'/getItemData/'+table
			,type:'POST'
			,data:"ID="+tar
			,dataType:'json'
			,async:false//非同步處理設定
			//,beforeSend://驗證資料
			,success:function(e){
				obj = e;
				
				//設定基本庫存、最小訂量的slider
				form.find('.ui-slider').each(function(){
					//alert($(this).attr('name'));
					textBox = $(this).prev('input');
					//alert(textBox.attr('name'));
					if(obj[textBox.attr('name')] != 'undefined'){
						$(this).slider('value',obj[textBox.attr('name')]);
					};
				});
				//$("#levelSlider").slider('value',obj['minimumLevel']);
				//$("#QtySlider").slider('value',obj['defaultQty']);

				form.find('input').each(function(){
					//alert($(this).attr('name'));
					if($(this).attr('type') == 'file'){
						$(this).prev('img').attr('src',obj[$(this).attr('name')]);
					};
					if(obj[$(this).attr('name')] != 'undefined'){
						$(this).attr('value',obj[$(this).attr('name')]);
					}
				});
				
				
				var selectBox = form.find('select');
				
				
				selectBox.each(function(){
					var key = $(this).attr('name');
					$(this).find('option').each(function(){
						$(this).attr('selected',false);
						if($(this).attr('value') == obj[key]){
							$(this).attr('selected',true);
						}
					});
				});
				

				form.find('textarea').each(function(){
					if(obj[$(this).attr('name')] != 'undefined'){
						$(this).text('');
						$(this).text(obj[$(this).attr('name')]);
					}
				})
				form.find("#id").attr('value',obj[table+'ID']);
				
			}
			/*,error:
			,data:tar*/
		})
	}
	
	//定義顯示彈跳視窗的動作
	function showDetail(type,ids){
		if(typeof ids == 'undefined'){
			ids=0;
		}
		switch(type){				
			case 'edit':
				var gr = jQuery("#typeList").jqGrid('getGridParam','selrow');
				clearFormData($("#modifyForm"));
				$("#oper").attr('value','edit');					
				getItemData(ids,$("#modifyForm"),'item');
				$("#modifyForm").get(0).reset();
				id = $("#modifyForm").find("#id").val();
				$("#tabPriceHistory").jqGrid().setGridParam({url : base_url+'/sendPriceHistory/'+id});		
				$("#tabPriceHistory").trigger("reloadGrid");
				showitemDetail(gr);
				$("#mode").html('<p>Edit Product</p>');
				$("#detailWindow").dialog("open");
			break;
			case 'add':
			default:					
				//$("#modifyForm").clearForm();
				clearFormData($("#modifyForm"));
				$("#levelSlider").slider('value',1);
				$("#QtySlider").slider('value',1);
				$("#minimumLevel").attr('value',1);
				$("#defaultQty").attr('value',1);
				$("#oper").attr('value','add');
				$("#mode").html('<p>New Product</p>');
				$("#detailWindow").dialog("open");
			break;
		}
	};
	//定義供應商顯示彈跳視窗的動作
	function supShowDetail(type,ids){
		if(typeof ids == 'undefined'){
			ids=0;
		}
		switch(type){				
			case 'edit':
				clearFormData($("#supModifyForm"));
				clearFormData($("#supEvaModifyForm"));
				$("#supModifyForm").find("#oper").attr('value','edit');					
				$("#supEvaModifyForm").find("#oper").attr('value','edit');					
				getItemData(ids,$("#supModifyForm"),'supplier');
				getItemData(ids,$("#supEvaModifyForm"),'supplier');
				$("#supModifyForm").get(0).reset();
				$("#supEvaModifyForm").get(0).reset();
				$("#supMode").html('<p>Edit Suppliers</p>'); 
				$("#supDetailWindow").dialog("open");
			break;
			case 'add':
			default:					
				clearFormData($("#supModifyForm"));
				clearFormData($("#supEvaModifyForm"));
				$("#supModifyForm").find('#oper').attr('value','add');
				$("#supEvaModifyForm").find('#oper').attr('value','add');
				$("#supMode").html('<p>New Suppliers</p>'); 
				$("#supDetailWindow").dialog("open");
			break;
		}
	};
	$(".supEvaluation").change(function(){
		var tar = $("#totalScore");
		var score = 0;
		$(".supEvaluation").each(function(){
			//alert($(this).val());
			score += parseInt($(this).val(),10);
		})
		tar.val(score);
	})
	//定義服務顯示彈跳視窗的動作
	function showServDetail(type,ids){
		if(typeof ids == 'undefined'){
			ids=0;
		}
		switch(type){				
			case 'edit':				
				clearFormData($("#ServFodifyForm"));
				$("#ServFodifyForm").find("#oper").attr('value','edit');					
				getItemData(ids,$("#ServFodifyForm"),'item');
				$("#ServFodifyForm").get(0).reset();				
				$("#servMode").html('<p>Edit Servicet</p>');
				$("#ServiceDetailWindow").dialog("open");
			break;
			case 'add':
			default:					
				//$("#modifyForm").clearForm();
				clearFormData($("#ServFodifyForm"));
				$("#ServFodifyForm").find("#levelSlider").slider('value',1);
				$("#ServFodifyForm").find("#QtySlider").slider('value',1);
				$("#ServFodifyForm").find("#minimumLevel").attr('value',1);
				$("#ServFodifyForm").find("#defaultQty").attr('value',1);
				$("#ServFodifyForm").find("#oper").attr('value','add');
				$("#servMode").html('<p>New Service</p>');
				$("#ServiceDetailWindow").dialog("open");
			break;
		}
	};
	
	//重置並顯示採購歷程、使用歷程
	function showitemDetail(target){
		if(typeof target !='undefined'){
			//重置採購歷程
			$("#tabPurHistory").jqGrid('setGridParam',{url:base_url+'/sendPurHistory/'+target});
			$("#tabPurHistory").trigger('reloadGrid');
			//重置使用歷程
			$("#tabUsageHistory").jqGrid('setGridParam',{url:base_url+'/sendUsageHistory/'+target});
			$("#tabUsageHistory").trigger('reloadGrid');
		}		
	}
	
	//新增、編輯表單傳送
	$("#modifyForm").ajaxForm({
		success:function(){		
			$("#typeList").trigger("reloadGrid");
			$("#detailWindow").dialog("close");
			clearFormData($("#modifyForm"));				
		}
	});
	
	//供應商新增、編輯表單傳送
	$("#supModifyForm").ajaxForm({
		success:function(){		
			$("#tabSuppliers").trigger("reloadGrid");
			$("#supDetailWindow").dialog("close");
			clearFormData($("#supModifyForm"));				
		}
	});	
	
	//供應商評價新增、編輯表單傳送
	$("#supEvaModifyForm").ajaxForm({
		beforeSubmit:function(){
			//alert($("#supModifyForm").find("#oper").attr('value'));
			if($("#supModifyForm").find("#oper").attr('value') == 'add'){
				alert('Please Add & Save Supplier First');
				return false;
			}
		}
		,success:function(){		
			$("#tabSuppliers").trigger("reloadGrid");
			$("#supDetailWindow").dialog("close");
			clearFormData($("#supModifyForm"));				
		}
	});	
	
	//Service服務新增、編輯表單傳送
	$("#ServFodifyForm").ajaxForm({
		success:function(){		
			$("#tabServices").trigger("reloadGrid");
			$("#ServiceDetailWindow").dialog("close");
			clearFormData($("#ServFodifyForm"));				
		}
	});		
	
	//New Product編輯選中項
	$("#newEditSelect").click(function(){
		var gr = jQuery("#typeList").jqGrid('getGridParam','selrow');
		if( gr != null ){
			//alert(gr);
			showDetail('edit',gr);
		}else{
			alert("Please Select Row")
		};
	})
	
	//New Product刪除選中項
	$("#newDelSelect").click(function(){
		var gr = jQuery("#typeList").jqGrid('getGridParam','selrow');
		if( gr != null ) jQuery("#typeList").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		else alert("Please Select Row to delete!");
	})
	
	//New Suppliers編輯選中項
	$("#supplierEditSelect").click(function(){
		var gr = jQuery("#tabSuppliers").jqGrid('getGridParam','selrow');
		if( gr != null ){
			//alert(gr);
			supShowDetail('edit',gr);
		}else{
			alert("Please Select Row")
		};
	})
	
	//New Supplier刪除選中項
	$("#supplierDelSelect").click(function(){
		var gr = jQuery("#tabSuppliers").jqGrid('getGridParam','selrow');
		if( gr != null ) jQuery("#tabSuppliers").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		else alert("Please Select Row to delete!");
	})
	
	//New Survice編輯選中項
	$("#serviceEditSelect").click(function(){
		var gr = jQuery("#tabServices").jqGrid('getGridParam','selrow');
		if( gr != null ){
			//alert(gr);
			showServDetail('edit',gr);
		}else{
			alert("Please Select Row")
		};
	})
	
	//New Service刪除選中項
	$("#serviceDelSelect").click(function(){
		var gr = jQuery("#tabServices").jqGrid('getGridParam','selrow');
		if( gr != null ) jQuery("#tabServices").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		else alert("Please Select Row to delete!");
	})
	
	
	/*function showInventory(id){
		//清除Inventory Level,Need Restocking表單資料
		$("#tabInventoryLevel").jqGrid("clearGridData", true);
		$("#tabNeedRestocking").jqGrid("clearGridData", true);
		//重設Inventory Level,Need Restocking取得資料的網址
		$("#tabInventoryLevel").jqGrid().setGridParam({url : base_url+'/sendPRDetail/0/'+id});
		$("#tabNeedRestocking").jqGrid().setGridParam({url : base_url+'/sendPRDetail/1/'+id});
		//重新取得兩表單的資料
		$("#tabInventoryLevel").trigger("reloadGrid");
		$("#tabNeedRestocking").trigger("reloadGrid");
	}*/
	//刪除資料
	/*$("#delDetail").click(function(){
		var gr = jQuery("#typeList").jqGrid('getGridParam','selrow');
		if( gr != null ) jQuery("#typeList").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		else alert("Please Select Row to delete!");
	});*/
	//主表單資料
	jQuery("#typeList").jqGrid({
		url:base_url+'/sendQueryData',
		datatype: "json",
		colNames:['Product Code','Product Name','Description','Category','Supplier','UoM','Unit Cost'],
		colModel:[
			{name:'code',index:'code', width:100, align:"left"}
			,{name:'name',index:'name', width:100, align:"left"}
			,{name:'description',index:'description', width:150, align:"left"}
			,{name:'Category',index:'Category', width:70, align:"left"}
			,{name:'supplier',index:'supplier', width:100, align:"left"}
			,{name:'UoM',index:'UoM', width:40, align:"left"}
			,{name:'unitCost',index:'unitCost', width:40, align:"left"}					
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#pag_menuType',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:500,
		//caption:"New Product",
		//hidegrid:false,
		//altRows:true,
		//autoWidth:true,
		//multiselect:false,
		onSelectRow: function(id) {
			//alert(id);
			//showDetail('edit',id);
			//showInventory(id);
		},
		editurl:base_url+"/modify/"
	});
	$("#typeList").jqGrid('navGrid','#pag_menuType',
		{edit:false,add:false,del:false,search:false,view:false},
		{}, //edit options
		{}, // add options
		{reloadAfterSubmit:true}, // del options
		{}
	);
	//Product庫儲狀況
	jQuery("#tabInventoryLevel").jqGrid({
		url:base_url+'/inventoryCondition/0/',
		datatype: "json",
		colNames:[
			'Product Code'
			,'Product Name'
			,'Description'
			,'On Hand'
			,'Allocated'
			,'Avalliable'
			,'On Order'
			,'Current Level'
			,'Minimum Level'
			,'Location'
		],
		colModel:[
			{name:'code',index:'code',align:"left"}	
			,{name:'name',index:'name',align:"left"}	
			,{name:'description',index:'description',align:"left"}	
			,{name:'onHand',index:'onHand',align:"left"}	
			,{name:'allocated',index:'allocated',align:"left"}	
			,{name:'avalliable',index:'avalliable',align:"left"}	
			,{name:'onOrder',index:'onOrder',align:"left"}	
			,{name:'currentLevel',index:'currentLevel',align:"left"}	
			,{name:'minimumLevel',index:'minimumLevel',align:"left"}	
			,{name:'warehouseID',index:'warehouseID',align:"left"}	
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#InventoryLevelList',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:500,
		onSelectRow: function(id) {
			//alert(id);
			//showDetail('edit',id);
		},
		editurl:base_url+"/modify/"
	});
	//Product Need Restocking需叫貨項目
	jQuery("#tabNeedRestocking").jqGrid({
		url:base_url+'/inventoryCondition/1/',
		datatype: "json",
		colNames:[
			'Product Code'
			,'Product Name'
			,'Description'
			,'On Hand'
			,'Allocated'
			,'Avaliable'
			,'On Hand'
			,'Current Level'
			,'Minimum Level'
			,'Location'
		],
		colModel:[
			{name:'Product Code',index:'Product Code',align:"left"}	
			,{name:'Product Name',index:'Product Name',align:"left"}	
			,{name:'Description',index:'Description',align:"left"}	
			,{name:'On Hand',index:'On Hand',align:"left"}	
			,{name:'Allocated',index:'Allocated',align:"left"}	
			,{name:'Avalliable',index:'Avalliable',align:"left"}	
			,{name:'on Order',index:'on Order',align:"left"}	
			,{name:'Current Level',index:'Current Level',align:"left"}	
			,{name:'Minimum Level',index:'Minimum Level',align:"left"}	
			,{name:'location',index:'location',align:"left"}	
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#NeedRestockingList',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:500,
		onSelectRow: function(id) {
			//showDetail('edit',id);
		},
		editurl:base_url+"/modify/"
	});
	//Suppliers供應商
	jQuery("#tabSuppliers").jqGrid({
		url:base_url+'/sendSuppData',
		datatype: "json",
		colNames:[
			'Supplier Code'
			,'Company'
			,'First Name'
			,'Last Name'
			,'Gender'
			,'Position'
			,'Email Address'
			,'Phone'
			,'Status'
		],
		colModel:[
			{name:'supplierNo',index:'supplierNo',align:"left"}	
			,{name:'name',index:'name',align:"left"}	
			,{name:'nameFirst',index:'nameFirst',align:"left"}	
			,{name:'nameLast',index:'nameLast',align:"left"}	
			,{name:'gender',index:'gender',align:"left"}	
			,{name:'position',index:'position',align:"left"}	
			,{name:'email',index:'email',align:"left"}	
			,{name:'phone',index:'phone',align:"left"}	
			,{name:'statue',index:'statue',align:"left"}	
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#SuppliersList',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:500,
		onSelectRow: function(id) {
			//alert(id);
			//supShowDetail('edit',id);
		},
		editurl:base_url+"/modify/supplier"
	});
	$("#tabSuppliers").jqGrid('navGrid','#SuppliersList',
		{edit:false,add:false,del:false,search:false,view:false},
		{}, //edit options
		{}, // add options
		{reloadAfterSubmit:true}, // del options
		{}
	);
	//Service服務列表
	jQuery("#tabServices").jqGrid({
		url:base_url+'/sendServiceData',
		datatype: "json",
		colNames:[
			'Service Code'
			,'Service Name'
			,'Description'
			,'Cotegory'
			,'Supplier'
			,'Unit Cost'
		],
		colModel:[
			{name:'code',index:'code',align:"left"}	
			,{name:'name',index:'name',align:"left"}	
			,{name:'description',index:'description',align:"left"}	
			,{name:'cotegory',index:'cotegory',align:"left"}	
			,{name:'supplier',index:'supplier',align:"left"}	
			,{name:'unitCost',index:'unitCost',align:"left"}	
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#servicesList',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:500,
		onSelectRow: function(id) {
			//alert(id);
			//showServDetail('edit',id);
		},
		editurl:base_url+"/modify/"
	});
	$("#tabServices").jqGrid('navGrid','#servicesList',
		{edit:false,add:false,del:false,search:false,view:false},
		{}, //edit options
		{}, // add options
		{reloadAfterSubmit:true}, // del options
		{}
	);
	//Product Purchase History採購歷程
	jQuery("#tabPurHistory").jqGrid({
		//url:base_url+'/sendPurHistory',
		datatype: "json",
		colNames:[
			'P.O No.'
			,'Date'
			,'Supplier'
			,'Qty.'
			,'Amount'
			,'Received Date'
			,'Remarks'
		],
		colModel:[
			{name:'P.O No',index:'Product Code',align:"left"}	
			,{name:'Date',index:'Product Name',align:"left"}	
			,{name:'Supplier',index:'Supplier',align:"left"}	
			,{name:'Qty',index:'Qty',align:"left"}	
			,{name:'Amount',index:'Amount',align:"left"}	
			,{name:'Received Date',index:'Received Date',align:"left"}	
			,{name:'Remarks',index:'Remarks',align:"left"}	
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#purList',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:670,
		height:400,
		onSelectRow: function(id) {
			//alert(id);
			//showDetail('edit',id);
		},
		//editurl:base_url+"/modify/"
	});
	//Product Usage History使用歷程
	jQuery("#tabUsageHistory").jqGrid({
		//url:base_url+'/sendUsageHistory',
		datatype: "json",
		colNames:[
			'Purchase Request No.'
			,'Date'
			,'Project Code'
			,'Plan No.'
			,'Qty.'
			,'Amount'
			,'Remarks'
		],
		colModel:[
			{name:'Purchase Request No.',index:'Purchase Request No.',align:"left"}	
			,{name:'Date',index:'Date',align:"left"}	
			,{name:'Project Code',index:'Project Code',align:"left"}	
			,{name:'Plan No.',index:'Plan No.',align:"left"}	
			,{name:'Qty.',index:'Qty.',align:"left"}	
			,{name:'Amount',index:'Amount',align:"left"}	
			,{name:'Remarks',index:'Remarks',align:"left"}	
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#usageList',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:670,
		height:400,
		onSelectRow: function(id) {
			//alert(id);
			//showDetail('edit',id);
		},
		//editurl:base_url+"/modify/"
	});
	//Product Price History價格歷程
	jQuery("#tabPriceHistory").jqGrid({
		//url:base_url+'/sendPriceHistory/'+id,
		datatype: "json",
		colNames:[
			'Date'
			,'Previous Price'
			,'Price Difference'
			,'Remarks'
		],
		colModel:[
			{name:'cDate',index:'cDate',align:"left",editable:true,editoptions:{readonly:true,size:10}}	
			,{name:'previousPrice',index:'previousPrice',align:"left",editable:true,editoptions:{readonly:true,size:10}}	
			,{name:'priceDifference',index:'priceDifference',align:"left",editable:true,editoptions:{readonly:true,size:10}}	
			,{name:'remark',index:'remark',align:"left",editable: true,edittype:"textarea", editoptions:{rows:"2",cols:"20"}}	
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#priceList',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:670,
		height:400,
		editurl:base_url+"/modify/priceHistory"
	});
	jQuery("#tabPriceHistory").jqGrid('navGrid','#priceList',
		{view:false,edit:true,add:false,del:false,search:false}, //options
		{height:280,reloadAfterSubmit:false,closeAfterEdit: true}, // edit options
		{}, // add options
		{reloadAfterSubmit:false}, // del options
		{} // search options
	);
	//Service Purchase History採購歷程
	jQuery("#servTabPurHistory").jqGrid({
		//url:base_url+'/sendServPurHistory',
		datatype: "json",
		colNames:[
			'P.O No.'
			,'Date'
			,'Supplier'
			,'Qty.'
			,'Amount'
			,'Received Date'
			,'Remarks'
		],
		colModel:[
			{name:'P.O No',index:'Product Code',align:"left"}	
			,{name:'Date',index:'Product Name',align:"left"}	
			,{name:'Supplier',index:'Supplier',align:"left"}	
			,{name:'Qty',index:'Qty',align:"left"}	
			,{name:'Amount',index:'Amount',align:"left"}	
			,{name:'Received Date',index:'Received Date',align:"left"}	
			,{name:'Remarks',index:'Remarks',align:"left"}	
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#servPurList',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:670,
		height:400,
		onSelectRow: function(id) {
			//alert(id);
			showDetail('edit',id);
		},
		editurl:base_url+"/modify/"
	});
	//Service Usage History使用歷程
	jQuery("#servTabsUsageHistory").jqGrid({
		//url:base_url+'/sendServUsageHistory',
		datatype: "json",
		colNames:[
			'Purchase Request No.'
			,'Date'
			,'Project Code'
			,'Plan No.'
			,'Qty.'
			,'Amount'
			,'Remarks'
		],
		colModel:[
			{name:'Purchase Request No.',index:'Purchase Request No.',align:"left"}	
			,{name:'Date',index:'Date',align:"left"}	
			,{name:'Project Code',index:'Project Code',align:"left"}	
			,{name:'Plan No.',index:'Plan No.',align:"left"}	
			,{name:'Qty.',index:'Qty.',align:"left"}	
			,{name:'Amount',index:'Amount',align:"left"}	
			,{name:'Remarks',index:'Remarks',align:"left"}	
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#servUsageList',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:670,
		height:400,
		onSelectRow: function(id) {
			//alert(id);
			showDetail('edit',id);
		},
		editurl:base_url+"/modify/"
	});
	//Service Price History價格歷程
	jQuery("#servTabsPriceHistory").jqGrid({
		//url:base_url+'/sendServPriceHistory',
		datatype: "json",
		colNames:[
			'Date'
			,'Previous Price'
			,'Price Difference'
			,'Remarks'
		],
		colModel:[
			{name:'Date',index:'Date',align:"left"}	
			,{name:'Current Price',index:'Current Price',align:"left"}	
			,{name:'Price Difference',index:'Price Difference',align:"left"}	
			,{name:'Remarks',index:'Remarks',align:"left"}	
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#servPriceList',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:670,
		height:400,
		onSelectRow: function(id) {
			//alert(id);
			showDetail('edit',id);
		},
		editurl:base_url+"/modify/"
	});
})