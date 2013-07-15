<?php
	class Modify extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		
		public function checkDataDifference($dataDetail){
			$tableID = $dataDetail['table']."ID";
			$sqlString = sprintf("SELECT %s FROM %s WHERE %s=%s",$dataDetail['field'],$dataDetail['table'],$tableID,$dataDetail['sn']);
			$dataResult = $this->db->query($sqlString);
			$query = $dataResult->row();
			$result = array();
			if($query->$dataDetail['field'] != $dataDetail['fieldData']){
				$result['difference'] = true;				
			}else{
				$result = false;
			};
			$result['previousData'] = $query->$dataDetail['field'];
			return $result;
		}
		
		public function modify($target,$post){
			//指定目標表格並取得欄位資訊
			$targetID = $target."ID";
			$fields = $this->db->list_fields($target);
			//var_dump($post);
			//宣告資料陣列
			$data = array();
			$insertID = "";
			//比對欄位與post的資料鍵值，若符合則將資料放入data陣中中相對應的位置
			foreach($post as $key => $value){
				if(in_array($key , $fields)){
					$data[$key] = $value;
				}
			}
			
			//建立操作記錄陣列
			$modify = array(
				"tableName" => $target,
				"managerID" => $this->session->userdata('account'),
				"uDate" => date("Y-m-d h:i:s",now()),
				"modify" => $post['oper'],
				"ipAddress" => $this->input->ip_address()
			);
			//var_dump($modify);
			//依oper進行相對應的資料庫操作
			switch($post['oper']){
				case 'add'://新增
					$data['cDate'] = date("Y-m-d h:i:s",now());
					//$sqlString = $this->db->insert_string($target,$data);//驗證新增的SQL指令
					
					$this->db->insert($target,$data);
					$insertID = $this->db->insert_id();
					break;
				case 'edit'://編輯
					$data['uDate'] = date("Y-m-d h:i:s",now());
					//$where = $targetID."=".$post['id'];//設定搜尋條件
					//$sqlString = $this->db->update_string($target,$data,$where);//驗證編輯的SQL指令
					
					$this->db->where($targetID,$post['id']);
					$this->db->update($target,$data);
					break;
				case 'del'://刪除
					//$sqlString = "DELETE FROM ".$target." WHERE ".$targetID."=".$post['id'];//驗證刪除的SQL指令
					$this->db->where($targetID,$post['id']);
					$this->db->delete($target);
					break;
				default:
					$sqlString = "no data";
					break;
			}
			if($insertID != ""){
				return $insertID;
			}
			$this->db->insert('modifyLog',$modify);//將操作記錄寫入資料庫			
		}

	}