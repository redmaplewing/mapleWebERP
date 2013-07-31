<?php

//class Login extends CI_Controller {	
class PurchaseOrder extends MY_Controller {

    //base Setting
    var $tableName = array();
    var $project = array();
    var $item = array();
    var $supplier = array();
    var $employee = array();

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
        $view = "purchaseOrder";

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
        $data['project'] = $this->project;
        $data['supplier'] = $this->supplier;
        $data['employee'] = $this->employee;
        $data['purchaseOrderLocal'] = $this->checkPermission('2', 'purchaseOrder', "purPurchaseOrderLocal");
        $data['purchaseOrderOversea'] = $this->checkPermission('2', 'purchaseOrder', "purPurchaseOrderOverseas");
        $data['purchaseOrderLocalControl'] = $this->checkPermission('3', 'purchaseOrder', "purPurchaseOrderLocal");
        $data['purchaseOrderOverseaControl'] = $this->checkPermission('3', 'purchaseOrder', "purPurchaseOrderOverseas");

        //var_dump($data);//驗證輸出陣列
        //取得請購單Purchase Request 資料
        $sqlString = "SELECT * FROM purchaseRequest WHERE status='0'";
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

    public function sendServiceData($type = 0, $progress = 0) {
        /*
          $progress-處理階段
          1. Waiting for approval => 有submitDate但沒有approved(approved=0)
          2. Arriving/In-Progress => 有submitDate也有approved(approved=成員id)
          3. Completed => 已完成，Status=1
         */
        //取得服務資料
        $infoData = array();
        $table = $this->tableName['mainTable'];
        $tableID = $table . "ID";
        $subQuery = "AND status ='0' ";
        switch ($progress) {
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
        $sqlString = "SELECT * FROM %s WHERE type=%s %s ORDER BY %s ASC";
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table, $type, $subQuery, $tableID);
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $infoData['column'] = array(
            "purchaseOrderNo"
            , "cDate"
            , "managerID"
            , "status"
            , "supplierID"
            , "purchase"
            , "payDate"
            , "totalAmt"
        );

        $result = $this->returnGridData($infoData);
        //var_dump($result);
        echo json_encode($result);
    }

