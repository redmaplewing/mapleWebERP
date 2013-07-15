<?php

	//class Login extends CI_Controller {	
	class HumanMain extends MY_Controller {	
		//base Setting
		var $tableName = array();
		var $employee = array();
		
		public function __construct()
		{
			parent::__construct();//繼承父類別的涵數
			$this->_load();
		}
		
		public function index ($menuID){
			//建構基本參數設定
			$this->_load();
			//var_dump($this->groupPermission);
			//載入基本套件、設定頁面基本資訊
			$this->lang->load('main',$this->session->userdata('lang'));//戴入語言套件
			$data['loginInfo'] = $this->session->all_userdata();
			$data['tableName'] = $this->tableName;
			$view = "humanMain";
			
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
			//var_dump($menuInfo);
			//定義左側標籤何者開啟
			$active = "";
			foreach($this->session->userdata('menuType') as $key => $val){
				if($menuInfo['parentID'] == $val['id']){
					$active = $key;
				};
			}
			$data['active'] = $active;
			$data['employee'] = $this->employee;
			$data['organizationalChart'] = $this->checkPermission('2','organizationalChart');
			$data['addressbook'] = $this->checkPermission('2','addressbook');
			$data['companyCalendar'] = $this->checkPermission('2','companyCalendar');
			
			//取得組織結構圖
			$sqlString = "SELECT * FROM systemConfig WHERE menuID='%s' ORDER BY cDate DESC,systemConfigID DESC LIMIT 1";
			//echo sprintf($sqlString,$menuID);
			$query = $this->db->query(sprintf($sqlString,$menuID));
			$result = $query->row();
			$file = base_url().'images/chartUnset.jpg';
			if($query->num_rows() > 0){
				$file = base_url().'upload/'.$result->file;
			}
			
			$data['file'] = $file;
			$data['menuID'] = $menuID;
			//var_dump($data);//驗證輸出陣列
			//取得請購單Purchase Request 資料
			$sqlString = "SELECT * FROM purchaseRequest";
			$prSql = $this->db->query($sqlString);
			$prNo = array();
			
			//var_dump($this->session->all_userdata());
			
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
		
		public function sendEmployeeData(){
		//取得服務資料
		$infoData = array();
		$table = $this->tableName['mainTable'];
		$tableID = $table."ID";		
		$sqlString = "SELECT * FROM %s ORDER BY %s ASC";
		$infoData['tableName'] = $table;
		$infoData['baseSql'] = sprintf($sqlString,$table,$tableID);
		$infoData['numLimit'] = 20;
		$infoData['page'] = $this->input->get('page') == ""?1:$this->input->get('page');
		$infoData['column'] = array(
			"no"
			,"name"
			,"eMail"
			,"skype"
			,"compMobile"
			,"personalMobile"
			,"ext"
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
						//自動產生流水號
						case "no":
							$data = $i;							
						break;
						case "name":
							$data = $row->nameFirst."&nbsp;".$row->nameLast;							
						break;
						default:
							$data = $row->$val;
						break;
					}
					array_push($menuTypeData,$data);
				}
				$i++;
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
		
		public function getChart($menuID){
			$sqlString = "SELECT * FROM systemConfig WHERE menuID='%s' ORDER BY cDate DESC,systemConfigID DESC LIMIT 1";
			$query = $this->db->query(sprintf($sqlString,$menuID));
			$result = $query->row();
			echo json_encode($result);
		}
		
		//查詢項目資料並回傳
		public function getFunctionData(){
			$table = "itemHandle";
			$tableID = $table."ID";
			$sqlString = sprintf("SELECT * FROM %s WHERE %s=%s",$table,$tableID,$this->input->post('ID'));			
			$row = $this->db->query($sqlString);
			$result = $row->row_array();
			echo json_encode($result);
			//$this->session->set_userdata('thisAjaxPost',$this->input->post());//驗證post資料
			//$this->session->set_userdata('thisAjaxQuery',$result);//驗證Query資料
		}
		
		//資料庫操作
		public function modify($tar=''){
			$config['upload_path'] = './upload/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['encrypt_name'] = 'true';			
			
			$this->load->library('upload',$config);
			$file_name = "file";
			$this->upload->do_upload($file_name);
			$uploadData = $this->upload->data();
			//var_dump($uploadData);
			//echo "this is post page";
			if($tar == ''){
				$tar = $this->tableName['mainTable'];
			}
			
			//載入資料寫入模組
			$this->load->model("modify");
			//取得表單傳入資料
			$post = $this->input->post();
			//echo $uploadData['file_name'];
			if($uploadData['file_name'] != ''){
				$post['file'] = $uploadData['file_name'];
				$tar = 'systemConfig';
				
				//刪除之前的圖片
				$sqlString = "SELECT * FROM systemConfig WHERE menuID='%s'";
				$query = $this->db->query(sprintf($sqlString,$post['menuID']));
				$delTarget = array();
				$delTarget['oper'] = 'del';
				foreach($query->result() as $key => $val){
					$delTarget['id'] = $val->systemConfigID;
					$fileName = base_url().'upload/'.$val->file;
					//echo $fileName."<br />";
					//echo unlink($fileName);
					$this->modify->modify('systemConfig',$delTarget);
				}
			}
			//var_dump($post);
			$post['managerID'] = $this->session->userdata('employeeID');
			//var_dump($post);
			$target = $tar;
			
			//驗證傳入資料
			$_sesResult = array("result"=>$post,"table"=>$tar);
			$this->session->set_userdata($_sesResult);
			//寫入資料庫
			$this->modify->modify($target,$post);				
		}
		
		//顯示傳入資料
		public function echoPost(){
			var_dump($this->session->all_userdata());
		}
		
		//設定程式基本參數
		private function _load(){
			$tableName = array();
			$tableName['mainTable'] = "employee";
			$tableName['linkTable'] = array(
				'item' => 'item'
				,'handleDetail' => 'handleDetail'
			);
			
			//取得成員資料
			$sqlString = "SELECT * FROM employee WHERE enable='1'";
			$dbQuery = $this->db->query($sqlString);
			$employee = array();
			foreach($dbQuery->result() as $key => $val){
				$employee[$val->employeeID] = $val->nameFirst.$val->nameLast;
			};
		
			$this->tableName = $tableName;
			$this->employee = $employee;
		}
	}