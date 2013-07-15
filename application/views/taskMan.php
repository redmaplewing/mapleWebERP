<div id="mainArea">
	<!--InterNal Memo 浮動視窗-->
	<div id="showTaskInterface" title="Task Management">
		<div id="mode" style="width:100%;text-align:center;">Internal Memo</div>
		<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="taskForm" name="taskForm"  class="customForm" enctype="multipart/form-data">
			<table style="width:100%;">
					<tr>
						<td>Specific Task</td>
						<td>
							<input type="text" name="title" id="title"/>
						</td>
						<td>Date Started</td>
						<td>
							<input type="text" name="startDate" id="startDate" class="date"/>
						</td>						
					</tr>
					<tr>
						<td>Assigned By</td>
						<td>
							<select name="assignedBy" id="assignedBy">
								<option value="">====Select Employee====</option>
								<?php foreach($employee as $key => $val):?>
									<option value="<?php echo $key;?>"><?php echo $val;?></option>
								<?php endforeach;?>
							</select>
						</td>
						<td>Assigned To</td>
						<td>
							<select name="assignedTo" id="assignedTo">
								<option value="">====Select Employee====</option>
								<?php foreach($employee as $key => $val):?>
									<option value="<?php echo $key;?>"><?php echo $val;?></option>
								<?php endforeach;?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Expected Completion Date</td>
						<td>
							<input type="text" name="expectedCompletion" id="expectedCompletion" class="date"/>
						</td>
						<td>Actual Completion Date</td>
						<td>
							<input type="text" name="actualCompletion" id="actualCompletion" class="date"/>
						</td>
					</tr>
					<tr>
						<td>Petrol Allowance(Y or N)</td>
						<td>
							<select name="petrolAllowance" id="petrolAllowance">
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
						</td>
						<td colspan='2'>
							Remark:<br />
							<textarea name="remark" id="reamrk" cols="30" rows="10"></textarea>
						</td>
					</tr>
				</table>
			<?php if($internalMemoControl):?>	
			<input type="hidden" name="oper" id="oper"/>
			<input type="hidden" name="managerID" id="managerID"/>
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
	<div id="taskListInterface">
		<div id="task">
			<table id="taskTable"></table>
			<div id="taskList"></div>		
			<?php if($internalMemoControl):?>			
			<input type="button" name="addTask" id="addTask" value="Add Task"/>
			<input type="button" name="delTask" id="delTask" value="Delete Selected Task"/>
			<?php endif;?>
			<input type="button" name="editTask" id="editTask" value="View/Edit Selected Task"/>			
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