    public function sendPoDetail($securityCode = 0, $supplier = 0) {
        //取得服務資料
        $infoData = array();
        $table = $this->tableName['linkTable']['purchaseDetail'];
        $tableID = $table . "ID";
        $sqlString = "SELECT a.*,b.* FROM %s as a inner join item as b WHERE a.securityCode='%s' and a.itemID=b.itemID ";
        if ($supplier != 0) {
            $sqlString .= " and b.supplier='" . $supplier . "'";
        }
        $sqlString .= " ORDER BY %s ASC";
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table, $securityCode, $tableID);
        //echo $infoData['baseSql'];
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $infoData['column'] = array(
            "No"
            , "code"
            , "name"
            , "cotegory"
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
    public function sendPRProcess($purchaseOrderID = 0) {
        if ($purchaseOrderID != 0) {
            //取得項目處理流程
            $infoData = array();
            $detailID = $this->input->get('id');
            //echo $detailId.",".$this->input->get('id');
            $sqlString = "SELECT * FROM purchaseDetail WHERE purchaseOrderID='%s' and purchaseDetailID=%s";
            $infoData['tableName'] = $this->tableName['linkTable']['purchaseDetail'];
            $infoData['baseSql'] = sprintf($sqlString, $purchaseOrderID, $detailID);
            //echo sprintf($sqlString,$purchaseRequestID,$detailID);
            $infoData['numLimit'] = 20;
            $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
            $infoData['column'] = array(
                "processes10"
                , "processes11"
                , "processes12"
                , "processes13"
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

    //取得項目接受資料
    public function sendPOReceiving($purchaseOrderID) {
        //取得服務資料
        $infoData = array();
        $table = $this->tableName['linkTable']['purchaseDetail'];
        $tableID = $table . "ID";
        $sqlString = "SELECT a.*,b.* FROM %s as a inner join item as b WHERE a.purchaseOrderID='%s' and a.itemID=b.itemID ORDER BY %s ASC";
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table, $purchaseOrderID, $tableID);
        //echo $infoData['baseSql'];
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $infoData['column'] = array(
            "No"
            , "code"
            , "name"
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
        $i = 0;
        //封裝查詢結果
        foreach ($query->result() as $row) {
            $menuTypeData = array();
            $data = "";
            $i = 1;
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
                            $data = "the user has been delete";
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
                            $sqlString = "SELECT * FROM plan WHERE planID=%s";
                            $result = $this->db->query(sprintf($sqlString, $row->$val));
                            $rs = $result->row();
                            $data = $rs->planNo;
                        } else {
                            $data = "";
                        }
                        break;
                    //依專案編號取得專案名稱
                    case "projectID":
                        $sqlString = "SELECT * FROM project WHERE projectID=%s";
                        $result = $this->db->query(sprintf($sqlString, $row->$val));
                        $rs = $result->row();
                        $data = $rs->projectNo;
                        break;
                    //自動產生流水號
                    case "No":
                        $data = $i;
                        break;
                    //計算總金額
                    case "totalAmt":
                        $sqlString = "SELECT a.*,b.* FROM purchaseDetail AS a INNER JOIN item AS b WHERE a.purchaseOrderID='%s' AND a.itemID=b.itemID";
                        $sqlString = sprintf($sqlString, $row->purchaseOrderID);
                        $query = $this->db->query($sqlString);
                        $total = "";
                        foreach ($query->result() as $k => $v) {
                            $total += ($v->qty * $v->unitCost);
                        }
                        $data = $total;
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
                    case "supplierID":
                        $data = $this->supplier[$row->$val]['name'];
                        break;
                    case "purchase":
                        if ($row->$val != '0') {
                            $data = isset($this->employee[$row->$val]) ? $this->employee[$row->$val] : "the user has been delete";
                        } else {
                            $data = "";
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
                    case "processes10":
                    case "processes11":
                    case "processes12":
                    case "processes13":
                        $sqlString = "SELECT * FROM purchaseOrder WHERE purchaseOrderID='%s'";
                        $query = $this->db->query(sprintf($sqlString, $row->purchaseOrderID));
                        $purchaseOrder = $query->row();
                        if ($row->$val == "0000-00-00" && $purchaseOrder->status == 0) {
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
        }

        $i++;
        $result = array(
            'records' => count($reInfoData),
            'total' => ceil($infoNum / $numLimit),
            'page' => $page,
            'rows' => $reInfoData
        );

        //包json編碼後傳送
        return $result;
    }

    public function sendInvoceNo() {
        $this->load->model("modify");
        $this->modify->modify('purchaseDetail', $this->input->post());
        echo 'true';
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

    //查詢項目資料並回傳
    public function getPRData() {
        $table = "purchaseOrder";
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
        $post['managerID'] = $this->session->userdata('employeeID');
        var_dump($post);
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

    public function getPurchaseRequestData() {
        $purchaseRequestID = $this->input->post('id');
        $sqlString = 'SELECT * FROM purchaseRequest WHERE purchaseRequestID="%s"';
        //echo sprintf($sqlString,$purchaseRequestID);
        $query = $this->db->query(sprintf($sqlString, $purchaseRequestID));
        $result = $query->row();
        $sqlString = "SELECT drawingNo FROM drawing WHERE drawingID='%s'";
        $query = $this->db->query(sprintf($sqlString, $result->planID));
        if ($query->num_rows() > 0) {
            $plan = $query->row();
            $planNo = $plan->drawingNo;
        } else {
            $planNo = "";
        }
        //var_dump($plan);
        $purchaseRequestData = array();
        $purchaseRequestData['projectName'] = $this->project[$result->projectID]['name'];
        $purchaseRequestData['projectID'] = $result->projectID;
        $purchaseRequestData['planName'] = $planNo;
        $purchaseRequestData['securityCode'] = $result->securityCode;

        echo json_encode($purchaseRequestData);
    }

    public function groupItemToPo() {
        //載入資料寫入模組
        $this->load->model("modify");

        //var_dump($this->input->post());
        $post = $this->input->post();
        //取得目標的資料
        $sqlString = "SELECT a.* FROM %s AS a INNER JOIN item AS b WHERE a.securityCode='%s' AND a.itemID = b.itemID AND b.supplier='%s'";
        $sqlString = sprintf($sqlString, $this->tableName['linkTable']['purchaseDetail'], $post['securityCode'], $post['supplierID']);
        //echo $sqlString;
        $query = $this->db->query($sqlString);
        $result = $query->result();

        //取得po編號
        $sqlString = "SELECT * FROM %s WHERE securityCode='%s' and supplierID='%s'";
        $sqlString = sprintf($sqlString, $this->tableName['mainTable'], $post['securityCode'], $post['supplierID']);
        $query = $this->db->query($sqlString);
        $PO = $query->row();
        $postData = array();
        foreach ($result as $key => $val) {
            $postData['oper'] = 'edit';
            $postData['purchaseOrderID'] = $PO->purchaseOrderID;
            $postData['id'] = $val->purchaseDetailID;
            //寫入資料庫
            $this->modify->modify($this->tableName['linkTable']['purchaseDetail'], $postData);
            var_dump($postData);
        }
        //var_dump($postData);	
    }

    //設定程式基本參數
    private function _load() {
        $tableName = array();
        $tableName['mainTable'] = "purchaseOrder";
        $tableName['linkTable'] = array(
            'purchaseDetail' => 'purchaseDetail'
        );
        //取得專案資料
        $projSqlString = "SELECT * FROM project";
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
            $supplier[$val->supplierID]['no'] = $val->supplierNo;
            $supplier[$val->supplierID]['status'] = $val->status;
        }

        //取得成員資料
        $sqlString = "SELECT * FROM employee WHERE enable='1'";
        $dbQuery = $this->db->query($sqlString);
        $employee = array();
        foreach ($dbQuery->result() as $key => $val) {
            $employee[$val->employeeID] = $val->nameFirst . $val->nameLast;
        };

        $this->tableName = $tableName;
        $this->project = $project;
        $this->supplier = $supplier;
        $this->employee = $employee;
    }

}