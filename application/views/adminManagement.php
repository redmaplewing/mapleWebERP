<div id="mainArea">
	<!--InterNal Memo 浮動視窗-->
	<div id="showInternalMemoInterface" title="Internal Memo">
		<div id="mode" style="width:100%;text-align:center;">Internal Memo</div>
		<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="internalForm" name="internalForm"  class="customForm" enctype="multipart/form-data">
			<table style="width:100%;">
					<tr>
						<td>Internal Memo Code</td>
						<td>
							<input type="text" name="code" id="code"/>
						</td>
						<td>Issued Date</td>
						<td>
							<input type="text" name="issuedDate" id="issuedDate" class="date"/>
						</td>						
					</tr>
					<tr>
						<td>Title</td>
						<td>
							<input type="text" name="title" id="title"/>
						</td>
						<td>File</td>
						<td>
							<input type="file" name="file" id="file"/>
							<div id="fileName"></div>
						</td>
					</tr>
				</table>
			<?php if($internalMemoControl):?>	
			<input type="hidden" name="oper" id="oper"/>
			<input type="hidden" name="managerID" id="managerID"/>
			<input type="hidden" name="id" id="id"/>
			<input type="hidden" name="type" id="type" value="1"/>
			<input type="submit" id="save" value="Save"/>
			<input type="reset" id="cancel" value="Cancel"/>
			<?php endif;?>
		</form>
	</div>
	<!--Procedures 浮動視窗-->
	<div id="showProceduresInterface" title="Procedures">
		<div id="mode" style="width:100%;text-align:center;">Procedures</div>
		<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="proceduresForm" name="proceduresForm"  class="customForm" enctype="multipart/form-data">
			<table style="width:100%;">
					<tr>
						<td>Procedures Code</td>
						<td>
							<input type="text" name="code" id="code"/>
						</td>
						<td>Version</td>
						<td>
							<input type="text" name="version" id="version"/>
						</td>	
						<td>Revision</td>
						<td>
							<input type="text" name="revision" id="revision"/>
						</td>
					</tr>
					<tr>
						<td>Issued Date</td>
						<td>
							<input type="text" name="issuedDate2" id="issuedDate2" class="date"/>
						</td>
						<td>Title</td>
						<td>
							<input type="text" name="title" id="title"/>
						</td>
						<td>File</td>
						<td>
							<input type="file" name="file" id="file"/>
							<div id="fileName"></div>
						</td>
					</tr>
				</table>
			<?php if($proceduresControl):?>	
			<input type="hidden" name="oper" id="oper"/>
			<input type="hidden" name="managerID" id="managerID"/>
			<input type="hidden" name="id" id="id"/>
			<input type="hidden" name="type" id="type" value="2"/>
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
			<li><a href="#internal" id="internalLink">Internal Memo</a></li>
			<li><a href="#procedures" id="proceduresLink">Procedures</a></li>
		</ul>
		<div id="internal">
			<table id="internalTable"></table>
			<div id="internalList"></div>		
			<?php if($internalMemoControl):?>			
			<input type="button" name="addInternal" id="addInternal" value="Add Internal"/>
			<input type="button" name="delInternal" id="delInternal" value="Delete Selected Internal"/>
			<?php endif;?>
			<input type="button" name="editInternal" id="editInternal" value="View/Edit Selected Internal"/>			
		</div>
		<div id="procedures">
			<table id="proceduresTable"></table>
			<div id="proceduresList"></div>			
			<?php if($proceduresControl):?>			
			<input type="button" name="addProcedures" id="addProcedures" value="Add Procedures"/>
			<input type="button" name="delProcedures" id="delProcedures" value="Delete Selected Procedures"/>
			<?php endif;?>
			<input type="button" name="editProcedures" id="editProcedures" value="View/Edit Selected Procedures"/>
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