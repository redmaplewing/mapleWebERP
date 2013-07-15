<style type="text/css">
	#tabs {
		font-size:12px;
		width:670px;
		position:relative;
		margin-left:auto;
		margin-right:auto;
	}
	.customForm input[type='text'] {
		width:95%;
	}
	 .customForm  select {
		width:90%;
	}
	.customForm  textarea {
		width:90%;
	}
</style>
<script type="text/javascript">
$(function(){
	$("#loadLocation").fadeOut();
})
</script>
<div id="mainArea">
	<!--單元浮動視窗-->
	<div id="showWarehoustDetail" title="Warehoust Information">
		<div id="mode"></div>
		<div id="warehouseDetail">
			<ul>
				<li><a href="#ShowDetailArea" id="warehouseInfo">Warehouse Information</a></li>
				<li><a href="#stockData" id="showStockData">View Stock Data</a></li>
				<li><a href="#TEData" id="showTEData">View Tools &#38; Equip. Data</a></li>
			</ul>
			<!--倉庫新增、編輯-->
			<div id="ShowDetailArea" style="width:80%;position:relative;margin-left:auto;margin-right:auto;">
				
				<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="warehouseForm" name="warehouseForm"  class="customForm" enctype="multipart/form-data">		
				Warehouse Name/Location: <input type="text" name="name" id="name" style="width:40%;"/>
				Status : <select name="status" id="status" style="width:20%;">
					<option value="" selected>---Select Status---</option>
					<!--Warehouse status
					0 => Closed Down
					1 => Active
					-->
					<option value="1">Active</option>
					<option value="0">Closed Down</option>
				</select>
				<div id="pic" style="float:left;width:30%;text-align:center;">
					<div id="image" style="width:60%;margin-left:auto;margin-right:auto;position:relative;">
						<img src="" alt="" style="width:100%"/>
						<input type="file" name="managerImg" id="managerImg" style="width:100%"/>
					</div>
				</div>
				<div id="information" style="float:left;width:65%;margin-right:5px;">
					<table style="width:100%;">
						<tr>
							<td style="width:25%;">Project Name</td>
							<td style="width:75%;">
								<select name="projectID" id="projectID">
									<option value="">----Select Project----</option>
									<?php foreach($project as $key=>$val):?>
										<option value="<?php echo $key;?>"><?php echo $val;?></option>
									<?php endforeach;?>
								</select>
							</td>
						</tr><tr>
							<td style="width:25%;">Manager</td>
							<td style="width:75%;">
								<select name="warehouseManagerID" id="warehouseManagerID">
									<option value="">----Select Employee----</option>
									<?php foreach($employee as $key => $val):?>
										<option value="<?php echo $key;?>"><?php echo $val;?></option>
									<?php endforeach;?>
								</select>
							</td>
						</tr>
						<tr style="height:20px;">
							<td>Gender</td>
							<td><div id="managerGender" style="hieght:20px;"></div></td>
						</tr>
						<tr style="height:20px;">
							<td>Position</td>
							<td><div id="managerPosition" style="hieght:20px;"></div></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><input type="text" name="mail" id="mail"/></td>
						</tr>
						<tr>
							<td>Phone</td>
							<td><input type="text" name="phone" id="phone"/></td>
						</tr>
					</table>
				</div>
				<div id="address" style="clear:both;width:100%">
					Postal Address of the Warehouse :<br />
					<input type="text" name="address" id="address"/>			
				</div>
				<br />
				<div id="registed" style="position:relative;margin-left:400px;width:40%">
					Registered by: <?php echo $this->session->userdata['username'];?>
					<input type="hidden" name="managerID" id="managerID" value="<?php echo $this->session->userdata['username'];?>"/>
					<br />
					Approved by :
					<select name="approve" id="approve" style="width:60%;">
						<option value="">----Select Employee----</option>
						<?php foreach($employee as $key => $val):?>
							<option value="<?php echo $key;?>"><?php echo $val;?></option>
						<?php endforeach;?>
					</select>
				</div>
				<?php if($invInfoRegistry):?>
				<input type="hidden" name="oper" id="oper"/>
				<input type="hidden" name="id" id="id"/>
				<input type="submit" id="save" value="Save"/>
				<input type="reset" id="save" value="Cancel"/>
				<?php endif;?>
				</form>
			</div>
			<!--項目儲存資料-->
			<div id="stockData">
				<div id="stockDetail">
					<ul class="subTabs">
						<li><a href="#inventory" id="inventoryLink">Inventory Level</a></li>
						<li><a href="#needsRestocking" id="needsLink">Needs Restocking</a></li>
						<li><a href="#fastMoving" id="fastLink">Fast-Moving</a></li>
					</ul>
					<!--Inventory Level-->
					<div id="inventory">
						<table id="inventoryTable"></table>
						<div id="inventoryList"></div>
					</div>
					<!--Needs Restocking-->
					<div id="needsRestocking">
						<table id="needsTable"></table>
						<div id="needsList"></div>
					</div>
					<!--Fast-moving-->
					<div id="fastMoving">
						<table id="fastTable"></table>
						<div id="fastList"></div>
					</div>					
				</div>				
			</div>
			<!--工具、施備儲存資料-->
			<div id="TEData">
				<div id="toolsDetail">
					<ul class="subTabs">
						<li><a href="#working" id="workLink">Working Propely</a></li>
						<li><a href="#repair" id="repairLink">Under Repair</a></li>
						<li><a href="#calibration" id="calibrationLink">Sent for Calibration</a></li>
						<li><a href="#disposed" id="disposedLink">Disposed</a></li>
						<li><a href="#lost" id="lostLink">Lost</a></li>
					</ul>
					<!--Working Propely-->
					<div id="working">
						<table id="workingTable"></table>
						<div id="workingList"></div>
						<!--新增按扭-->
						<?php if($invInfoRegistry):?>
						<input type="button" id="addTEDetail" value="New Tools"/>
						<input type="button" id="editTEDetail" value="Edit Tools"/>
						<!--刪除按扭-->
						<input type="button" id="delTEDetail" value="Delete Tools"/>
						<?php endif;?>
					</div>
					<!--Under Repair-->
					<div id="repair">
						<table id="repairTable"></table>
						<div id="repairList"></div>
					</div>
					<!--Sent for Calibration-->
					<div id="calibration">
						<table id="calibrationTable"></table>
						<div id="calibrationList"></div>
					</div>
					<!--Disposed-->
					<div id="disposed">
						<table id="disposedTable"></table>
						<div id="disposedList"></div>
					</div>
					<!--Lost-->
					<div id="lost">
						<table id="lostTable"></table>
						<div id="lostList"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Tools & Equipment Detail-->
	<div id="TEDialog">
		<div id="TEModes"></div>
		LOST :<input type="checkbox" id="itemLost"/>
		<div id="TEDetail">
			<ul>
				<li><a href="#detail" id="detailLink">Details</a></li>
				<li><a href="#divUsage" id="usageLink">Usage History</a></li>
				<li><a href="#repair" id="repairLink">Repair History</a></li>
				<li><a href="#calibration" id="calibrationLink">Calibration History</a></li>
			</ul>
			<div id="detail">
				<!--項目使用狀況跟詳細資料表單-->			
				<form action="<?php echo base_url().$menuInfo['link']."/modify/item"?>" method="post" id="TEDetailForm" name="TEDetailForm"  class="customForm" enctype="multipart/form-data">	
					<table style="width:100%">	
						<tr>
							<td>Tools & Equip. Name</td>
							<td colspan="3"><input type="text" id="name" name="name"/></td>
						</tr>
						<tr>
							<td>Tools & Equip. Code</td>
							<td><input type="text" name="code" id="code"/></td>
							<td>Calibration Period</td>
							<td><input type="text" name="calibrationPeriod" id="calibrationPeriod"/></td>
						</tr>
						<tr>
							<td>Usage</td>
							<td><input type="text" name="usage" id="usage"/></td>
							<td>UsefulLife</td>
							<td><input type="text" name="usefulLife" id="usefulLife"/></td>
						</tr>
						<tr>
							<td>Unit Cost</td>
							<td><input type="text" name="unitCost" id="unitCost"/></td>
							<td>Disposal Method</td>
							<td><input type="text" name="disposalMethod" id="disposalMethod"/></td>
						</tr>
						<tr>
							<td>Date Purchased</td>
							<td><input type="text" name="purchasedDate" id="purchasedDate" class="date"/></td>
							<td>Waranty Period</td>
							<td><input type="text" name="warrantyPeriod" id="warrantyPeriod"/></td>
						</tr>
					</table>
					Description<br />
					<textarea name="description" id="description" cols="30" rows="7" style="width:50%;float:left;"></textarea>
					<div id="att" style="float:left;width:45%;margin-left:25px;">
						Attachment<br />
						<input type="file" name="attachment" id="attachment" style="width:100%"/>
						<br />
						Disposal Date : <input type="text" name="disposalDate" id="disposalDate" class="date"/>
						<br />
						Disposed by :
						<select name="disposedBy" id="disposedBy">
							<option value="">----Select Employee----</option>
							<?php foreach($employee as $key => $val):?>
								<option value="<?php echo $key;?>"><?php echo $val;?></option>
							<?php endforeach;?>
						</select>
					</div><br />
					<div id="detailBtn" style="clear:both;width:60%;float:left;">
						<input type="button" id="formAddTEDetail" value="New Tools & Equipment"/>
						<input type="button" id="viewDataSheet" value="View Data Sheet"/>
					</div>
					<div id="registerInfo" style="float:left;margin-left:20px;width:35%">
						Registered By : <?php echo $this->session->userdata('username');?><br />
						<input type="hidden" id="managerID" value="<?php echo $this->session->userdata('employeeID');?>"/>
						Approved By : 
						<select name="approved" id="approved">
							<option value="">----Select Employee----</option>
							<?php foreach($employee as $key => $val):?>
								<option value="<?php echo $key;?>"><?php echo $val;?></option>
							<?php endforeach;?>
						</select>
					</div>
					<?php if($invInfoRegistry):?>
					<input type="hidden" name="oper" id="oper"/>
					<input type="hidden" name="id" id="id"/>
					<input type="hidden" name="type" id="type" value="3"/>
					<input type="hidden" name="warehouseID" id="warehouseID">
					<div id="editControl" style="clear:both;">
						<input type="submit" id="save" value="Save"/>
						<input type="reset" id="save" value="Cancel"/>
					</div>
					<?php endif;?>					
				</form>
				
			</div>
			<div id="divUsage">
				<table id="detailUsageTable"></table>
				<div id="detailUsageList"></div>
			</div>
			<div id="repair">
				<table id="detailRepairTable"></table>
				<div id="detailRepairList"></div>
			</div>
			<div id="calibration">
				<table id="detailCalibTable"></table>
				<div id="detailCalibList"></div>
			</div>
		</div>
	</div>
	
	<!--主視窗-->
	<div id="menuLocation">
		<?php echo $menuInfo['parent']."=>".anchor($menuInfo['link']."/index/".$menuInfo['menuID'],$menuInfo['menuName']);//輸出功能所在位置?>
	</div>
	<br />
	<div id="InventoryInformationMainInterface">
		<table id="mainWarehouse"></table>
		<div id="warehouseList"></div>
		<!--新增按扭-->
		<?php if($invInfoRegistry):?>
		<input type="button" id="addwh" value="New Warehouse"/>		
		<!--刪除按扭-->
		<input type="button" id="delwh" value="Delete Warehoust"/>
		<?php endif;?>
		<!--編輯按鈕-->		
		<input type="button" id="editwh" value="view/edit Warehouse"/>
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