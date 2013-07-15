<?php

	//class Login extends CI_Controller {	
	class Mainmenu extends MY_Controller {	
		
		public function index (){
			$this->lang->load('main',$this->session->userdata('lang'));//戴入語言套件
			//$this->load->helper('url');
			$loginInformation = $this->session->all_userdata();
			$data['loginInfo'] = $loginInformation;
			
			$this->load->view('header',$data);
			$this->load->view('nav',$data);
			$this->load->view('mainmenu',$data);
			$this->load->view('footer',$data);
		}
		
		public function changeLanguage($lang,$target){
			//echo $lang;
			//var_dump($this->session->userdata('menuType'));
			//echo "<br />".$target;
			$id="";
			foreach($this->session->userdata('menuType') as $key => $val){
				//var_dump($val);
				foreach($val['menulist'] as $k => $v){					
					if($v['link'] != '' && $v['link'] == $target){
						$id = $v['id'];
					}
				};
			}
			//echo $id;
			$this->session->set_userdata("lang",$lang);
			echo '<script type="text/javascript">location.href="'.base_url().$target.'/index/'.$id.'"</script>';
		}
	}