<?php

//class Login extends CI_Controller {	
class PurchaseRequest extends MY_Controller {

    //base Setting
    var $tableName = array();
    var $project = array();
    var $item = array();
    var $supplier = array();

    public function __construct() {
        parent::__construct(); //繼承父類別的涵數
        $this->_load();
        $this->getItem();
    }

    public function index($menuID) {
        //建構基本參數設定
        $this->_load();
        //載入基本套件、設定頁面基本資訊
        $this->lang->load('main', $this->session->userdata('lang')); //戴入語言套件
        $data['loginInfo'] = $this->session->all_userdata();
        $data['tableName'] = $this->tableName;
        $view = "purchaseRequest";

        //var_dump($this->session->all_userdata());
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
        $data['itemOption'] = $this->item;
        //var_dump($menuInfo);
        //定義左側標籤何者開啟
        foreach ($this->session->userdata('menuType') as $key => $val) {
            if ($menuInfo['parentID'] == $val['id']) {
                $active = $key;
            };
        }
        $data['active'] = $active;
        $data['project'] = $this->project;
        $data['purchaseRequest'] = $this->checkPermission('3', 'purchaseRequest');
        //var_dump($data);//驗證輸出陣列			

        $this->load->view('header', $data);
        $this->load->view('nav', $data);
        $this->load->view($view, $data);
        $this->load->view('footer', $data);
    }

    public function sendPRData($type = 0) {
        //取得服務資料
        $infoData = array();
        $table = $this->tableName['mainTable'];
        $tableID = $table . "ID";
        $sqlString = "SELECT * FROM %s WHERE status=%s ORDER BY %s ASC";
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table, $type, $tableID);
        //echo $infoData['baseSql'];
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $infoData['column'] = array(
            "purchaseRequestNo"
            , "cDate"
            , "managerID"
            , "status"
            , "projectID"
            , "planID"
            , "eDate"
        );

