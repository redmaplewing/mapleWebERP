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
<?php if(!$materialRR):?>
	<script type="text/javascript">
		$(function(){
			$(".permissionControl").hide();
		})		
	</script>
<?php endif;?>	

<div id="mainArea">
	<!--項目請求浮動視窗-->
	<div id="showMeterIalRequest" title="Material Request">
		<div id="mRequestMode"></div>
		<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="requestForm" name="requestForm"  class="customForm">
		
		<table style="width:100%;">
			<tr>
				<td>M.R. No.</td>
				<td><input type="text" name="materialRequestNo" id="materialRequestNo"/></td>
				<td>Status</td>
				<td>
					<select name="status" id="status">
						<option value="">Select Status</option>
						<option value="0">Arriving/In-progress</option>
						<option value="1">Completed</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Project Code</td>
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
					<input type="hidden" name="cDate" id="cDate" class="date"/>
				</td>
			</tr>
			<tr>
				<td>Project Name</td>
				<td><input type="text" name="projectName" id="projectName" readonly/></td>
				<td>Expected Date</td>
				<td><input type="text" name="eDate" id="eDate" class="date"/></td>
			</tr>
			<tr>
				<td>Customer Name</td>
				<td><input type="text" name="cusName" id="cusName" readonly/></td>
				<td>Submitted Date</td>
				<td>
					<div id="showSubmitDate"></div>
					<input type="hidden" id="submitDate" name="submitDate" class="date"/>
				</td>
			</tr>
			<tr>
				<td>Plan No.</td>
				<td>
					<select name="planID" id="planID">
						<option value="">--Select Plan No--</option>
					</select>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr class="permissionControl">
				<td colspan="4">
					<div id="requestInfo">
						<ul class="subTabs">
							<li><a href="#reqeustDetail" id="detilLink">M.R. Details</a></li>
							<li><a href="#requestReceiving" id="receivingLink">Product Receiving</a></li>
						</ul>
						<!--識別碼-->
						<input type="hidden" name="securityCode" id="securityCode" value=''/>
						<div id="reqeustDetail">
							<table id="requestDetailTable"></table>
							<div id="requestDetailList"></div>
							<div id="addItemArea" style="display:none;">
								<table style="width:100%" name="addItem" id="addItem">
									<tr>
										<td style="width:10%;text-align:center;">Type</td>
										<td style="width:15%;">
											<select name="mrDetailItemType" id="mrDetailItemType">
												<option value="1">Product</option>
												<option value="2">Service</option>
												<option value="3">Tools & Equipment</option>
											</select>
										</td>
										<td style="width:10%;text-align:center;">Code</td>
										<td style="width:35%">
											<select name="mrDetailItemCode" id="mrDetailItemCode" style="width:100%">
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
											<input type="text" name="mrDetailItemQty" id="mrDetailItemQty"/>
										</td>
										<td style="width:15%;text-align:center;">
											<input type="button" name="mrDetailAddItem" id="mrDetailAddItem" value="Add"/><input type="button" name="mrDetailDelItem" id="mrDetailDelItem" value="Delete Select"/>
										</td>
									</tr>
								</table>
							</div>							
						</div>
						<div id="requestReceiving">
							<table id="requestReceivingTable"></table>
							<div id="requestReceivingList"></div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" rowspan="3">
					Remarks:<br />
					<textarea name="remark" id="remark" cols="30" rows="3"></textarea>
				</td>
				<td>Requested By</td>
				<td>
					<div id="managerName"><?php echo $this->session->userdata('username');?></div>
					<input type="hidden" name="managerID" id="managerID" value='<?php echo $this->session->userdata('employeeID');?>'/>
				</td>
			</tr>
			<tr>
				<td>Checked By</td>
				<td>
					<select name="checked" id="checked">
						<option value="">----Select Employee----</option>
						<?php foreach($employee as $key => $val):?>
							<option value="<?php echo $key;?>"><?php echo $val;?></option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Approved By</td>
				<td>
					<select name="approve" id="approve">
						<option value="">----Select Employee----</option>
						<?php foreach($employee as $key => $val):?>
							<option value="<?php echo $key;?>"><?php echo $val;?></option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
		</table>
		<div class="permissionControl">
			<input type="hidden" name="oper" id="oper"/>
			<input type="hidden" name="id" id="id"/>
			<input type="submit" id="save" value="Save"/>
			<input type="reset" id="cancel" value="Cancel"/>
			<input type="button" id="print" value="PRINT"/>
			<input type="button" id="submit" name="submit" value="Submit"/>
		</div>		
		</form>
	</div>
	
	<!--項目退貨浮動視窗-->
	<div id="showMeterIalReturn" title="Goods Return">
		<div id="mReturnMode"></div>
		<form action="<?php echo base_url().$menuInfo['link']."/modify/goodReturn/"?>" method="post" id="returnForm" name="returnForm"  class="customForm">
		
		<table style="width:100%;">
			<tr>
				<td>G.R. No.</td>
				<td><input type="text" name="goodReturnNo" id="goodReturnNo"/></td>
				<td><!--Status--></td>
				<td>
					<!--
					<select name="status" id="status">
						<option value="">----Select Status----</option>
					</select>
					-->
				</td>
			</tr>
			<tr>
				<td>From</td>
				<td>
					<select name="from" id="from">
						<option value="">----Select Warehoust----</option>
						<?php foreach($warehouse as $key=>$val):?>
							<option value="<?php echo $key;?>"><?php echo $val;?></option>
						<?php endforeach;?>
					</select>
				</td>
				<td>Creation Date</td>
				<td>
					<div id="showCDate"></div>
					<input type="hidden" name="cDate" id="cDate" class="date"/>
					<!--<input type="text" name="cDate" id="cDate" class="date"/>-->
				</td>
			</tr>
			<tr>
				<td>To</td>
				<td>
					<select name="to" id="to">
						<option value="">----Select Supplier----</option>
						<?php foreach($supplier as $key=>$val):?>
							<option value="<?php echo $key;?>"><?php echo $val['name'];?></option>
						<?php endforeach;?>
					</select>
				</td>
				<td>Returned  Date</td>
				<td><input type="text" name="returnDate" id="returnDate" class="date"/></td>
			</tr>
			<tr class="permissionControl">
				<td colspan="4">
					<div id="returnInfo">
						<ul class="subTabs">
							<li><a href="#returnDetail" id="detailLink">G.R. Details</a></li>
							<li><a href="#returnGoods" id="goodsLink">Returning Goods</a></li>
						</ul>
						<!--識別碼-->
						<input type="hidden" name="securityCode" id="securityCode" value=''/>
						<div id="returnDetail">
							<table id="returnDetailTable"></table>
							<div id="returnDetailList"></div>
							<!--新增項目區塊-->
							<div id="addItemArea" style="display:none;">
								<table style="width:100%" name="addItem" id="addItem">
									<tr>
										<td style="width:5%;text-align:center;">Type</td>
										<td style="width:10%;">
											<select name="grDetailItemType" id="grDetailItemType">
												<option value="1">Product</option>
												<option value="2">Service</option>
											</select>
										</td>
										<td style="width:5%;text-align:center;">Code</td>
										<td style="width:40%">
											<select name="grDetailItemCode" id="grDetailItemCode" style="width:100%">
												<option value="">----Select Code----</option>
												<?php foreach($itemOption as $key => $val):?>
													<option value="<?php echo $key;?>"><?php echo $val;?></option>
												<?php endforeach;?>
											</select>
										</td>
										<td style="width:5%;text-align:center;">
											Qty
										</td>
										<td style="width:5%;text-align:center;">
											<input type="text" name="grDetailItemQty" id="grDetailItemQty"/>
										</td>
										<td style="width:5%;text-align:center;">Reason</td>
										<td style="width:15%;text-align:center;">
											<input type="text" name="returnRemark" id="returnRemark"/>
										</td>
										<td style="width:10%;text-align:center;">
											<input type="button" name="grDetailAddItem" id="grDetailAddItem" value="Add"/>
										</td>
									</tr>
								</table>
							</div>
						</div>
						<div id="returnGoods">
							<table id="returnGoodsTable"></table>
							<div id="returnGoodsList"></div>
						</div>
					</div>
					Reason:<br />
					<textarea name="reason" id="reason" cols="30" rows="3" style="width:95%"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2" rowspan="3">
					Remarks:<br />
					<textarea name="remark" id="remark" cols="30" rows="3"></textarea>
				</td>
				<td>Returned By</td>
				<td>
					<div id="managerName"><?php echo $this->session->userdata('username');?></div>
					<input type="hidden" name="managerID" id="managerID" value='<?php echo $this->session->userdata('employeeID');?>'/>
				</td>
			</tr>			
			<tr>
				<td>Approved By</td>
				<td>
					<select name="approved" id="approved">
						<option value="">----Select Employee----</option>
						<?php foreach($employee as $key => $val):?>
							<option value="<?php echo $key;?>"><?php echo $val;?></option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Received & <br />Inspected by</td>
				<td>
					<input type="text" name="inspected" id="inspected"/>
				</td>
			</tr>
		</table>
		<div class="permissionControl">
			<input type="hidden" name="oper" id="oper"/>
			<input type="hidden" name="id" id="id"/>
			<input type="submit" id="save" value="Save"/>
			<input type="reset" id="save" value="Cancel"/>
		</div>
		
		</form>
	</div>
	
	
	<!--主視窗-->
	<div id="menuLocation">
		<?php echo $menuInfo['parent']."=>".anchor($menuInfo['link']."/index/".$menuInfo['menuID'],$menuInfo['menuName']);//輸出功能所在位置?>
	</div>
	<br />
	<select name="warehoustName" id="warehoustName">
		<option value="">----Select Warehoust----</option>
		<?php foreach($warehouse as $key=>$val):?>
			<option value="<?php echo $key;?>"><?php echo $val;?></option>
		<?php endforeach;?>
	</select>
	<div id="MaterialRRMainInterface">
		<ul>			
			<li><a href="#materialRequest" id="requestLink">Material Request</a></li>
			<li><a href="#materialReturn" id="returnLink">Goods Return</a></li>
		</ul>
		<div id="materialRequest">
			<ul class="subTabs">			
				<li><a href="#newMR" id="mrLink">New M.R.</a></li>
				<li><a href="#approval" id="approvalLink">Waiting for Approval</a></li>
				<li><a href="#arriving" id="arrivingLink">Arriving</a></li>
				<li><a href="#completed" id="completedLink">Completed</a></li>
			</ul>
			<div id="newMR">
				<table id="requestTable" class="materialRequest"></table>
				<div id="requestList"></div>
				<div class="permissionControl">
					<!--新增按扭-->
					<input type="button" id="addRequest" value="New Request"/>				
					<!--刪除按扭-->
					<input type="button" id="delReqeust" value="Delete Request"/>
				</div>				
				<input type="button" id="editRequest" value="View/Edit Request"/>
			</div>
			<div id="approval">
				<table id="approvalTable" class="materialRequest"></table>
				<div id="approvalTableList"></div>
			</div>
			<div id="arriving">
				<table id="arrivingTable" class="materialRequest"></table>
				<div id="arrivingTableList"></div>
			</div>
			<div id="completed">
				<table id="completedTable" class="materialRequest"></table>
				<div id="completedTableList"></div>
			</div>			
		</div>
		<div id="materialReturn">
			<table id="returnTable"></table>
			<div id="returnList"></div>
			<div class="permissionControl">
				<!--新增按扭-->
				<input type="button" id="addReturn" value="New Return"/>			
				<!--刪除按扭-->
				<input type="button" id="delReturn" value="Delete Return"/>
			</div>			
			<input type="button" id="editReturn" value="Edit Return"/>
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