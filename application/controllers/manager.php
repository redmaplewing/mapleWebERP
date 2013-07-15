<?php
		
	class Manager extends CI_Controller {		
		
		public function index($page=0){
			$this->load->library('table');
			$this->load->library('pagination');
			$this->load->helper('url');
			//$this->load->database();
			//$query = $this->db->query('select * from manager where enable = 1');
				
			$config['per_page'] = 5;
			$sqlString = 'select name,managerID,groupID from manager where enable = 1 LIMIT '.$page.','.$config['per_page'];
			$sqlStringTotal = 'select * from manager where enable = 1';
			$this->load->model("get_data","query");
			$query = $this->query->getData($sqlString);
			$totalNum = $this->query->getData($sqlStringTotal);
			
			$config['base_url'] = "http://ciexample.localhost/manager/index/";
			$config['total_rows'] = $totalNum->num_rows();
			$config['first_link'] = "<< 第一頁";
			$config['last_link'] = "最未頁 >>";
			$config['prev_link'] = "< prev";
			$config['next_link'] = "next >";
			
			//echo $page;
			//echo $this->input->get('page',TRUE);
			$this->pagination->initialize($config);
			/*var_dump($query);
			foreach($query->result() as $row){
				echo "name: ".$row->name;
				echo "managerID: ".$row->managerID;
				echo "groupID: ".$row->groupID;
				echo "<br />";
			}
			echo "Hello Manager";*/
			$data = array();
			$data['query'] = $query;
			//echo $this->pagination->create_links();
			$this->load->view('manager',$data);
		}
		
		public function host(){
			//$query = $this->db->get("hostType");
			$this->load->helper('url');
			$this->load->model("get_data","table");
			$query = $this->table->getTableData("hostType");
			/*var_dump($query);
			foreach($query->result() as $row){
				echo "hostTypeName: ".$row->hostTypeName;
				echo "hostSystem: ".$row->hostSys;
				echo "hostDisk: ".$row->hostDisk;
				echo "<br />";
			}
			echo "Hello host";*/
			$data = array();
			$data['query'] = $query;
			$this->load->view('host',$data);
		}
		
	}