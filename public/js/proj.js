$(function(){
	//alert('purchaseRequest');
	//定義頁面基本原素
	var mainForm = $("#projectForm");//定義主要表單
	var dialogDiv = $("#showModifyProject");//定義Request彈跳視窗
	var oper = mainForm.find('#oper');//定義Request的oper欄位
	var targetID =mainForm.find('#id');//定義Request的id欄位
	var targetTable = "project";//定主目的資料庫表格

	//定義主表格欄位
	var gridColName = [
		"Date"
		,"Project No."
		,"Project Name"
		,"Location"
		,"Client Name"
		,"Person in Charge(Site Manager)"
		,"As per Contact"
		,"Actual"
		,"As per Contact"
		,"Actual"
	];
	
	//定義主表格各欄位屬性設定
	var gridColModel = [
		{name:'cDate',index:'cDate',align:"left"}
		,{name:'projectNo',index:'projectNo',align:"left"}
		,{name:'name',index:'name',align:"left"}
		,{name:'location',index:'location',align:"left",editable: true,edittype:"select",editoptions:{value:"0:Local;1:Overseas"},formatter:'select'}
		,{name:'clientName',index:'clientName',align:"left"}
		,{name:'siteManager',index:'siteManager',align:"left"}
		,{name:'perContactStart',index:'perContactStart',align:"left"}
		,{name:'actualStart',index:'actualStart',align:"left"}
		,{name:'perContactCompletion',index:'perContactCompletion',align:"left"}
		,{name:'actualCompletion',index:'actualCompletion',align:"left"}
	];

	var negotiationGridName = [
		"Date"
		,"inquiry No."
		,"Client Name"
		,"Location"
		,"Negotiating Person/Team"		
		,"Status"//,"Closed Deal","Declined","Cancelled"
	];
	
	var negotiationGridModel = [
		{name:'cDate',index:'cDate',align:"left"}
		,{name:'inquiryNo',index:'inquiryNo',align:"left"}
		,{name:'clientName',index:'clientName',align:"left"}
		,{name:'location',index:'location',align:"left"}
		,{name:'negotiating',index:'negotiating',align:"left"}
		,{name:'negotiatingStatus',index:'negotiatingStatus',align:"left"}
	];
	
	//定義介面基本Tabs,Tools & Equipment Manager
	$("#projectInterface").tabs();

	//案件為洽談中時才顯示洽談中選項
	function checkProjStatus(){
		$("#underNegotiating").hide();
		if($("#status").val() == 0){
			$("#underNegotiating").show();
		}
	}
	//定義時間按扭
	$("form").find('.date').each(function(){
		//alert($(this).attr('name'));
		$(this).datepicker();
		$(this).datepicker("option","dateFormat","yy-mm-dd");
	});
	//定義warehoust的Dialog
	$("#showModifyProject").dialog({
		width:800
		,autoOpen:false
		,closeText:"close"
	});

	//Add Project新增
	$("#addProj").click(function(){
		$("#projectMode").html('Add Project');
		showFormDetail('add',"",$("#showModifyProject"));
	});

		
	//Disposal新增、編輯項目
	$("#projectForm").ajaxForm({
		success:function(){		
			$("#projListTable").trigger("reloadGrid");
			$("#projNegotiationTable").trigger("reloadGrid");
			$("#projInProgressTable").trigger("reloadGrid");
			$("#projInProgressList").trigger("reloadGrid");
			dialogDiv.dialog("close");
			clearFormData($("#projectForm"));				
		}
	});

	//清空表單
	function clearFormData(tar){
		//$(tar).get(0).reset();
		var inputName = '';
		tar.find('input').each(function(){
			if($(this).attr('type') != 'submit' && $(this).attr('type') != 'reset'  
				&& $(this).attr('name') != 'type' && $(this).attr('name') != 'managerID'
				&& $(this).attr('id') != 'print'){
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
	
	//顯示表單資料
	function showFormDetail(type,ids,tar){
		if(typeof ids == 'undefined'){
			ids=0;
		}
		if(typeof tar == 'undefined'){
			tar = dialogDiv;
		}
		mainForm = tar.find('form');
		switch(type){				
			case 'edit':				
				clearFormData(mainForm);			
				getFormData(mainForm,targetTable,ids);
				mainForm.find('#oper').attr('value','edit');
				mainForm.find('#id').attr('value',ids);
				checkProjStatus();
				mainForm.get(0).reset();
				$("#showCDate").html($("#cDate").val());
				tar.dialog("open");
			break;
			case 'add':
			default:					
				clearFormData(mainForm);
				mainForm.find('#oper').attr('value','add');				
				mainForm.get(0).reset();
				$("#cDate").datepicker('setDate', new Date());
				$("#showCDate").html($("#cDate").val());
				tar.dialog("open");
			break;
		}
	};
	
	//Project檢視、編輯
	$("#editProj").click(function(){
		var gr = jQuery("#projListTable").jqGrid('getGridParam','selrow');
		if( gr != null ){
			//alert(gr);
			showFormDetail('edit',gr);
		}else{
			alert("Please Select Row")
		};
	});
	//project刪除
	$("#delProj").click(function(){
		var gr = jQuery("#projListTable").jqGrid('getGridParam','selrow');
		if( gr != null ){
			jQuery("#projListTable").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		}else{
			alert("Please Select Row to delete!");
		}
	});
	//主視窗各grid
	makeGrid($("#projListTable"),"projListList");
	makeGrid($("#projInProgressTable"),"projInProgressList",gridColName,gridColModel,1);
	makeGrid($("#projCompletedTable"),"projCompletedList",gridColName,gridColModel,2);

	//Request主頁面jqGrid
	function makeGrid(tarTable,tarDiv,colName,colModel,type){
		if(typeof colName == 'undefined'){
			colName = gridColName;
		};
		if(typeof colModel == 'undefined'){
			colModel = gridColModel;
		};
		if(typeof type == 'undefined'){
			type = 3;
		}
		tarTable.jqGrid({
			url:base_url+'/sendServiceData/'+type,
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
			editurl:base_url+"/modify/"
		});
		tarTable.jqGrid('navGrid',tarDiv,
			{edit:false,add:false,del:true,search:false,view:false},
			{}, //edit options
			{}, // add options
			{reloadAfterSubmit:true}, // del options
			{}
		);
		tarTable.jqGrid('setGroupHeaders', {
			useColSpanStyle: true, 
			groupHeaders:[
			{startColumnName: 'perContactStart', numberOfColumns: 2, titleText: 'Starting Date'},
			{startColumnName: 'perContactCompletion', numberOfColumns: 2, titleText: 'Completion Date'}
			]	
		});
	};
	$("#projNegotiationTable").jqGrid({
		url:base_url+'/sendServiceData/0',
		datatype: "json",
		colNames:negotiationGridName,
		colModel:negotiationGridModel,
		rowNum:20,
		rowList:[20,40,60],
		pager: projNegotiationList,
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:250,
		editurl:base_url+"/modify/"
	});
	$("#projNegotiationTable").jqGrid('navGrid',projNegotiationList,
		{edit:false,add:false,del:true,search:false,view:false},
		{}, //edit options
		{}, // add options
		{reloadAfterSubmit:true}, // del options
		{}
	);
	
})