<?php

	//class Login extends CI_Controller {	
	class CreatePermission extends MY_Controller {	
		
		public function index (){
			$this->lang->load('main',$this->session->userdata('lang'));//戴入語言套件
			//$this->load->helper('url');
			$loginInformation = $this->session->all_userdata();
			$data['loginInfo'] = $loginInformation;
			
			$this->load->view('header',$data);
			$this->load->view('nav',$data);
			$this->load->view('createPermission',$data);
			$this->load->view('footer',$data);
		}
	}