        $result = $this->returnGridData($infoData);
        //var_dump($result);
        echo json_encode($result);
    }

    public function sendPRDetail($securityCode) {
        //取得服務資料
        $infoData = array();
        $table = $this->tableName['linkTable']['purchaseDetail'];
        $tableID = $table . "ID";
        $sqlString = "SELECT a.*,b.* FROM %s as a inner join item as b WHERE a.securityCode='%s' and a.itemID=b.itemID ORDER BY %s ASC";
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table, $securityCode, $tableID);
        //echo $infoData['baseSql'];
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $infoData['column'] = array(
            "No"
            , "code"
            , "name"
            , "description"
            , "qty"
            , "UoM"
            , "unitCost"
            , "totalAmt"
        );

        $result = $this->returnGridData($infoData);
        //var_dump($result);
        echo json_encode($result);
    }

    //取得項目處理流程並回傳
    public function sendPRProcess($purchaseRequestID = 0) {
        if ($purchaseRequestID != 0) {
            //取得項目處理流程
            $infoData = array();
            $detailID = $this->input->get('id');
            //echo $detailId.",".$this->input->get('id');
            $sqlString = "SELECT * FROM purchaseDetail WHERE purchaseRequestID='%s' and purchaseDetailID=%s";
            $infoData['tableName'] = $this->tableName['linkTable']['purchaseDetail'];
            $infoData['baseSql'] = sprintf($sqlString, $purchaseRequestID, $detailID);
            //echo sprintf($sqlString,$purchaseRequestID,$detailID);
            $infoData['numLimit'] = 20;
            $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
            $infoData['column'] = array(
                "processes1"
                , "processes2"
                , "processes3"
                , "processes4"
                , "processes5"
                , "processes6"
                , "processes7"
                , "processes8"
                , "processes9"
            );

            $result = $this->returnGridData($infoData);
            echo json_encode($result);
        } else {
            echo null;
        }
    }

    //輸入流程達成時間
    public function changeProcess() {
        $explodeString = explode('checkprocesses', $this->input->post('target'));
        $explodeString2 = explode('-', $explodeString[1]);
        //var_dump($explodeString2);
        $purchaseProcessID = 'processes' . $explodeString2[0];
        $post['id'] = $explodeString2[1];
        $post[$purchaseProcessID] = date("Y-m-d h:i:s", now());
        $post['oper'] = 'edit';

        //載入資料寫入模組
        $this->load->model("modify");
        $this->modify->modify('purchaseDetail', $post);

        echo 'true';
        //echo $target;
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
        $this->modify->modify('purchaseDetail', $post);

        echo 'true';
        //echo $target;
    }

    //取得項目接受資料
    public function sendPRReceiving($securityCode) {
        //取得服務資料
        $infoData = array();
        $table = $this->tableName['linkTable']['purchaseDetail'];
        $tableID = $table . "ID";
        $sqlString = "SELECT a.*,b.* FROM %s as a inner join item as b WHERE a.securityCode='%s' and a.itemID=b.itemID ORDER BY %s ASC";
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table, $securityCode, $tableID);
        //echo $infoData['baseSql'];
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $infoData['column'] = array(
            "No"
            , "code"
            , "name"
            , "description"
            , "qty"
            , "UoM"
            , "receivedDate"
            , "inventoryPost"
            , "invoceNo"//Invoice No./Delivery
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
            $data = "";

            foreach ($infoData['column'] as $val) {
                switch ($val) {
                    //取得成名編號回傳成員名稱
                    case "managerID":
                        $sqlString = "SELECT * FROM employee WHERE employeeID=%s";
                        $result = $this->db->query(sprintf($sqlString, $row->$val));
                        $rs = $result->row();
                        if ($result->num_rows() > 0) {
                            $data = $rs->nameFirst . " " . $rs->nameLast;
                        } else {
                            $data = "The User has been delete";
                        }

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
                    //依專案編號取得專案名稱
                    case "projectID":
                        $sqlString = "SELECT * FROM project WHERE projectID=%s";
                        $result = $this->db->query(sprintf($sqlString, $row->$val));
                        if ($result->num_rows > 0) {
                            $rs = $result->row();
                            $data = $rs->projectNo;
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
                        $sqlString = "SELECT * FROM purchaseRequest WHERE purchaseRequestID='%s'";
                        $query = $this->db->query(sprintf($sqlString, $row->purchaseRequestID));
                        $purchaseRequest = $query->row();
                        if ($row->$val == '0' && $purchaseRequest->status == 0) {
                            $data = '<input type="button" id="inventoryPost' . $row->$targetID . '" value="Post" itemID="' . $row->$targetID . '" class="inventoryPost"/>';
                        } else {
                            $data = 'posted';
                        }
                        break;
                    case "receivedDate":
                        $sqlString = "SELECT * FROM purchaseRequest WHERE purchaseRequestID='%s'";
                        $query = $this->db->query(sprintf($sqlString, $row->purchaseRequestID));
                        $purchaseRequest = $query->row();
                        if ($row->$val == "0000-00-00" && $purchaseRequest->status == 0) {
                            $data = '<input type="checkbox" id="receiving-' . $row->$targetID . '" class="checkReceiving"/>';
                        } else {
                            $data = $row->$val;
                        }
                        break;
                    case "processes1":
                    case "processes2":
                    case "processes3":
                    case "processes4":
                    case "processes5":
                    case "processes6":
                    case "processes7":
                    case "processes8":
                    case "processes9":
                        $sqlString = "SELECT * FROM purchaseRequest WHERE purchaseRequestID='%s'";
                        $query = $this->db->query(sprintf($sqlString, $row->purchaseRequestID));
                        $purchaseRequest = $query->row();
                        if ($row->$val == "0000-00-00" && $purchaseRequest->status == 0) {
                            $data = '<input type="checkbox" id="check' . $val . "-" . $row->$targetID . '" class="checkProcess"/>';
                        } else {
                            $data = $row->$val;
                        }
                        break;
                    default:
                        $data = $row->$val;
                        break;
                }
                array_push($menuTypeData, $data);
            }

            $reInfoData[] = array(
                "id" => $row->$targetID
                , "cell" => $menuTypeData
            );
            $i++;
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

    public function postToInventory() {
        $this->load->model("modify");
        $receiveDate = date("Y-m-d h:i:s", now());
        $sqlString = "SELECT * FROM purchaseDetail WHERE purchaseDetailID='" . $this->input->post('id') . "'";
        $query = $this->db->query($sqlString);
        $result = $query->row();
        $post['receivedDate'] = $result->receivedDate == '0000-00-00' ? $receiveDate : $result->receivedDate;
        $post['id'] = $this->input->post('id');
        $post['inventoryPost'] = 1;
        $post['oper'] = 'edit';

        //載入資料寫入模組			
        $this->modify->modify('purchaseDetail', $post);

        //將資料覆寫倉儲數據
        $sqlString = "SELECT a.*,b.* FROM purchaseDetail AS a INNER JOIN purchaseRequest AS b WHERE a.purchaseDetailID='%s' AND a.purchaseRequestID = b.purchaseRequestID";
        //echo sprintf($sqlString,$this->input->post('id'));
        $query = $this->db->query(sprintf($sqlString, $this->input->post('id')));
        $result = $query->row();
        //var_dump($result);
        $post['itemID'] = $result->itemID;
        $checkSql = "SELECT * FROM itemInventory WHERE itemID='%s'";
        $checkQuery = $this->db->query(sprintf($checkSql, $result->itemID));
        $checkResult = $checkQuery->row();
        if ($checkQuery->num_rows() != '0') {
            $post['oper'] = 'edit';
            $post['onHand'] = $checkResult->onHand + $result->qty;
            $post['id'] = $checkResult->itemInventoryID;
        } else {
            $warehouseSql = "SELECT * FROM warehouse WHERE projectID='%s'";
            $warehouseQuery = $this->db->query(sprintf($warehouseSql, $result->projectID));
            $warehouseResult = $warehouseQuery->row();
            $post['oper'] = 'add';
            $post['onHand'] = $result->qty;
            $post['warehouseID'] = $warehouseResult->warehouseID;
        }
        $post['managerID'] = $this->session->userdata('employeeID');

        $this->modify->modify('itemInventory', $post);
        echo 'true';
    }

    public function sendInvoceNo() {
        $this->load->model("modify");
        $this->modify->modify('purchaseDetail', $this->input->post());
        echo 'true';
    }

    //查詢圖紙編號並回傳
    public function getProjData() {
        $sqlString = sprintf("SELECT * FROM drawing WHERE projectID=%s", $this->input->post('key'));
        $plan = $this->db->query($sqlString);
        $result['plan'] = $plan->result();
        $result['project'] = $this->project;
        echo json_encode($result);
    }

    //查詢項目資料並回傳
    public function getPRData() {
        $table = $this->tableName['mainTable'];
        $tableID = $table . "ID";
        $sqlString = sprintf("SELECT * FROM %s WHERE %s=%s", $table, $tableID, $this->input->post('ID'));
        $row = $this->db->query($sqlString);
        $result = $row->row_array();
        $sqlString = sprintf("SELECT * FROM %s WHERE projectID=%s", "project", $result['projectID']);
        $row = $this->db->query($sqlString);
        $projResult = $row->row_array();
        $result['projectName'] = $projResult['name'];
        $result['cusName'] = $projResult['clientName'];
        echo json_encode($result);
        //$this->session->set_userdata('thisAjaxPost',$this->input->post());//驗證post資料
        //$this->session->set_userdata('thisAjaxQuery',$result);//驗證Query資料
    }

    //資料庫操作
    public function modify($tar = '') {
        //var_dump($this->input->post());
        //echo "this is post page";
        if ($tar == '') {
            $tar = $this->tableName['mainTable'];
        }
        //載入資料寫入模組
        $this->load->model("modify");
        //取得表單傳入資料
        $post = $this->input->post();
        $post['managerID'] = $this->session->userdata('employeeID');
        //var_dump($post);
        $target = $tar;
        //驗證傳入資料
        $_sesResult = array("result" => $post, "table" => $tar);
        $this->session->set_userdata($_sesResult);
        //寫入資料庫
        //var_dump($this->input->post());
        //var_dump($post);
        $this->modify->modify($target, $post);
        if (isset($post['securityCode'])) {
            $this->groupPrDetail($tar, $post['securityCode']);
        }
    }

    //顯示傳入資料
    public function echoPost() {
        var_dump($this->session->all_userdata());
    }

    //回傳Item
    public function returnItem() {
        $type = $this->input->post('type');
        $this->getItem($type);
        echo json_encode($this->item);
    }

    //取得Item清單
    private function getItem($type = 1) {
        $sqlString = sprintf("SELECT * FROM item WHERE type=%s", $type);
        $itemQuery = $this->db->query($sqlString);
        $item = $itemQuery->result();
        $itemOption = array();
        $supplierStatus = array(
            "0" => "Active"
            , "1" => "Discontinued"
        );
        foreach ($item as $key => $val) {
            if (isset($this->supplier[$val->supplier])) {
                $string = "";
                $string = $val->code . ":" . $val->name . "=>";
                $string .= $val->description . ",Provided by:";
                $string .= $this->supplier[$val->supplier]['name'] . ":";
                $string .= $supplierStatus[$this->supplier[$val->supplier]['status']];
                $itemOption[$val->itemID] = $string;
            }
        }
        $this->item = $itemOption;
    }

    //新增PR項目
    public function insertPrDetail() {
        if ($this->input->post()) {
            $this->modify('purchaseDetail');
        }
    }

    private function groupPrDetail($tar, $securityCode) {
        $this->load->model("modify");
        //取得pr的id
        $sqlString = "SELECT * FROM %s WHERE securityCode='%s'";
        $query = $this->db->query(sprintf($sqlString, $tar, $securityCode));
        $result = $query->row();
        $target = $tar . 'ID';
        $id = $result->$target;
        //將pr id更新進prdetail
        $sqlString = "SELECT * FROM purchaseDetail WHERE securityCode='%s'";
        $query = $this->db->query(sprintf($sqlString, $securityCode));
        $data = array();
        $data['oper'] = 'edit';
        foreach ($query->result() as $key => $val) {
            $data['purchaseRequestID'] = $id;
            $data['id'] = $val->purchaseDetailID;
            $this->modify->modify('purchaseDetail', $data);
        }
        //echo $id;
    }

    //清除項目表單中未歸於PR的項目
    public function clearPRDetail() {
        $sqlString = "SELECT * FROM purchaseDetail WHERE purchaseRequestID=0";
        $unGroupItem = $this->db->query($sqlString);
        $this->load->model("modify");
        $data = array();
        foreach ($unGroupItem->result() as $key => $val) {
            $data['id'] = $val->purchaseDetailID;
            $data['oper'] = 'del';
            $this->modify->modify('purchaseDetail', $data);
        }
    }

    //設定程式基本參數
    private function _load() {
        $tableName = array();
        $tableName['mainTable'] = "purchaseRequest";
        $tableName['linkTable'] = array(
            'item' => 'item'
            , 'list' => 'purchaseList'
            , 'purchaseDetail' => 'purchaseDetail'
        );
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

        //取得供應商資料
        $supplierSqlString = "SELECT * FROM supplier";
        $supplierSql = $this->db->query($supplierSqlString);
        $supplier = array();

        //var_dump($supplierSql->result());

        foreach ($supplierSql->result() as $key => $val) {
            $supplier[$val->supplierID]['name'] = $val->name;
            $supplier[$val->supplierID]['status'] = $val->status;
        }
        $this->tableName = $tableName;
        $this->project = $project;
        $this->supplier = $supplier;
    }

}