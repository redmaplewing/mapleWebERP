$(function(){
	var defaultUrl = "/sendEmployeeData"//設定預設Grid網址

	//定義主表格欄位
	var gridColName = [
		'No.'
		,'Name'
		,'Email'
		,'Skype'
		,'Company Issued Mobile No.'
		,'Personal Mobile No.'
		,'Ext No.'
	];
	//定義主表格各欄位屬性設定
	var gridColModel = [
		{name:'no',index:'no',align:"left"}
		,{name:'name',index:'name',align:"left"}
		,{name:'eMail',index:'eMail',align:"left"}
		,{name:'skype',index:'skype',align:"left"}
		,{name:'compMobile',index:'compMobile',align:"left"}
		,{name:'personalMobile',index:'personalMobile',align:"left"}
		,{name:'ext',index:'ext',align:"left"}
	];

	//定義介面基本Tabs,Tools & Equipment Manager
	$("#humanManagerInterface").tabs();	
	
	//修改結構圖
	$("#chartForm").ajaxForm({
		success:function(){		
			var obj = getChartData();
			//console.log(obj);
			var picLink = localhost+'/upload/'+obj['file'];
			$("#ChartPic").find('img').attr('src',picLink);
			$("#picName").find('a').attr('href',picLink);
			$("#picName").find('a').html(picLink);
		}
	});
	
	//取得結構圖資料
	function getChartData(){
		var result;
		$.ajax({
			url:base_url+'/getChart/'+$("#menuID").attr('value')
			,type:'POST'
			,dataType:'json'
			,async:false			
			,success:function(e){
				result = e;
			}
		})
		return result;
	}
	
	makeGrid($("#addressTable"),"addressList");//

	//Request主頁面jqGrid
	function makeGrid(tarTable,tarDiv,url,colName,colModel){
		if(typeof colName == 'undefined'){
			colName = gridColName;
		};
		if(typeof colModel == 'undefined'){
			colModel = gridColModel;
		};
		if(typeof url == 'undefined'){
			url = defaultUrl;
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
		});
	}
	//產生每個功能的grid

})