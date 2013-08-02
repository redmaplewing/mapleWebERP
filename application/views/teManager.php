<?php if(!$teManager):?>
	<script type="text/javascript">
		$(function(){
			$(".permissionControl").hide();
		})		
	</script>
<?php endif;?>	
<div id="mainArea">

<!--Repair Request浮動視窗-->
	<div id="showRepairRequest" title="Repair Request">
		<div id="repairMode"></div>
		<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="repairForm" name="repairForm"  class="customForm">
		
		<table style="width:100%;">
			<tr>
				<td>R.R. No.</td>
				<td><input type="text" name="itemHandleNo" id="itemHandleNo"></td>
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
					<select name="projectID" id="projectID" class="projectID">
						<option value="">--Select Project Code--</option>
						<?php foreach($project as $key=>$val):?>
						<option value="<?php echo $val['id'];?>"  projectName="<?php echo $val['name'];?>"><?php echo $val['code'];?></option>
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
				<td><input type="text" name="projectName" id="projectName"/></td>
				<td>Expected Date</td>
				<td><input type="text" name="eDate" id="eDate" class="date"/></td>
			</tr>
			<tr>
				<td>Purpose</td>
				<td><input type="text" name="purpose" id="purpose"/></td>
				<td>Submitted Date</td>
				<td>
					<div id="showSubmitDate"></div>
					<input type="hidden" id="submitDate" name="submitDate" class="date"/>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<div id="repairInfo">
						<ul class="subTabs">
							<li><a href="#repairDetail" id="detilLink">R.R. Details</a></li>
							<li><a href="#repairReceiving" id="receivingLink">Tools & Equip. Receiving</a></li>
						</ul>
						<!--項目新增控制項-->
						<!--識別碼-->
						<input type="hidden" name="securityCode" id="securityCode" value=''/>
						<div id="repairDetail">
							<table id="repairDetailTable" class="detailTable"></table>
							<div id="repairDetailList" ></div>
							<div id="addItemArea"  class="permissionControl"><!-- style="display:none;"-->
								<table style="width:100%" name="addItem" id="addItem">
									<tr>
										<td style="width:10%;text-align:center;">Code</td>
										<td style="width:40%">
											<select name="itemID" id="itemID" style="width:100%">
												<option value="">----Select Code----</option>
												<?php foreach($item as $key => $val):?>
													<option value="<?php echo $key;?>"><?php echo $val;?></option>
												<?php endforeach;?>
											</select>
										</td>
										<td style="width:10%;text-align:center;">
											Qty
										</td>
										<td>
											<input type="text" name="qty" id="qty"/>
										</td>
										
										<td style="width:10%;text-align:center;">
											Amt.Spent
										</td>
										<td>
											<input type="text" name="amtSpent" id="amtSpent">
										</td>										
									<tr>
										<td style="width:10%;text-align:center;">
											Ref.(LPO#)
										</td>
										<td>
											<select name="purchaseOrderID" id="purchaseOrderID">
												<option value="">----Select PurchaseOrder----</option>
												<?php foreach($purchaseOrder as $key => $val):?>
													<option value="<?php echo $key;?>"><?php echo $val;?></option>
												<?php endforeach;?>
											</select>
										</td>
										<td style="width:10%;text-align:center;">
											Mechanic's Note
										</td>
										<td colspan="3">
											<input type="text" name="note" id="note">
										</td>
									</tr>
									<tr>
										<td style="width:10%;text-align:center;">Reason</td>
										<td colspan="5" style="width:10%">
											<input type="text" name="reason" id="reason">
										</td>
										<td style="width:10%;text-align:center;">
											<input type="button" name="addItem" id="addItem" value="Add" class='addItem'/>
										</td>
									</tr>
									</tr>
								</table>
							</div>	
						</div>	
						<div id="repairReceiving">
							<table id="repairReceivingTable" class="receiveTable"></table>
							<div id="repairReceivingList"></div>
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
					<select name="approved" id="approved">
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
			<input type="hidden" name="type" id="type" value="1"/>
			<input type="submit" id="save" value="Save"/>
			<input type="reset" id="cancel" value="Cancel"/>
			<input type="button" id="printRR" value="PRINT"/>
			<input type="button" id="submit" name="submit" value="Submit" class="submit"/>
		</div>		
		</form>
	</div>
	
	<!--Request Calibration浮動視窗-->
	<div id="showCalibrationRequest" title="Calibration Request">
		<div id="calibrationMode"></div>
		<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="CalibrationForm" name="CalibrationForm"  class="customForm">
		
		<table style="width:100%;">
			<tr>
				<td>C.R. No.</td>
				<td><input type="text" name="itemHandleNo" id="itemHandleNo"></td>
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
					<select name="projectID" id="projectID" class="projectID"> 
						<option value="">--Select Project Code--</option>
						<?php foreach($project as $key=>$val):?>
						<option value="<?php echo $val['id'];?>" projectName="<?php echo $val['name'];?>"><?php echo $val['code'];?></option>
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
				<td><input type="text" name="projectName" id="projectName"/></td>
				<td>Expected Date</td>
				<td><input type="text" name="eDate" id="ceDate" class="date"/></td>
			</tr>
			<tr>
				<td>Purpose</td>
				<td><input type="text" name="purpose" id="purpose"/></td>
				<td>Submitted Date</td>
				<td>
					<div id="showSubmitDate"></div>
					<input type="hidden" id="submitDate" name="submitDate" class="date"/>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<div id="calibrationInfo">
						<ul class="subTabs">
							<li><a href="#calibrationDetail" id="detilLink">R.C. Details</a></li>
							<li><a href="#calibrationReceiving" id="receivingLink">Tools & Equip. Receiving</a></li>
						</ul>
						<!--項目新增控制項-->
						<!--識別碼-->
						<input type="hidden" name="securityCode" id="securityCode" value=''/>
						<div id="calibrationDetail">
							<table id="calibrationDetailTable"  class="detailTable"></table>
							<div id="calibrationDetailList"></div>
							<div id="addItemArea" class="permissionControl"><!-- style="display:none;"-->
								<table style="width:100%" name="addItem" id="addItem" >
									<tr>
										<td style="width:10%;text-align:center;">Code</td>
										<td style="width:40%">
											<select name="itemID" id="itemID" style="width:100%">
												<option value="">----Select Code----</option>
												<?php foreach($item as $key => $val):?>
													<option value="<?php echo $key;?>"><?php echo $val;?></option>
												<?php endforeach;?>
											</select>
										</td>
										<td style="width:10%;text-align:center;">
											Qty
										</td>
										<td>
											<input type="text" name="qty" id="qty"/>
										</td>
										
										<td style="width:10%;text-align:center;">
											Amt.Spent
										</td>
										<td>
											<input type="text" name="amtSpent" id="amtSpent">
										</td>	
									</tr>
									<tr>
										<td style="width:10%;text-align:center;">
											Ref.(LPO#)
										</td>
										<td>
											<select name="purchaseOrderID" id="purchaseOrderID">
												<option value="">----Select PurchaseOrder----</option>
												<?php foreach($purchaseOrder as $key => $val):?>
													<option value="<?php echo $key;?>"><?php echo $val;?></option>
												<?php endforeach;?>
											</select>
										</td>
										<td style="width:10%;text-align:center;">
											Mechanic's Note
										</td>
										<td colspan="3">
											<input type="text" name="note" id="note">
										</td>
									</tr>
									<tr>
										<td>Cabli. Result</td>
										<td colspan='3'><input type="text" name="cabliResult" id="cabliResult"></td>
										<td style="width:10%;text-align:center;">Reason</td>
										<td style="width:10%">
											<input type="text" name="reason" id="reason">
										</td>
										<td>
											<input type="button" name="addItem" id="addItem" value="Add"  class="addItem"/>
										</td>
									</tr>
									
								</table>
							</div>
						</div>
						<div id="calibrationReceiving">
							<table id="calibrationReceivingTable" class="receiveTable"></table>
							<div id="calibrationReceivingList"></div>
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
					<select name="approved" id="approved">
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
			<input type="hidden" name="type" id="type" value="2"/>
			<input type="submit" id="save" value="Save"/>
			<input type="reset" id="cancel" value="Cancel"/>
			<input type="button" id="printRC" value="PRINT"/>
			<input type="button" id="submit" name="submit" value="Submit" class="submit"/>
		</div>		
		</form>
	</div>
	
	<!--Request Disposal浮動視窗-->
	<div id="showDisposalRequest" title="Disposal Request">
		<div id="disposalMode"></div>
		<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="disposalForm" name="disposalForm"  class="customForm">
		
		<table style="width:100%;">
			<tr>
				<td>D.R. No.</td>
				<td><input type="text" name="itemHandleNo" id="itemHandleNo"></td>
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
					<select name="projectID" id="projectID"  class="projectID">
						<option value="">--Select Project Code--</option>
						<?php foreach($project as $key=>$val):?>
						<option value="<?php echo $val['id'];?>" projectName="<?php echo $val['name'];?>"><?php echo $val['code'];?></option>
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
				<td><input type="text" name="projectName" id="projectName"/></td>
				<td>Expected Date</td>
				<td><input type="text" name="eDate" id="deDate" class="date"/></td>
			</tr>
			<tr>
				<td>Purpose</td>
				<td><input type="text" name="purpose" id="purpose"/></td>
				<td>Submitted Date</td>
				<td>
					<div id="showSubmitDate"></div>
					<input type="hidden" id="submitDate" name="submitDate" class="date"/>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					<div id="disposalInfo">
						<ul class="subTabs">
							<li><a href="#disposalDetail" id="detilLink">R.D. Details</a></li>
							<li><a href="#disposalReceiving" id="receivingLink">Tools & Equip. Receiving</a></li>
						</ul>
						<!--項目新增控制項-->
						<!--識別碼-->
						<input type="hidden" name="securityCode" id="securityCode" value=''/>
						<div id="disposalDetail">
							<table id="disposalDetailTable"  class="detailTable"></table>
							<div id="disposalDetailList"></div>
							<div id="addItemArea" class="permissionControl"><!-- style="display:none;"-->
								<table style="width:100%" name="addItem" id="addItem">
									<tr>
										<td style="width:10%;text-align:center;">Code</td>
										<td style="width:40%">
											<select name="itemID" id="itemID" style="width:100%">
												<option value="">----Select Code----</option>
												<?php foreach($item as $key => $val):?>
													<option value="<?php echo $key;?>"><?php echo $val;?></option>
												<?php endforeach;?>
											</select>
										</td>
										<td style="width:10%;text-align:center;">Reason</td>
										<td style="width:30%">
											<input type="text" name="reason" id="reason">
										</td>
										<td>
											<input type="button" name="addItem" id="addItem" value="Add" class="addItem"/>
										</td>
									</tr>
								</table>
							</div>
						</div>
						<div id="disposalReceiving">
							<table id="disposalReceivingTable" class="receiveTable"></table>
							<div id="disposalReceivingList"></div>
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
					<select name="approved" id="approved">
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
			<input type="hidden" name="type" id="type" value="3"/>
			<input type="submit" id="save" value="Save"/>
			<input type="reset" id="cancel" value="Cancel"/>
			<input type="button" id="printRD" value="PRINT"/>
			<input type="button" id="submit" name="submit" value="Submit" class="submit"/>
		</div>		
		</form>
	</div>
	
	<!--主視窗-->
	<div id="menuLocation">
		<?php echo $menuInfo['parent']."=>".anchor($menuInfo['link']."/index/".$menuInfo['menuID'],$menuInfo['menuName']);//輸出功能所在位置?>
	</div>
	<br />
	<select name="warehouseName" id="warehouseName">
		<option value="">----Select Warehoust----</option>
		<?php foreach($warehouse as $key=>$val):?>
			<option value="<?php echo $key;?>"><?php echo $val;?></option>
		<?php endforeach;?>
	</select>
	<div id="TEManagerInterface">
		<ul>			
			<li><a href="#managerRepair" id="repairLink">Request for Repair</a></li>
			<li><a href="#managerCalibration" id="calibrationLink">Request for Calibration</a></li>
			<li><a href="#managerDisposal" id="disposalLink">Request for Disposal</a></li>
		</ul>
		<div id="managerRepair">
			<ul class="subTabs">			
				<li><a href="#repairNewRR" id="newLink">New R.R.</a></li>
				<li><a href="#repairApproval" id="approvalLink">Waiting for Approval</a></li>
				<li><a href="#repairInProgress" id="inProgressLink">Arriving</a></li>
				<li><a href="#repairCompleted" id="completedLink">Completed</a></li>
			</ul>
			<div id="repairNewRR">
				<table id="rRepairTable" class="defaultGrid"></table>
				<div id="rRepairList"></div>
				<div class="permissionControl">
					<!--新增按扭-->
					<input type="button" id="addrrRequest" value="New Request"/>
					<!--刪除按扭-->
					<input type="button" id="delrrRequest" value="Delete Request"/>
				</div>				
				<input type="button" id="editrrRequest" value="Edit Request"/>
				
			</div>
			<div id="repairApproval">
				<table id="rApprovalTable" class="defaultGrid"></table>
				<div id="rApprovalList"></div>
			</div>
			<div id="repairInProgress">
				<table id="rInProgressTable" class="defaultGrid"></table>
				<div id="rInProgressList"></div>
			</div>
			<div id="repairCompleted">
				<table id="rCompletedTable" class="defaultGrid"></table>
				<div id="rCompletedList"></div>
			</div>			
		</div>
		<div id="managerCalibration">
			<ul class="subTabs">			
				<li><a href="#calibrationNewRR" id="calibrationNewLink">New R.C.</a></li>
				<li><a href="#calibrationApproval" id="calibrationApprovalLink">Waiting for Approval</a></li>
				<li><a href="#calibrationInProgress" id="calibrationInProgressLink">Arriving</a></li>
				<li><a href="#calibrationCompleted" id="calibrationCompletedLink">Completed</a></li>
			</ul>
			<div id="calibrationNewRR">
				<table id="cRequestTable" class="defaultGrid"></table>
				<div id="cRequestList"></div>
				<div class="permissionControl">
					<!--新增按扭-->
					<input type="button" id="addcRequest" value="New Request"/>				
					<!--刪除按扭-->
					<input type="button" id="delcReqeust" value="Delete Request"/>
				</div>
				<input type="button" id="editcRequest" value="Edit Request"/>
			</div>
			<div id="calibrationApproval">
				<table id="cApprovalTable" class="defaultGrid"></table>
				<div id="cApprovalList"></div>
			</div>
			<div id="calibrationInProgress">
				<table id="cInProgressTable" class="defaultGrid"></table>
				<div id="cInProgressList"></div>
			</div>
			<div id="calibrationCompleted">
				<table id="cCompletedTable" class="defaultGrid"></table>
				<div id="cCompletedList"></div>
			</div>		
		</div>
		<div id="managerDisposal">
			<ul class="subTabs">			
				<li><a href="#disposalNewRR" id="disposalNewLink">New R.D.</a></li>
				<li><a href="#disposalApproval" id="disposalApprovalLink">Waiting for Approval</a></li>
				<li><a href="#disposalInProgress" id="disposalInProgressLink">Arriving</a></li>
				<li><a href="#disposalCompleted" id="disposalCompletedLink">Completed</a></li>
			</ul>
			<div id="disposalNewRR">
				<table id="dRequestTable" class="defaultGrid"></table>
				<div id="dRequestList"></div>
					<div class="permissionControl">
					<!--新增按扭-->
					<input type="button" id="adddRequest" value="New Request"/>
					<!--刪除按扭-->
					<input type="button" id="deldReqeust" value="Delete Request"/>
					</div>
				<input type="button" id="editdRequest" value="View/Edit Request"/>
				
			</div>
			<div id="disposalApproval">
				<table id="dApprovalTable" class="defaultGrid"></table>
				<div id="dApprovalList"></div>
			</div>
			<div id="disposalInProgress">
				<table id="dInProgressTable" class="defaultGrid"></table>
				<div id="dInProgressList"></div>
			</div>
			<div id="disposalCompleted">
				<table id="dCompletedTable" class="defaultGrid"></table>
				<div id="dCompletedList"></div>
			</div>		
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