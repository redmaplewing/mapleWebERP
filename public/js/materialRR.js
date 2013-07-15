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
	var targetTable1='materialRequest';//定主目的資料庫表格
	var targetTable2='goodReturn';//定義退貨資料庫表格
	var mainTable1 = $("#requestTable");//定義頁面主要Grid的表格
	var mainTable2 = $("#returnTable");//定義頁面主要Grid的表格
	//定義頁面主要Grid的Div，因為僅供jqGrid使用，故回傳div的id字串
	var mainListName1= $("#requestList").attr('id');
	var mainListName2= $("#returnList").attr('id');
	var addBtn1 = $("#addRequest");
	var addBtn2 = $("#addReturn");
	var securityCode = "";
	
	//定義主表格欄位
	var gridColName1 = [
		'M.R. No.'
		,'Creation Date'
		,'Requested By'
		,'status'
		,'Project Code'
		,'Plan No.'
		,'Expected Date'
	];
	//定義主表格各欄位屬性設定
	var gridColModel1 = [
		{name:'no',index:'no',align:"left"}
		,{name:'creation',index:'creation',align:"left"}
		,{name:'request',index:'request',align:"left"}
		,{name:'status',index:'status',align:"left"}
		,{name:'code',index:'code',align:"left"}
		,{name:'planNo',index:'planNo',align:"left"}
		,{name:'expectedDate',index:'expectedDate',align:"left"}
	];
	//定義主表格欄位
	var gridColName2 = [
		'G.R. No.'
		,'Creadtion Date'
		,'Returned by'
		,'From'
		,'Returned date'
		,'Reason'
		,'To'
		,'Received & Inspected by'
	];
	//定義主表格各欄位屬性設定
	var gridColModel2 = [
		{name:'no',index:'no',align:"left"}
		,{name:'creadtionDate',index:'creadtionDate',align:"left"}
		,{name:'returned',index:'returned',align:"left"}
		,{name:'from',index:'from',align:"left"}
		,{name:'returnedDate',index:'returnedDate',align:"left"}
		,{name:'reason',index:'reason',align:"left"}
		,{name:'to',index:'to',align:"left"}
		,{name:'received',index:'received',align:"left"}
	];
	
	function setWarehouse(warehouseID){
		mainTable1.jqGrid("clearGridData", true);
		$("#approvalTable").jqGrid("clearGridData", true);
		$("#arrivingTable").jqGrid("clearGridData", true);
		$("#completedTable").jqGrid("clearGridData", true);
	
		mainTable1.jqGrid().setGridParam({url : base_url+'/sendMaterialData/'+warehouseID});
		$("#approvalTable").jqGrid().setGridParam({url : base_url+'/sendStatusData/1/'+warehouseID});
		$("#arrivingTable").jqGrid().setGridParam({url : base_url+'/sendStatusData/2/'+warehouseID});
		$("#completedTable").jqGrid().setGridParam({url : base_url+'/sendStatusData/3/'+warehouseID});
		
		mainTable1.trigger("reloadGrid");//重置項目表單
		$("#approvalTable").trigger("reloadGrid");//重置項目表單
		$("#arrivingTable").trigger("reloadGrid");//重置項目表單
		$("#completedTable").trigger("reloadGrid");//重置項目表單
	}
	
	$("#warehoustName").change(function(){
		setWarehouse($(this).val());
	});
	
	//定義介面基本Tabs,MaterialRequest
	$("#MaterialRRMainInterface").tabs();
	//Request Tabs
	$("#materialRequest").tabs();
	//Request Infomation Tabs
	$("#requestInfo").tabs();
	
	//Request Infomation Tabs
	$("#returnInfo").tabs();
	
	//定義時間按扭
	$("form").find('.date').each(function(){
		//alert($(this).attr('name'));
		$(this).datepicker();
		$(this).datepicker("option","dateFormat","yy-mm-dd");
	});
	//定義warehoust的Dialog
	dialogDiv1.dialog({
		width:800
		,autoOpen:false
		,closeText:"close"
	});
	dialogDiv2.dialog({
		width:800
		,autoOpen:false
		,closeText:"close"
	});
	//Request新增
	addBtn1.click(function(){
		$("#mRequestMode").html('Material Request');
		showFormDetail('add',"",dialogDiv1);
	});
	//Return新增
	addBtn2.click(function(){
		$("#mReturnMode").html('Goods Return');
		showFormDetail('add',"",dialogDiv2);
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
		getItemList('1',$(this).val());
	});
	
	//定義倉庫選單變動時狀態
	$("#from").change(function(){
		getGRItemList('1',$(this).val());
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
	
	//Request新增、編輯項目
	mainForm1.ajaxForm({
		success:function(){		
			//mainTable1.trigger("reloadGrid");
			$("#materialRequest").find(".materialRequest").each(function(){
				$(this).jqGrid("clearGridData", true);
				$(this).trigger("reloadGrid");
			});
			dialogDiv1.dialog("close");
			clearFormData(mainForm1);				
		}
	});
	
	//更換項目列表
	$("#mrDetailItemType").change(function(){			
			getItemList($(this).val(),mainForm1.find("#projectID").val());
	});
	//返回項目列表
	function getItemList($type,$project){
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
	//刪除MR項目
	$("#mrDetailDelItem").click(function(){
		var gr = jQuery("#requestDetailTable").jqGrid('getGridParam','selrow');
		if( gr != null ) jQuery("#requestDetailTable").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		else alert("Please Select Row to delete!");
	})
	
	//新增MR項目
	$("#mrDetailAddItem").click(function(){
		//alert(parseInt('word',10));
		var errMsg = '';
		var qty = mainForm1.find("#mrDetailItemQty").val();
		if($("#mrDetailItemType").val() == '3'){
			qty = '1';
		}
		//alert(qty);		
		if(isNaN(parseInt(qty,10)) && $("#mrDetailItemType").val() != '3'){
			errMsg = 'Qty is no a number';
		};
		if(qty == '' && $("#mrDetailItemType").val() != '3'){
			errMsg = 'Please insert Qty';
		};
		if(errMsg != ''){
			alert(errMsg);
			
		}else{
			var data = {
				'itemID':mainForm1.find("#mrDetailItemCode").val()
				,'qty':qty
				,'securityCode':mainForm1.find("#securityCode").val()
				,'oper':'add'
			};
			$.post(base_url+'/insertmrDetail/',data,function(){
				$("#requestDetailTable").jqGrid().setGridParam({url : base_url+'/sendmrDetail/'+securityCode});
				$("#requestDetailTable").trigger("reloadGrid");
			});
		}
	});
	
	//Return新增、編輯項目
	mainForm2.ajaxForm({
		success:function(){		
			$("#returnTable").trigger("reloadGrid");
			dialogDiv2.dialog("close");
			clearFormData(mainForm2);				
		}
	});
	
	//更換項目列表
	$("#grDetailItemType").change(function(){			
			getGRItemList($(this).val(),$("#returnForm").find("#from").val());
	});
	//返回項目列表
	function getGRItemList(type,warehouse){
		//alert(warehouse);
		if(warehouse != ''){
			$("#returnForm").find("#addItemArea").show();		
			$.ajax({
				url:base_url+'/returnGRItem/'
				,type:'POST'
				,data:"type="+type+"&wareHouseID="+warehouse
				,dataType:'json'
				,async:false
				,success:function(e){
					$("#grDetailItemCode").find('option').each(function(){
						if($(this).val() != ''){
							$(this).remove();
						};
					});
					for(i in e){
						var option = '<option value="'+i+'">'+e[i]+'</option>';
						$("#grDetailItemCode").append(option);
					}
				}
			})
		}else{
			//alert("Please Select warehouse");
		}
	}
	//新增MR項目
	$("#grDetailAddItem").click(function(){
		//alert(parseInt('word',10));
		var errMsg = '';
		var qty = mainForm2.find("#grDetailItemQty").val();
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
				'itemID':mainForm2.find("#grDetailItemCode").val()
				,'qty':qty
				,'remark':mainForm2.find("#returnRemark").val()
				,'securityCode':mainForm2.find("#securityCode").val()
				,'oper':'add'
			};
			$.post(base_url+'/insertgrDetail/',data,function(){
				$("#returnDetailTable").jqGrid().setGridParam({url : base_url+'/sendgrDetail/'+securityCode});
				$("#returnDetailTable").trigger("reloadGrid");
			});
		}
	});
	
	
	//發送請購單
	$("#submit").click(function(){
		$("#submitDate").datepicker('setDate', new Date());//建立時間
		var data = {
			'id':mainForm1.find("#id").val()
			,'submitDate':$("#submitDate").val()
			,'oper':'edit'
		};
		$.post(base_url+'/modify/materialRequest',data,function(){
			$("#showSubmitDate").html($("#submitDate").val());
		})
	})
	//清空表單
	function clearFormData(tar){
		//$(tar).get(0).reset();
		var inputName = '';
		tar.find('input').each(function(){
			if($(this).attr('type') != 'submit' && $(this).attr('type') != 'reset'  
				&& $(this).attr('name') != 'type' && $(this).attr('name') != 'managerID'
				&& $(this).attr('id') != 'print' && $(this).attr('type') != 'button'){
				$(this).attr('value','');
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
	
	//取得表單資料
	function getFormData(tar,table,id){
		var obj=null;//定義空的資料儲存陣列
		var tarID = id;
		$.ajax({
			url:base_url+'/getFunctionData/'+table
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
							if($(this).parent('select').attr('name') == 'projectID'){
								getPlan($(this).val());
							}	
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
	
	//顯示表單資料
	function showFormDetail(type,ids,tar){
		if(typeof ids == 'undefined'){
			ids=0;
		}
		if(typeof tar == 'undefined'){
			tar = dialogDiv1;
		}
		//alert(tar.attr('id'));
		switch(tar.attr('id')){
			case 'showMeterIalReturn':
				targetTable = targetTable2;
				tarType = 2;
			break;
			case 'materialRequest':
			default:
				targetTable = targetTable1;
				tarType = 1;
			break;
		}
		mainForm = tar.find('form');
		switch(type){				
			case 'edit':
				
				clearFormData(mainForm);
				mainForm.find('#oper').attr('value','edit');
				mainForm.find('#id').attr('value',ids)
				getFormData(mainForm,targetTable,ids);
				securityCode = mainForm.find("#securityCode").val();//取得識別碼
				//項目清單
				$("#requestDetailTable").jqGrid("clearGridData", true);
				$("#requestDetailTable").jqGrid().setGridParam({url : base_url+'/sendmrDetail/'+securityCode});
				$("#requestDetailTable").trigger("reloadGrid");//重置項目表單
				//項目接受表單
				$("#requestReceivingTable").jqGrid("clearGridData", true);
				$("#requestReceivingTable").jqGrid().setGridParam({url : base_url+'/sendMRReceiving/'+securityCode});
				$("#requestReceivingTable").trigger("reloadGrid");//重置項目表單
				//退貨項目表單
				$("#returnDetailTable").jqGrid("clearGridData", true);
				$("#returnDetailTable").jqGrid().setGridParam({url : base_url+'/sendgrDetail/'+securityCode});
				$("#returnDetailTable").trigger("reloadGrid");//重置項目表單
				//退貨項目送出表單
				$("#returnGoodsTable").jqGrid("clearGridData", true);
				$("#returnGoodsTable").jqGrid().setGridParam({url : base_url+'/sendGRReceiving/'+securityCode});
				$("#returnGoodsTable").trigger("reloadGrid");//重置項目表單
				mainForm.get(0).reset();
				//alert(tarType);
				switch(tarType){
					case 2:
						getGRItemList('1',mainForm.find('#from').val());
					break;
					case 1:
					default:
						getItemList('1',$("#projectID").val());
					break;
				}				
				securityCode = mainForm.find("#securityCode").val();
				mainForm.find("#showCDate").html(mainForm.find("#cDate").val());
				tar.dialog("open");
			break;
			case 'add':
			default:				
				securityCode = RandomNumber();//產生識別認證碼
				/*$("#requestDetailTable").jqGrid().setGridParam({url : base_url+'/sendMRDetail/'+securityCode});
				$("#requestDetailTable").trigger("reloadGrid");*/		
				$("#requestDetailTable").jqGrid("clearGridData", true);				
				$("#returnDetailTable").jqGrid("clearGridData", true);				
				clearFormData(mainForm);
				mainForm.find("#securityCode").attr('value',securityCode);//識別碼
				mainForm.find('#oper').attr('value','add');
				mainForm.find('#cDate').datepicker('setDate', new Date());//建立時間
				mainForm.find("#showCDate").html(mainForm.find("#cDate").val());
				mainForm.get(0).reset();
				$("#showSubmitDate").html(' ');
				tar.dialog("open");
			break;
		}
	};
	
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
					$("#requestReceivingTable").trigger("reloadGrid");
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
					$("#requestReceivingTable").trigger("reloadGrid");
				}
			}
		})
	});
	
	//確認退貨
	$(document).on('click','.checkGRReceiving',function(){
		//alert($(this).attr('id'));
		$.ajax({
			url:base_url+'/changeGrReceiving/'
			,type:'POST'
			,data:"target="+$(this).attr('id')
			,dataType:'json'
			,async:false
			,success:function(e){
				if(e){
					$("#returnGoodsTable").trigger("reloadGrid");
				}				
			}
		})
	})
	
	//將退貨資料移至倉儲
	$(document).on('click','.GRinventoryPost',function(){
		$.ajax({
			url:base_url+'/postGrToInventory/'
			,type:'POST'
			,data:'id='+$(this).attr('itemID')
			,dataType:'json'
			,async:false
			,success:function(e){
				if(e){
					$("#returnGoodsTable").trigger("reloadGrid");
				}
			}
		})
	});
	
	//Request編輯選中項
	$("#editRequest").click(function(){
		var gr = jQuery("#requestTable").jqGrid('getGridParam','selrow');
		if( gr != null ){
			//alert(gr);
			showFormDetail('edit',gr);
		}else{
			alert("Please Select Row")
		};
	})
	
	//Request刪除選中項
	$("#delReqeust").click(function(){
		var gr = jQuery("#requestTable").jqGrid('getGridParam','selrow');
		if( gr != null ) jQuery("#requestTable").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		else alert("Please Select Row to delete!");
	})
	
	//Request主頁面jqGrid
	mainTable1.jqGrid({
		url:base_url+'/sendMaterialData',
		datatype: "json",
		colNames:gridColName1,
		colModel:gridColModel1,
		rowNum:20,
		rowList:[20,40,60],
		pager: mainListName1,
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:250,
		onSelectRow: function(id) {
			//alert(id);
			//showServDetail('edit',id);
		},
		editurl:base_url+"/modify/"
	});
	mainTable1.jqGrid('navGrid',mainListName1,
		{edit:false,add:false,del:true,search:false,view:false},
		{}, //edit options
		{}, // add options
		{reloadAfterSubmit:true}, // del options
		{}
	);
	//reuqest approval
	$("#approvalTable").jqGrid({
		url:base_url+'/sendStatusData/1',
		datatype: "json",
		colNames:gridColName1,
		colModel:gridColModel1,
		rowNum:20,
		rowList:[20,40,60],
		pager: approvalTableList,
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:250,
		onSelectRow: function(id) {
			//alert(id);
			showServDetail('edit',id);
		},
		editurl:base_url+"/modify/"
	});
	//request arriving
	$("#arrivingTable").jqGrid({
		url:base_url+'/sendStatusData/2',
		datatype: "json",
		colNames:gridColName1,
		colModel:gridColModel1,
		rowNum:20,
		rowList:[20,40,60],
		pager: arrivingTableList,
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:250,
		onSelectRow: function(id) {
			//alert(id);
			showServDetail('edit',id);
		},
		editurl:base_url+"/modify/"
	});
	//request completed
	$("#completedTable").jqGrid({
		url:base_url+'/sendStatusData/3',
		datatype: "json",
		colNames:gridColName1,
		colModel:gridColModel1,
		rowNum:20,
		rowList:[20,40,60],
		pager: completedTableList,
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:250,
		onSelectRow: function(id) {
			//alert(id);
			showServDetail('edit',id);
		},
		editurl:base_url+"/modify/"
	});
	//request Detail
	$("#requestDetailTable").jqGrid({
		//url:base_url+'/sendServiceData',
		datatype: "json",
		colNames:[
			"No."
			,"Code"
			,"Product Name"
			,"Description"
			,"Qty"
			,"UoM"
			,"Unit Cost"
			,"Total Amt."
		],
		colModel:[
			{name:'no',index:'no',align:"left"}
			,{name:'code',index:'code',align:"left"}
			,{name:'productName',index:'productName',align:"left"}
			,{name:'description',index:'description',align:"left"}
			,{name:'Qty',index:'Qty',align:"left"}
			,{name:'UoM',index:'UoM',align:"left"}
			,{name:'unitCost',index:'unitCost',align:"left"}			
			,{name:'totalAmt',index:'totalAmt',align:"left"}
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: requestDetailList,
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:250,
		onSelectRow: function(id) {
			//alert(id);
			//showServDetail('edit',id);
		},
		editurl:base_url+"/modify/requestDetail"
	});
	$("#requestDetailTable").jqGrid('navGrid',requestDetailList,
		{edit:false,add:false,del:true,search:false,view:false},
		{}, //edit options
		{}, // add options
		{reloadAfterSubmit:true}, // del options
		{}
	);
	//request Receiving
	$("#requestReceivingTable").jqGrid({
		//url:base_url+'/sendServiceData',
		datatype: "json",
		colNames:[
			"No."
			,"Code"
			,"Product Name"
			,"Qty"
			,"Date Receivied"
			,"Post Inventory"
		],
		colModel:[
			{name:'no',index:'no',align:"left"}
			,{name:'code',index:'code',align:"left"}
			,{name:'productName',index:'productName',align:"left"}
			,{name:'Qty',index:'Qty',align:"left"}
			,{name:'receiviedDate',index:'receiviedDate',align:"left"}
			,{name:'post',index:'post',align:"left"}			
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: requestReceivingList,
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:250,
		onSelectRow: function(id) {
			//alert(id);
			showServDetail('edit',id);
		},
		editurl:base_url+"/modify/"
	});
	$("#requestReceivingTable").jqGrid('navGrid',requestReceivingList,
		{edit:false,add:false,del:true,search:false,view:false},
		{}, //edit options
		{}, // add options
		{reloadAfterSubmit:true}, // del options
		{}
	);
	
	//Return編輯選中項
	$("#editReturn").click(function(){
		var gr = jQuery("#returnTable").jqGrid('getGridParam','selrow');
		if( gr != null ){
			//alert(gr);
			showFormDetail('edit',gr,dialogDiv2);
		}else{
			alert("Please Select Row")
		};
	})
	
	//Return刪除選中項
	$("#delReturn").click(function(){
		var gr = jQuery("#returnTable").jqGrid('getGridParam','selrow');
		if( gr != null ) jQuery("#returnTable").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		else alert("Please Select Row to delete!");
	})
	
	//return Detail
	$("#returnDetailTable").jqGrid({
		//url:base_url+'/sendServiceData',
		datatype: "json",
		colNames:[
			"No."
			,"Code"
			,"Product Name"
			,"Description"
			,"Qty"
			,"UoM"
			,"Unit Cost"
			,"Total Amt."
		],
		colModel:[
			{name:'no',index:'no',align:"left"}
			,{name:'code',index:'code',align:"left"}
			,{name:'productName',index:'productName',align:"left"}
			,{name:'description',index:'description',align:"left"}
			,{name:'Qty',index:'Qty',align:"left"}
			,{name:'UoM',index:'UoM',align:"left"}
			,{name:'unitCost',index:'unitCost',align:"left"}			
			,{name:'totalAmt',index:'totalAmt',align:"left"}
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: returnDetailList,
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:250,
		onSelectRow: function(id) {
			//alert(id);
			//showServDetail('edit',id);
		},
		editurl:base_url+"/modify/"
	});
	$("#returnDetailTable").jqGrid('navGrid',returnDetailList,
		{edit:false,add:false,del:true,search:false,view:false},
		{}, //edit options
		{}, // add options
		{reloadAfterSubmit:true}, // del options
		{}
	);
	//request Receiving
	$("#returnGoodsTable").jqGrid({
		//url:base_url+'/sendServiceData',
		datatype: "json",
		colNames:[
			"No."
			,"Code"
			,"Product Name"
			,"Qty"
			,"Date Receivied"
			,"Post Inventory"
			,"Remark"
		],
		colModel:[
			{name:'no',index:'no',align:"left"}
			,{name:'code',index:'code',align:"left"}
			,{name:'productName',index:'productName',align:"left"}
			,{name:'Qty',index:'Qty',align:"left"}
			,{name:'receiviedDate',index:'receiviedDate',align:"left"}
			,{name:'post',index:'post',align:"left"}			
			,{name:'remark',index:'remark',align:"left"}			
		],
		rowNum:20,
		rowList:[20,40,60],
		pager: returnGoodsList,
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:250,
		onSelectRow: function(id) {
			//alert(id);
			//showServDetail('edit',id);
		},
		editurl:base_url+"/modify/"
	});
	$("#returnGoodsTable").jqGrid('navGrid',returnGoodsList,
		{edit:false,add:false,del:true,search:false,view:false},
		{}, //edit options
		{}, // add options
		{reloadAfterSubmit:true}, // del options
		{}
	);
	
	//Return主頁面jqGrid
	mainTable2.jqGrid({
		url:base_url+'/sendReturnData',
		datatype: "json",
		colNames:gridColName2,
		colModel:gridColModel2,
		rowNum:20,
		rowList:[20,40,60],
		pager: mainListName2,
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:250,
		onSelectRow: function(id) {
			//alert(id);
			//showServDetail('edit',id);
		},
		editurl:base_url+"/modify/goodReturn"
	});
	mainTable2.jqGrid('navGrid',mainListName2,
		{edit:false,add:false,del:true,search:false,view:false},
		{}, //edit options
		{}, // add options
		{reloadAfterSubmit:true}, // del options
		{}
	);
})