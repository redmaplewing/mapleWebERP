<?php if(!$proj):?>
	<script type="text/javascript">
		$(function(){
			$(".permissionControl").hide();
		})		
	</script>
<?php endif;?>	
<div id="mainArea">

<!--Repair Request浮動視窗-->
	<div id="showModifyProject" title="Project Detail">
		<div id="projectMode"></div>
		<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="projectForm" name="projectForm"  class="customForm">
		
		<table style="width:100%;">
			<tr>
				<td style="width:15%">Project No.</td>
				<td style="width:25%"><input type="text" name="projectNo" id="projectNo"/></td>
				<td style="width:15%">Status</td>
				<td style="width:45%">
					<select name="status" id="status">
						<option value="">----Select Status----</option>
						<option value="0">Under Negotiation</option>
						<option value="1">In-Progress</option>
						<option value="2">Completed</option>
						
					</select>
				</td>
			</tr>
			<tr>
				<td>Project Name</td>
				<td><input type="text" name="name" id="name"/></td>
				<td>Creation Date</td>
				<td>
					<div id="showCDate"></div>
					<input type="hidden" name="cDate" id="cDate" class="date"/>
				</td>
			</tr>
			<tr>
				<td>Locaton</td>
				<td>
					<select name="location" id="location">
						<option value="">----Select Location----</option>
						<option value="0">Local</option>
						<option value="1">Overseas</option>
					</select>
				</td>
				<td>Start Date</td>
				<td>
					As Per Contact:<input type="text" name="perContactStart" id="perContactStart" class="date" style="width:20%"/>
					&nbsp;Actual:<input type="text" name="actualStart" id="actualStart" class="date" style="width:20%"/>
				</td>
			</tr>
			<tr>				
				<td>Person In Charge<br />(Site Manager)</td>
				<td>
					<select name="siteManager" id="siteManager">
						<option value="">----Select Manager----</option>
						<?php foreach($employee as $key => $val):?>
							<option value="<?php echo $key;?>"><?php echo $val;?></option>
						<?php endforeach;?>
					</select>
				</td>				
				<td>Completion Date</td>
				<td>
					As Per Contact:<input type="text" name="perContactCompletion" id="perContactCompletion" class="date" style="width:20%"/>
					&nbsp;Actual:<input type="text" name="actualCompletion" id="actualCompletion" class="date" style="width:20%"/>
				</td>
			</tr>
			<tr>
				<td colspan="4" >
					<div id="underNegotiating" style="width:100%;">
					<br />
						<table  style="width:100%">
							<tr>
								<td colspan="4" style="center;text-align:center;height:25px;background-color:#c3c3c3">Under Negotiating</td>
							</tr>
							<tr>
								<td>Inquiry No</td>
								<td><input type="text" name="inquiryNo" id="inquiryNo"/></td>
								<td>Negotiating Person/Team</td>
								<td>
                                    <select name="negotiating" id="negotiating">
                                        <option value="">----Select Employee----</option>
                                        <?php foreach($employee as $key => $val):?>
                                            <option value="<?php echo $key;?>"><?php echo $val;?></option>
                                        <?php endforeach;?>
                                    </select>
                                </td>
							</tr>
							<tr>
								<td>Client Name</td>
								<td><input type="text" name="clientName" id="clientName"/></td>
								<td>Negotiating Status</td>
								<td>
									<select name="negotiatingStatus" id="negotiatingStatus">
										<option value="">----Select Status----</option>
										<option value="0">Closed Deal</option>
										<option value="1">Declined</option>
										<option value="2">Cancelled</option>
									</select>
								</td>								
							</tr>
							<tr>							
								<td colspan="4">
									Client Requirement:<br />
									<textarea name="clientRequirement" id="clientRequirement" cols="30" rows="3"></textarea>
								</td>
							</tr>
						</table>
					</div>					
				</td>
			</tr>
			<tr>
				<td>Warranty Period</td>
				<td><input type="text" name="warrantyPeriod" id="warrantyPeriod"/></td>
				<td>Requested By</td>
				<td>
					<?php echo $this->session->userdata('username')?>
					<input type="hidden" name="managerID" id="managerID" value="<?php echo $this->session->userdata('employeeID');?>"/>
				</td>
			</tr>
			<tr>
				<td colspan="4">
					Scope of Work:<br />
					<textarea name="scope" id="scope" cols="30" rows="3"></textarea>
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
	<div id="projectInterface">
		<ul>			
			<li><a href="#projList" id="listLink">Project List</a></li>
			<li><a href="#projNegotiation" id="negotiationLink">Under Negotiation</a></li>
			<li><a href="#projInProgress" id="inProgressLink">In-Progress</a></li>
			<li><a href="#projCompleted" id="completedLink">Completed</a></li>
		</ul>
		
		<!--Project List-->
		<div id="projList">
			<table id="projListTable"></table>
			<div id="projListList"></div>
			<div class="permissionControl">
				<!--新增按扭-->
				<input type="button" id="addProj" value="New Project"/>
				<input type="button" id="delProj" value="Delete Project"/>
			</div>
			
			<input type="button" id="editProj" value="View/Edit Project"/>
			<!--刪除按扭-->
			<!--<input type="button" id="delDetail" value="Delete Item"/>-->
		</div>
		<!--洽談中案件-->
		<div id="projNegotiation">
			<table id="projNegotiationTable"></table>
			<div id="projNegotiationList"></div>
		</div>
		<!--執行中案件-->
		<div id="projInProgress">
			<table id="projInProgressTable"></table>
			<div id="projInProgressList"></div>
		</div>
		<!--完成案件-->
		<div id="projCompleted">
			<table id="projCompletedTable"></table>
			<div id="projCompletedList"></div>
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