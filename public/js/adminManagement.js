$(function(){
	
	//定義showRecruitmentRequest的Dialog	
	$("#showInternalMemoInterface").dialog({
		width:800
		,autoOpen:false
		,closeText:"close"
	});
	var dialogDiv=$("#showInternalMemoInterface");
	
	//定義showRecruitmentRequest的Dialog	
	$("#showProceduresInterface").dialog({
		width:800
		,autoOpen:false
		,closeText:"close"
	});
	var dialogDiv2=$("#showProceduresInterface");

	//定義時間按扭
	$("form").find('.date').each(function(){
		//alert($(this).attr('name'));
		$(this).datepicker();
		$(this).datepicker("option","dateFormat","yy-mm-dd");
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
	
	//取得表單資料
	function getFormData(tar,id,type){
		//alert(id);
		var obj=null;//定義空的資料儲存陣列
		var tarID = id;
		$.ajax({
			url:base_url+'/getNewsData/'+type
			,type:'POST'
			,data:"ID="+tarID+"&type="+type
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
						if($(this).attr('type') == 'file'){
							$(this).next('div').html(obj[$(this).attr('name')]);
						}else if($(this).attr('name') == 'issuedDate2'){
							$(this).attr('value',obj['issuedDate'])
						}else{
							$(this).attr('value',obj[$(this).attr('name')]);
						}						
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
		var receiveType = "";
		mainForm = tar.find('form');
		var datatype = "";
		switch(mainForm.attr('name')){
			case 'proceduresForm':
				datatype = '2';
			break;
			case 'internalForm':
			default:
				datatype = '1';
			break;
		}
		switch(type){				
			case 'edit':	
				clearFormData(mainForm);
				mainForm.find('#oper').attr('value','edit');
				mainForm.find('#id').attr('value',ids);				
				getFormData(mainForm,ids,datatype);
				mainForm.get(0).reset();
				mainForm.find("#showCDate").html(mainForm.find("#cDate").val());
				tar.dialog("open");
			break;
			case 'add':
			default:	
				clearFormData(mainForm);
				mainForm.find('#oper').attr('value','add');
				mainForm.find('#cDate').datepicker('setDate', new Date());//建立時間
				mainForm.find("#showCDate").html(mainForm.find("#cDate").val());
				mainForm.get(0).reset();
				tar.dialog("open");
			break;
		}
	};
	
	//新增Internal Memo
	$("#addInternal").click(function(){
		showFormDetail('add');
	})
	
	//編輯Employee Leave
	$("#editInternal").click(function(){
		var gr = jQuery("#internalTable").jqGrid('getGridParam','selrow');
		if( gr != null ){
			showFormDetail('edit',gr);
		}else{
			alert("Please Select Row")
		};
	})
	
	//刪除Employee Leave
	$("#delInternal").click(function(){
		var gr = jQuery("#internalTable").jqGrid('getGridParam','selrow');
		if( gr != null ) jQuery("#internalTable").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		else alert("Please Select Row to delete!");
	});
	
	//新增Employee Leave
	$("#addProcedures").click(function(){
		showFormDetail('add','',dialogDiv2);
	})
	
	//編輯Employee Leave
	$("#editProcedures").click(function(){
		var gr = jQuery("#proceduresTable").jqGrid('getGridParam','selrow');
		if( gr != null ){
			//alert(gr);
			showFormDetail('edit',gr,dialogDiv2);
		}else{
			alert("Please Select Row")
		};
	})
	
	//刪除Employee Leave
	$("#delProcedures").click(function(){
		var gr = jQuery("#proceduresTable").jqGrid('getGridParam','selrow');
		if( gr != null ) jQuery("#proceduresTable").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		else alert("Please Select Row to delete!");
	});
	
	//表單控制
	$("#internalForm").ajaxForm({
		success:function(){		
			//$("#rRepairTable").trigger("reloadGrid");
			$("#internalTable").jqGrid("clearGridData", true);
			$("#internalTable").trigger("reloadGrid");
			dialogDiv.dialog("close");
			clearFormData($(this));				
		}
	});
	
	//表單控制
	$("#proceduresForm").ajaxForm({
		success:function(){		
			//$("#rRepairTable").trigger("reloadGrid");
			$("#proceduresTable").jqGrid("clearGridData", true);
			$("#proceduresTable").trigger("reloadGrid");
			dialogDiv2.dialog("close");
			clearFormData($(this));				
		}
	});
	
	//定義主表格欄位
	var gridColName = [
		'Memo No.'
		,'Date Issued'
		,'Subject'
		,'Download'
	];
	//定義主表格各欄位屬性設定
	var gridColModel = [
		{name:'code',index:'code',align:"left"}
		,{name:'issuedDate',index:'issuedDate',align:"left"}
		,{name:'title',index:'title',align:"left"}
		,{name:'file',index:'file',align:"left"}
	];
	//定義employeeLeaveTable欄位
	var proceduresColName = [
		'Code'
		,'Version'
		,'Revision'
		,'Date Issued'
		,'Title'
		,'download'
	];
	//定義主表格各欄位屬性設定
	var proceduresColModel = [
		{name:'code',index:'code',align:"left"}
		,{name:'version',index:'version',align:"left"}
		,{name:'revision',index:'revision',align:"left"}
		,{name:'issuedDate',index:'issuedDate',align:"left"}
		,{name:'title',index:'title',align:"left"}
		,{name:'file',index:'file',align:"left"}
	];

	//定義介面基本Tabs,Employee List
	$("#employeeListInterface").tabs();
			
	makeGrid($("#internalTable"),"attendanceList",'1');
	makeGrid($("#proceduresTable"),"employeeLeaveList",'2',proceduresColName,proceduresColModel);

	//Request主頁面jqGrid
	function makeGrid(tarTable,tarDiv,type,colName,colModel){
		if(typeof colName == 'undefined'){
			colName = gridColName;
		};
		if(typeof colModel == 'undefined'){
			colModel = gridColModel;
		};
		if(typeof type == 'undefined'){
			type='1';
		}
		tarTable.jqGrid({
			url:base_url+'/sendNewsData/'+type,
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
	}

	//群組化RECRUITMENT DATABASE
	jQuery("#attendanceTable").jqGrid('setGroupHeaders', {
		useColSpanStyle: true, 
		groupHeaders:[
			{startColumnName: 'employmentWorkDay', numberOfColumns: 10, titleText: 'Total'},
		]	
	});

})