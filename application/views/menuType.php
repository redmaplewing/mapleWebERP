<div id="mainArea">
	<table id="typeList"></table>
	<div id="pag_menuType"></div>
	<br />
	<table id="typeDetail"></table>
	<div id="pagDetail"></div>
</div>
<script type="text/javascript">
	$(function(){
		var linkID="";
		jQuery("#typeList").jqGrid({
			url:'<?php echo base_url();?>menuType/sendQueryData',
			datatype: "json",
			colNames:['menu name', 'Language', 'Enable','Ord'/*,'EnglishName'*/],
			colModel:[
				{name:'name',index:'name', width:200, align:"left",editable:true,editoptions:{size:20}},
				{name:'lang',index:'lang', width:80, align:"left", editable:false,editrules:{hidden:true}, edittype:'select',formatter:'select',
					editoptions:{value:"<?php
						$count = 1;
						foreach($this->session->userdata('languageType') as $key => $val){
							echo $key.":".$val;
							if($count < count($this->session->userdata('languageType'))){
								echo ";";
							}
							$count++;
						}
					?>"}
				},		
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
				?>"}}
			],
			rowNum:10,
			rowList:[10,20,30],
			pager: '#pag_menuType',
			sortname: 'id',
			viewrecords: true,
			sortorder: "asc",
			width:800,
			height:250,
			caption:"Menu Type",
			//autowidth:true,
			altRows:true,
			multiselect:false,
			onSelectRow: function(ids) {
				if(ids == null){
					ids=1;
					if($("#typeDetail").jqGrid('getGridParam','records') > 0){
						$("#typeDetail").jqGrid('setGridParam',{url:'<?php echo base_url();?>menuType/subQueryData?q=1&id='+ids,page:1});
						$("#typeDetail").jqGrid('setCaption',"other Language"+ids).trigger('reloadGrid');
					}
				}else{
					$("#typeDetail").jqGrid('setGridParam',{url:'<?php echo base_url();?>menuType/subQueryData?q=1&id='+ids,page:1});
					$("#typeDetail").jqGrid('setCaption',"other Language"+ids).trigger('reloadGrid');
				}				
				linkID = ids;
				//alert(linkID);
			},
			editurl:"<?php echo base_url();?>menuType/modify/<?php echo $tableName;?>"
		});
		jQuery("#typeList").jqGrid('navGrid','#pag_menuType',
			{}, //options
			{height:280,reloadAfterSubmit:true}, // edit options
			{height:280,reloadAfterSubmit:true}, // add options
			{reloadAfterSubmit:true}, // del options
			{} // search options
		);		
		$("#typeDetail").jqGrid({
			height:100,
			url:'<?php echo base_url();?>menuType/subQueryData',
			datatype: "json",
			colNames:['menu name', 'Language', 'Enable'/*,'linkID'*/],
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
				{name:'enable',index:'enable', width:80,align:"left",editable:true,edittype:"select",formatter:"select",
					editoptions:{value:"1:Enable ; 0:Disable"}}
				/*{name:'linkID',index:'linkID',width:80,align:"left",editable:true,edittype:"select",formatter:"select",
					editoptions:{value:"<?php 
						$count = 1;
						foreach($this->session->userdata('engMenuType') as $key => $val){
							echo $key.":".$val;
							if($count < count($this->session->userdata('engMenuType'))){
								echo ";";
							}
							$count++;
						}
					?>"} 
				}*/
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
			editurl:"<?php echo base_url();?>menuType/modify/<?php echo $tableName;?>/true"
		});
		$("#typeDetail").jqGrid('navGrid','#pagDetail',
			{},
			{height:280,reloadAfterSubmit:true}, //edit options
			{height:280,reloadAfterSubmit:true}, // add options
			{reloadAfterSubmit:true}, // del options
			{}
		);
	})
</script>