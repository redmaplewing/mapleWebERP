<div id="mainArea">
	<!--Recruitment 浮動視窗-->
	<div id="showGroupInterface" title="Group Permission">
		<div id="mode" style="width:100%;text-align:center;"></div>
		<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="groupForm" name="groupForm"  class="customForm">
			<table style="width:100%;">
				<tr>
					<td colspan="2">Group Setting</td>
				</tr>
				<tr>
					<td style="width:65%">Group Name</td>
					<td>
						<input type="text" name="name" id="name"/>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Enable</td>
					<td>
						<select name="enable" id="enable" style="width:150px;">
							<option value="1">Enable</option>
							<option value="0">Disable</option>
						</select>
					</td>
				</tr>
				<!-- Part of Admin Management -->
				<tr>
					<td colspan='2' style="text-align:center">Admin Management</td>
				</tr>
				<tr>
					<td style="width:65%">Internal Memo</td>
					<td>
						<select name="internalMemo" id="internalMemo">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Procedures</td>
					<td>
						<select name="procedures" id="procedures">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Review Log Sheet Data</td>
					<td>
						<select name="logSheetData" id="logSheetData">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Create Backup File</td>
					<td>
						<select name="createBackFile" id="createBackFile">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Adjust Data</td>
					<td>
						<select name="adjustData" id="adjustData">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Task Management</td>
					<td>
						<select name="taskManagement" id="taskManagement">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<!-- Part of HumanResource Management -->
				<tr>
					<td colspan='2' style="text-align:center">Human Resource Management</td>
				</tr>
				<tr>
					<td style="width:65%">Organizational Chart</td>
					<td>
						<select name="organizationalChart" id="organizationalChart">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Address Book</td>
					<td>
						<select name="addressbook" id="addressbook">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Company Calendar</td>
					<td>
						<select name="companyCalendar" id="companyCalendar">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Employee Profile - General Information</td>
					<td>
						<select name="empGeneralInformation" id="empGeneralInformation">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Employee Profile - Tasks</td>
					<td>
						<select name="empTask" id="empTask">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Employee Profile - jobDescription</td>
					<td>
						<select name="empJobDescription" id="empJobDescription">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Employee Profile - appraisal</td>
					<td>
						<select name="empAppraisal" id="empAppraisal">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Recruitment Database</td>
					<td>
						<select name="recruitmentDatabase" id="recruitmentDatabase">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Shortlisted Applicants</td>
					<td>
						<select name="shortlistApplicants" id="shortlistApplicants">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Employee List</td>
					<td>
						<select name="employeeList" id="employeeList">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Attendance Record</td>
					<td>
						<select name="attandanceRecord" id="attandanceRecord">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<!-- Part of Purchase Management -->
				<tr>
					<td colspan='2' style="text-align:center">Purchase Management</td>
				</tr>
				<tr>
					<td style="width:65%">Information Registry</td>
					<td>
						<select name="purInformationRegistry" id="purInformationRegistry">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Purchase Request</td>
					<td>
						<select name="purPurchaseRequest" id="purPurchaseRequest">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Purchase Order - Local</td>
					<td>
						<select name="purPurchaseOrderLocal" id="purPurchaseOrderLocal">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Purchase Order - Overseas</td>
					<td>
						<select name="purPurchaseOrderOverseas" id="purPurchaseOrderOverseas">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Report Center</td>
					<td>
						<select name="purReportCenter" id="purReportCenter">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<!-- Part of Inventory Management -->
				<tr>
					<td colspan='2' style="text-align:center">Inventory Management</td>
				</tr>
				<tr>
					<td style="width:65%">Information Registry</td>
					<td>
						<select name="invInformationRegistry" id="invInformationRegistry">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Material Request & Return</td>
					<td>
						<select name="invMaterialRequestReturn" id="invMaterialRequestReturn">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Tools & Equipment Management</td>
					<td>
						<select name="invToolEqupmentManagement" id="invToolEqupmentManagement">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Report Center</td>
					<td>
						<select name="invReportCenter" id="invReportCenter">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<!-- Part of Drawing Management -->
				<tr>
					<td colspan='2' style="text-align:center">Drawing Management</td>
				</tr>
				<tr>
					<td style="width:65%">Drawing List</td>
					<td>
						<select name="drawList" id="drawList">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width:65%">Drawing Distribution</td>
					<td>
						<select name="drawDistribution" id="drawDistribution">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>
				<!-- Part of Project List -->
				<tr>
					<td colspan='2' style="text-align:center">Project List</td>
				</tr>
				<tr>
					<td style="width:65%">Project List</td>
					<td>
						<select name="projectList" id="projectList">
							<option value="">====Select Permission====</option>
							<option value="0">No Access</option>
							<option value="1">View</option>
							<option value="2">Full Control</option>
						</select>
					</td>
				</tr>				
			</table>			
			<input type="hidden" name="oper" id="oper"/>
			<input type="hidden" name="id" id="id"/>
			<input type="submit" id="save" value="Save"/>
			<input type="reset" id="cancel" value="Cancel"/>
		</form>
	</div>
	
	
	<!--主視窗-->
	<div id="menuLocation">
		<?php echo $menuInfo['parent']."=>".anchor($menuInfo['link']."/index/".$menuInfo['menuID'],$menuInfo['menuName']);//輸出功能所在位置?>
	</div>
	<br />
	<div id="groupPermission">
		<table id="groupTable"></table>
		<div id="groupList"></div>
		<input type="button" name="addGroup" id="addGroup" value="Add Grouup"/>
		<input type="button" name="editGroup" id="editGroup" value="Edit Selected Grouup"/>
		<input type="button" name="delGroup" id="delGroup" value="Delete Selected Grouup"/>
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