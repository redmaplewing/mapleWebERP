<style type="text/css">
#mainArea {
	padding-top:5px;
}
</style>
<div id="mainArea">
	<table id="mainList"></table>
	<div id="pag_main"></div>
	
	<br />
	<table id="mainDetail"></table>
	<div id="pagDetail"></div>

</div>
<script type="text/javascript">
	$(function(){
		var linkID="";
		jQuery("#mainList").jqGrid({
			url:'<?php echo base_url();?>menuSetting/sendQueryData',
			datatype: "json",
			colNames:['menu name(English Name)', 'Group', 'Enable','Ord','Target'],
			colModel:[
				{name:'name',index:'name', width:200, align:"left",editable:true,editoptions:{size:20}},	
				{name:'parentID',index:'parentID', width:80,align:"left",editable:true,edittype:"select",formatter:"select",
					editoptions:{value:"<?php
						$count = 1;
						
						foreach($this->session->userdata('menuType') as $key => $val){
							echo $val['id'].":".$val['name'];
							if($count < count($this->session->userdata('menuType'))){
								echo ";";
							}
							$count++;
						}
					?>"}},
				{name:'enable',index:'enable', width:80,align:"left",editable:true,edittype:"select",formatter:"select",
					editoptions:{value:"1:Enable ; 0:Disable"}},		
				{name:'ord',index:'ord', width:80, align:"left",editable:true,edittype:"select",formatter:"select",
				editoptions:{value:"<?php
					for($i = 1; $i <= 30; $i++){
						echo $i.":".$i;
						if($i < 30){
							echo ";";
						}
					}
				?>"}},
				{name:'link',index:'link', width:200, align:"left",editable:true,editoptions:{size:20}},
			],
			rowNum:10,
			rowList:[10,20,30],
			pager: '#pag_main',
			sortname: 'id',
			viewrecords: true,
			sortorder: "asc",
			grouping:true,
			groupingView:{groupField:['parentID'] },
			width:800,
			height:250,
			caption:"Menu Setting",
			//autowidth:true,
			altRows:true,
			multiselect:false,
			onSelectRow: function(ids) {
				if(ids == null){
					ids=1;
					if($("#mainDetail").jqGrid('getGridParam','records') > 0){
						$("#mainDetail").jqGrid('setGridParam',{url:'<?php echo base_url();?>menuSetting/subQueryData?q=1&id='+ids,page:1});
						$("#mainDetail").jqGrid('setCaption',"other Language"+ids).trigger('reloadGrid');
					}
				}else{
					$("#mainDetail").jqGrid('setGridParam',{url:'<?php echo base_url();?>menuSetting/subQueryData?q=1&id='+ids,page:1});
					$("#mainDetail").jqGrid('setCaption',"other Language"+ids).trigger('reloadGrid');
				}				
				linkID = ids;
				//alert(linkID);
			},
			editurl:"<?php echo base_url();?>menuSetting/modify/<?php echo $tableName;?>"
		});
		jQuery("#mainList").jqGrid('navGrid','#pag_main',
			{}, //options
			{height:280,reloadAfterSubmit:true}, // edit options
			{height:280,reloadAfterSubmit:true}, // add options
			{reloadAfterSubmit:true}, // del options
			{} // search options
		);		
		$("#mainDetail").jqGrid({
			height:100,
			url:'<?php echo base_url();?>menuSetting/subQueryData',
			datatype: "json",
			colNames:['menu name', 'Language'],
			colModel:[
				{name:'name',index:'name', width:200, align:"left",editable:true,editoptions:{size:20}},
				{name:'lang',index:'lang', width:80, align:"left",editable:true,edittype:'select',formatter:'select',
					editoptions:{value:"<?php
						$count = 1;
						foreach($this->session->userdata('languageType') as $key => $val){
							if($key != 'en_US'){
								echo $key.":".$val;														
								if($count < count($this->session->userdata('languageType'))){
									echo ";";
								};					
							};
							$count++;
						}
					?>"}},
			],
			rowNum:10,
			rowList:[10,20,30],
			pager: '#pagDetail',
			sortname: 'id',
			viewrecords: true,
			sortorder: "asc",
			width:800,
			height:250,
			caption:"other Language",
			//autowidth:true,
			altRows:true,
			multiselect:false,
			editurl:"<?php echo base_url();?>menuSetting/modify/nameLang/true"
		});
		$("#mainDetail").jqGrid('navGrid','#pagDetail',
			{},
			{height:280,reloadAfterSubmit:true}, //edit options
			{height:280,reloadAfterSubmit:true}, // add options
			{reloadAfterSubmit:true}, // del options
			{}
		);
	})
</script>