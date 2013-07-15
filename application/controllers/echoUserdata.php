<?php

	class EchoUserdata extends MY_Controller {	
		
		public function index (){
			var_dump($this->session->all_userdata());
		}
	}