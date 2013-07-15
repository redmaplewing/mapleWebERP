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
<div id="mainArea">
	<!--項目編輯彈跳視窗-->
	<div id="detailWindow"  title="Product Information">
		<div id="mode"></div>		
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1" id="addEdit">Product Details</a></li>
				<li><a href="#tabs-2" id="purHistory">Purchase History</a></li>
				<li><a href="#tabs-3" id="usageHistory">Usage History</a></li>
				<li><a href="#tabs-4" id="priceHistory">Price History</a></li>
			</ul>
			<!--項目新增、編輯表單-->
			<div id="tabs-1">
				<div id="modifyFormDiv">
					<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="modifyForm" name="modifyForm"  class="customForm" enctype="multipart/form-data">
					<table style="width:100%;boder:1px;">					
						<tr>
							<td style="width:25%;">Product Name</td>
							<td colspan="3" style="width:75%;text-align:left"><input type="text" id="name" name="name" style="width:100%;"/></td>
						</tr>
						<tr>
							<td style="width:25%;">Product Code</td>
							<td style="width:25%;"><input type="text" size="20" id="code" name="code" /></td>
							<td style="width:20%;">Unit Cost:</td>
							<td style="width:30%;">$US<input type="text" id="unitCost" name="unitCost" style="width:70%"/></td>
						</tr>
						<tr>
							<td style="width:25%;">Category</td>
							<td style="width:25%;"><input type="text" size="20" id="category" name="cotegory" /></td>
							<td style="width:25%;"><label for="levelAmount">Minimum Level:</lable></td>
							<td style="width:25%;">
								<input type="text" id="minimumLevel" name="minimumLevel"/>
								<!--
								<input type="text" id="minimumLevel" name="minimumLevel" style="width:20%" readonly/>
								<div id="levelSlider" name="levelSlider" style="width:65%;float:left;margin-top:7px;"></div>
								-->
							</td>
						</tr>
						<tr>
							<td style="width:25%;">Supplier</td>
							<td style="width:25%;">
							<select name="supplier" id="supplier">
								<option value="">----Select Supplier----</option>
								<?php foreach($supplier as $key => $val):?>
									<option value="<?php echo $key;?>"><?php echo $val;?></option>
								<?php endforeach;?>
							</select>
							</td>
							<td style="width:25%;"><label for="defaultQtyAmount">Default Recorder Qty:</lable></td>
							<td style="width:25%;">
								<input type="text" id="defaultQty" name="defaultQty"/>
								<!--
								<input type="text" id="defaultQty" name="defaultQty" style="width:20%" readonly/>
								<div id="QtySlider" name="QtySlider"  style="width:65%;float:left;margin-top:7px;"></div>
								-->
							</td>
						</tr>
						<tr>
							<td style="width:25%;">UoM</td>
							<td style="width:25%;"><input type="text" size="20" id="UoM" name="UoM" /></td>
							<td style="width:25%;">Location:</td>
							<td style="width:25%;">
								<!--Local = 0, Overseas=1-->
								<select name="location" id="location">
									<option value="" selected>Select Location</option>
									<option value="0">Local</option>
									<option value="1">Overseas</option>
								</select>
								<!--
								Local :<input type="radio" name="location" value="0"/>
								Overseas :<input type="radio" name="location" value="1"/>
								-->								
							</td>
						</tr>
						<tr>
							<td colspan="2" style="width:50%">
							Description<br />
							<textarea name="description" id="description" cols="30" rows="10"></textarea>
							</td>
							<td colspan="2" style="width:50%">
							Attachment<br />
							<textarea name="attachment" id="attachment" cols="30" rows="10"></textarea>
							</td>
						</tr>					
					</table>
					<?php if($pruInfoRegistry):?>
					<input type="hidden" id="oper" name="oper" value="add"/>
					<!-- item type product=1,service=2,equiment=3,tools=4-->
					<input type="hidden" id="type" name="type" value="1"/>
					<input type="hidden" id="id" name="id" value=""/>
					<input type="submit" value="save"/>
					<input type="reset" value="cancel"/>
					<?php endif;?>
					</form>
				</div>
			</div>
			<!--採購歷程-->
			<div id="tabs-2">
				<table id="tabPurHistory"></table>
				<div id="purList"></div>
			</div>
			<!--使用歷程-->
			<div id="tabs-3">
				<table id="tabUsageHistory"></table>
				<div id="usageList"></div>
			</div>
			<!--價格歷程-->
			<div id="tabs-4">
				<table id="tabPriceHistory"></table>
				<div id="priceList"></div>
			</div>
		</div>		
	</div>
	<!--供應商彈跳視窗-->
	<div id="supDetailWindow"  title="Supplier">
		<div id="supMode"></div>
		<div id="supTabs">			
			<ul>
				<li><a href="#supTabs1" id='Supplier Profile'>Supplier Profile</a></li>
				<li><a href="#supTabs2" id='Supplier Evaluation'>Supplier Evaluation</a></li>
			</ul>
			<div id="supTabs1">
				<form action="<?php echo base_url().$menuInfo['link']."/modify/".$tableName['linkTable']['supplier'];?>"  method="post" id="supModifyForm" name="supModifyForm"  class="customForm" enctype="multipart/form-data">
				<table border="1" >
					<tr>
						<td colspan="1">Supplier Code</td>
						<td colspan="2"><input type="text" name="supplierNo" value="supplierNo"/></td>
						<td colspan="1">Status</td>
						<td colspan="1">
							<select name="status" id="status">
								<option value="">----Select Status----</option>
								<option value="0">Active</option>
								<option value="1">Discontinued</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="1">Supplier Name</td>
						<td colspan="4"><input type="text" name="name"/></td>
					</tr>
					<tr>
						<td colspan="1" style="width:20%">Location:</td>
						<td colspan="4" style="width:80%">
							<select name="location" id="location" style="width:25%;">
								<!--Local = 0, Overseas=1-->
								<option value="" selected>Select Location</option>
								<option value="0">Local</option>
								<option value="1">Overseas</option>
							</select>&nbsp;
							Payment Term Agreement : <input type="text" name="payment" style="width:40%;"/>
						</td>
					</tr>
					<tr>
						<td rowspan="6">
							Contact Person Photo<br />
							<img src="" style="width:80%;margin-left:5px;" alt=""/>
							<input type="file" name="photo" id="photo" style="width:100%"/>
						</td>
						<td style="width:20%;">First Name</td>
						<td style="width:20%;"><input type="text" name="nameFirst"/></td>
						<td style="width:20%;">Buss. Type</td>
						<td style="width:20%;"><input type="text" name="bussType"/></td>
					</tr>
					<tr>
						<td>Lase Name</td>
						<td><input type="text" name="nameLast"/></td>
						<td>Webpage</td>
						<td><input type="text" name="webpage"/></td>
					</tr>
					<tr>
						<td>Gender</td>
						<td>
							<!--gender male=0, female=1-->
							<select name="gender" id="gender">							
								<option value="" selected>choose gender</option>
								<option value="0">Male</option>
								<option value="1">Female</option>
							</select>
						<!--<input type="text" name="gender"/>-->						
						</td>
						<td>Buss. Phone</td>
						<td><input type="text" name="bussPhone"/></td>
					</tr>
					<tr>
						<td>Position</td>
						<td><input type="text" name="position"/></td>
						<td>Fax No.</td>
						<td><input type="text" name="fax"/></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="text" name="email"/></td>
						<td>Mobile No.</td>
						<td><input type="text" name="mobile"/></td>
					</tr>
					<tr style="height:30px;">
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td colspan="5">
							<p>Postal Address:(Bldg.NO. & Street)</p>
							<input type="text" name="postalFirst"/>
						</td>					
					</tr>
					<tr>
						<td colspan="5">
							<p>City&nbsp;State/Province&nbsp;Postal Code&nbsp;Country/Region</p>
							<input type="text" name="postalLast"/>
						</td>
					</tr>
				</table>
				<?php if($pruInfoRegistry):?>
				<input type="hidden" id="oper" name="oper" value="add"/>
				<input type="hidden" id="id" name="id" value=""/>
				<input type="submit" value="save"/>
				<input type="reset" value="cancel"/>
				<?php endif;?>
				</form>
			</div>			
			<div id="supTabs2" style="width:100%">
				<div id="supInformation" style="width:100%;"></div>
				<form action="<?php echo base_url().$menuInfo['link']."/modify/supplier"?>" method="post" id="supEvaModifyForm" name="supEvaModifyForm"  class="customForm">
				<table style="width:100%;">
					<tr>
						<td>Localtion</td>
						<td id="supLocation"></td>
						<td>Buss. Type</td>
						<td id="supType"></td>
					</tr>
					<tr>
						<td colspan="2" style="width:60%;text-align:center;">Areas of Evaliuation</td>
						<td colspan="2"></td>
					</tr>
					<tr>
						<td colspan="2">1. Timeliness of Deliveries.</td>
						<td colspan="2">
							<select name="supEvaluation1" id="supEvaluation1" class="supEvaluation">
								<option value="0">====Select Scpre====</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">2. Notice of Changes in Delivery Date.</td>
						<td colspan="2">
							<select name="supEvaluation2" id="supEvaluation2" class="supEvaluation">
								<option value="0">====Select Scpre====</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">3. Quality of Products/Services upon  Delivery.</td>
						<td colspan="2">
							<select name="supEvaluation3" id="supEvaluation3" class="supEvaluation">
								<option value="0">====Select Scpre====</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>							
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">4. Overall Quality of Products/Services.</td>
						<td colspan="2">
							<select name="supEvaluation4" id="supEvaluation4" class="supEvaluation">
								<option value="0">====Select Scpre====</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">5. Competitiveness of Price.</td>
						<td colspan="2">
							<select name="supEvaluation5" id="supEvaluation5" class="supEvaluation">
								<option value="0">====Select Scpre====</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">6. Quality of After Sales Services.</td>
						<td colspan="2">
							<select name="supEvaluation6" id="supEvaluation6" class="supEvaluation">
								<option value="0">====Select Scpre====</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">7. Competitiveness of Terms and Conditions.</td>
						<td colspan="2">
							<select name="supEvaluation7" id="supEvaluation7" class="supEvaluation">
								<option value="0">====Select Scpre====</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2">8. Reputation of the Company.</td>
						<td colspan="2">
							<select name="supEvaluation8" id="supEvaluation8" class="supEvaluation">
								<option value="0">====Select Scpre====</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
							</select>
						</td>
					</tr>
				</table>
				<div id="total">
					Prepared By:&nbsp;
					<select name="supPrepareID" id="supPrepareID" style="width:40%;">
						<option value="">====Select Employee====</option>
						<?php foreach($employee as $key => $val):?>
							<option value="<?php echo $key;?>"><?php echo $val;?></option>
						<?php endforeach;?>
					</select>
					Total Score:&nbsp;
					<input type="text" name="totalScore" id="totalScore" style="width:20%;"/>
				</div>
				<?php if($pruInfoRegistry):?>
				<input type="hidden" id="oper" name="oper" value="edit"/>
				<input type="hidden" id="id" name="id" value=""/>
				<input type="submit" value="save"/>
				<input type="reset" value="cancel"/>
				<?php endif;?>
				</form>
			</div>
		</div>
	</div>
	<!--Service服務彈跳視窗-->
	<div id="ServiceDetailWindow"  title="Service Information">
		<div id="servMode"></div>		
		<div id="servTabs">
			<ul>
				<li><a href="#servTabs-1" id="addEdit">Service Details</a></li>
				<li><a href="#servTabs-2" id="purHistory">Purchase History</a></li>
				<li><a href="#servTabs-3" id="usageHistory">Usage History</a></li>
				<li><a href="#servTabs-4" id="priceHistory">Price History</a></li>
			</ul>
			<!--項目新增、編輯表單-->
			<div id="servTabs-1">
				<div id="modifyFormDiv">
					<form action="<?php echo base_url().$menuInfo['link']."/modify"?>" method="post" id="ServFodifyForm" name="ServFodifyForm"  class="customForm">
					<table style="width:100%;boder:1px;">					
						<tr>
							<td style="width:25%;">Service Name</td>
							<td colspan="3" style="width:75%;text-align:left"><input type="text" id="name" name="name" style="width:100%;"/></td>
						</tr>
						<tr>
							<td style="width:25%;">Service Code</td>
							<td style="width:25%;"><input type="text" size="20" id="code" name="code" /></td>
							<td style="width:20%;">UoM</td>
							<td style="width:30%;"><input type="text" id="UoM" name="UoM"/></td>
						</tr>
						<tr>
							<td style="width:25%;">Category</td>
							<td style="width:25%;"><input type="text" size="20" id="category" name="cotegory" /></td>
							<td style="width:20%;">Unit Cost</td>
							<td style="width:30%;"><input type="text" id="unitCost" name="unitCost"/></td>
						</tr>
						<tr>
							<td style="width:25%;">Supplier</td>
							<td style="width:25%;">
								<select name="supplier" id="supplier">
									<option value="">----Select Supplier----</option>
									<?php foreach($supplier as $key => $val):?>
										<option value="<?php echo $key;?>"><?php echo $val;?></option>
									<?php endforeach;?>
								</select>
							</td>
							<td style="width:25%;">Location:</td>
							<td style="width:25%;">
								<!--Local = 0, Overseas=1-->
								<select name="location" id="location">
									<option value="" selected>Select Location</option>
									<option value="0">Local</option>
									<option value="1">Overseas</option>
								</select>
								<!--
								Local :<input type="radio" name="location" value="0"/>
								Overseas :<input type="radio" name="location" value="1"/>
								-->								
							</td>
						</tr>
						<tr>
							<td colspan="2" style="width:50%">
							Description<br />
							<textarea name="description" id="description" cols="30" rows="10"></textarea>
							</td>
							<td colspan="2" style="width:50%">
							Attachment<br />
							<textarea name="attachment" id="attachment" cols="30" rows="10"></textarea>
							</td>
						</tr>	
						<tr>
							<td colspan="2"></td>
							<td>Registered by:</td>
							<td>
								<?php echo $this->session->userdata['username'];?>
								<input type="hidden" name="managerID" id="managerID"/>
							</td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td>Approved by</td>
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
					<?php if($pruInfoRegistry):?>
					<input type="hidden" id="oper" name="oper" value="add"/>
					<input type="hidden" id="id" name="id" value=""/>
					<!-- item type product=1,service=2,equiment=3,tools=4-->
					<input type="hidden" id="type" name="type" value="2"/>
					<input type="submit" value="save"/>
					<input type="reset" value="cancel"/>
					<?php endif;?>
					</form>
				</div>
			</div>
			<!--採購歷程-->
			<div id="servTabs-2">
				<table id="servTabPurHistory"></table>
				<div id="servPurList"></div>
			</div>
			<!--使用歷程-->
			<div id="servTabs-3">
				<table id="servTabsUsageHistory"></table>
				<div id="servUsageList"></div>
			</div>
			<!--價格歷程-->
			<div id="servTabs-4">
				<table id="servTabsPriceHistory"></table>
				<div id="servPriceList"></div>
			</div>
		</div>		
	</div>
	
	<div id="menuLocation">
		<?php echo $menuInfo['parent']."=>".anchor($menuInfo['link']."/index/".$menuInfo['menuID'],$menuInfo['menuName']);//輸出功能所在位置?>
	</div>
	<br />
	
	<!--產品、服務的tabs定義-->
	<div id="pureMainInterface">
		<ul>
			<li><a href="#tab-product" id="Products" >Products</a></li>
			<li><a href="#tab-services" id="Services">Services</a></li>
		</ul>
		<div id="tab-product">
			<ul class="subTabs">
				<li><a href="#tab-pro1" id="newProduct">New Product</a></li>
				<li><a href="#tab-pro2" id="inventoryLevel">Inventory Level</a></li>
				<li><a href="#tab-pro3" id="needRestocking">Need Restocking</a></li>
				<li><a href="#tab-pro4" id="suppliers">Suppliers</a></li>
			</ul>
			<!--New Product-->
			<div id="tab-pro1">				
				<table id="typeList"></table>
				<div id="pag_menuType"></div>
				<!--新增按扭-->
				<?php if($pruInfoRegistry):?>
				<input type="button" id="showDetail" value="New Product"/>				
				<input type="button" id="newDelSelect" value="Delete Selected"/>
				<?php endif;?>
				<input type="button" id="newEditSelect" value="View/Edit Selectd"/>
				<!--刪除按扭-->
				<!--<input type="button" id="delDetail" value="Delete Item"/>-->
			</div>
			<!--Inventory Level-->
			<div id="tab-pro2">
				<table id="tabInventoryLevel"></table>
				<div id="InventoryLevelList"></div>
			</div>
			<!--Need Restocking-->
			<div id="tab-pro3">
				<table id="tabNeedRestocking"></table>
				<div id="NeedRestockingList"></div>	
			</div>
			<!--Suppliers-->
			<div id="tab-pro4">
				<table id="tabSuppliers"></table>
				<div id="SuppliersList"></div>
				<!--新增按扭-->
				<?php if($pruInfoRegistry):?>
				<input type="button" id="showSupDetail" value="New Suppliers"/>
				<input type="button" id="supplierDelSelect" value="Delete Selected"/>
				<?php endif;?>
				<input type="button" id="supplierEditSelect" value="View/Edit Selectd"/>
				<!--刪除按扭-->
				<!--<input type="button" id="delSupDetail" value="Delete Item"/>-->
			</div>
		</div>
		<div id="tab-services">
			<table id="tabServices"></table>
			<div id="servicesList"></div>
			<br />
			<!--新增按扭-->
				<?php if($pruInfoRegistry):?>
				<input type="button" id="addServiceDetail" value="New Service"/>				
				<input type="button" id="serviceDelSelect" value="Delete Selected"/>
				<?php endif;?>
				<input type="button" id="serviceEditSelect" value="View/Edit Selectd"/>
				<!--刪除按扭-->
				<!--<input type="button" id="delDetail" value="Delete Item"/>-->
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
<script src="<?=base_url();?>js/purInfoRegistry.js"></script><!--此頁面的js-->