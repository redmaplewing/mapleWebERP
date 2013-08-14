<?php if(!$drawManagementControlList):?>
	<script type="text/javascript">
		$(function(){
			$(".permissionControl").hide();
		})		
	</script>
<?php endif;?>
			
<div id="mainArea">

<!--Repair Request浮動視窗-->
	<div id="showModifyDrawing" title="Drawing Detail">
		<div id="drawingMode"></div>
		<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="drawingForm" name="drawingForm"  class="customForm" enctype="multipart/form-data">
		<table style="width:100%;">
			<tr>
				<td style="width:15%">Drawing No.</td>
				<td style="width:25%"><input type="text" name="drawingNo" id="drawingNo"/></td>
				<td style="width:15%">Project No.</td>
				<td style="width:45%">
					<select name="projectID" id="projectID">
						<option value="">--Select Project Code--</option>
						<?php foreach($project as $key=>$val):?>
						<option value="<?php echo $val['id'];?>"><?php echo $val['code'];?></option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Version</td>
				<td><input type="text" name="version" id="version"/></td>
				<td>Creation Date</td>
				<td>
					<div id="showCDate"></div>
					<input type="hidden" name="cDate" id="cDate" class="date"/>
				</td>
			</tr>
			<tr>
				<td>Revision</td>
				<td>
					<input type="text" name="revision" id="revision"/>
				</td>
				<td>Distributed to</td>
				<td>
					GM:<input type="checkbox" name="toGM" id="toGM"/>&nbsp;
					Deputy GM<input type="checkbox" name="toDGM" id="toDGM"/>&nbsp;
					Client<input type="checkbox" name="toPM" id="toPM"/><br />
					Site Manager<input type="checkbox" name="toSubcontractor" id="toSubcontractor"/>&nbsp;
					Subcontractor<input type="checkbox" name="toClient" id="toClient"/>					
				</td>
			</tr>
			<tr>
				<td colspan="4">
					Description<br />
					<textarea name="description" id="scope" cols="30" rows="3"></textarea>
				</td>
			</tr>
			<tr>				
				<td>Status</td>
				<td>				
				<select name="status" id="status">
					<option value="0" selected>Select Status</option>
					<option value="3">Complect</option>
					<option value="1">Pending For Checking</option>
					<option value="2">Pending For Approval</option>
				</select>
				</td>				
				<td>Draw By</td>
				<td>
					<select name="draw" id="draw">
						<option value="">----Select Employee----</option>
						<?php foreach($employee as $key => $val):?>
							<option value="<?php echo $key;?>"><?php echo $val;?></option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>			
			<tr>
				<td>PDF Link</td>
				<td>
                    <!--http://<input type="text" name="pdfLink" id="pdfLink" style="width:75%"/>-->
                    <a href="" style="display:none;">download</a>
                    <input type="file" id="pdfLink" name="pdfLink"/>
                </td>
				<td>Check By</td>
				<td>
					<select name="check" id="check">
						<option value="">----Select Employee----</option>
						<?php foreach($employee as $key => $val):?>
							<option value="<?php echo $key;?>"><?php echo $val;?></option>
						<?php endforeach;?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Autocad Link</td>
				<td>
                    <!--http://<input type="text" name="pdfLink" id="pdfLink" style="width:75%"/>-->
                    <a href="" style="display:none;">download</a>
                    <input type="file" id="autocadLink" name="autocadLink"/>
                </td>
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
	<div id="DrawingInterface">
		<ul>
			<?php if($drawManagementViewList):?>
			<li><a href="#drawList" id="listLink">Drawing List</a></li>
			<li><a href="#drawCheck" id="checkLink">Pending For Checking</a></li>
			<li><a href="#drawApproval" id="approvalLink">Pending For Approval</a></li>
			<?php endif;?>
			<?php if($drawManagementViewDis):?>
			<li><a href="#drawDistribution" id="distributionLink">Drawing Distribution</a></li>
			<?php endif;?>
		</ul>
		
		<!--draw List-->
		<?php if($drawManagementViewList):?>
		<div id="drawList">
			<table id="drawListTable"></table>
			<div id="drawListList"></div>
			<!--新增按扭-->
			<div class="permissionControl">
				<input type="button" id="addDraw" value="New Drawing"/>
				<input type="button" id="delDraw" value="Delete Drawing"/>
			</div>			
			<input type="button" id="editDraw" value="View/Edit Drawing"/>
		</div>
		<!--洽談中案件-->
		<div id="drawCheck">
			<table id="drawCheckTable"></table>
			<div id="drawCheckList"></div>
		</div>
		<!--執行中案件-->
		<div id="drawApproval">
			<table id="drawApprovalTable"></table>
			<div id="drawApprovalList"></div>
		</div>
		<?php endif;?>
		<!--完成案件-->
		<?php if($drawManagementViewDis):?>
		<div id="drawDistribution">
			<table id="drawDistributionTable"></table>
			<div id="drawDistributionList"></div>
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