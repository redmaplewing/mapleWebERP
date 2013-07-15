<?php

	//class Login extends CI_Controller {	
	class RecruProcess extends MY_Controller {	
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
			//載入基本套件、設定頁面基本資訊
			$this->lang->load('main',$this->session->userdata('lang'));//戴入語言套件
			$data['loginInfo'] = $this->session->all_userdata();
			$data['tableName'] = $this->tableName;
			$view = "recruProcess";
			
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
			$data['employee'] = $this->employee;
			$data['recruitmentDatabase'] = $this->checkPermission('2','recruProcess',"recruitmentDatabase");
			$data['shortlistApplicants'] = $this->checkPermission('2','recruProcess',"shortlistApplicants");
			$data['recruitmentDatabaseControl'] = $this->checkPermission('3','recruProcess',"recruitmentDatabase");
			$data['shortlistApplicantsControl'] = $this->checkPermission('3','recruProcess',"shortlistApplicants");

			//var_dump($data);//驗證輸出陣列
			
			$this->load->view('header',$data);
			$this->load->view('nav',$data);
			$this->load->view($view,$data);
			$this->load->view('footer',$data);
		}
		
		public function sendEmployeeData($type='1'){
		/*
		$type-員工所在地
		1=>Head Office or Site Management
		2=>Site Employee
		*/
		//取得服務資料
		$infoData = array();
		$table = $this->tableName['mainTable'];
		$tableID = $table."ID";		
		$subSqlString = "";
		$sqlString = "SELECT a.*,b.* FROM %s AS a INNER JOIN employee AS b WHERE a.employeeID = b.employeeID %s ORDER BY %s ASC";
		switch($type){
			case '2':
				$subSqlString = " AND interviewDate!='0000-00-00'";
				$infoData['column'] = array(
					"interviewDate"
					,"interview1st"
					,"time1st"
					,"interviewer1st"
					,"interview2nd"
					,"time2nd"
					,"interviewer2nd"
					,"employeeNo"
					,"name"
					,"ga"
					,"position"
					,"expectSalary"
					,"offerSalary"
					,"applicationMode"
					,"pass"
					,"resultConfirm"
				);				
			break;
			case '1':
			default:
				$subSqlString = "";
				$infoData['column'] = array(
					"requestDate"
					,"approvalDate"
					,"cvReceiveDate"
					,"employeeNo"
					,"name"
					,"ga"
					,"position"
					,"expectSalary"
					,"applicationMode"
					,"requesterID"
					,"toRequestDate"
					,"interviewDate"
					,"other"
				);
			break;
		}
		$infoData['tableName'] = $table;
		$infoData['baseSql'] = sprintf($sqlString,$table,$subSqlString,$tableID);
		//echo sprintf($sqlString,$table,$type,$tableID);
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
									$data = "regular";
								break;
								case "0":
								default:
									$data = "";
								break;
							}
						break;
						//自動產生流水號
						case "No":
							$data = $i;							
						break;
						case "ga":
							$data = 'gender:'.$row->Gender.',age:'.$row->age;
						break;
						case 'employeeNo':
							$data = $this->employee[$row->employeeID]['No'];
						break;
						case "name":
							$data = $row->nameFirst."&nbsp;".$row->nameLast;
						break;
						case "Gender":
							switch($row->$val){
								case "2":
									$data = "Female";
								break;
								case "1":
								default:
									$data = "Male";
								break;
							}
						break;
						case 'requesterID':
							$data = $this->employee[$row->$val]['name'];
						break;
						case "interviewer1st":
						case "interviewer2nd":
							$data = $this->employee[$row->$val]['name'];
						break;
						case "pass":
						case "resultConfirm":
							$data = $row->$val == '1'?"Yes":"No";
						break;
						default:
							$data = $row->$val=='0'?"":$row->$val;
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
		
		//查詢項目資料並回傳
		public function getEmployeeData($type='1'){
			$table = "recruitment";
			$tableID = $table."ID";
			$sqlString = "SELECT a.*,b.* FROM %s AS a INNER JOIN employee AS b WHERE a.employeeID = b.employeeID %s AND %s='%s'";
			switch($type){
				case '2':
					$subSqlString = " AND interviewDate!='0000-00-00'";
				break;
				case '1':
				default:
					$subSqlString = "";
				break;
			}
			$sqlString = sprintf($sqlString,$table,$subSqlString,$tableID,$this->input->post('ID'));
			$row = $this->db->query($sqlString);
			$result = $row->row_array();
			echo json_encode($result);
			//$this->session->set_userdata('thisAjaxPost',$this->input->post());//驗證post資料
			//$this->session->set_userdata('thisAjaxQuery',$result);//驗證Query資料
		}
		
		//資料庫操作
		public function modify($target=''){
			//echo "this is post page";
			
			//載入資料寫入模組
			$this->load->model("modify");
			$this->load->helper('security');//security輔助涵數，執行md5加密用
			//取得表單傳入資料
			$post = $this->input->post();
			if($post['password'] != ''){
				$password = do_hash($post['password'],'md5');
				$post['password'] = $password;
			}
			//var_dump($post);
			$post['managerID'] = $this->session->userdata('employeeID');
			//var_dump($post);
			if($target == ''){
				$target = $this->tableName['mainTable'];
				$postToEmployee = array();				
				if($post['pass'] == '1'){
					//array_push($postToEmployee['status'],'Regular');
					$post['status'] = 'Regular';
				}
				$postToEmployee = $post;
				var_dump($postToEmployee);
				if($postToEmployee['oper'] == 'add'){
					$insertID = $this->modify->modify('employee',$post);
					$postToEmployee['employeeID'] = $insertID;
				}else{
					unset($postToEmployee['account']);
					unset($postToEmployee['password']);
					$sqlString = "SELECT employeeID FROM recruitment WHERE recruitmentID='%s'";
					$query = $this->db->query(sprintf($sqlString,$post['id']));
					$employee = $query->row();
					$postToEmployee['id'] = $employee->employeeID;
					$this->modify->modify('employee',$postToEmployee);
				}
			}
			$post['requestDate'] = $post['cDate'];
			//$target = $tar;
			//驗證傳入資料
			$_sesResult = array("result"=>$this->input->post(),"table"=>$target);
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
			$tableName['mainTable'] = "recruitment";
			$tableName['linkTable'] = array(
				'item' => 'item'
			);
					
			//取得成員資料
			$sqlString = "SELECT * FROM employee WHERE enable='1'";
			$dbQuery = $this->db->query($sqlString);
			$employee = array();
			foreach($dbQuery->result() as $key => $val){
				$employee[$val->employeeID]['name'] = $val->nameFirst.$val->nameLast;
				$employee[$val->employeeID]['No'] = $val->emplyoeeNo;
				$employee[$val->employeeID]['groupID'] = $val->groupID;
			};
		
			$this->tableName = $tableName;
			$this->employee = $employee;
		}
	}