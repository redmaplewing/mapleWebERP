<style type="text/css">
	.leftTitle {
		text-align:right;
	}
</style>
<div id="mainArea">
	<!--新增管理PR-->
	<div id="showPRDetail" title="Purchase Request">
		
		<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="prDetailForm" name="prDetailForm"  class="customForm">
		<table style="width:95%">		
			<tr>
				<td>P.R. No. <input type="text" name="purchaseRequestNo" id="purchaseRequestNo" style="width:70%"/></td>
				<td>
					<select name="status" id="status">
						<option value="">Select Status</option>
						<option value="0">Arriving/In-progress</option>
						<option value="1">Completed</option>
					</select>
				</td>
				<td colspan="2"><span style="color:red;">WARNING!</span> The Project has no WAREHOUSE will not show in list</td>
			</tr>
			<tr>
				<td class="leftTitle">Project Code</td>
				<td>
					<select name="projectID" id="projectID">
						<option value="">--Select Project Code--</option>
						<?php foreach($project as $key=>$val):?>
						<option value="<?php echo $val['id'];?>"><?php echo $val['code'];?></option>
						<?php endforeach;?>
					</select>
				</td>
				<td>Creation Date</td>
				<td>
				<div id="showCDate"></div>
				<input type="hidden" name="cDate" id="cDate" class="date"/></td>
			</tr>
			<tr>
				<td class="leftTitle">Project Name</td>
				<td><input type="text" name="projectName" id="projectName" readonly/></td>
				<td>Expected Date</td>
				<td><input type="text" name="eDate" class="date"/></td>
			</tr>
			<tr>
				<td class="leftTitle">Customer Name</td>
				<td><input type="text" name="cusName" id="cusName" readonly/></td>
				<td>Submitted Date</td>
				<td>
					<div id="showSubmitDate"></div>
					<input type="hidden" id="submitDate" name="submitDate" class="date"/>
				</td>
			</tr>
			<tr>
				<td class="leftTitle">Plan No.</td>
				<td>
					<select name="planID" id="planID">
						<option value="">--Select Plan No--</option>
					</select>
				</td>
				<td>Requested by</td>
				<td>
					<div id="managerName"></div>
					<input type="hidden" name="managerID" id="managerID" value=''/>
				</td>
			</tr>
			<!--發票號碼-->
			<tr id="invoceInformation" style="display:none;">
				<td colspan="4" style="width:100%;">
					<table style="width:100%;">
						<tr>
							<td style="text-align:center;" colspan="4">Insert Invoice No./Delivery</td>
						</tr>
						<tr>
							<td>Product/Service Code</td>
							<td><div id="showItemCode"></div></td>
							<td>Invoice No./Delivery</td>
							<td>
								<input type="text" name="invoceNo" id="invoceNo" style="width:60%"/>
								<input type="hidden" name="itemID" id="itemID"/>
								<input type="button" name="sendInvoceNo" id="sendInvoceNo" value="send"/>
							</td>
						</tr>
					</table>
				</td>				
			</tr>
		</table>
		<div id="poTabs">
			<ul>
				<li><a href="#prDetail" id="showDetail">P.R. Detail</a></li>
				<li><a href="#prReceiving" id="showReceiving">Product/Service Receiving</a></li>
			</ul>
			<!--PO Detail-->
			<!--識別碼-->
			<input type="hidden" name="securityCode" id="securityCode" value=''/>
			<div id="prDetail">
				<table id="tabPRDetail"></table>
				<div id="prDetailList"></div>				
				<table style="width:100%" name="addItem" id="addItem">
					<tr>
						<td style="width:10%;text-align:center;">Type</td>
						<td style="width:15%;">
							<select name="prDetailItemType" id="prDetailItemType">
								<option value="1">Product</option>
								<option value="2">Service</option>
							</select>
						</td>
						<td style="width:10%;text-align:center;">Code</td>
						<td style="width:40%">
							<select name="prDetailItemCode" id="prDetailItemCode" style="width:100%">
								<option value="">----Select Code----</option>
								<?php foreach($itemOption as $key => $val):?>
									<option value="<?php echo $key;?>"><?php echo $val;?></option>
								<?php endforeach;?>
							</select>
						</td>
						<td style="width:10%;text-align:center;">
							Qty
						</td>
						<td>
							<input type="text" name="prDetailItemQty" id="prDetailItemQty"/>
						</td>
						<td style="width:10%;text-align:center;">
							<input type="button" name="prDetailAddItem" id="prDetailAddItem" value="Add"/>
						</td>
					</tr>
				</table>
				<div id="processesNote">
					<h1>Processes's Notes</h1>
					1.Submit P.R. P.R. w/Site Manager Recommendation to the Project Management Team to determine the processes involve in turning P.R. to P.O.<br />
					2.Forward the P.R. w/Site Manager Recommendation to Purchase Dept.<br />
					3.Forward the P.R. to the Design Dept.<br />
					4.Forward the P.R. to Senior Inventory Controller<br />
					5.Forward the P.R. to Technical Purchaser<br />
					6.Comparison Price & Quality by Purchase Dept. (shld. do in excel)<br />
					7.Forward the P.R. to the G.M. for verification (including the data comparison done by the Purchase Dept.)<br />
					8.Purchase Dept. Staff shall encode the details of the P.R. and print P.O.<br />
					9.Submit the P.O. to the Director for approval before sending to supplier<br />
					<table id="tabPRProcess"></table>
					<div id="prPJrocessesList"></div>
				</div>
			</div>
			<div id="prReceiving">
				<table id="tabPRReceiving"></table>
				<div id="prReceivingList"></div>
			</div>
		</div>
		remark:<br />
		<textarea name="remark" id="remark" cols="30" rows="10" style="width:95%"></textarea>
		<input type="hidden" name='oper' id="oper" value="add"/>
		<input type="hidden" name='id' id="id" value=""/>
		<?php if($purchaseRequest):?>
		<div id="controlBar">
			<input type="submit" value="save"/>
			<input type="reset" value="cancel"/>
			<input type="button" id="submit" name="submit" value="Submit"/>
		</div>
		<?php endif;?>
		</form>
		
	</div>

	<!--主視窗-->
	<div id="menuLocation">
		<?php echo $menuInfo['parent']."=>".anchor($menuInfo['link']."/index/".$menuInfo['menuID'],$menuInfo['menuName']);//輸出功能所在位置?>
	</div>
	<br />
	<div id="purRequestMainInterface">
		<ul>			
			<li><a href="#pur-inprogress" id="inProgress">Arriving/In-progress</a></li>
			<li><a href="#pur-completed" id="completed">Completed</a></li>
		</ul>
		<!--採購arriving/In-progress-->
		<div id="pur-inprogress">
			<table id="tabPurInProgress"></table>
			<div id="PurInProgressList"></div>
			<br />
			<!--新增按扭-->
				<?php if($purchaseRequest):?>
				<input type="button" id="addpr" value="New Purchase Request"/>
				<input type="button" id="delpr" value="Delete Select Purchase Request"/>
				<?php endif;?>
				<input type="button" id="editpr" value="View/Edit Select Purchase Request"/>
			<!--刪除按扭-->
			<!--<input type="button" id="delDetail" value="Delete Item"/>-->
		</div>
		<!--採購completed-->
		<div id="pur-completed">
			<table id="tabPurCompleted"></table>
			<div id="PurCompleted"></div>
			<br />
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		//nav側邊欄對應控制
		$("#menuList").accordion("option","active",<?php echo $active;?>);
		//alert(userID+"=>"+userName);
	})
</script>
<script src="<?=base_url();?>js/purchaseRequest.js"></script><!--此頁面的js-->