$(function(){
	//alert('purchaseRequest');
	//定義新增時的辯識碼
	var securityCode = '';
	//定義PR基本Tabs
	$("#purRequestMainInterface").tabs();
	$("#poTabs").tabs();
	$("#prDetailForm").find('.date').each(function(){
		$(this).datepicker();
		$(this).datepicker("option","dateFormat","yy-mm-dd");
	});
	
	//定義New Purchase Request Interface
	$("#showPRDetail").dialog({
		width:800
		,autoOpen:false
		,closeText:"close"
	});
	//新增pr
	$("#addpr").click(function(){
		showPRDetail('add');
	});
	
	//清空圖紙下拉選單
	function clearSelect(tar){
		tar.find('option').each(function(){
			if($(this).val() != ''){
				$(this).remove();
			}
		})
	}
	//定義專案選單變動時狀態
	$("#projectID").change(function(){
		getPlan($(this).val());
	});
	
	//取得專案跟圖紙資料
	function getPlan(tar){
		if(tar == ''){
			clearSelect($("#planNo"));
		}
		//alert($(this).val());
		$.ajax({
			url:base_url+'/getProjData/'
			,type:'POST'
			,data:"key="+tar
			,dataType:'json'
			,async:false
			,success:function(e){
				clearSelect($("#planID"));
				for(var obj in e['plan']){
					//alert(e['plan'][obj]['planID']);
					var option = "<option value='"+e['plan'][obj]['drawingID']+"'>"+e['plan'][obj]['drawingNo']+"</option>";
					$("#planID").append(option);
				};
				$("#projectName").attr('value',e['project'][tar]['name']);
				$("#cusName").attr('value',e['project'][tar]['customerName']);
			}
		})
	};
	
	//新增、編輯請購單
	$("#prDetailForm").ajaxForm({
		success:function(){		
			$("#tabPurInProgress").trigger("reloadGrid");
			$("#tabPurCompleted").trigger("reloadGrid");
			$("#showPRDetail").dialog("close");
			clearFormData($("#prDetailForm"));				
		}
	});
	
	//更換項目列表
	$("#prDetailItemType").change(function(){
		//alert($(this).val());
		$.ajax({
			url:base_url+'/returnItem/'
			,type:'POST'
			,data:"type="+$(this).val()
			,dataType:'json'
			,async:false
			,success:function(e){
				$("#prDetailItemCode").find('option').each(function(){
					if($(this).val() != ''){
						$(this).remove();
					};
				});
				for(i in e){
					var option = '<option value="'+i+'">'+e[i]+'</option>';
					$("#prDetailItemCode").append(option);
				}
			}
		})
	});
	//新增PR項目
	$("#prDetailAddItem").click(function(){
		//alert(parseInt('word',10));
		var errMsg = '';
		var qty = $("#prDetailItemQty").val();
		//alert(qty);		
		if(isNaN(parseInt(qty,10))){
			errMsg = 'Qty is no a number';
		};
		if(qty == ''){
			errMsg = 'Please insert Qty';
		};
		if(errMsg != ''){
			alert(errMsg);
			
		}else{
			var data = {
				'itemID':$("#prDetailItemCode").val()
				,'qty':qty
				,'securityCode':$("#securityCode").val()
				,'oper':'add'
			};
			$.post(base_url+'/insertPrDetail/',data,function(){
				$("#tabPRDetail").jqGrid().setGridParam({url : base_url+'/sendPRDetail/'+securityCode});
				$("#tabPRDetail").trigger("reloadGrid");
			});
		}
	});
	//發送請購單
	$("#submit").click(function(){
		$("#submitDate").datepicker('setDate', new Date());//建立時間
		var data = {
			'id':$("#id").val()
			,'submitDate':$("#submitDate").val()
			,'oper':'edit'
		};
		$.post(base_url+'/modify/purchaseRequest',data,function(){
			$("#showSubmitDate").html($("#submitDate").val());
		})
	})
	//清空表單
	function clearFormData(tar){
		$(tar).get(0).reset();
		var inputName = '';
		tar.find('input').each(function(){
			if($(this).attr('type') != 'submit' && $(this).attr('type') != 'reset'  
				&& $(this).attr('name') != 'type' && $(this).attr('type') != 'button'){
				$(this).attr('value','');
				inputName += $(this).attr('name')+"\n";
			}				
		});
		//alert(inputName);
		tar.find('select').find('option').each(function(){$(this).attr('selected',false);});
		tar.find('select').find('option').first().attr('selected',true);
		tar.find('textarea').each(function(){
			$(this).text('');
		});
	}
	
	//取得表單資料
	function getItemData(tar){
		var obj=null;
		$.ajax({
			url:base_url+'/getPRData/'
			,type:'POST'
			,data:"ID="+tar
			,dataType:'json'
			,async:false//非同步處理設定
			//,beforeSend://驗證資料
			,success:function(e){
				obj = e;
				var form = $("#prDetailForm");
				var table = 'purchaseRequest';
				
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
				//將資料塞入input類別的欄位
				form.find('input').each(function(){
					//alert($(this).attr('name'));
					if(obj[$(this).attr('name')] != 'undefined'){
						$(this).attr('value',obj[$(this).attr('name')]);
					}
				});
				
				var selectBox = form.find('select');
				
				//將資料塞入select類別的欄位
				selectBox.each(function(){
					var key = $(this).attr('name');
					$(this).find('option').each(function(){
						$(this).attr('selected',false);
						if($(this).attr('value') == obj[key]){
							$(this).attr('selected',true);
							if($(this).parent('select').attr('name') == 'projectID'){
								getPlan($(this).val());
							}							
						}
					});
				});
				
				//將資料塞入textarea類別的欄位
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
	
	//操作表單控制項
	function formControl(type){
		//alert(type);
		switch(type){
			case "complete":
				$("#controlBar").hide();
				$("#addItem").hide();
			break;
			case "modify":
			default:
				$("#controlBar").show();
				$("#addItem").show();
			break;
		}
	}
	
	//顯示PR詳細資料
	function showPRDetail(type,ids){
		if(typeof ids == 'undefined'){
			ids=0;
		}
		var tar = $("#prDetailForm");
		//alert(type);
		switch(type){
			case 'complete':
				//alert('in complete');
				clearFormData(tar);//清除表格資料
				//tar.find("#oper").attr('value','edit');//設定表單狀態為組輯			
				getItemData(ids);//取得表單資料
				formControl('complete');
				securityCode = $("#securityCode").val();//取得識別碼
				$("#tabPRDetail").jqGrid().setGridParam({url : base_url+'/sendPRDetail/'+securityCode});//依識別碼取得pr項目列表		
				$("#tabPRDetail").trigger("reloadGrid");//重置項目表單
				$("#tabPRProcess").jqGrid("clearGridData", true);//清除處理程序表單
				$("#prDetailForm").get(0).reset();//重置表格
				tar.find('#managerName').html(userName);//設定表單Title
				tar.find('#managerID').attr('value',userID);//設定ManagerID	
				$("#showCDate").html($("#cDate").val());//將開始日期顯示於畫面上
				$("#showSubmitDate").html($("#submitDate").val());//將送出日期顯示於畫面上
				$("#showPRDetail").dialog("open");//開啟編輯選單
			break;
			case 'edit':				
				clearFormData(tar);//清除表格資料
				tar.find("#oper").attr('value','edit');//設定表單狀態為編輯			
				getItemData(ids);//取得表單資料
				formControl('modify');
				securityCode = $("#securityCode").val();//取得識別碼
				$("#tabPRDetail").jqGrid().setGridParam({url : base_url+'/sendPRDetail/'+securityCode});//依識別碼取得pr項目列表
				$("#tabPRReceiving").jqGrid().setGridParam({url : base_url+'/sendPRReceiving/'+securityCode});//依識別碼取得pr項目列表-簽收tab		
				$("#tabPRDetail").trigger("reloadGrid");//重置項目表單
				$("#tabPRReceiving").trigger("reloadGrid");//重置項目表單
				$("#tabPRProcess").jqGrid("clearGridData", true);
				$("#prDetailForm").get(0).reset();//重置表格
				tar.find('#managerName').html(userName);//設定表單Title
				tar.find('#managerID').attr('value',userID);//設定ManagerID	
				$("#showCDate").html($("#cDate").val());//將開始日期顯示於畫面上
				$("#showSubmitDate").html($("#submitDate").val());//將送出日期顯示於畫面上
				$("#showPRDetail").dialog("open");//開啟編輯選單
			break;
			case 'add':
			default:
				formControl('modify');
				securityCode = RandomNumber();//產生識別認證碼
				$.post(base_url+'/clearPRDetail/');//清除未歸於pr的項目
				//設定並讀取項目列表
				$("#tabPRDetail").jqGrid("clearGridData", true);
				$("#tabPRDetail").jqGrid().setGridParam({url : base_url+'/sendPRDetail/'+securityCode});
				$("#tabPRDetail").trigger("reloadGrid");
				//清空表單
				clearFormData(tar);
				//設定欄位預設數值
				$("#securityCode").attr('value',securityCode);//識別碼
				$("#oper").attr('value','add');//操作類別
				$("#cDate").datepicker('setDate', new Date());//建立時間
				$("#showCDate").html($("#cDate").val());
				tar.find('#managerName').html(userName);//建立者資訊
				tar.find('#managerID').attr('value',userID);
				$("#showPRDetail").dialog("open");//開啟編輯選單
			break;
		}
	};
	
	//alert($.now());
	
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
	
	$("#editpr").click(function(){
		var gr = jQuery("#tabPurInProgress").jqGrid('getGridParam','selrow');
		if( gr != null ){
			//alert(gr);
			showPRDetail('edit',gr);
		}else{
			alert("Please Select Row")
		};
	});
	$("#delpr").click(function(){
		var gr = jQuery("#tabPurInProgress").jqGrid('getGridParam','selrow');
		if( gr != null ) jQuery("#tabPurInProgress").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		else alert("Please Select Row to delete!");
	});
	
	//P.R. Detail
	jQuery("#tabPRDetail").jqGrid({
		//url:base_url+'/sendPRDetail/'+securityCode,
		datatype: "json",
		colNames:[
			'No.'
			,'Code'
			,'Product/Service Name'
			,'Description'
			,'Qty'
			,'UoM.'
			,'Unit Cost'
			,'Total Amt.'
		],
		colModel:[
			{name:'prno',index:'prno',align:"left"}	
			,{name:'code',index:'code',align:"left"}	
			,{name:'name',index:'name',align:"left"}	
			,{name:'description',index:'description',align:"left"}	
			,{name:'Qty',index:'Qty',align:"left"}	
			,{name:'UoM',index:'UoM',align:"left"}	
			,{name:'unitCost',index:'unitCost',align:"left"}	
			,{name:'totalAmt.',index:'totalAmt',align:"left"}	
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#prDetailList',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:250,
		onSelectRow: function(id) {
			$("#tabPRProcess").jqGrid('setGridParam',{url:base_url+'/sendPRProcess/'+$("#id").val()+'?id='+id,page:1});
			$("#tabPRProcess").trigger('reloadGrid');
		},
		editurl:base_url+"/modify/purchaseDetail"
	});
	
	//P.R. Detail Process
	var lastsel3;
	jQuery("#tabPRProcess").jqGrid({
		//url:base_url+'/sendPRDetail/'+securityCode,
		datatype: "json",
		colNames:[
			'Processes1'
			,'Processes2'
			,'Processes3'
			,'Processes4'
			,'Processes5'
			,'Processes6'
			,'Processes7'
			,'Processes8'
			,'Processes9'
		],
		colModel:[
			{name:'processes1',index:'processes1',align:"left",editable:true, sorttype:"date"}	
			,{name:'processes2',index:'processes2',align:"left",editable:true, sorttype:"date"}	
			,{name:'processes3',index:'processes3',align:"left",editable:true, sorttype:"date"}	
			,{name:'processes4',index:'processes4',align:"left",editable:true, sorttype:"date"}	
			,{name:'processes5',index:'processes5',align:"left",editable:true, sorttype:"date"}	
			,{name:'processes6',index:'processes6',align:"left",editable:true, sorttype:"date"}	
			,{name:'processes7',index:'processes7',align:"left",editable:true, sorttype:"date"}	
			,{name:'processes8',index:'processes8',align:"left",editable:true, sorttype:"date"}	
			,{name:'processes9',index:'processes9',align:"left",editable:true, sorttype:"date"}	
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#prPJrocessesList',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		caption: "Purchase Request Processes",
		width:765,
		height:60,
	});
	
	//確認流程完成
	$(document).on('click','.checkProcess',function(){
		//alert($(this).attr('id'));
		$.ajax({
			url:base_url+'/changeProcess/'
			,type:'POST'
			,data:"target="+$(this).attr('id')
			,dataType:'json'
			,async:false
			,success:function(e){
				if(e){
					$("#tabPRProcess").trigger("reloadGrid");
				}				
			}
		})
	})
	
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
				if(e){
					$("#tabPRReceiving").trigger("reloadGrid");
				}				
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
				if(e){
					$("#tabPRReceiving").trigger("reloadGrid");
				}
			}
		})
	});
	$("#tabPRDetail").jqGrid('navGrid','#prDetailList',
		{edit:false,add:false,del:false,search:false,view:false},
		{}, //edit options
		{}, // add options
		{reloadAfterSubmit:true}, // del options
		{}
	);
	/*
	var id = jQuery("#list2").jqGrid('getGridParam','selrow'); 
	if (id) {
		var ret = jQuery("#list2").jqGrid('getRowData',id); //3.6的方法
		//var ret = jQuery("#list2").getRowData(id);  //3.5以前的方法
		alert("id="+ret.id+" invdate="+ret.invdate+"...");
	} else {
		alert("Please select row");
	}
	*/
	var inforDiv = $("#invoceInformation");
	function showInvoce(target,id){
		var ret = target.jqGrid('getRowData',id);
		//alert(ret.code);		
		inforDiv.find("#showItemCode").html(ret.code);
		inforDiv.find("#itemID").attr('value',id);
		inforDiv.show();
	}
	
	$("#sendInvoceNo").click(function(){
		/*svar invoceData = [];
		invoceData['itemID'] = inforDiv.find("#itemID").attr('value');
		invoceData['invoceNo'] = inforDiv.find("#invoceNo").attr('value');
		invoceData['oper'] = 'edit';*/
		var invoceData = {
			"id" : inforDiv.find("#itemID").attr('value')
			,"invoceNo" : inforDiv.find("#invoceNo").val()
			,"oper" : 'edit'
		};
		$.ajax({
			url:base_url+'/sendInvoceNo/'
			,type:'POST'
			,data:invoceData
			,dataType:'json'
			,async:false
			,success:function(e){
				//alert('success');
				$("#tabPRReceiving").trigger("reloadGrid");				
			}
		})
	})
	
	//P.R. Receiving
	jQuery("#tabPRReceiving").jqGrid({
		//url:base_url+'/sendPRReceiving',
		datatype: "json",
		colNames:[
			'No.'
			,'Code'
			,'Product/Service Name'
			,'Description'
			,'Qty'
			,'UoM'
			,'Date Received.'
			,'Post to Inventory'
			,'Invoice No./Delivery'
		],
		colModel:[
			{name:'prno',index:'prno',align:"left"}	
			,{name:'code',index:'code',align:"left"}	
			,{name:'name',index:'name',align:"left"}	
			,{name:'description',index:'description',align:"left"}	
			,{name:'Qty',index:'Qty',align:"left"}	
			,{name:'UoM',index:'UoM',align:"left"}	
			,{name:'receivedDate',index:'receivedDate',align:"left"}	
			,{name:'postInventory.',index:'postInventory',align:"left"}	
			,{name:'invoceNo.',index:'invoceNo',align:"left"}	
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#prReceivingList',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:250,
		onSelectRow: function(id) {
			//alert(id);
			//showServDetail('edit',id);
			showInvoce($(this),id);
		},
		editurl:base_url+"/modify/purchaseDetail"
	});
	$("#tabPRReceiving").jqGrid('navGrid','#prReceivingList',
		{edit:false,add:false,del:false,search:false,view:false},
		{}, //edit options
		{}, // add options
		{reloadAfterSubmit:true}, // del options
		{}
	);
	
	//P.R. Arriving/In-Progress
	jQuery("#tabPurInProgress").jqGrid({
		url:base_url+'/sendPRData/0',
		datatype: "json",
		colNames:[
			'P.R. No.'
			,'Creation Date'
			,'Requested By'
			,'status'
			,'Project Code'
			,'Plan No.'
			,'Expected Date.'
		],
		colModel:[
			{name:'purchaseRequestNo',index:'purchaseRequestNo',align:"left"}	
			,{name:'cDate',index:'cDate',align:"left"}	
			,{name:'managerID',index:'managerID',align:"left"}	
			,{name:'status',index:'status',align:"left"}	
			,{name:'projectCode',index:'projectCode',align:"left"}	
			,{name:'planID',index:'planID',align:"left"}	
			,{name:'eDate',index:'eDate',align:"left"}		
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#PurInProgressList',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:500,		
		onSelectRow: function(id) {
			//alert(id);
			//showPRDetail('edit',id);
		},
		editurl:base_url+"/modify/"
	});
	$("#tabPurInProgress").jqGrid('navGrid','#PurInProgressList',
		{edit:false,add:false,del:false,search:false,view:false},
		{}, //edit options
		{}, // add options
		{reloadAfterSubmit:true}, // del options
		{}
	);
	//P.O Completed
	jQuery("#tabPurCompleted").jqGrid({
		url:base_url+'/sendPRData/1/',
		datatype: "json",
		colNames:[
			'P.R No.'
			,'Creation Date'
			,'Requested By'
			,'Status'
			,'Project Code'
			,'Plan No.'
			,'Expected Date'
		],
		colModel:[
			{name:'purchaseRequestNo',index:'purchaseRequestNo',align:"left"}	
			,{name:'cDate',index:'cDate',align:"left"}	
			,{name:'managerID',index:'managerID',align:"left"}	
			,{name:'status',index:'status',align:"left"}	
			,{name:'projectCode',index:'projectCode',align:"left"}	
			,{name:'planNo',index:'planNo',align:"left"}	
			,{name:'eDate',index:'eDate',align:"left"}	
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: '#PurCompleted',
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:500,
		onSelectRow: function(id) {
			//alert(id);
			showPRDetail('complete',id);
		},
		editurl:base_url+"/modify/"
	});
})