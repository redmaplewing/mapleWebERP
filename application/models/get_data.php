<?php
	class Get_data extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		
		function getData($query){
			$result = $this->db->query($query);
			return $result;
		}
		
		function getTableData($tableName){
			$result = $this->db->get($tableName);
			return $result;
		}
	}