<div id="mainArea">
	<!--Recruitment 浮動視窗-->
	<div id="showEmployeeInterface" title="Human Resource">
		<div id="mode" style="width:100%;text-align:center;"></div>
		<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="employeeForm" name="employeeForm"  class="customForm">
			<table style="width:100%;">
					<tr>
						<td>Employment Date</td>
						<td>
							<input type="text" name="employmentDate" id="employmentDate" class="date"/>
						</td>
						<td>Birthday</td>
						<td>
							<input type="text" name="birthday" id="birthday" class="date"/>
						</td>
						<td>ID Card/Passport No.</td>
						<td>
							<input type="text" name="UID" id="UID"/>
						</td>
					</tr>
					<tr>
						<td>Personal Phone</td>
						<td>
							<input type="text" name="personalMobile" id="personalMobile" class="date"/>
						</td>
						<td>Company Mobile</td>
						<td>
							<input type="text" name="compMobile" id="compMobile" class="date"/>
						</td>
						<td>Ext.</td>
						<td>
							<input type="text" name="ext" id="ext"/>
						</td>
					</tr>
					<tr>
						<td>Enable</td>
						<td>
							<select name="enable" id="enable">
                                <option value="">Select Enable or Not</option>
								<option value="1">Enable</option>
								<option value="0">Disable</option>
							</select>
						</td>
						<td>Group</td>
						<td>
							<select name="groupID" id="groupID">
								<option value="">====Select Group====</option>
								<?php foreach($group as $key=>$val):?>
								<option value="<?php echo $key;?>"><?php echo $val;?></option>
								<?php endforeach;?>
							</select>
						</td>
						<td>Location</td>
						<td>
							<select name="location" id="location">
								<option value="1">Head Office & Site Management</option>
								<option value="2">Site Employee</option>
							</select>
						</td>
					</tr>
				</table>
			<?php if($employee):?>	
			<input type="hidden" name="oper" id="oper"/>
			<input type="hidden" name="id" id="id"/>
			<input type="submit" id="save" value="Save"/>
			<input type="reset" id="cancel" value="Cancel"/>
			<?php endif;?>
		</form>
	</div>
	
	
	<!--主視窗-->
	<div id="menuLocation">
		<?php echo $menuInfo['parent']."=>".anchor($menuInfo['link']."/index/".$menuInfo['menuID'],$menuInfo['menuName']);//輸出功能所在位置?>
	</div>
	<br />
	<div id="employeeListInterface">
		<ul>			
			<li><a href="#headEmployee" id="headLink">EMPLOYEE LIST<br />(Head Office & Site Mgt.)</a></li>
			<li><a href="#siteEmployee" id="siteLink">SITE EMPLOYEE LIST</a></li>
		</ul>
		<div id="headEmployee">
			<table id="headEmployeeTable"></table>
			<div id="headEmployeeList"></div>
			<?php if($employee):?>			
			<input type="button" name="delEmployee" id="delEmployee" value="Delete Selected Employee"/>
			<?php endif;?>
			<input type="button" name="editEmployee" id="editEmployee" value="View/Edit Selected Employee"/>
		</div>
		<div id="siteEmployee">
			<table id="siteEmployeeTable"></table>
			<div id="siteEmployeeList"></div>	
		</div>
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