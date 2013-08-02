<?php

//class Login extends CI_Controller {	
class TeManager extends MY_Controller {

    //base Setting
    var $tableName = array();
    var $warehouse = array();
    var $project = array();
    var $employee = array();
    var $item = array();
    var $purchaseOrder = array();

    public function __construct() {
        parent::__construct(); //繼承父類別的涵數
        $this->_load();
    }

    public function index($menuID) {
        //建構基本參數設定
        $this->_load();
        //載入基本套件、設定頁面基本資訊
        $this->lang->load('main', $this->session->userdata('lang')); //戴入語言套件
        $data['loginInfo'] = $this->session->all_userdata();
        $data['tableName'] = $this->tableName;
        $view = "teManager";

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
        $data['active'] = $active;
        $data['warehouse'] = $this->warehouse;
        $data['project'] = $this->project;
        $data['employee'] = $this->employee;
        $data['item'] = $this->item;
        $data['purchaseOrder'] = $this->purchaseOrder;
        $data['teManager'] = $this->checkPermission('3', 'teManager');

        //var_dump($data);//驗證輸出陣列
        //取得請購單Purchase Request 資料
        $sqlString = "SELECT * FROM purchaseRequest";
        $prSql = $this->db->query($sqlString);
        $prNo = array();

        foreach ($prSql->result() as $key => $val) {
            $subArray = array();
            $subArray['id'] = $val->purchaseRequestID;
            $subArray['No'] = $val->purchaseRequestNo;
            $prNo[$val->purchaseRequestID] = $subArray;
        }
        $data['prNo'] = $prNo;

        $this->load->view('header', $data);
        $this->load->view('nav', $data);
        $this->load->view($view, $data);
        $this->load->view('footer', $data);
    }

    public function sendServiceData($functionType = 0, $statusType = 0, $warehouse = '0') {
        //取得服務資料
        $infoData = array();
        $table = $this->tableName['mainTable'];
        $tableID = $table . "ID";
        $subQuery = "AND status ='0' ";
        switch ($statusType) {
            case 3:
                $subQuery = "AND status = '1'";
                break;
            case 2:
                $subQuery .= "AND submitDate != '0000-00-00' AND approved != '0'";
                break;
            case 1:
                $subQuery .= "AND submitDate != '0000-00-00' AND approved = '0'";
                break;
            case 0:
            default:
                $subQuery .= "";
                break;
        }
        $warehouseSqlString = "";
        if ($warehouse != '0') {
            $warehouseSqlString = sprintf(" AND  projectID=(SELECT projectID FROM warehouse WHERE warehouseID='%s')", $warehouse);
        }
        $sqlString = "SELECT * FROM %s WHERE type=%s %s %s ORDER BY %s ASC";
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table, $functionType, $subQuery, $warehouseSqlString, $tableID);
        //echo $infoData['baseSql'];
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $infoData['column'] = array(
            "itemHandleNo"
            , "managerID"
            , "status"
            , "projectNo"
            , "projectName"
            , "eDate"
        );

