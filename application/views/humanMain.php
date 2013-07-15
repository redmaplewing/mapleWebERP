<div id="mainArea">
	<!--主視窗-->
	<div id="menuLocation">
		<?php echo $menuInfo['parent']."=>".anchor($menuInfo['link']."/index/".$menuInfo['menuID'],$menuInfo['menuName']);//輸出功能所在位置?>
	</div>
	<br />
	<div id="humanManagerInterface">
		<ul>
			<?php if($organizationalChart):?>
			<li><a href="#organizationalChart" id="chartLink">Organizational Chart</a></li>
			<?php endif;?>
			<?php if($addressbook):?>
			<li><a href="#addressBook" id="addressLink">Address Book</a></li>
			<?php endif;?>
			<?php if($companyCalendar):?>
			<li><a href="#CompanyCalendar" id="calendarLink">Company Calendar</a></li>
			<?php endif;?>
		</ul>
		<!--Organizational Chart組織結構圖-->
		<?php if($organizationalChart):?>
		<div id="organizationalChart">
			<div id="ChartPic" style="width:720px;height:480px;overflow:hidden;margin-top:10px;margin-left:20px;text-align:center;">
				<img src="<?php echo $file;?>" alt="Organizational Chart" style="margin-top:10px;height:460px;"/>
			</div>
			<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="chartForm" name="chartForm"  class="customForm" enctype="multipart/form-data">
			<input type="file" name="file" id="file"/>
			<input type="hidden" name="title" id="title" value="Organizational Chart"/>
			<input type="hidden" name="oper" id="oper" value="add"/>
			<input type="hidden" name="menuID" id="menuID" value="<?php echo $menuID;?>"/>
			<input type="submit" name="uploadChart" id="uploadChart" value="Upload"/>
			</form>
			<div id="picName">
				<a href="<?php echo $file;?>" target="_blank"><?php echo $file;?></a>
			</div>			
		</div>
		<?php endif;?>
		<?php if($addressbook):?>
		<div id="addressBook">
			<table id="addressTable" class="defaultGrid"></table>
			<div id="addressList"></div>	
		</div>
		<?php endif;?>
		<?php if($companyCalendar):?>
		<div id="CompanyCalendar"></div>
		<?php endif;?>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		//nav側邊欄對應控制
		$("#menuList").accordion("option","active",<?php echo $active;?>);
		//alert(base_url);
	})
</script>
<script src="<?=base_url();?>js/<?php echo $menuInfo['link'];?>.js"></script><!--此頁面的js-->