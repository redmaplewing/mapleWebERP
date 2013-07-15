$(function(){
	
	//定義時間按扭
	$("form").find('.date').each(function(){
		//alert($(this).attr('name'));
		$(this).datepicker();
		$(this).datepicker("option","dateFormat","yy-mm-dd");
	});

	//定義showRecruitmentRequest的Dialog	
	$("#showRecruitmentRequest").dialog({
		width:800
		,autoOpen:false
		,closeText:"close"
	});
	var dialogDiv=$("#showRecruitmentRequest");
	
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
			url:base_url+'/getEmployeeData/'
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
		var receiveType = "";
		mainForm = tar.find('form');
		switch(type){				
			case 'edit':	
				clearFormData(mainForm);
				mainForm.find('#oper').attr('value','edit');
				mainForm.find('#id').attr('value',ids);		
				mainForm.find("#employeeAccount").hide();				
				getFormData(mainForm,ids);
				mainForm.get(0).reset();
				mainForm.find("#showCDate").html(mainForm.find("#cDate").val());
				/*預留，改為approvalDate
				mainForm.find("#showSubmitDate").html(mainForm.find("#submitDate").val());
				*/
				tar.find("#mode").html('Shortlisted Information');
				tar.dialog("open");
			break;
			case 'add':
			default:	
				clearFormData(mainForm);
				mainForm.find('#oper').attr('value','add');
				mainForm.find('#cDate').datepicker('setDate', new Date());//建立時間
				mainForm.find("#showCDate").html(mainForm.find("#cDate").val());
				mainForm.find("#employeeAccount").show();
				mainForm.get(0).reset();
				tar.find("#mode").html('New Recruitment');
				tar.dialog("open");
			break;
		}
	};
	
	//新增recruitment database
	$("#addRecruitment").click(function(){
		dialogDiv.attr('title','Recruitment Database');
		dialogDiv.find("#interviewInformation").hide();
		showFormDetail('add');
	})
	
	//編輯shortlisted applicants
	$("#editRecruitment").click(function(){
		dialogDiv.attr('title','Recruitment Database');
		dialogDiv.find("#interviewInformation").show();
		var gr = jQuery("#recruApplicantsTable").jqGrid('getGridParam','selrow');
		editResource(gr);
	})
	//編輯Recruitment Database
	$("#editRecruitmentData").click(function(){
		dialogDiv.attr('title','Recruitment Database');
		dialogDiv.find("#interviewInformation").hide();
		var gr = jQuery("#recruDatabaseTable").jqGrid('getGridParam','selrow');
		editResource(gr);
	})

	function editResource(gr){
		if( gr != null ){
			showFormDetail('edit',gr);
		}else{
			alert("Please Select Row")
		};
	}
	//刪除Recruitment Database
	$("#delRecruitment").click(function(){
		var gr = jQuery("#addRecruitment").jqGrid('getGridParam','selrow');
		if( gr != null ) jQuery("#addRecruitment").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		else alert("Please Select Row to delete!");
	});
	//刪除 Shortlisted Applicants
	$("#delRecruApplicant").click(function(){
		var gr = jQuery("#recruApplicantsTable").jqGrid('getGridParam','selrow');
		if( gr != null ) jQuery("#recruApplicantsTable").jqGrid('delGridRow',gr,{reloadAfterSubmit:false});
		else alert("Please Select Row to delete!");
	});
	
	//表單控制
	$("#recruitmentForm").ajaxForm({
		success:function(){		
			//$("#rRepairTable").trigger("reloadGrid");
			$("#recruDatabaseTable").jqGrid("clearGridData", true);
			$("#recruApplicantsTable").jqGrid("clearGridData", true);
			$("#recruDatabaseTable").trigger("reloadGrid");
			$("#recruApplicantsTable").trigger("reloadGrid");
			dialogDiv.dialog("close");
			clearFormData($(this));				
		}
	});
	
	//人資資料庫表單欄位設定
	//定義主表格欄位
	var gridColName = [
		'Requesting Date'
		,'Approval Date'
		,'CV Received Date'
		,'Code'
		,'Name'
		,'G.A.'
		,'Position'
		,'Expected Salary'
		,'Mode of Application'
		,'Name'
		,'Date'
		,'Interview / Exam Date'
		,'Others'
	];
	//定義主表格各欄位屬性設定
	var gridColModel = [
		{name:'requestDate',index:'employeeNo',align:"left"}
		,{name:'approvalDate',index:'approvalDate',align:"left"}
		,{name:'cvReceiveDate',index:'cvReceiveDate',align:"left"}
		,{name:'employeeNo',index:'employeeNo',align:"left"}
		,{name:'name',index:'name',align:"left"}
		,{name:'ga',index:'ga',align:"left"}
		,{name:'position',index:'position',align:"left"}
		,{name:'expectSalary',index:'expectSalary',align:"left"}
		,{name:'applicationMode',index:'applicationMode',align:"left"}
		,{name:'requesterID',index:'requesterID',align:"left"}
		,{name:'toRequestDate',index:'toRequestDate',align:"left"}
		,{name:'interviewDate',index:'interviewDate',align:"left"}
		,{name:'others',index:'others',align:"left"}
	];
	
	//人資資料庫入選表單欄位設定
	//定義主表格欄位
	var shortlistGridColName = [
		'Confirm Interview'
		,'1st Interview / EXAM'
		,'Time'
		,'Interviewer'
		,'2nd Interview'
		,'Time'
		,'Interviewer'
		,'Code'
		,'Name'
		,'G.A'
		,'Position'
		,'Expected Salary'
		,'Salary Offer'
		,'Mode of Application'
		,'Passed(Y)/Archive(N)'
		,'Confirmed(Y or N)'
	];
	//定義主表格各欄位屬性設定
	var shortlistGridColModel = [
		{name:'confirmDate',index:'confirmDate',align:"left"}
		,{name:'interview1st',index:'interview1st',align:"left"}
		,{name:'time1st',index:'time1st',align:"left"}
		,{name:'interviewer1st',index:'interviewer1st',align:"left"}
		,{name:'interview2nd',index:'interview2nd',align:"left"}
		,{name:'time2nd',index:'time2nd',align:"left"}
		,{name:'interviewer2nd',index:'interviewer2nd',align:"left"}
		,{name:'employeeNo',index:'employeeNo',align:"left"}
		,{name:'name',index:'name',align:"left"}
		,{name:'ga',index:'ga',align:"left"}
		,{name:'position',index:'position',align:"left"}
		,{name:'expectSalary',index:'expectSalary',align:"left"}
		,{name:'offerSalary',index:'offerSalary',align:"left"}
		,{name:'applicationMode',index:'applicationMode',align:"left"}
		,{name:'pass',index:'pass',align:"left"}
		,{name:'resultConfirm',index:'resultConfirm',align:"left"}
	];

	//定義介面基本Tabs,Employee List
	$("#employeeListInterface").tabs();
			
	makeGrid($("#recruDatabaseTable"),"recruDatabaseList",'1');//
	makeGrid($("#recruApplicantsTable"),"recruApplicantsList",'2',shortlistGridColName,shortlistGridColModel);

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
			url:base_url+'/sendEmployeeData/'+type,
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
		});
	}

	//群組化RECRUITMENT DATABASE
	jQuery("#recruDatabaseTable").jqGrid('setGroupHeaders', {
		useColSpanStyle: true, 
		groupHeaders:[
			{startColumnName: 'requesterID', numberOfColumns: 2, titleText: 'Forwarded to the Requesting Person'},
		]	
	});

})