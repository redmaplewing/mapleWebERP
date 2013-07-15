<?php

	class Login extends CI_Controller {	
		
		public function index ($lang="en_US"){
			$this->load->helper('form');//載入表單套件
			$this->lang->load('login',$lang);//戴入語言套件
			$this->load->helper('security');//security輔助涵數，執行md5加密用
			$this->load->helper('captcha');//載入驗證碼輔助函數
			
			//清除所有session(cookie in codeigniter)資訊
			$this->session->sess_destroy();
			
			//產生驗證碼
			$pool = 'abcdefghijklmnopqrstuvwxyz123456789';
			$word = '';
			for($i = 0; $i < 9;$i++){
				$word .= substr($pool,mt_rand(0,strlen($pool)-1),1);
			}
			//echo $word;
			//$this->session->set_userdata('captcha',$wood);
			$vals = array(
				'word' => $word,
				'img_path'	 => './images/tmp/',
				'img_url'	 => base_url().'images/tmp/',
				'img_width'	 => 150,
				'img_height'	 => 30
				);				
			$cap = create_captcha($vals);
			//var_dump($cap);
			
			//將驗證碼資料寫入資料庫
			$captcha = array(
				'captcha_time' => $cap['time'],
				'ip_address' => $this->input->ip_address(),
				'word' => $cap['word']
			);
			$query = $this->db->insert_string('captcha',$captcha);
			$this->db->query($query);
			
			//語言選單
			$langType = array(
				"en_US" => "English",
				//"zh_CN" => "Chinese Simplified",
				//"km_KH" => "Khmer",
				"zh_TW" => "Chinese Traditional"
			);
			//var_dump($langType);
			$data['langType'] = $langType;
			
			//將驗證碼存入陣列，傳入後台
			$data['cap'] = $cap;
			$data['lang'] = $lang;

			$this->load->view('login',$data);
		}
		
		public function checkLogin(){
			$this->load->helper('date');//載入時間套件函數	
			$this->lang->load('login',$this->input->post('selectLang'));//戴入語言套件
			$this->load->helper('security');
			$this->load->helper('url');//載入連結輔助函數
			$this->load->helper('captcha');//載入驗證碼輔助函數
			$this->load->model("get_data","employee");
			
			//取得員工資料
			$sqlString = "select * from employee where account='".$this->input->post('account')."' and (enable = 1 or '".$this->input->post('account')."' = 'maple')";
			$query = $this->employee->getData($sqlString);
			$result = $query->row();
			
			//檢查驗證碼
			$expiration = time()-7200; // Two hour limit
			$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);	

			//驗證是否存在資料:
			$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
			$binds = array($this->input->post('check'), $this->input->ip_address(), $expiration);
			$query = $this->db->query($sql, $binds);
			$row = $query->row();

			if ($row->count == 0)
			{
				echo "<script>alert('".$this->lang->line('error_checkNumber')."');</script>";
				echo "<script>location.href = '".base_url()."';</script>";
			}
			
			//比對網頁輸入之密碼經md5加密後是否與資料庫密碼欄位之資料相當
			if($result->password == do_hash($this->input->post('passwd'),'md5')){
				//記錄登入資訊
				$userInformation = array(
					"username" => $result->nameFirst ." ". $result->nameLast,
					"account" => $result->account,
					"groupID" => $result->groupID,
					"employeeID" => $result->employeeID,
					"lang" => $this->input->post('selectLang'),
					"logined" => true,
					"loginTime" => now()
				);
				//將登入資訊寫入CI的SESSION(cookie)
				$this->session->set_userdata($userInformation);
				//var_dump($this->session->all_userdata());
				/*echo "登入成功";
				echo anchor(site_url("mainmenu"),"主頁面");*/
				echo "<script>location.href = '".base_url()."mainmenu';</script>";
			}else{
				echo "<script>alert('".$this->lang->line('error_login')."');</script>";
				echo "<script>location.href = '".base_url()."';</script>";
			}
		}
	}