        $result = $this->returnGridData($infoData);
        //var_dump($result);
        echo json_encode($result);
    }

    //新增維護項目
    public function insertDetail() {
        if ($this->input->post()) {
            $this->modify('handleDetail');
        }
    }

    //回傳項目清單
    public function sendDetail($securityCode, $receive = 0) {
        //取得服務資料
        $infoData = array();
        $table = $this->tableName['linkTable']['handleDetail'];
        $tableID = $table . "ID";
        $sqlString = "SELECT a.*,b.* FROM %s as a inner join item as b WHERE a.securityCode='%s' and a.itemID=b.itemID ORDER BY %s ASC";
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table, $securityCode, $tableID);
        //echo $infoData['baseSql'];
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        /*
          receive type
          1=>repair
          2=>calibration
          3=>disposal
          0=>非receive type是list的欄位
         */
        switch ($receive) {
            case 3:
                $infoData['column'] = array(
                    "No"
                    , "code"
                    , "name"
                    , "description"
                    , "receivedDate"
                    , "inventoryPost"
                );
                break;
            case 2:
                $infoData['column'] = array(
                    "No"
                    , "code"
                    , "name"
                    , "qty"
                    , "amtSpent"
                    , "purchaseOrderID"
                    , "receivedDate"
                    , "inventoryPost"
                    , "cabliResult"
                    , "note"
                );
                break;
            case 1:
                $infoData['column'] = array(
                    "No"
                    , "code"
                    , "name"
                    , "qty"
                    , "amtSpent"
                    , "purchaseOrderID"
                    , "receivedDate"
                    , "inventoryPost"
                    , "note"
                );
                break;
            case 0:
            default:
                $infoData['column'] = array(
                    "No"
                    , "code"
                    , "name"
                    , "description"
                    , "reason"
                );
                break;
        }


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
                    //自動置換status的資料
                    case "status":
                        switch ($row->$val) {
                            case "1":
                                $data = "completed";
                                break;
                            case "0":
                            default:
                                $data = "Arriving/In-progress";
                                break;
                        }
                        break;
                    //依圖紙編號取得圖紙名稱
                    case "planID":
                        if ($row->$val != 0) {
                            $sqlString = "SELECT * FROM drawing WHERE drawingID=%s";
                            $result = $this->db->query(sprintf($sqlString, $row->$val));
                            //echo sprintf($sqlString,$row->$val);
                            //var_dump($result);
                            if ($result->row()) {
                                $rs = $result->row();
                                $data = $rs->drawingNo;
                            } else {
                                $data = "";
                            }
                        } else {
                            $data = "";
                        }
                        break;
                    case "projectName":
                        if (isset($this->project[$row->projectID])) {
                            $data = $this->project[$row->projectID]['name'];
                        } else {
                            $data = "";
                        }

                        break;
                    case "projectNo":
                        if (isset($this->project[$row->projectID])) {
                            $data = $this->project[$row->projectID]['code'];
                        } else {
                            $data = "";
                        }

                        break;
                    //自動產生流水號
                    case "No":
                        $data = $i;
                        break;
                    //計算總金額
                    case "totalAmt":
                        $data = $row->qty * $row->unitCost;
                        break;
                    case "inventoryPost":

                        $targetTable = "itemHandle";
                        $id = $row->itemHandleID;
                        $class = "inventoryPost";

                        $targetTableID = $targetTable . "ID";
                        $sqlString = "SELECT * FROM %s WHERE %s='%s'";
                        $query = $this->db->query(sprintf($sqlString, $targetTable, $targetTableID, $id));
                        //echo sprintf($sqlString,$row->materialRequestID);
                        $queryRequest = $query->row();
                        if ($row->$val == '0'/* && $materialRequest->status == 0 */) {
                            $data = '<input type="button" id="inventoryPost' . $row->$targetID . '" value="Post" itemID="' . $row->$targetID . '" class="' . $class . '"/>';
                        } else {
                            $data = 'posted';
                        }
                        break;
                    case "receivedDate":

                        $targetTable = "itemHandle";
                        $id = $row->itemHandleID;
                        $class = "checkReceiving";

                        $targetTableID = $targetTable . "ID";
                        $sqlString = "SELECT * FROM %s WHERE %s='%s'";
                        $query = $this->db->query(sprintf($sqlString, $targetTable, $targetTableID, $id));
                        $queryRequest = $query->row();
                        if ($row->$val == "0000-00-00"/* && $materialRequest->status == 0 */) {
                            $data = '<input type="checkbox" id="receiving-' . $row->$targetID . '" class="' . $class . '"/>';
                        } else {
                            $data = $row->$val;
                        }
                        break;
                    case "from":
                        $data = $this->warehouse[$row->$val];
                        break;
                    case "to":
                        $data = $this->supplier[$row->$val]['name'];
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

    //輸入項目簽收時間
    public function changeReceiving() {
        $explodeString = explode('-', $this->input->post('target'));

        //var_dump($explodeString2);
        $post['id'] = $explodeString[1];
        $post['receivedDate'] = date("Y-m-d h:i:s", now());
        $post['oper'] = 'edit';

        //載入資料寫入模組
        $this->load->model("modify");
        $this->modify->modify('handleDetail', $post);

        echo 'true';
        //echo $target;
    }

    //將簽收結果輸入至倉儲
    public function postToInventory() {
        $this->load->model("modify");
        $receiveDate = date("Y-m-d h:i:s", now());
        $sqlString = "SELECT * FROM handleDetail WHERE handleDetailID='" . $this->input->post('id') . "'";
        $query = $this->db->query($sqlString);
        $result = $query->row();
        $post['receivedDate'] = $result->receivedDate == '0000-00-00' ? $receiveDate : $result->receivedDate;
        $post['id'] = $this->input->post('id');
        $post['inventoryPost'] = 1;
        $post['oper'] = 'edit';

        //載入資料寫入模組			
        $this->modify->modify('handleDetail', $post);
        echo 'true';
    }

    //查詢項目資料並回傳
    public function getFunctionData() {
        $table = "itemHandle";
        $tableID = $table . "ID";
        $sqlString = sprintf("SELECT * FROM %s WHERE %s=%s", $table, $tableID, $this->input->post('ID'));
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
        if (isset($post['securityCode'])) {
            $this->groupmrDetail($tar, $post['securityCode']);
        }
    }

    //將未歸檔的維護項目歸檔
    public function groupmrDetail($tar, $securityCode) {
        $this->load->model("modify");
        //取得pr的id
        $sqlString = "SELECT * FROM %s WHERE securityCode='%s'";
        //echo sprintf($sqlString,$tar,$securityCode);
        $query = $this->db->query(sprintf($sqlString, $tar, $securityCode));
        $result = $query->row();
        $target = $tar . 'ID';
        $id = $result->$target;
        //將pr id更新進prdetail
        $sqlString = "SELECT * FROM handleDetail WHERE securityCode='%s'";
        $query = $this->db->query(sprintf($sqlString, $securityCode));
        //echo sprintf($sqlString,$securityCode);
        $data = array();
        $data['oper'] = 'edit';
        foreach ($query->result() as $key => $val) {
            $data['itemHandleID'] = $id;
            $data['id'] = $val->handleDetailID;
            //var_dump($data);
            $this->modify->modify('handleDetail', $data);
        }
        //echo $id;
    }

    //顯示傳入資料
    public function echoPost() {
        var_dump($this->session->all_userdata());
    }

    //設定程式基本參數
    private function _load() {
        $tableName = array();
        $tableName['mainTable'] = "itemHandle";
        $tableName['linkTable'] = array(
            'item' => 'item'
            , 'handleDetail' => 'handleDetail'
        );

        //取得倉庫資料
        $warehouse = array();
        $sqlString = "SELECT a.*,b.name AS 'projectName' FROM warehouse AS a INNER JOIN project AS b WHERE a.projectID!='0' AND a.projectID=b.projectID";
        $query = $this->db->query($sqlString);
        //var_dump($query->result());
        foreach ($query->result() as $key => $val) {
            $warehouse[$val->warehouseID] = $val->name . "(" . $val->projectName . ")";
        }

        //取得專案資料
        $projSqlString = "SELECT a.* FROM project AS a INNER JOIN warehouse AS b WHERE a.projectID=b.projectID";
        $projSql = $this->db->query($projSqlString);
        $project = array();

        foreach ($projSql->result() as $key => $val) {
            $subArray = array();
            $subArray['id'] = $val->projectID;
            $subArray['name'] = $val->name;
            $subArray['customerName'] = $val->clientName;
            $subArray['code'] = $val->projectNo;
            $project[$val->projectID] = $subArray;
        }

        //取得成員資料
        $sqlString = "SELECT * FROM employee WHERE enable='1'";
        $dbQuery = $this->db->query($sqlString);
        $employee = array();
        foreach ($dbQuery->result() as $key => $val) {
            $employee[$val->employeeID] = $val->nameFirst . $val->nameLast;
        };

        //取得工具(tools or equipment)資料
        $sqlString = "SELECT * FROM item";
        $dbQuery = $this->db->query($sqlString);
        $item = array();
        foreach ($dbQuery->result() as $key => $val) {
            $item[$val->itemID] = $val->code . ":" . $val->name;
        }

        //取得採購單編踸
        $sqlString = "SELECT * FROM purchaseOrder";
        $dbQuery = $this->db->query($sqlString);
        $purchaseOrder = array();
        foreach ($dbQuery->result() as $key => $val) {
            $purchaseOrder[$val->purchaseOrderID] = $val->purchaseOrderNo;
        }

        $this->tableName = $tableName;
        $this->warehouse = $warehouse;
        $this->project = $project;
        $this->employee = $employee;
        $this->item = $item;
        $this->purchaseOrder = $purchaseOrder;
    }

}