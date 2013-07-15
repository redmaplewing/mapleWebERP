<?php

	//class Login extends CI_Controller {	
	class MenuType extends MY_Controller {	
		
		public function index (){
			$this->lang->load('main',$this->session->userdata('lang'));//戴入語言套件
			$loginInformation = $this->session->all_userdata();
			$data['loginInfo'] = $loginInformation;
			$data['tableName'] = 'menuType';
			
			$this->load->view('header',$data);
			$this->load->view('nav',$data);
			$this->load->view('menuType',$data);
			$this->load->view('footer',$data);
		}
		
		public function sendQueryData(){//取得選單類別資料

			$sqlString = "select * from menuType where lang='en_US' order by lang asc,ord asc";
			//$sqlString = "select * from employee";
			$query = $this->db->query($sqlString);
			//var_dump($query->result());
			$infoData = array();
			foreach($query->result() as $row){
				$menuTypeData = array(
					$row->name,
					$row->lang,
					$row->enable,
					$row->ord
					//$row->linkID,
					//'menuType'
				);
				$infoData[] = array(
					"id" => $row->menuTypeID,
					"cell" => $menuTypeData,
				);
			}
			
			$result = array(
				'records'=>count($infoData),
				'total'=>ceil(count($infoData)/10),
				'page'=>1,
				'rows'=>$infoData
			);
			
			//回傳json陣列
			echo json_encode($result);
			//return json_encode($result);
		}

		public function subQueryData(){//取得選單類別資料
			$id = $this->input->get('id') == null?1:$this->input->get('id');
			$sqlString = "select * from menuType where linkID=$id order by lang asc";
			//$sqlString = "select * from employee";
			$query = $this->db->query($sqlString);
			//var_dump($query->result());
			$infoData = array();
			foreach($query->result() as $row){
				$menuTypeData = array(
					$row->name,
					$row->lang,
					$row->enable,
					$id
				);
				$infoData[] = array(
					"id" => $row->menuTypeID,
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
			/*$_sesResult = array("result"=>$post);
			$this->session->set_userdata($_sesResult);*/
			//寫入資料庫
			$this->modify->modify($target,$post);			
		}
		//顯示傳入資料
		public function echoPost(){
			var_dump($this->session->all_userdata());
		}
	}