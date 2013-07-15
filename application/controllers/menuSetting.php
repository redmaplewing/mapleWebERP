<?php

	//class Login extends CI_Controller {	
	class MenuSetting extends MY_Controller {	
		var $tableName = 'menu';
		
		public function index (){
			//載入基本套件、設定頁面基本資訊
			$this->lang->load('main',$this->session->userdata('lang'));//戴入語言套件
			$data['loginInfo'] = $this->session->all_userdata();
			$data['tableName'] = $this->tableName;
			$view = "menuSetting";
			
			$this->load->view('header',$data);
			$this->load->view('nav',$data);
			$this->load->view($view,$data);
			$this->load->view('footer',$data);
		}
		
		public function sendQueryData(){//取得選單類別資料
			$page = $this->input->get('page') == ""?1:$this->input->get('page');
			//$page = 1;
			//echo $page."<br />";
			//var_dump($this->input->get());
			$numLimit = 10;
			$startRow = $page*$numLimit-$numLimit;
			$numString = sprintf("SELECT * FROM %s",$this->tableName);
			$rowNum = $this->db->query($numString);
			$sqlString = sprintf("select * from %s order by parentID asc,ord asc Limit %s,%s",$this->tableName,$startRow,$numLimit);
			//echo $sqlString;
			//$sqlString = "select * from employee";
			$query = $this->db->query($sqlString);
			//var_dump($query->result());
			$infoData = array();
			foreach($query->result() as $row){
				$menuTypeData = array(
					$row->name		
					,$row->parentID
					,$row->enable					
					,$row->ord
					,$row->link
					//$row->linkID,
					//'menuType'
				);
				$targetID = $this->tableName."ID";
				$infoData[] = array(
					"id" => $row->$targetID
					,"cell" => $menuTypeData
				);
			}
			
			$result = array(
				'records'=>count($infoData),
				'total'=>ceil($rowNum->num_rows / $numLimit),
				'page'=>$page,
				'rows'=>$infoData
			);
			
			//回傳json陣列
			echo json_encode($result);
			//return json_encode($result);
		}

		public function subQueryData(){//取得選單類別資料
			$id = $this->input->get('id') == null?1:$this->input->get('id');
			$sqlString = "select * from nameLang where linkID=$id order by lang asc";
			//$sqlString = "select * from employee";
			$query = $this->db->query($sqlString);
			//var_dump($query->result());
			$infoData = array();
			foreach($query->result() as $row){
				$menuTypeData = array(
					$row->name,
					$row->lang
				);
				$infoData[] = array(
					"id" => $row->nameLangID,
					"cell" => $menuTypeData
				);
			}
			
			$result = array(
				'records'=>count($infoData),
				'total'=>ceil(count($infoData)/10),
				'page'=>1,
				'rows'=>$infoData
			);
			//回傳json陣列
			$this->session->set_userdata('typeLinkID',$id);
			echo json_encode($result);
			//return json_encode($result);
		}
		
		public function modify($target,$sub=false){
			//載入資料寫入模組
			$this->load->model("modify");
			//取得表單傳入資料
			$post = $this->input->post();
			//設定語言類別及父選單id
			$post['lang'] = $post['lang'] == null?"en_US":$post['lang'];			
			$post['linkID'] = $sub == true?$this->session->userdata('typeLinkID'):0;
			
			//若刪除為父類別，檢查是否有子類別，並刪除
			if(!$sub && $post['oper'] == 'del'){
				$sqlString = "SELECT * FROM $target WHERE linkID ='".$post['id']."'";
				$query = $this->db->query($sqlString);
				$targetID = $target."ID";
				foreach($query->result() as $row){
					$sub['id'] = $row->$targetID;
					$sub['oper'] = $post['oper'];
					//驗證傳入資料
					//$_sesSubResult = array("subResult" => $sub);
					//$this->session->set_userdata($_sesSubResult);
					$this->modify->modify($target,$sub);
				}								
			}
			
			//驗證傳入資料
			$_sesResult = array("result"=>$post);
			$this->session->set_userdata($_sesResult);
			//寫入資料庫
			$this->modify->modify($target,$post);			
		}
		//顯示傳入資料
		public function echoPost(){
			var_dump($this->session->all_userdata());
		}
	}