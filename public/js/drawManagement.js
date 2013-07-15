$(function(){
	//alert('purchaseRequest');
	//定義頁面基本原素
	var mainForm = $("#drawingForm");//定義主要表單
	var dialogDiv = $("#showModifyDrawing");//定義Request彈跳視窗
	var oper = mainForm.find('#oper');//定義Request的oper欄位
	var targetID =mainForm.find('#id');//定義Request的id欄位
	var targetTable = "project";//定主目的資料庫表格

	//定義主表格欄位
	var gridColName = [
		"Date"
		,"Drawing No."
		,"Project Name"
		,"Version No."
		,"Revision No."
		,"Description / Content of Change"
		,"Drawn by"
		,"Checked by"
		,"Approved by"
		,"PDF"
		,"AUTOCAD"
	];
	
	//定義主表格各欄位屬性設定
	var gridColModel = [
		{name:'cDate',index:'cDate',align:"left"}
		,{name:'drawingNo',index:'drawingNo',align:"left"}
		,{name:'projectID',index:'projectID',align:"left"}
		,{name:'version',index:'version',align:"left"/*,editable: true,edittype:"select",editoptions:{value:"0:Local;1:Overseas"},formatter:'select'*/}
		,{name:'revision',index:'revision',align:"left"}
		,{name:'description',index:'description',align:"left"}
		,{name:'draw',index:'draw',align:"left"}
		,{name:'check',index:'check',align:"left"}
		,{name:'approved',index:'approved',align:"left"}
		,{name:'pdfLink',index:'pdfLink',align:"left"}
		,{name:'autocadLink',index:'autocadLink',align:"left"}
	];

	var distributionGridName = [
		"Date"
		,"Drawing No."
		,"Project Name"
		,"Version No."
		,"Revision No."
		,"Description / Content of Change"
		,"GM"
		,"Deputy GM"
		,"Site Manager"
		,"Subcontractor"
		,"Client"
	];
	
	var distributionGridModel = [
		{name:'cDate',index:'cDate',align:"left"}
		,{name:'drawNo',index:'drawNo',align:"left"}
		,{name:'projectName',index:'projectName',align:"left"}
		,{name:'versionNo',index:'versionNo',align:"left"}
		,{name:'revisionNo',index:'revisionNo',align:"left"}
		,{name:'description',index:'description',align:"left"}
		,{name:'gm',index:'gm',align:"left"}
		,{name:'deputyGm',index:'deputyGm',align:"left"}
		,{name:'siteManager',index:'siteManager',align:"left"}
		,{name:'subcontractor',index:'subcontractor',align:"left"}
		,{name:'client',index:'client',align:"left"}
	];
	
	//定義介面基本Tabs,Tools & Equipment Manager
	$("#DrawingInterface").tabs();

	//定義時間按扭
	$("form").find('.date').each(function(){
		//alert($(this).attr('name'));
		$(this).datepicker();
		$(this).datepicker("option","dateFormat","yy-mm-dd");
	});
	//定義warehoust的Dialog
	$("#showModifyDrawing").dialog({
		width:800
		,autoOpen:false
		,closeText:"close"
	});

	//Add Project新增
	$("#addDraw").click(function(){
		$("#drawingMode").html('Add Drawing');
		showFormDetail('add',"",$("#showModifyDrawing"));
	});

		
	//圖紙新增、編輯項目
	$("#drawingForm").ajaxForm({
		success:function(){		
			$("#drawListTable").trigger("reloadGrid");
			$("#drawCheckTable").trigger("reloadGrid");
			$("#drawApprovalTable").trigger("reloadGrid");
			$("#drawDistributionTable").trigger("reloadGrid");
			dialogDiv.dialog("close");
			clearFormData($("#drawingForm"));				
		}
	});
	
	//圖紙檢視、編輯
	$("#editDraw").click(function(){
		var gr = jQuery("#drawListTable").jqGrid('getGridParam','selrow');
		if( gr != null ){
			//alert(gr);
			showFormDetail('edit',gr);
		}else{
			alert("Please Select Row")
		};
	});
	//圖紙刪除
	$("#delDraw").click(function(){
		var gr = jQuery("#drawListTable").jqGrid('getGridParam','selrow');
		if( gr != null ){
			jQuery("#drawListTable").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		}else{
			alert("Please Select Row to delete!");
		}
	});

	//清空表單
	function clearFormData(tar){
		//$(tar).get(0).reset();
		var inputName = '';
		tar.find('input').each(function(){
			if($(this).attr('type') != 'submit' && $(this).attr('type') != 'reset'  
				&& $(this).attr('name') != 'managerID'
				&& $(this).attr('name') != 'version' && $(this).attr('name') != 'revision'){
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
				
				form.find('input [type=checkbox]').each(function(){
					var key = $(this).attr('name');
					$(this).attr('checked',false);
					if(obj[$(this).attr('name')] != 'undefined' && obj[$(this).attr('name')] != ''){
						$(this).attr('checked',true);
					}
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
	//主視窗各grid
	makeGrid($("#drawListTable"),"drawListList");
	makeGrid($("#drawCheckTable"),"drawCheckList",gridColName,gridColModel,1);
	makeGrid($("#drawApprovalTable"),"drawApprovalList",gridColName,gridColModel,2);

	//Request主頁面jqGrid
	function makeGrid(tarTable,tarDiv,colName,colModel,type){
		if(typeof colName == 'undefined'){
			colName = gridColName;
		};
		if(typeof colModel == 'undefined'){
			colModel = gridColModel;
		};
		if(typeof type == 'undefined'){
			type = 0;
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
			/*onSelectRow: function(id) {
				//alert(id);
				showFormDetail('edit',id);
			},*/
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
			{startColumnName: 'pdfLink', numberOfColumns: 2, titleText: 'Download'}
			]	
		});
	};
	$("#drawDistributionTable").jqGrid({
		url:base_url+'/sendServiceData/4',
		datatype: "json",
		colNames:distributionGridName,
		colModel:distributionGridModel,
		rowNum:20,
		rowList:[20,40,60],
		pager: "drawDistributionList",
		sortname: 'code',
		viewrecords: true,
		sortorder: "asc",
		width:765,
		height:250,
		/*onSelectRow: function(id) {
			//alert(id);
			showFormDetail('edit',id);
		},*/
		editurl:base_url+"/modify/"
	});
	$("#drawDistributionTable").jqGrid('setGroupHeaders', {
		useColSpanStyle: true, 
		groupHeaders:[
			{startColumnName: 'gm', numberOfColumns: 5, titleText: 'Distributed to'}
		]	
	});
	
})