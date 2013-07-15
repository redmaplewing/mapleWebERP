<div id="mainArea">
	<!--Recruitment 浮動視窗-->
	<div id="showRecruitmentRequest" title="Human Resource">
		<div id="mode" style="width:100%;text-align:center;"></div>
		<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="recruitmentForm" name="recruitmentForm"  class="customForm">
			<table style="width:100%;">
				<tr>
					<td style="width:15%;">Code</td>
					<td style="width:25%;">
						<input type="text" name="emplyoeeNo" id="emplyoeeNo"/>
					</td>
					<td style="width:15%;">Name</td>
					<td style="width:45%;">
						First Name: <input type="text" name="nameFirst" id="nameFirst" style="width:25%"/>
						Last Name: <input type="text" name="nameLast" id="nameLast" style="width:25%"/>
					</td>
				</tr>
				<tr id="employeeAccount" style="display:none;">
					<td>Account</td>
					<td>
						<input type="text" name="account" id="account"/>
					</td>
					<td>Password</td>
					<td>
						<input type="password" name="password" id="password"/>
					</td>
				</tr>
				<tr>
					<td>Request Date</td>
					<td>
						<div id="showCDate"></div>
						<input type="hidden" name="cDate" id="cDate" class="date"/>
					</td>
					<td>Approval Date</td>
					<td>
						<input type="text" name="approvalDate" id="approvalDate" class="date"/>
					</td>
				</tr>
				<tr>
					<td>G. A.</td>
					<td>
						<select name="Gender" id="Gender">
							<option value="">----Select Gender----</option>
							<option value="1">Male</option>
							<option value="2">Female</option>
						</select>
						<select name="age" id="age">
							<option value="">----Select Age----</option>
							<?php for($i=16;$i<=70;$i++):?>
								<option value="<?php echo $i;?>"><?php echo $i;?></option>
							<?php endfor;?>
						</select>
					</td>
					<td>Position</td>
					<td>
						<input type="text" name="position" id="position"/>
					</td>
				</tr>
				<tr>
					<td>Expected Salary</td>
					<td>
						<input type="text" name="expectSalary" id="expectSalary"/>
					</td>
					<td>Mode of Application</td>
					<td>
						<input type="text" name="applicationMode" id="applicationMode"/>
					</td>
				</tr>
				<tr>
					<td>Requesting Person</td>
					<td>
						<select name="requesterID" id="requesterID">
							<option value="">----Select Employee ID----</option>
							<?php foreach($employee as $key => $val):?>
								<option value="<?php echo $key;?>"><?php echo $val['name'];?></option>
							<?php endforeach;?>
						</select>
					</td>
					<td>CV Received Date</td>
					<td><input type="text" name="cvReceiveDate" id="cvReceiveDate" class="date"
					/></td>
				</tr>
				<tr>
					<td>Interview/Exam Date</td>
					<td>
						<input type="text" name="interviewDate" id="interviewDate" class="date"/>
					</td>
					<td>Location</td>
					<td>
						<select name="location" id="location">
							<option value="">----Select Location----</option>
							<option value="1">Head Office & Site Manager</option>
							<option value="2">Site Employee</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:center">
						Other:<br>
						<textarea name="other" id="other" cols="30" rows="10"></textarea>
					</td>
				</tr>
			</table>
			<div id="interviewInformation" style="display:none;text-align:center;">
				<p>Interview Information</p>
				<table style="width:100%;">
					<tr>
						<td>1st Interview/Exam</td>
						<td>
							<input type="text" name="interview1st" id="interview1st" class="date"/>
						</td>
						<td>Time</td>
						<td>
							<input type="text" name="time1st" id="time1st"/>
						</td>
						<td>Interviewer</td>
						<td>
							<select name="interviewer1st" id="interviewer1st">
								<option value="">----Select Employee----</option>
								<?php 
									foreach($employee as $key => $val):
										if($val['groupID'] == '1'):
								?>
									<option value="<?php echo $key;?>"><?php echo $val['name'];?></option>
								<?php 
										endif;
									endforeach;
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>2nd Interview/Exam</td>
						<td>
							<input type="text" name="interview2nd" id="interview2nd" class="date"/>
						</td>
						<td>Time</td>
						<td>
							<input type="text" name="time2nd" id="time2nd"/>
						</td>
						<td>Interviewer</td>
						<td>
							<select name="interviewer2nd" id="interviewer2nd">
								<option value="">----Select Employee----</option>
								<?php 
									foreach($employee as $key => $val):
										if($val['groupID'] == '1'):
								?>
									<option value="<?php echo $key;?>"><?php echo $val['name'];?></option>
								<?php 
										endif;
									endforeach;
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Salary Offer</td>
						<td>
							<input type="text" name="offerSalary" id="offerSalary"/>
						</td>
						<td>Passed(Y)/Archive(N)'</td>
						<td>
							<select name="pass" id="pass">
								<option value="">----Select Result----</option>
								<option value="1">Yes</option>
								<option value="2">No</option>
							</select>
						</td>
						<td>Confirmed(Y or N)</td>
						<td>
							<select name="resultConfirm" id="resultConfirm">
								<option value="">----Select Confirmed----</option>
								<option value="1">Yes</option>
								<option value="2">No</option>
							</select>
						</td>
					</tr>
					<!--
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
					-->
				</table>
			</div>
			<!--
			<select name="enable" id="enable" style="width:150px;">
				<option value="1">Enable</option>
				<option value="0">Disable</option>
			</select>
			-->
			<?php if($shortlistApplicantsControl || $recruitmentDatabaseControl):?>
			<input type="hidden" name="id" id="id"/>
			<input type="hidden" name="oper" id="oper"/>
			<input type="submit" id="save" value="Save"/>
			<input type="reset" id="cancel" value="Cancel"/>
			<input type="button" id="sendRequest" value="sendRequest"/>
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
			<?php if($recruitmentDatabase):?>
			<li><a href="#recruDatabase" id="databaseLink">RECRUITMENT DATABASE</a></li>
			<?php endif;?>
			<?php if($shortlistApplicants):?>
			<li><a href="#recruApplicants" id="applicantsLink">SHORTLISTED APPLICANTS</a></li>
			<?php endif;?>
		</ul>
		<?php if($recruitmentDatabase):?>
		<div id="recruDatabase">
			<table id="recruDatabaseTable" class="tableSetting"></table>
			<div id="recruDatabaseList"></div>
			<?php if($recruitmentDatabaseControl):?>
			<input type="button" name="addRecruitment" id="addRecruitment" value="Add Recruitment"/>
			
			<input type="button" name="delRecruitment" id="delRecruitment" value="Delete Selected Recruitment"/>
			<?php endif;?>
			<input type="button" name="editRecruitmentData" id="editRecruitmentData" value="View/Edit Selected  Recruitment"/>
		</div>
		<?php endif;?>
		<?php if($shortlistApplicants):?>
		<div id="recruApplicants">
			<table id="recruApplicantsTable" class="tableSetting"></table>
			<div id="recruApplicantsList"></div>
			<?php if($shortlistApplicantsControl):?>			
			<input type="button" name="delRecruApplicant" id="delRecruApplicant" value="Delete Selected Recruitment"/>
			<?php endif;?>
			<input type="button" name="editRecruitment" id="editRecruitment" value="View/Edit Selected Recruitment"/>
		</div>
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