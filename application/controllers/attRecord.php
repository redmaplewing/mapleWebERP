<?php

//class Login extends CI_Controller {	
class AttRecord extends MY_Controller {

    //base Setting
    var $tableName = array();
    var $employee = array();
    var $group = array();

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
        $view = "attRecord";

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

    public function sendAttRecordData() {
        //取得服務資料
        $infoData = array();
        $table = $this->tableName['mainTable'];
        $tableID = $table . "ID";
        $sqlString = "SELECT * FROM %s %s ORDER BY %s ASC";
        $subString = "";
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table, $subString, $tableID);
        //echo sprintf($sqlString,$table,$type,$tableID);
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $infoData['column'] = array(
            "No"
            , "employeeNo"
            , "name"
            , "position"
            , "employmentDate"
            , "employmentWorkDay"
            , "employmentDayWork"
            , "unpaid"
            , "sick"
            , "holiday"
            , "annual"
            , "bl"
            , "ml"
            , "off"
            , "other"
        );


        $result = $this->returnGridData($infoData);
        //var_dump($result);
        echo json_encode($result);
    }

    //取得員工出缺勤資料
    public function sendEmployeeLeaveData($type = '1', $id = '0', $month = '0') {
        //取得服務資料
        $infoData = array();
        //設定目標月份
        $targetMonth = $month == 0 ? date('m') : $month;
        $targetDate = date('Y') . '-' . $targetMonth . '-01';
        $firstday = date('Y-m-01', strtotime($targetDate));
        $lastday = date('Y-m-d', strtotime("$firstday +1 month -1 day"));

        //echo $firstday."<br />".$lastday;

        $table = $this->tableName['linkTable']['employeeAttendance'];
        $tableID = $table . "ID";
        $sqlString = "SELECT * FROM %s %s ORDER BY %s ASC";
        $subString = sprintf(" WHERE employeeID='%s' AND startDay >= '%s' AND startDay <= '%s'", $id, $firstday, $lastday);
        //echo $sqlString;
        /*
          if ($type == '2') {
          //var_dump($this->input->get());
          $leaveId = $this->input->get('id');
          $subString = sprintf(" WHERE %s='%s' AND startDay => '%s' AND startDay <= '%s'", $tableID, $leaveId,$firstday,$lastday);
          echo sprintf($sqlString, $table, $subString, $tableID);
          }
         * 
         */
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table, $subString, $tableID);
        //echo sprintf($sqlString, $table, $type, $tableID);
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $infoData['column'] = array(
            "month"
            , "day"
            , "hour"
            , "dayOff"
            , "leaveType"
            , "signCheck"
            , "hrDeptCheck"
            , "checked"
            , "approved"
        );
        $result = $this->returnGridData($infoData);
        //var_dump($result);
        echo json_encode($result);
    }

    //回傳Grid資料
    public function returnGridData($infoData) {
        //定義基本變數
        $page = $infoData['page'];
        $numLimit = $infoData['numLimit'];
        $startRow = $page * $numLimit - $numLimit;
        $tableName = $infoData['tableName'];
        $targetID = $tableName . "ID";

        //產生mySql查詢結果
        $baseSql = $infoData['baseSql'];
        //計算總筆數
        $rowNum = $this->db->query($baseSql);
        $infoNum = isset($rowNum->num_rows) ? $rowNum->num_rows : 0;
        //封裝查詢結果
        $sqlString = sprintf($baseSql . " Limit %s,%s", $startRow, $numLimit);
        $query = $this->db->query($sqlString);
        $reInfoData = array();
        //封裝查詢結果
        $i = 1;
        foreach ($query->result() as $row) {
            $menuTypeData = array();
            foreach ($infoData['column'] as $val) {
                switch ($val) {
                    //取得成名編號回傳成員名稱
                    case "managerID":
                        $sqlString = "SELECT * FROM employee WHERE employeeID=%s";
                        $result = $this->db->query(sprintf($sqlString, $row->$val));
                        $rs = $result->row();
                        $data = $rs->nameFirst . " " . $rs->nameLast;
                        break;
                    //自動產生流水號
                    case "No":
                        $data = $i;
                        break;
                    case "name":
                        $data = $row->nameFirst . "&nbsp;" . $row->nameLast;
                        break;
                    case "employeeNo":
                        $data = $row->emplyoeeNo; //資料表建立時名稱輸入錯誤employee打成emplyoee
                        break;
                    case "month":
                    case "day":
                    case "hour":
                        $time = array();
                        $time['month'] = idate("m", strtotime($row->startDay));
                        $time['day'] = idate("d", strtotime($row->startDay));
                        $time['hour'] = idate("H", strtotime($row->endDay)) - idate("H", strtotime($row->startDay));
                        $data = $time[$val];
                        break;
                    case "dayOff":
                        $data = $row->startDay . "<br /> to <br />" . $row->endDay . "<br />";
                        break;
                    case "leaveType":
                        $leaveType = "";
                        switch ($row->leaveType) {
                            case '1'://Unpaid Leave事假
                                $leaveType = 'Unpaid Leave';
                                break;
                            case '2'://Sick Leave病假
                                $leaveType = 'Sick Leave';
                                break;
                            case '3'://Visit Leave公出
                                $leaveType = 'Visit Leave';
                                break;
                            case '4'://Matemity Leave產假
                                $leaveType = 'Matemity Leave';
                                break;
                            case '5'://Marriage Leave婚假
                                $leaveType = 'Marriage Leave';
                                break;
                            case '6'://Bereavment Leave喪假
                                $leaveType = 'Bereavment Leave';
                                break;
                            case '7'://Off Leave休假
                                $leaveType = 'Off Leave';
                                break;
                            case '8'://Other Leave其它原因
                                $leaveType = $row->other;
                                break;
                        }
                        $data = $leaveType;
                        break;
                    case "employmentWorkDay":
                    case "employmentDayWork":
                        $data = '';
                        break;
                    case "unpaid"://事假天數
                    case "sick"://病假天數
                    case "bl"://喪假天數
                    case "ml"://婚、產假天數
                    case "off"://休假
                    case "other"://其它
                        $daysCount = $this->getLeaveDaysCount($val, $row->employeeID);
                        $data = $daysCount;
                        break;
                    case "holiday":
                    case "annual":
                        $data = "";
                        break;
                    /* case "other": */
                    case "checked":
                    case "approved":
                        $data = $row->$val != '0' ? $this->employee[$row->$val] : "Uncheck";
                        break;
                    case "signCheck":
                    case "hrDeptCheck":
                        $data = $row->$val == '1' ? "yes" : "no";
                        break;
                    case "Gender":
                        switch ($row->$val) {
                            case "2":
                                $data = "Female";
                                break;
                            case "1":
                            default:
                                $data = "Male";
                                break;
                        }
                        break;
                    default:
                        $data = $row->$val;
                        break;
                }
                array_push($menuTypeData, $data);
            }
            $i++;
            $reInfoData[] = array(
                "id" => $row->$targetID
                , "cell" => $menuTypeData
            );
        }
        $result = array(
            'records' => count($reInfoData),
            'total' => ceil($infoNum / $numLimit),
            'page' => $page,
            'rows' => $reInfoData
        );

        //包json編碼後傳送
        return $result;
    }

    //回傳特定假別(天數)
    function getLeaveDaysCount($type = '', $id = 0) {

        $daysCount = '';
        $leaveType = array(
            'sick' => '2'
            , 'unpaid' => '1'
            , 'bl' => '6'
            , 'ml' => '4,5'
            , 'off' => '7'
            , 'other' => '8'
        );

        $sqlString = "SELECT * FROM employeeAttendance WHERE leaveType IN('%s') AND employeeID='%s'";
        $result = $this->db->query(sprintf($sqlString, $leaveType[$type], $id));

        foreach ($result->result() as $key => $val) {
            $leaveHour = idate("H", strtotime($val->endDay)) - idate("H", strtotime($val->startDay));
            if ($leaveHour == 0) {
                $leaveHour = 1;
            }
            $daysCount += $leaveHour / 8;
        }
        return $daysCount;
    }

    //查詢員工項目資料並回傳
    public function getEmployeeData($type = '1') {
        $table = "employee";
        $tableID = $table . "ID";
        $sqlString = "SELECT * FROM %s WHERE enable='1' AND %s='%s' ";
        $sqlString = sprintf($sqlString, $table, $tableID, $this->input->post('ID'));
        $row = $this->db->query($sqlString);
        $result = $row->row_array();
        echo json_encode($result);
        //$this->session->set_userdata('thisAjaxPost',$this->input->post());//驗證post資料
        //$this->session->set_userdata('thisAjaxQuery',$result);//驗證Query資料
    }

    //查詢休假項目資料並回傳
    public function getEmployeeLeaveData($type = '1') {
        $table = "employeeAttendance";
        $tableID = $table . "ID";
        $sqlString = "SELECT * FROM %s WHERE %s='%s' ";
        $sqlString = sprintf($sqlString, $table, $tableID, $this->input->post('ID'));
        $row = $this->db->query($sqlString);
        $result = $row->row_array();
        echo json_encode($result);
        //$this->session->set_userdata('thisAjaxPost',$this->input->post());//驗證post資料
        //$this->session->set_userdata('thisAjaxQuery',$result);//驗證Query資料
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
        $tableName['mainTable'] = "employee";
        $tableName['linkTable'] = array(
            'employeeAttendance' => 'employeeAttendance'
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