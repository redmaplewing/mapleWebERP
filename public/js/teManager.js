$(function(){
	//alert('purchaseRequest');
	//定義頁面基本原素
	var mainForm1 = $("#requestForm");//定義主要表單
	var mainForm2 = $("#returnForm");//定義主要表單
	var dialogDiv1 = $("#showMeterIalRequest");//定義Request彈跳視窗
	var dialogDiv2 = $("#showMeterIalReturn");//定義Return彈跳視窗
	var oper1 = mainForm1.find('#oper');//定義Request的oper欄位
	var oper2 = mainForm2.find('#oper');//定義Return的oper欄位
	var targetID1 =mainForm1.find('#id');//定義Request的id欄位
	var targetID2 =mainForm2.find('#id');//定義Return的id欄位
	var targetTable;//定主目的資料庫表格
	var mainTable1 = $("#repairTable");//定義頁面主要Grid的表格
	var mainTable2 = $("#returnTable");//定義頁面主要Grid的表格
	var mainTable2 = $("#returnTable");//定義頁面主要Grid的表格
	//定義頁面主要Grid的Div，因為僅供jqGrid使用，故回傳div的id字串
	var mainListName1= $("#requestList").attr('id');
	var mainListName2= $("#returnList").attr('id');
	var addBtn1 = $("#addRequest");
	var addBtn2 = $("#addReturn");

	//定義主表格欄位
	var gridColName = [
		'T.M No.'
		,'Requested By'
		,'status'
		,'Project Code'
		,'Project Name'
		,'Expected Date'
	];
	//定義主表格各欄位屬性設定
	var gridColModel = [
		{name:'itemHandleNo',index:'itemHandleNo',align:"left"}
		,{name:'managerID',index:'managerID',align:"left"}
		,{name:'status',index:'status',align:"left"}
		,{name:'projectNo',index:'projectNo',align:"left"}
		,{name:'projectName',index:'projectName',align:"left"}
		,{name:'eDate',index:'eDate',align:"left"}
	];

	//定義介面基本Tabs,Tools & Equipment Manager
	$("#TEManagerInterface").tabs();
	//manager Repair tabs
	$("#managerRepair").tabs();
	//manager Calibration tabs
	$("#managerCalibration").tabs();
	//manager Disposal tabs
	$("#managerDisposal").tabs();
	//repair detail tabs
	$("#repairInfo").tabs();
	//calibration detail tabs
	$("#calibrationInfo").tabs();
	//disposal detail tabs
	$("#disposalInfo").tabs();
	
	//定義時間按扭
	$("form").find('.date').each(function(){
		//alert($(this).attr('name'));
		$(this).datepicker();
		$(this).datepicker("option","dateFormat","yy-mm-dd");
	});
	//定義Repair的Dialog
	$("#showRepairRequest").dialog({
		width:800
		,autoOpen:false
		,closeText:"close"
	});
	//定義Calibration的Dialog
	$("#showCalibrationRequest").dialog({
		width:800
		,autoOpen:false
		,closeText:"close"
	});
	//定義Disposal的Dialog
	$("#showDisposalRequest").dialog({
		width:800
		,autoOpen:false
		,closeText:"close"
	});
	//Repair新增
	$("#addrrRequest").click(function(){
		$("#repairMode").html('Repair Request');
		showFormDetail('add',"",$("#showRepairRequest"));
	});
	//Calibation新增
	$("#addcRequest").click(function(){
		$("#calibrationMode").html('Calibation Request');
		showFormDetail('add',"",$("#showCalibrationRequest"));
	});
	//Disposal新增
	$("#adddRequest").click(function(){
		$("#disposalMode").html('Disposal Request');
		showFormDetail('add',"",$("#showDisposalRequest"));
	});
	
	//Repair檢視、編輯
	$("#editrrRequest").click(function(){
		$("#repairMode").html('Repair Request');
		//showFormDetail('add',"",$("#showRepairRequest"));
		var gr = jQuery("#rRepairTable").jqGrid('getGridParam','selrow');
		if( gr != null ){
			//alert(gr);
			showFormDetail('edit',gr,$("#showRepairRequest"));
		}else{
			alert("Please Select Row")
		};
	});
	//Calibation檢視、編輯
	$("#editcRequest").click(function(){
		$("#calibrationMode").html('Calibation Request');
		//showFormDetail('add',"",$("#showCalibrationRequest"));
		var gr = jQuery("#cRequestTable").jqGrid('getGridParam','selrow');
		if( gr != null ){
			//alert(gr);
			showFormDetail('edit',gr,$("#showCalibrationRequest"));
		}else{
			alert("Please Select Row")
		};
	});
	//Disposal檢視、編輯
	$("#editdRequest").click(function(){
		$("#disposalMode").html('Disposal Request');
		//showFormDetail('add',"",$("#showDisposalRequest"));
		var gr = jQuery("#dRequestTable").jqGrid('getGridParam','selrow');
		if( gr != null ){
			//alert(gr);
			showFormDetail('edit',gr,$("#showDisposalRequest"));
		}else{
			alert("Please Select Row")
		};
	});
		
	//Disposal新增、編輯項目
	$("#repairForm").ajaxForm({
		success:function(){		
			//$("#rRepairTable").trigger("reloadGrid");
			gridReload('1');
			$("#showRepairRequest").dialog("close");
			clearFormData($(this));				
		}
	});
	
	//Calibration新增、編輯項目
	$("#CalibrationForm").ajaxForm({
		success:function(){		
			gridReload('2');
			//$("#cRequestTable").trigger("reloadGrid");
			$("#showCalibrationRequest").dialog("close");
			clearFormData($(this));				
		}
	});
	
	//Disposal新增、編輯項目
	$("#disposalForm").ajaxForm({
		success:function(){	
			gridReload('3');		
			//$("#dRequestTable").trigger("reloadGrid");
			$("#showDisposalRequest").dialog("close");
			clearFormData($(this));				
		}
	});
	
	//依專案編號更換專案名稱
	$(document).on('change','.projectID',function(){
		//alert($(this).parents("form").attr('name'));
		$(this).parents("form").find("#projectName").attr("value",$(this).find("option:selected").attr("projectName"));
	})
	
	//發送維護單
	$(document).on('click','.submit',function(){
		var form = $(this).parents("form");
		form.find("#submitDate").datepicker('setDate', new Date());//建立時間
		var data = {
			'id':form.find("#id").val()
			,'submitDate':form.find("#submitDate").val()
			,'oper':'edit'
		};
		$.post(base_url+'/modify/',data,function(){
			form.find("#showSubmitDate").html(form.find("#submitDate").val());
		})
	});
	
	//新增維護項目
	$(document).on('click','.addItem',function(){
		var mainForm = $(this).parents("form");
		switch(mainForm.attr('name')){
			case "repairForm":
				var type = "1";
				var data = {
					'itemID':mainForm.find("#itemID").find("option:selected").val()
					,'securityCode':mainForm.find("#securityCode").val()
					,'qty':mainForm.find("#qty").val()
					,'amtSpent':mainForm.find("#amtSpent").val()
					,'purchaseOrderID':mainForm.find("#purchaseOrderID").find("option:selected").val()
					,'note':mainForm.find("#note").val()
					,'reason':mainForm.find("#reason").val()
					,'oper':'add'
				};
			break;
			case "CalibrationForm":
				var type = "2";
				var data = {
					'itemID':mainForm.find("#itemID").val()
					,'securityCode':mainForm.find("#securityCode").val()
					,'qty':mainForm.find("#qty").val()
					,'amtSpent':mainForm.find("#amtSpent").val()
					,'purchaseOrderID':mainForm.find("#purchaseOrderID").find("option:selected").val()
					,'note':mainForm.find("#note").val()
					,'cabliResult':mainForm.find("#cabliResult").val()
					,'reason':mainForm.find("#reason").val()
					,'oper':'add'
				};
			break;
			case "disposalForm":
				var type = "3";
				var data = {
					'itemID':mainForm.find("#itemID").val()
					,'securityCode':mainForm.find("#securityCode").val()
					,'reason':mainForm.find("#reason").val()
					,'oper':'add'
				};
			break;
		}
		$.post(base_url+'/insertDetail/',data,function(){
			var target = mainForm.find(".detailTable");
			var receiveTarget = mainForm.find(".receiveTable");
			var inputArea = mainForm.find("#addItemArea");
			//alert(inputArea.attr('id'));
			clearFormData(inputArea);
			loadDetail(target,mainForm.find("#securityCode").val());
			loadDetail(receiveTarget,mainForm.find("#securityCode").val(),type);
			/*
			target.jqGrid("clearGridData", true);
			target.jqGrid().setGridParam({url : base_url+'/sendDetail/'+securityCode});
			target.trigger("reloadGrid");
			receiveTarget.jqGrid("clearGridData", true);
			receiveTarget.jqGrid().setGridParam({url : base_url+'/sendDetail/'+securityCode});
			receiveTarget.trigger("reloadGrid");*/
		});
	});
	
	//清空表單
	function clearFormData(tar){
		//$(tar).get(0).reset();
		var inputName = '';
		tar.find('input').each(function(){
			if($(this).attr('type') != 'submit' && $(this).attr('type') != 'reset'  
				&& $(this).attr('name') != 'type' && $(this).attr('name') != 'managerID'
				&& $(this).attr('id') != 'print' && $(this).attr('type') != 'button'){
				$(this).attr('value',' ');
				//inputName += $(this).attr('name')+"\n";//將清空欄位寫入驗證訊息
			}				
		});
		//alert(inputName);//驗證表單清空的執行
		tar.find('select').each(function(){
			//取消所有select的option的選取
			$(this).find('option').each(function(){
				$(this).attr('selected',false);
			});
			$(this).find('option').first().attr('selected',true);
		});
		//將select的第一項option設定預設選取
		tar.find('textarea').each(function(){
			$(this).text('');
		});
	}
	
	//重置Grid
	function gridReload(type){
		var target = "";
		switch(type){
			case "3":
				target = ["dRequestTable","dApprovalTable","dInProgressTable","dCompletedTable"];
			break;
			case "2":
				target = ["cRequestTable","cApprovalTable","cInProgressTable","cCompletedTable"];
			break;			
			default:
			case "1":
				target = ["rRepairTable","rApprovalTable","rInProgressTable","rCompletedTable"];
			break;
		}
		for(i in target){				
			$("#"+target[i]).jqGrid("clearGridData", true);
			//$("#"+target[i]).jqGrid().setGridParam({url : base_url+url});
			$("#"+target[i]).trigger("reloadGrid");//重置項目表單
		}
	
	}
	
	//取得表單資料
	function getFormData(tar,table,id){
		//alert(id);
		var obj=null;//定義空的資料儲存陣列
		var tarID = id;
		$.ajax({
			url:base_url+'/getFunctionData/'
			,type:'POST'
			,data:"ID="+tarID
			,dataType:'json'
			,async:false//非同步處理設定
			//,beforeSend://驗證資料
			,success:function(e){
				obj = e;
				var form = tar;
				//設定功能的slider
				form.find('.ui-slider').each(function(){
					textBox = $(this).prev('input');
					if(obj[textBox.attr('name')] != 'undefined'){
						$(this).slider('value',obj[textBox.attr('name')]);
					};
				});

				form.find('input').each(function(){
					//alert($(this).attr('name'));
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
				form.find("#id").attr('value',tarID);
				
			}
			/*,error:
			,data:tar*/
		})
	}
	
	//返回項目列表
	function getItemList($project){
		if($project != ''){
			mainForm1.find("#addItemArea").show();		
			$.ajax({
				url:base_url+'/returnItem/'
				,type:'POST'
				,data:"type="+$type+"&project="+$project
				,dataType:'json'
				,async:false
				,success:function(e){
					$("#mrDetailItemCode").find('option').each(function(){
						if($(this).val() != ''){
							$(this).remove();
						};
					});
					for(i in e){
						var option = '<option value="'+i+'">'+e[i]+'</option>';
						mainForm1.find("#mrDetailItemCode").append(option);
					}
				}
			})
		}else{
			alert("Please Select Project");
		}
	}
	
	//顯示表單資料
	function showFormDetail(type,ids,tar){
		if(typeof ids == 'undefined'){
			ids=0;
		}
		if(typeof tar == 'undefined'){
			tar = dialogDiv;
		}
		var receiveType = "";
		mainForm = tar.find('form');
		switch(mainForm.attr('name')){
			case "repairForm":
				var receiveType = "1";
			break;
			case "CalibrationForm":
				var receiveType = "2";
			break;
			case "disposalForm":
				var receiveType = "3";
			break;
		}
		switch(type){				
			case 'edit':	
				clearFormData(mainForm);
				mainForm.find('#oper').attr('value','edit');
				mainForm.find('#id').attr('value',ids);				
				getFormData(mainForm,'',ids);
				mainForm.get(0).reset();
				securityCode = mainForm.find("#securityCode").val();//取得識別碼
				mainForm.find("#showCDate").html(mainForm.find("#cDate").val());
				mainForm.find("#projectName").attr('value',mainForm.find("#projectID").find("option:selected").attr('projectName'));
				mainForm.find("#showSubmitDate").html(mainForm.find("#submitDate").val());
				loadDetail(mainForm.find(".detailTable"),securityCode);
				loadDetail(mainForm.find(".receiveTable"),securityCode,receiveType);
				tar.dialog("open");
			break;
			case 'add':
			default:	
				securityCode = RandomNumber();//產生識別認證碼
				clearFormData(mainForm);
				mainForm.find("#securityCode").attr('value',securityCode);//識別碼
				mainForm.find('#oper').attr('value','add');
				mainForm.find('#cDate').datepicker('setDate', new Date());//建立時間
				mainForm.find("#showCDate").html(mainForm.find("#cDate").val());
				mainForm.get(0).reset();
				loadDetail(mainForm.find(".detailTable"),securityCode);
				loadDetail(mainForm.find(".receiveTable"),securityCode,receiveType);
				tar.dialog("open");
			break;
		}
	};
	
	//確認接收
	$(document).on('click','.checkReceiving',function(){
		//alert($(this).attr('id'));
		$.ajax({
			url:base_url+'/changeReceiving/'
			,type:'POST'
			,data:"target="+$(this).attr('id')
			,dataType:'json'
			,async:false
			,success:function(e){
				$(".receiveTable").each(function(){
					$(this).trigger("reloadGrid");
				})				
			}
		})
	})
	
	//將資料移至倉儲
	$(document).on('click','.inventoryPost',function(){
		$.ajax({
			url:base_url+'/postToInventory/'
			,type:'POST'
			,data:'id='+$(this).attr('itemID')
			,dataType:'json'
			,async:false
			,success:function(e){
				$(".receiveTable").each(function(){
					$(this).trigger("reloadGrid");
				})
			}
		})
	});
	
	function loadDetail(target,securityCode,type){
		if(typeof type == 'undefined'){
			type='0';
		}
		url = '/sendDetail/'+securityCode+"/"+type;
		target.jqGrid("clearGridData", true);
		target.jqGrid().setGridParam({url : base_url+url});
		target.trigger("reloadGrid");//重置項目表單
	}
	//產生驗證碼
	function RandomNumber()
	{
		var array1 = new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	　　var Str = "";
		for (var i=1; i<=10; i++)
		{
			index = Math.floor(Math.random() * array1.length);
			Str = Str +array1[index];
		}
		
		Str = Str + $.now();

	  　return Str;

	}
	
	var functionUrl = "/sendServiceData";
	var defaultUrl = {
		"rRepairTable":functionUrl+"/1/0"
		,"rApprovalTable":functionUrl+"/1/1"
		,"rInProgressTable":functionUrl+"/1/2"
		,"rCompletedTable":functionUrl+"/1/3"
		,"cRequestTable":functionUrl+"/2/0"
		,"cApprovalTable":functionUrl+"/2/1"
		,"cInProgressTable":functionUrl+"/2/2"
		,"cCompletedTable":functionUrl+"/2/3"
		,"dRequestTable":functionUrl+"/3/0"
		,"dApprovalTable":functionUrl+"/3/1"
		,"dInProgressTable":functionUrl+"/3/2"
		,"dCompletedTable":functionUrl+"/3/3"
	}
	
	$("#warehouseName").change(function(){
		if($(this).val != ''){
			var warehouseID = $(this).val();
			$(".defaultGrid").each(function(){
				var warehouseUrl = base_url + defaultUrl[$(this).attr('id')] + "/" + warehouseID;
				$(this).jqGrid("clearGridData", true);
				$(this).jqGrid().setGridParam({url : warehouseUrl});
				$(this).trigger("reloadGrid");
			})
		}
	})
	
	
	//主視窗各grid
	/*
	makeGrid($("#rRepairTable"),"rRepairList",functionUrl+"/1/0");//
	makeGrid($("#rApprovalTable"),"rApprovalList",functionUrl+"/1/1");
	makeGrid($("#rInProgressTable"),"rInProgressList",functionUrl+"/1/2");
	makeGrid($("#rCompletedTable"),"rCompletedList",functionUrl+"/1/3");
	makeGrid($("#cRequestTable"),"cRequestList",functionUrl+"/2/0");
	makeGrid($("#cApprovalTable"),"cApprovalList",functionUrl+"/2/1");
	makeGrid($("#cInProgressTable"),"cInProgressList",functionUrl+"/2/2");
	makeGrid($("#cCompletedTable"),"cCompletedList",functionUrl+"/2/3");
	makeGrid($("#dRequestTable"),"dRequestList",functionUrl+"/3/0");
	makeGrid($("#dApprovalTable"),"dApprovalList",functionUrl+"/3/1");
	makeGrid($("#dInProgressTable"),"dInProgressList",functionUrl+"/3/2");
	makeGrid($("#dCompletedTable"),"dCompletedList",functionUrl+"/3/3");
	*/
	
	makeGrid($("#rRepairTable"),"rRepairList",defaultUrl["rRepairTable"]);//
	makeGrid($("#rApprovalTable"),"rApprovalList",defaultUrl["rApprovalTable"]);
	makeGrid($("#rInProgressTable"),"rInProgressList",defaultUrl["rInProgressTable"]);
	makeGrid($("#rCompletedTable"),"rCompletedList",defaultUrl["rCompletedTable"]);
	makeGrid($("#cRequestTable"),"cRequestList",defaultUrl["cRequestTable"]);
	makeGrid($("#cApprovalTable"),"cApprovalList",defaultUrl["cApprovalTable"]);
	makeGrid($("#cInProgressTable"),"cInProgressList",defaultUrl["cInProgressTable"]);
	makeGrid($("#cCompletedTable"),"cCompletedList",defaultUrl["cCompletedTable"]);
	makeGrid($("#dRequestTable"),"dRequestList",defaultUrl["dRequestTable"]);
	makeGrid($("#dApprovalTable"),"dApprovalList",defaultUrl["dApprovalTable"]);
	makeGrid($("#dInProgressTable"),"dInProgressList",defaultUrl["dInProgressTable"]);
	makeGrid($("#dCompletedTable"),"dCompletedList",defaultUrl["dCompletedTable"]);
	
	var rDetailColName = [
		"No."
		,"Code"
		,"Tools & <br />Equip. Name"
		,"Description"
		/*,"Qty"
		,"UoM"*/
		,"Reason"
	];
	var rDetailColModel = [
		{name:'no',index:'no',align:"left"}
		,{name:'code',index:'code',align:"left"}
		,{name:'name',index:'name',align:"left"}
		,{name:'description',index:'description',align:"left"}
		/*,{name:'Qty',index:'Qty',align:"left"}
		,{name:'UoM',index:'UoM',align:"left"}*/
		,{name:'reason',index:'reason',align:"left"}
	];
	var rReceivingColName = [
		"No"
		,"Code"
		,"Tools & <br />Equip. Name"
		,"Qty"
		,"Amt. Spent"
		,"Ref.(LPO #)"
		,"Date Receivied"
		,"Post to <br />Tools & Equip."
		,"Mechanic's <br />Note"
	];
	var cReceivingColName = [
		"No"
		,"Code"
		,"Tools & <br />Equip. Name"
		,"Qty"
		,"Amt. Spent"
		,"Ref.(LPO #)"
		,"Date Receivied"
		,"Post to <br />Tools & Equip."
		,"Calib Result"
		,"Mechanic's <br />Note"
	];

	var rReceivingColModel = [
		{name:'no',index:'no',align:"left"}
		,{name:'code',index:'code',align:"left"}
		,{name:'name',index:'name',align:"left"}
		,{name:'Qty',index:'Qty',align:"left"}
		,{name:'amt',index:'amt',align:"left"}
		,{name:'ref',index:'ref',align:"left"}
		,{name:'receivedDate',index:'receivedDate',align:"left"}
		,{name:'post',index:'post',align:"left"}
		,{name:'note',index:'note',align:"left"}
	];
	var cReceivingColModel = [
		{name:'no',index:'no',align:"left"}
		,{name:'code',index:'code',align:"left"}
		,{name:'name',index:'name',align:"left"}
		,{name:'Qty',index:'Qty',align:"left"}
		,{name:'amt',index:'amt',align:"left"}
		,{name:'ref',index:'ref',align:"left"}
		,{name:'receivedDate',index:'receivedDate',align:"left"}
		,{name:'post',index:'post',align:"left"}
		,{name:'result',index:'result',align:"left"}
		,{name:'note',index:'note',align:"left"}
	];
	var toDisposedColName = [
		"No."
		,"Code"
		,"Product/<br />Service Name"
		,"Description"
		,"Description Date"
		,"Post to <br />Tools & Equip."
	];
	var toDisposedColModel = [
		{name:'no',index:'no',align:"left"}
		,{name:'code',index:'code',align:"left"}
		,{name:'name',index:'name',align:"left"}
		,{name:'description',index:'description',align:"left"}
		,{name:'descriptionDate',index:'descriptionDate',align:"left"}
		,{name:'post',index:'post',align:"left"}
	];
	//detail 各grid
	makeGrid($("#repairDetailTable"),"repairDetailList",'',rDetailColName,rDetailColModel);
	makeGrid($("#repairReceivingTable"),"repairReceivingList",'',rReceivingColName,rReceivingColModel);
	makeGrid($("#calibrationDetailTable"),"calibrationDetailList",'',rDetailColName,rDetailColModel);
	makeGrid($("#calibrationReceivingTable"),"calibrationReceivingList",'',cReceivingColName,cReceivingColModel);
	makeGrid($("#disposalDetailTable"),"disposalDetailList",'',rDetailColName,rDetailColModel);
	makeGrid($("#disposalReceivingTable"),"disposalReceivingList",'',toDisposedColName,toDisposedColModel);
	//Request主頁面jqGrid
	function makeGrid(tarTable,tarDiv,url,colName,colModel,tablename){
		if(typeof colName == 'undefined'){
			colName = gridColName;
		};
		if(typeof colModel == 'undefined'){
			colModel = gridColModel;
		};
		if(typeof tablename == 'undefined'){
			tablename = "itemHandle";
		}
		if(typeof url == 'undefined'){
			url = "sendServiceData";
		}
		tarTable.jqGrid({
			url:base_url+url,
			datatype: "json",
			colNames:colName,
			colModel:colModel,
			rowNum:20,
			rowList:[20,40,60],
			pager: tarDiv,
			sortname: 'code',
			viewrecords: true,
			sortorder: "asc",
			width:765,
			height:250,
			editurl:base_url+"/modify/"+tablename
		});
		tarTable.jqGrid('navGrid',tarDiv,
			{edit:false,add:false,del:true,search:false,view:false},
			{}, //edit options
			{}, // add options
			{reloadAfterSubmit:true}, // del options
			{}
		);
	}
	//產生每個功能的grid

})