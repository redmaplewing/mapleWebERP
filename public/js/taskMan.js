$(function(){
	
	//定義showRecruitmentRequest的Dialog	
	$("#showTaskInterface").dialog({
		width:800
		,autoOpen:false
		,closeText:"close"
	});
	var dialogDiv=$("#showTaskInterface");

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
	function getFormData(tar,id){
		//alert(id);
		var obj=null;//定義空的資料儲存陣列
		var tarID = id;
		$.ajax({
			url:base_url+'/getTaskData/'
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
		switch(type){				
			case 'edit':	
				clearFormData(mainForm);
				mainForm.find('#oper').attr('value','edit');
				mainForm.find('#id').attr('value',ids);				
				getFormData(mainForm,ids);
				mainForm.get(0).reset();
				tar.dialog("open");
			break;
			case 'add':
			default:	
				clearFormData(mainForm);
				mainForm.find('#oper').attr('value','add');
				mainForm.get(0).reset();
				tar.dialog("open");
			break;
		}
	};
	
	//新增Internal Memo
	$("#addTask").click(function(){
		showFormDetail('add');
	})
	
	//編輯Employee Leave
	$("#editTask").click(function(){
		var gr = jQuery("#taskTable").jqGrid('getGridParam','selrow');
		if( gr != null ){
			showFormDetail('edit',gr);
		}else{
			alert("Please Select Row")
		};
	})
	
	//刪除Employee Leave
	$("#delTask").click(function(){
		var gr = jQuery("#taskTable").jqGrid('getGridParam','selrow');
		if( gr != null ) jQuery("#taskTable").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		else alert("Please Select Row to delete!");
	});
	
	//表單控制
	$("#taskForm").ajaxForm({
		success:function(){		
			//$("#rRepairTable").trigger("reloadGrid");
			$("#taskTable").jqGrid("clearGridData", true);
			$("#taskTable").trigger("reloadGrid");
			dialogDiv.dialog("close");
			clearFormData($(this));				
		}
	});
	
	//定義主表格欄位
	var gridColName = [
		'No.'
		,'Specific Task'
		,'Assigned to'
		,'Assigned by'
		,'Petrol Allowance(Y or N)'
		,'Date Started'
		,'Expected'
		,'Actual'
		,'remark'
	];
	//定義主表格各欄位屬性設定
	var gridColModel = [
		{name:'no',index:'no',align:"left"}
		,{name:'title',index:'title',align:"left"}
		,{name:'assignedTo',index:'assignedTo',align:"left"}
		,{name:'assignedBy',index:'assignedBy',align:"left"}
		,{name:'petrolAllowance',index:'petrolAllowance',align:"left"}
		,{name:'startDate',index:'startDate',align:"left"}
		,{name:'expectedCompletion',index:'expectedCompletion',align:"left"}
		,{name:'actualCompletion',index:'actualCompletion',align:"left"}
		,{name:'remark',index:'remark',align:"left"}
	];
			
	makeGrid($("#taskTable"),"taskList",'1');

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
			url:base_url+'/sendTaskData/'+type,
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
			editurl:base_url+"/modify/",
			caption:'Task Management'
		});
	}

	//群組化RECRUITMENT DATABASE
	jQuery("#taskTable").jqGrid('setGroupHeaders', {
		useColSpanStyle: true, 
		groupHeaders:[
			{startColumnName: 'expectedCompletion', numberOfColumns: 2, titleText: 'Completion Date'},
		]	
	});

})