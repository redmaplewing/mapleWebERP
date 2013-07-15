<?php

	//class Login extends CI_Controller {	
	class Proj extends MY_Controller {	
		//base Setting
		var $tableName = array();
		var $employee = array();
		
		public function __construct()
		{
			parent::__construct();//繼承父類別的涵數
			$this->_load();
		}
		
		public function index ($menuID){
			//var_dump($this->employee);
			$data['employee'] = $this->employee;
			//建構基本參數設定
			$this->_load();
			//載入基本套件、設定頁面基本資訊
			$this->lang->load('main',$this->session->userdata('lang'));//戴入語言套件
			$data['loginInfo'] = $this->session->all_userdata();
			$data['tableName'] = $this->tableName;
			$view = "proj";
			
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
			foreach($this->session->userdata('menuType') as $key => $val){
				if($menuInfo['parentID'] == $val['id']){
					$active = $key;
				};
			}
			$data['active'] = $active;
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
			$data['proj'] = $this->checkPermission('3','proj');
			
			$this->load->view('header',$data);
			$this->load->view('nav',$data);
			$this->load->view($view,$data);
			$this->load->view('footer',$data);
		}
		
		public function sendServiceData($type=0){
		//取得服務資料
		$infoData = array();
		$infoData['column'] = array(
			"cDate"
			,"projectNo"
			,"name"
			,"location"
			,"clientName"
			,"siteManager"
			,"perContactStart"
			,"actualStart"
			,"perContactCompletion"
			,"actualCompletion"
		);
		$table = $this->tableName['mainTable'];
		$tableID = $table."ID";
		$sqlString = "SELECT * FROM %s";
		switch($type){
			case 0:
				$sqlString .= " WHERE status = 0";
				$infoData['column'] = array(
					"cDate"
					,"inquiryNo"
					,"clientName"
					,"clientRequirement"
					,"location"					
					,"negotiating"					
					,"negotiatingStatus"					
				);
			break;
			case 1:
				$sqlString .= " WHERE status = 1";
			break;
			case 2;
				$sqlString .= " WHERE status = 2";
			break;
			default:
				$sqlString .= "";
			break;
		}
		$sqlString .= " ORDER BY %s ASC";
		$infoData['tableName'] = $table;
		$infoData['baseSql'] = sprintf($sqlString,$table,$tableID);
		$infoData['numLimit'] = 20;
		$infoData['page'] = $this->input->get('page') == ""?1:$this->input->get('page');
		
		
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
			foreach($query->result() as $row){
				$menuTypeData = array();
				foreach($infoData['column'] as $val){
					/*echo $row->$val === 0;
					echo "<br />";
					echo $row->$val."<br />";*/
					if($row->$val === 0 || $row->$val == ''){
						$result = '';
					}else{
						$result = $row->$val;
					}
				
					if($val == 'siteManager' && $row->$val != ''){
						$result = isset($this->employee[$result])?$this->employee[$result]:"";
					}				
					array_push($menuTypeData,$result);
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
		public function getFunctionData(){
			$table = "project";
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
		}
		
		//顯示傳入資料
		public function echoPost(){
			var_dump($this->session->all_userdata());
		}
		
		//設定程式基本參數
		private function _load(){
			$tableName = array();
			$employee = array();
			$sqlString = "SELECT * FROM employee";
			$employeeQuery = $this->db->query($sqlString);
			$result = $employeeQuery->result();
			foreach($result as $val){
				$employee[$val->employeeID] = $val->nameFirst.$val->nameLast;
			} 
			$this->employee = $employee;
			$tableName['mainTable'] = "project";
			$tableName['linkTable'] = array();
			$this->tableName = $tableName;
		}
	}