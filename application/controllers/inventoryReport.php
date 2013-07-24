<?php

//class Login extends CI_Controller {	
class inventoryReport extends MY_Controller {

    //base Setting
    var $tableName = array();//程式所使用的資料庫
    var $employee = array();//員工名單
    var $group = array();//員工權限

    public function __construct() {
        parent::__construct(); //繼承父類別的涵數
        $this->_load();
    }

    public function index($menuID) {
        //var_dump($this->session->all_userdata());
        //建構基本參數設定
        $this->_load();
        //載入基本套件、設定頁面基本資訊
        $this->lang->load('main', $this->session->userdata('lang')); //戴入語言套件
        $data['loginInfo'] = $this->session->all_userdata();
        $data['tableName'] = $this->tableName;
        $view = "purchaseReport";

        //取得功能資訊
        $sString = "SELECT a.*,b.name as parentName,b.menuTypeID as parentID FROM menu as a INNER JOIN menuType as b ";
        $sString .= "WHERE a.menuID = '%s' and b.menuTypeID = a.parentID";
        $sqlString = sprintf($sString, $menuID);
        //echo $sqlString;//驗證SQL碼

        $menuSql = $this->db->query($sqlString);

        $menuInfo = array();
        foreach ($menuSql->result() as $key => $val) {
            $menuInfo['menuName'] = $val->name;
            $menuInfo['parent'] = $val->parentName;
            $menuInfo['parentID'] = $val->parentID;
            $menuInfo['link'] = $val->link;
            $menuInfo['menuID'] = $menuID;
        }
        $data['menuInfo'] = $menuInfo;
        //var_dump($menuInfo);
        //定義左側標籤何者開啟
        foreach ($this->session->userdata('menuType') as $key => $val) {
            if ($menuInfo['parentID'] == $val['id']) {
                $active = $key;
            };
        }
        //var_dump($this->employee);
        $data['active'] = $active;
        $data['employee'] = $this->employee;
        $data['group'] = $this->group;
        $data['attRecord'] = $this->checkPermission('3', 'attRecord');

        //var_dump($data);//驗證輸出陣列

        $this->load->view('header', $data);
        $this->load->view('nav', $data);
        $this->load->view($view, $data);
        $this->load->view('footer', $data);
    }


    //資料庫操作
    public function modify($tar = '') {
        //echo "this is post page";
        if ($tar == '') {
            $tar = $this->tableName['mainTable'];
        }
        //載入資料寫入模組
        $this->load->model("modify");
        //取得表單傳入資料
        $post = $this->input->post();
        //var_dump($post);
        $post['managerID'] = $this->session->userdata('employeeID');
        //var_dump($post);
        $target = $tar;

        //驗證傳入資料
        $_sesResult = array("result" => $this->input->post(), "table" => $tar);
        $this->session->set_userdata($_sesResult);
        //寫入資料庫
        $this->modify->modify($target, $post);
    }

    //顯示傳入資料
    public function echoPost() {
        var_dump($this->session->all_userdata());
    }

    //設定程式基本參數
    private function _load() {
        $tableName = array();
        $tableName['mainTable'] = "purchase";
        $tableName['linkTable'] = array(
            //'employeeAttendance' => 'employeeAttendance'
        );

        //取得成員資料
        $sqlString = "SELECT * FROM employee WHERE enable='1'";
        $dbQuery = $this->db->query($sqlString);
        $employee = array();
        foreach ($dbQuery->result() as $key => $val) {
            $employee[$val->employeeID] = $val->nameFirst . $val->nameLast;
        };

        //取得群組資料
        $sqlString = "SELECT * FROM groupPermission WHERE enable='1'";
        $dbQuery = $this->db->query($sqlString);
        $group = array();
        foreach ($dbQuery->result() as $key => $val) {
            $group[$val->groupPermissionID] = $val->name;
        };

        $this->tableName = $tableName;
        $this->employee = $employee;
        $this->group = $group;
    }

}