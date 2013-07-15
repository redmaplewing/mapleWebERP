<?php

	//class Login extends CI_Controller {	
	class MaterialRR extends MY_Controller {	
		//base Setting
		var $tableName = array();
		var $project = array();
		var $item = array();
		var $supplier = array();
		var $employee = array();
		var $warehouse = array();
		
		public function __construct()
		{
			parent::__construct();//繼承父類別的涵數
			$this->_load();
			$this->getItem();
		}
		
		public function index ($menuID){
			//建構基本參數設定
			$this->_load();
			//載入基本套件、設定頁面基本資訊
			$this->lang->load('main',$this->session->userdata('lang'));//戴入語言套件
			$data['loginInfo'] = $this->session->all_userdata();
			$data['tableName'] = $this->tableName;
			$view = "materialRR";
			
			//取得功能資訊
			$sString = "SELECT a.*,b.name as parentName,b.menuTypeID as parentID FROM menu as a INNER JOIN menuType as b ";
			$sString .= "WHERE a.menuID = '%s' and b.menuTypeID = a.parentID";
			$sqlString = sprintf($sString,$menuID);
			//echo $sqlString;//驗證SQL碼
			
			$menuSql = $this->db->query($sqlString);
			
			$menuInfo = array();
			foreach($menuSql->result() as $key => $val){
				$menuInfo['menuName'] = $val->name;
				$menuInfo['parent'] = $val->parentName;
				$menuInfo['parentID'] = $val->parentID;
				$menuInfo['link'] = $val->link;
				$menuInfo['menuID'] = $menuID;
			}
			$data['menuInfo'] = $menuInfo;
			$data['itemOption'] = $this->item;
			//var_dump($menuInfo);
			//定義左側標籤何者開啟
			foreach($this->session->userdata('menuType') as $key => $val){
				if($menuInfo['parentID'] == $val['id']){
					$active = $key;
				};
			}
			$data['active'] = $active;
			$data['project'] = $this->project;
			$data['supplier'] = $this->supplier;
			$data['employee'] = $this->employee;
			$data['warehouse'] = $this->warehouse;
			$data['materialRR'] = $this->checkPermission('3','materialRR');
			//var_dump($data['supplier']);
			//var_dump($data);//驗證輸出陣列
			//取得請購單Purchase Request 資料
			$sqlString = "SELECT * FROM purchaseRequest";
			$prSql = $this->db->query($sqlString);
			$prNo = array();
			
			foreach($prSql->result() as $key => $val){
				$subArray = array();
				$subArray['id'] = $val->purchaseRequestID;
				$subArray['No'] = $val->purchaseRequestNo;
				$prNo[$val->purchaseRequestID] = $subArray;
			}
			$data['prNo'] = $prNo;
			
			$this->load->view('header',$data);
			$this->load->view('nav',$data);
			$this->load->view($view,$data);
			$this->load->view('footer',$data);
		}
		
		public function sendMaterialData($warehouse = ""){
		//取得服務資料
		$infoData = array();
		$table = $this->tableName['mainTable'];
		$tableID = $table."ID";		
		$subSql = "";
		if($warehouse != ""){
			$subSql = sprintf(" WHERE projectID=(SELECT projectID FROM warehouse WHERE warehouseID='%s')",$warehouse);
		}
		$sqlString = "SELECT * FROM %s %s ORDER BY %s ASC";
		$infoData['tableName'] = $table;
		$infoData['baseSql'] = sprintf($sqlString,$table,$subSql,$tableID);
		$infoData['numLimit'] = 20;
		$infoData['page'] = $this->input->get('page') == ""?1:$this->input->get('page');
		$infoData['column'] = array(
			"materialRequestNo"
			,"cDate"
			,"managerID"
			,"status"
			,"projectID"
			,"planID"
			,"eDate"
		);
		
		$result = $this->returnGridData($infoData);
		//var_dump($result);
		echo json_encode($result);
		}
		
		//退貨主表單資料
		public function sendReturnData($warehouse = ""){
		//取得服務資料
		$infoData = array();
		$table = $this->tableName['linkTable']['goodReturn'];
		$tableID = $table."ID";		
		$subSql = "";
		if($warehouse != ""){
			$subSql = sprintf(" WHERE warehouseID='%s'",$warehouse);
		}
		$sqlString = "SELECT * FROM %s %s ORDER BY %s ASC";
		$infoData['tableName'] = $table;
		$infoData['baseSql'] = sprintf($sqlString,$table,$subSql,$tableID);
		$infoData['numLimit'] = 20;
		$infoData['page'] = $this->input->get('page') == ""?1:$this->input->get('page');
		$infoData['column'] = array(
			"goodReturnNo"
			,"cDate"
			,"managerID"
			,"from"
			,"returnDate"
			,"reason"
			,"to"
			,"inspected"
		);
		
		$result = $this->returnGridData($infoData);
		//var_dump($result);
		echo json_encode($result);
		}
		
		public function sendStatusData($progress=0,$warehouse=""){
			/*
			$progress-處理階段
			1. Waiting for approval => 有submitDate但沒有approved(approved=0)
			2. Arriving/In-Progress => 有submitDate也有approved(approved=成員id)
			3. Completed => 已完成，Status=1
			*/
			//取得服務資料
			$infoData = array();
			$table = $this->tableName['mainTable'];
			$tableID = $table."ID";
			$subQuery = " status ='0' ";
			switch($progress){
				case 3:
					$subQuery = " status = '1'";
				break;
				case 2:
					$subQuery .= "AND submitDate != '0000-00-00' AND approve != '0'";
				break;
				case 1:
					$subQuery .= "AND submitDate != '0000-00-00' AND approve = '0'";
				break;
				case 0:
				default:
					$subQuery .= "";
				break;
			}
			if($warehouse != ""){
				$subQuery .= sprintf(" AND projectID=(SELECT projectID FROM warehouse WHERE warehouseID='%s')",$warehouse);
			}
			
			$sqlString = "SELECT * FROM %s WHERE %s ORDER BY %s ASC";
			//echo sprintf($sqlString,$table,$subQuery,$tableID);
			$infoData['tableName'] = $table;
			$infoData['baseSql'] = sprintf($sqlString,$table,$subQuery,$tableID);
			$infoData['numLimit'] = 20;
			$infoData['page'] = $this->input->get('page') == ""?1:$this->input->get('page');
			$infoData['column'] = array(
				"materialRequestNo"
				,"cDate"
				,"managerID"
				,"status"
				,"projectID"
				,"planID"
				,"eDate"
			);
			
			$result = $this->returnGridData($infoData);
			//var_dump($result);
			echo json_encode($result);
		}
		
		//輸入項目簽收時間
		public function changeReceiving(){
			$explodeString = explode('-',$this->input->post('target'));
		
			//var_dump($explodeString2);
			$post['id'] = $explodeString[1];
			$post['receivedDate'] = date("Y-m-d h:i:s",now());
			$post['oper'] = 'edit';
			
			//載入資料寫入模組
			$this->load->model("modify");
			$this->modify->modify('requestDetail',$post);
			
			echo 'true';
			//echo $target;
		}
		
		//輸入項目退貨時間
		public function changeGrReceiving(){
			$explodeString = explode('-',$this->input->post('target'));
		
			//var_dump($explodeString2);
			$post['id'] = $explodeString[1];
			$post['receivedDate'] = date("Y-m-d h:i:s",now());
			$post['oper'] = 'edit';
			
			//載入資料寫入模組
			$this->load->model("modify");
			$this->modify->modify('returnDetail',$post);
			
			echo 'true';
			//echo $target;
		}
		
		//將簽收結果輸入至倉儲
		public function postToInventory(){
			$this->load->model("modify");
			$receiveDate = date("Y-m-d h:i:s",now());
			$sqlString = "SELECT * FROM requestDetail WHERE requestDetailID='".$this->input->post('id')."'";
			$query = $this->db->query($sqlString);
			$result = $query->row();
			$post['receivedDate'] = $result->receivedDate == '0000-00-00'?$receiveDate:$result->receivedDate;
			$post['id'] = $this->input->post('id');
			$post['inventoryPost'] = 1;
			$post['oper'] = 'edit';			
			
			//載入資料寫入模組			
			$this->modify->modify('requestDetail',$post);
			echo 'true';
		}
		
		//將退貨結果輸入至倉儲
		public function postGrToInventory(){
			$this->load->model("modify");
			$receiveDate = date("Y-m-d h:i:s",now());
			$sqlString = "SELECT * FROM returnDetail WHERE returnDetailID='".$this->input->post('id')."'";
			$query = $this->db->query($sqlString);
			$result = $query->row();
			$post['receivedDate'] = $result->receivedDate == '0000-00-00'?$receiveDate:$result->receivedDate;
			$post['id'] = $this->input->post('id');
			$post['inventoryPost'] = 1;
			$post['oper'] = 'edit';
			
			//載入資料寫入模組			
			$this->modify->modify('returnDetail',$post);
			
			$sqlString = "SELECT * FROM itemInventory WHERE itemID='%s' AND warehouseID=(SELECT `from` FROM goodReturn WHERE goodReturnID='%s')";
			$query = $this->db->query(sprintf($sqlString,$result->itemID,$result->goodReturnID));
			//echo sprintf($sqlString,$result->itemID,$result->goodReturnID);
			$itemInventory = $query->row();
			/*var_dump($itemInventory);
			var_dump($result);*/
			
			//echo $itemInventory->onHand;
			
			$qty = $itemInventory->onHand - $result->qty;			
			
			//更新inventory數量
			$inventoryPost = array();
			$inventoryPost['id'] = $itemInventory->itemInventoryID;
			$inventoryPost['onHand'] = $qty;
			$inventoryPost['oper'] = 'edit';
			
			$this->modify->modify('itemInventory',$inventoryPost);
			
			echo 'true';
		}
		
		//取得項目接受資料
		public function sendMRReceiving($securityCode){
		//取得服務資料
		$infoData = array();
		$table = $this->tableName['linkTable']['requestDetail'];
		$tableID = $table."ID";
		$sqlString = "SELECT a.*,b.* FROM %s as a inner join item as b WHERE a.securityCode='%s' and a.itemID=b.itemID ORDER BY %s ASC";
		$infoData['tableName'] = $table;
		$infoData['baseSql'] = sprintf($sqlString,$table,$securityCode,$tableID);
		//echo $infoData['baseSql'];
		$infoData['numLimit'] = 20;
		$infoData['page'] = $this->input->get('page') == ""?1:$this->input->get('page');
		$infoData['column'] = array(
			"No"
			,"code"
			,"name"
			,"qty"
			,"receivedDate"
			,"inventoryPost"
		);
		
		$result = $this->returnGridData($infoData);
		//var_dump($result);
		echo json_encode($result);
		}
		
		//取得項目接受資料
		public function sendGRReceiving($securityCode){
		//取得服務資料
		$infoData = array();
		$table = $this->tableName['linkTable']['returnDetail'];
		$tableID = $table."ID";
		$sqlString = "SELECT a.*,b.* FROM %s as a inner join item as b WHERE a.securityCode='%s' and a.itemID=b.itemID ORDER BY %s ASC";
		$infoData['tableName'] = $table;
		$infoData['baseSql'] = sprintf($sqlString,$table,$securityCode,$tableID);
		//echo $infoData['baseSql'];
		$infoData['numLimit'] = 20;
		$infoData['page'] = $this->input->get('page') == ""?1:$this->input->get('page');
		$infoData['column'] = array(
			"No"
			,"code"
			,"name"
			,"qty"
			,"receivedDate"
			,"inventoryPost"
			,"remark"
		);
		
		$result = $this->returnGridData($infoData);
		//var_dump($result);
		echo json_encode($result);
		}
		
		//回傳Grid資料
		public function returnGridData($infoData){
			//定義基本變數
			$page = $infoData['page'];
			$numLimit = $infoData['numLimit'];
			$startRow = $page*$numLimit-$numLimit;
			$tableName = $infoData['tableName'];
			$targetID = $tableName."ID";
			
			//產生mySql查詢結果
			$baseSql = $infoData['baseSql'];
			//計算總筆數
			$rowNum = $this->db->query($baseSql);
			$infoNum = isset($rowNum->num_rows)?$rowNum->num_rows:0;
			//封裝查詢結果
			$sqlString = sprintf($baseSql." Limit %s,%s",$startRow,$numLimit);
			$query = $this->db->query($sqlString);
			$reInfoData = array();
			//封裝查詢結果
			$i = 1;
			foreach($query->result() as $row){
				$menuTypeData = array();
				foreach($infoData['column'] as $val){
					switch($val){
						//取得成名編號回傳成員名稱
						case "managerID":
							$sqlString = "SELECT * FROM employee WHERE employeeID=%s";
							$result = $this->db->query(sprintf($sqlString,$row->$val));
							$rs = $result->row();
							$data = $rs->nameFirst." ".$rs->nameLast;
						break;
						//自動置換status的資料
						case "status":
							switch($row->$val){
								case "1":
									$data = "completed";
								break;
								case "0":
								default:
									$data = "Arriving/In-progress";
								break;
							}
						break;
						//依圖紙編號取得圖紙名稱
						case "planID":
							if($row->$val != 0){
								$sqlString = "SELECT * FROM drawing WHERE drawingID=%s";
								$result = $this->db->query(sprintf($sqlString,$row->$val));
								//echo sprintf($sqlString,$row->$val);
								//var_dump($result);
								if($result->row()){
									$rs = $result->row();
									$data = $rs->drawingNo;
								}else{
									$data = "";
								}
							}else{
								$data = "";
							}
						break;
						//依專案編號取得專案名稱
						case "projectID":
							$sqlString = "SELECT * FROM project WHERE projectID=%s";
							$result = $this->db->query(sprintf($sqlString,$row->$val));
							$rs = $result->row();
							$data = $rs->projectNo;
						break;
						//自動產生流水號
						case "No":
							$data = $i;
						break;
						//計算總金額
						case "totalAmt":
							$data = $row->qty * $row->unitCost;
						break;
						case "inventoryPost":	
							if(isset($row->materialRequestID)){
								$targetTable = "materialRequest";
								$id = $row->materialRequestID;
								$class = "inventoryPost";
							}elseif(isset($row->goodReturnID)){
								$targetTable = "goodReturn";
								$id = $row->goodReturnID;
								$class = "GRinventoryPost";
							}
							$targetTableID = $targetTable."ID";
							$sqlString = "SELECT * FROM %s WHERE %s='%s'";
							$query = $this->db->query(sprintf($sqlString,$targetTable,$targetTableID,$id));
							//echo sprintf($sqlString,$row->materialRequestID);
							$queryRequest = $query->row();
							if($row->$val == '0'/*&& $materialRequest->status == 0*/){
								$data = '<input type="button" id="inventoryPost'.$row->$targetID.'" value="Post" itemID="'.$row->$targetID.'" class="'.$class.'"/>';
							}else{
								$data = 'posted';
							}						
						break;
						case "receivedDate":
							if(isset($row->materialRequestID)){
								$targetTable = "materialRequest";
								$id = $row->materialRequestID;
								$class = "checkReceiving";
							}elseif(isset($row->goodReturnID)){
								$targetTable = "goodReturn";
								$id = $row->goodReturnID;
								$class = "checkGRReceiving";
							}
							$targetTableID = $targetTable."ID";
							$sqlString = "SELECT * FROM %s WHERE %s='%s'";
							$query = $this->db->query(sprintf($sqlString,$targetTable,$targetTableID,$id));
							$queryRequest = $query->row();				
							if($row->$val == "0000-00-00"/*&& $materialRequest->status == 0*/){
								$data = '<input type="checkbox" id="receiving-'.$row->$targetID.'" class="'.$class.'"/>';
							}else{
								$data = $row->$val;
							}
						break;
						case "from":
							$data = $this->warehouse[$row->$val];
						break;
						case "to":
							$data = $this->supplier[$row->$val]['name'];
						break;
						default:
							$data = $row->$val;
						break;
					}
					array_push($menuTypeData,$data);
				}
								
				$reInfoData[] = array(
					"id" => $row->$targetID
					,"cell" => $menuTypeData
				);
			}			
			$result = array(
				'records'=>count($reInfoData),
				'total'=>ceil($infoNum/$numLimit),
				'page'=>$page,
				'rows'=>$reInfoData
			);
			
			//包json編碼後傳送
			return $result;
		}
		
		//查詢項目資料並回傳
		public function getFunctionData($table=""){
			if($table == ""){
				$table = "materialRequest";
			}
			$tableID = $table."ID";
			$sqlString = sprintf("SELECT * FROM %s WHERE %s=%s",$table,$tableID,$this->input->post('ID'));
			$row = $this->db->query($sqlString);
			$result = $row->row_array();
			echo json_encode($result);
			//$this->session->set_userdata('thisAjaxPost',$this->input->post());//驗證post資料
			//$this->session->set_userdata('thisAjaxQuery',$result);//驗證Query資料
		}
		
		//取得料件請求單的項件清單
		public function sendmrDetail($securityCode){
			//取得服務資料
			$infoData = array();
			$table = $this->tableName['linkTable']['requestDetail'];
			$tableID = $table."ID";
			$sqlString = "SELECT a.*,b.* FROM %s as a inner join item as b WHERE a.securityCode='%s' and a.itemID=b.itemID ORDER BY %s ASC";
			$infoData['tableName'] = $table;
			$infoData['baseSql'] = sprintf($sqlString,$table,$securityCode,$tableID);
			//echo $infoData['baseSql'];
			$infoData['numLimit'] = 20;
			$infoData['page'] = $this->input->get('page') == ""?1:$this->input->get('page');
			$infoData['column'] = array(
				"No"
				,"code"
				,"name"
				,"description"
				,"qty"
				,"UoM"
				,"unitCost"
				,"totalAmt"
			);
			
			$result = $this->returnGridData($infoData);
			//var_dump($result);
			echo json_encode($result);
		}
		
		//取得料件請求單的項件清單
		public function sendgrDetail($securityCode){
			//取得服務資料
			$infoData = array();
			$table = $this->tableName['linkTable']['returnDetail'];
			$tableID = $table."ID";
			$sqlString = "SELECT a.*,b.* FROM %s as a inner join item as b WHERE a.securityCode='%s' and a.itemID=b.itemID ORDER BY %s ASC";
			$infoData['tableName'] = $table;
			$infoData['baseSql'] = sprintf($sqlString,$table,$securityCode,$tableID);
			//echo $infoData['baseSql'];
			$infoData['numLimit'] = 20;
			$infoData['page'] = $this->input->get('page') == ""?1:$this->input->get('page');
			$infoData['column'] = array(
				"No"
				,"code"
				,"name"
				,"description"
				,"qty"
				,"UoM"
				,"unitCost"
				,"totalAmt"
			);
			
			$result = $this->returnGridData($infoData);
			//var_dump($result);
			echo json_encode($result);
		}
		
		//回傳MR Item
		public function returnItem(){
			$type = $this->input->post('type');
			$project= $this->input->post('project');
			$this->getItem($type,$project);
			//var_dump($this->item);
			echo json_encode($this->item);
		}
		
		//新增mr項目
		public function insertmrDetail(){
			if($this->input->post()){
				$this->modify('requestDetail');
			}
		}
		
		//取得Item清單
		public function getItem($type=1,$project=0){
			switch($type){
				case 3:
				
					$sqlString = sprintf("SELECT * FROM item WHERE type='%s' AND lost!='1' AND warehouseID=(SELECT warehouseID FROM warehouse WHERE projectID='%s')",$type,$project);
				
				break;
				case 2:
				case 1:
				default:
				
					$sqlString = sprintf("SELECT a.*,b.onHand FROM item AS a INNER JOIN itemInventory AS b WHERE a.type='%s' AND a.itemID = b.itemID AND b.onHand>0 AND b.warehouseID=(SELECT warehouseID FROM warehouse WHERE projectID='%s')",$type,$project);
				
				break;			
			}
			
			//echo $sqlString;
			$itemQuery = $this->db->query($sqlString);
			$item = $itemQuery->result();
			//var_dump($item);
			$itemOption = array();
			$supplierStatus = array(
				"0" => "Active"
				,"1" => "Discontinued"
			);
			foreach($item as $key => $val){				
				if(isset($this->supplier[$val->supplier])){
					$string = "";
					$string = $val->code.":".$val->name."=>";
					$string .= $val->description.",Provided by:";
					/*$string .= $this->supplier[$val->supplier]['name'].":";
					$string .= $supplierStatus[$this->supplier[$val->supplier]['status']];*/
					$string .= ", onHand:".$val->onHand;
							
				}else{
					$string = "";
					$string = $val->code.":".$val->name."=>";
					$string .= $val->description;
				}			
				$itemOption[$val->itemID] = $string;			
			}
			$this->item = $itemOption;
			//var_dump($itemOption);
		}
		
		//回傳GR Item
		public function returnGRItem(){
			$type = $this->input->post('type');
			$warehouse= $this->input->post('wareHouseID');
			//var_dump($this->input->post());
			$this->getGRItem($type,$warehouse);
			//var_dump($this->item);
			echo json_encode($this->item);
		}
		
		//新增GR項目
		public function insertgrDetail(){
			if($this->input->post()){
				$this->modify('returnDetail');
			}
		}
		
		//取得GR Item清單
		public function getGRItem($type=1,$warehouse=0){
		
			$sqlString = sprintf("SELECT a.*,b.onHand FROM item AS a INNER JOIN itemInventory AS b WHERE a.type='%s' AND a.itemID = b.itemID AND b.onHand>0 AND b.warehouseID='%s'",$type,$warehouse);
			//echo $sqlString;
			$itemQuery = $this->db->query($sqlString);
			$item = $itemQuery->result();
			//var_dump($item);
			$itemOption = array();
			$supplierStatus = array(
				"0" => "Active"
				,"1" => "Discontinued"
			);
			foreach($item as $key => $val){				
				if(isset($this->supplier[$val->supplier])){
					$string = "";
					$string = $val->code.":".$val->name."=>";
					$string .= $val->description.",Provided by:";
					/*$string .= $this->supplier[$val->supplier]['name'].":";
					$string .= $supplierStatus[$this->supplier[$val->supplier]['status']];*/
					$string .= ", onHand:".$val->onHand;
					$itemOption[$val->itemID] = $string;					
				}				
			}
			$this->item = $itemOption;
			//var_dump($itemOption);
		}
		
		//查詢圖紙編號並回傳
		public function getProjData(){
			$sqlString = sprintf("SELECT * FROM drawing WHERE projectID=%s",$this->input->post('key'));
			$plan = $this->db->query($sqlString);
			$result['plan'] = $plan->result();
			$result['project'] = $this->project;
			echo json_encode($result);
		}
		
		//資料庫操作
		public function modify($tar=''){
			//echo "this is post page";
			if($tar == ''){
				$tar = $this->tableName['mainTable'];
			}
			//載入資料寫入模組
			$this->load->model("modify");
			//取得表單傳入資料
			$post = $this->input->post();
			$post['managerID'] = $this->session->userdata('employeeID');
			//var_dump($post);
			$target = $tar;
			
			//驗證傳入資料
			$_sesResult = array("result"=>$this->input->post(),"table"=>$tar);
			$this->session->set_userdata($_sesResult);
			//寫入資料庫
			$this->modify->modify($target,$post);
			echo $tar;
			if(isset($post['securityCode'])){
				switch($tar){
					case "goodReturn":
						$this->groupgrDetail($tar,$post['securityCode']);
					break;
					case "materialRequest":
						$this->groupmrDetail($tar,$post['securityCode']);
					break;
				}
			}	
		}
		//將未歸檔的mr項目歸檔
		public function groupmrDetail($tar,$securityCode){
			$this->load->model("modify");
			//取得pr的id
			$sqlString = "SELECT * FROM %s WHERE securityCode='%s'";
			//echo sprintf($sqlString,$tar,$securityCode);
			$query = $this->db->query(sprintf($sqlString,$tar,$securityCode));
			$result = $query->row();
			$target = $tar.'ID';
			$id = $result->$target;
			//將pr id更新進prdetail
			$sqlString = "SELECT * FROM requestDetail WHERE securityCode='%s'";
			$query = $this->db->query(sprintf($sqlString,$securityCode));
			//echo sprintf($sqlString,$securityCode);
			$data = array();
			$data['oper'] = 'edit';
			foreach($query->result() as $key => $val){
				$data['materialRequestID'] = $id;
				$data['id'] = $val->requestDetailID;
				//var_dump($data);
				$this->modify->modify('requestDetail',$data);
			}
			//echo $id;
		}
		//將未歸檔的GR項目歸檔
		public function groupgrDetail($tar,$securityCode){
			$this->load->model("modify");
			//取得pr的id
			$sqlString = "SELECT * FROM %s WHERE securityCode='%s'";
			//echo sprintf($sqlString,$tar,$securityCode);
			$query = $this->db->query(sprintf($sqlString,$tar,$securityCode));
			$result = $query->row();
			$target = $tar.'ID';
			$id = $result->$target;
			//將pr id更新進prdetail
			$sqlString = "SELECT * FROM returnDetail WHERE securityCode='%s'";
			$query = $this->db->query(sprintf($sqlString,$securityCode));
			//echo sprintf($sqlString,$securityCode);
			$data = array();
			$data['oper'] = 'edit';
			foreach($query->result() as $key => $val){
				$data['goodReturnID'] = $id;
				$data['id'] = $val->returnDetailID;
				//var_dump($data);
				$this->modify->modify('returnDetail',$data);
			}
			//echo $id;
		}
		
		//顯示傳入資料
		public function echoPost(){
			var_dump($this->session->all_userdata());
		}
		
		//設定程式基本參數
		private function _load(){
			$tableName = array();
			$tableName['mainTable'] = "materialRequest";
			$tableName['linkTable'] = array(
				'requestDetail' => 'requestDetail'
				,'goodReturn' => 'goodReturn'
				,'returnDetail' => 'returnDetail'
			);
			
		//取得專案資料
		$projSqlString = "SELECT a.* FROM project AS a INNER JOIN warehouse AS b WHERE a.projectID=b.projectID";
		$projSql = $this->db->query($projSqlString);
		$project = array();
		
		foreach($projSql->result() as $key => $val){
			$subArray = array();
			$subArray['id'] = $val->projectID;
			$subArray['name'] = $val->name;
			$subArray['customerName'] = $val->clientName;
			$subArray['code'] = $val->projectNo;
			$project[$val->projectID] = $subArray;
		}
		
			//取得供應商資料
			$supplierSqlString = "SELECT * FROM supplier";
			$supplierSql = $this->db->query($supplierSqlString);
			$supplier = array();
			
			//var_dump($supplierSql->result());
			
			foreach($supplierSql->result() as $key => $val){
				$supplier[$val->supplierID]['name'] = $val->name;
				$supplier[$val->supplierID]['status'] = $val->status;
			}
			//取得成員資料
			$sqlString = "SELECT * FROM employee WHERE enable='1'";
			$dbQuery = $this->db->query($sqlString);
			$employee = array();
			foreach($dbQuery->result() as $key => $val){
				$employee[$val->employeeID] = $val->nameFirst.$val->nameLast;
			};
			
			//取得倉庫資料
			$warehouse = array();
			$sqlString = "SELECT a.*,b.name AS 'projectName' FROM warehouse AS a INNER JOIN project AS b WHERE a.projectID!='0' AND a.projectID=b.projectID";
			$query = $this->db->query($sqlString);
			//var_dump($query->result());
			foreach($query->result() as $key=>$val){
				$warehouse[$val->warehouseID] = $val->name."(".$val->projectName.")";
			}
			$this->warehouse = $warehouse;
			$this->employee = $employee;
			$this->project = $project;
			$this->tableName = $tableName;
			$this->supplier = $supplier;
		}
	}