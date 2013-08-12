<?php

//class Login extends CI_Controller {	
class PruInfoRegistry extends MY_Controller {

    //base Setting
    var $tableName = array();
    var $supplier = array();
    var $employee = array();

    public function __construct() {
        parent::__construct(); //繼承父類別的涵數
        $this->_load();
    }

    public function index($menuID) {
        //var_dump(file_exists('http://mapleweberp.localhost/upload/1'));
        //建構基本參數設定
        $this->_load();
        //var_dump($this->tableName);//驗證關聯資料庫陣列
        //var_dump($this->session->all_userdata());
        //載入基本套件、設定頁面基本資訊
        $this->lang->load('main', $this->session->userdata('lang')); //戴入語言套件
        $data['loginInfo'] = $this->session->all_userdata();
        $data['tableName'] = $this->tableName;
        $view = "purInfoRegistry";
        //var_dump($this->supplier);
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
        $data['supplier'] = $this->supplier;
        $data['employee'] = $this->employee;
        $data['pruInfoRegistry'] = $this->checkPermission('3', 'pruInfoRegistry');
        //var_dump($data);//驗證輸出陣列

        $this->load->view('header', $data);
        $this->load->view('nav', $data);
        $this->load->view($view, $data);
        $this->load->view('footer', $data);
    }

    public function sendQueryData() {//取得選單類別資料
        //設定jqGrid頁數資訊
        $page = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $numLimit = 20;
        $startRow = $page * $numLimit - $numLimit;
        $baseSql = "SELECT * FROM %s where type=1";
        $supplier = $this->supplier;

        //$numString = sprintf("SELECT * FROM %s",$this->tableName);
        $rowNum = $this->db->query(sprintf($baseSql, $this->tableName['mainTable']));
        $sqlString = sprintf($baseSql . " order by code asc Limit %s,%s", $this->tableName['mainTable'], $startRow, $numLimit);
        //echo $sqlString;

        $query = $this->db->query($sqlString);
        //var_dump($query->result());
        $infoData = array();
        $dataArray = array(
            "code"
            , "name"
            , "description"
            , "cotegory"
            , "supplier"
            , "UoM"
            , "unitCost"
                /* ,"minimumLevel"
                  ,"defaultQty"
                  ,"location"
                  ,"attachment" */
        );
        foreach ($query->result() as $row) {
            $menuTypeData = array();
            foreach ($dataArray as $val) {
                $result = "";
                if ($row->$val != '' && $row->$val != '0') {
                    switch ($val) {
                        case "supplier":
                            if (isset($supplier[$row->$val])) {
                                $result = $supplier[$row->$val];
                            } else {
                                $result = '';
                            }
                            break;
                        case "location":
                            $result = $val === 0 ? "Local" : "Overseas";
                            break;
                        default:
                            $result = $row->$val;
                            break;
                    }
                }
                array_push($menuTypeData, $result);
            }
            //var_dump($menuTypeData);
            $targetID = $this->tableName['mainTable'] . "ID";
            $infoData[] = array(
                "id" => $row->$targetID
                , "cell" => $menuTypeData
            );
        }

        $result = array(
            'records' => count($infoData),
            'total' => ceil($rowNum->num_rows / $numLimit),
            'page' => $page,
            'rows' => $infoData
        );

        //回傳json陣列
        echo json_encode($result);
        //return json_encode($result);
    }

    public function sendSuppData() {
        //取得供應商資料
        $infoData = array();
        $table = $this->tableName['linkTable']['supplier'];
        $tableID = $table . "ID";
        $sqlString = "SELECT * FROM %s ORDER BY %s ASC";
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table, $tableID);
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $infoData['column'] = array(
            "supplierNo", "name", "nameFirst", "nameLast", "gender", "position", "email", "bussPhone", "status"
        );

        $result = $this->returnGridData($infoData);
        //var_dump($result);
        echo json_encode($result);
    }

    public function sendServiceData() {
        //取得服務資料
        $infoData = array();
        $table = $this->tableName['mainTable'];
        $tableID = $table . "ID";
        $sqlString = "SELECT * FROM %s WHERE type=2 ORDER BY %s ASC";
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table, $tableID);
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $infoData['column'] = array(
            "code", "name", "description", "cotegory", "supplier", "unitCost"
        );

        $result = $this->returnGridData($infoData);
        //var_dump($result);
        echo json_encode($result);
    }

    public function sendPriceHistory($sn = 0) {
        //取得服務資料
        $infoData = array();
        $table = $this->tableName['linkTable']['priceHistory'];
        $tableID = $table . "ID";
        $sqlString = "SELECT * FROM %s WHERE link=%s ORDER BY %s ASC";
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table, $sn, $tableID);
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $infoData['column'] = array(
            "cDate", "previousPrice", "priceDifference", "remark"
        );

        $result = $this->returnGridData($infoData);
        //var_dump($result);
        echo json_encode($result);
    }

    //採購歷程
    public function sendPurHistory($sn = 0) {
        //取得服務資料
        $infoData = array();
        $table = $this->tableName['linkTable']['purchaseDetail'];
        $tableID = $table . "ID";
        $sqlString = "SELECT * FROM %s WHERE itemID='%s' AND inventoryPost='1' ORDER BY %s ASC";
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table, $sn, $tableID);
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $infoData['column'] = array(
            "purchaseOrderNo", "poCDate", "poSupplier", "qty", "amount", "receivedDate", "remark"
        );

        $result = $this->returnGridData($infoData);
        //var_dump($result);
        echo json_encode($result);
    }

    //採購歷程
    public function sendUsageHistory($sn = 0) {
        //取得服務資料
        $infoData = array();
        $table = $this->tableName['linkTable']['requestDetail'];
        $tableID = $table . "ID";
        $sqlString = "SELECT * FROM %s WHERE itemID='%s' AND inventoryPost='1' ORDER BY %s ASC";
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table, $sn, $tableID);
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $infoData['column'] = array(
            "materialRequestNo", "requestDate", "projectCode", "planNo", "qty", "amount", "materialRemark"
        );

        $result = $this->returnGridData($infoData);
        //var_dump($result);
        echo json_encode($result);
    }

    //取得項目儲存狀況資料(含需叫貨)--處理中06112013

    public function inventoryCondition($type = '0') {
        //取得服務資料
        $infoData = array();
        $table = $this->tableName['linkTable']['itemInventory'];
        $tableID = $table . "ID";
        $sqlString = "SELECT a.*,b.*,a.warehouseID as 'warehouseID' FROM %s AS a INNER JOIN item AS b WHERE a.itemID=b.itemID AND a.warehouseID!='0'";
        //echo sprintf($sqlString,$table)."<br />";
        if ($type == '1') {
            $query = $this->db->query(sprintf($sqlString, $table));
            $result = $query->result();
            //var_dump($result);
            $need = array();
            foreach ($result as $key => $val) {
                $onOrder = $this->getOnOrder($val->itemID, $val->warehouseID);
                if ($onOrder['num'] != 0) {
                    $currentLevel = $onOrder['orderNum']->onOrder + $val->onHand;
                } else {
                    $currentLevel = $val->onHand;
                }
                if ($currentLevel < $val->minimumLevel) {
                    array_push($need, $val->itemInventoryID);
                }
            }
            //var_dump($need);
            $needString = "";
            foreach ($need as $key => $val) {
                $needString .= $val;
                /* echo "<br />count=>need=".count($need);
                  echo "<br />nows key=".$key; */
                if ($key < (count($need) - 1) && count($need) != 1) {
                    $needString .=",";
                }
            }
            //echo $needString;
            $sqlString .= "AND itemInventoryID IN(" . $needString . ")";
        }
        $infoData['tableName'] = $table;
        $infoData['baseSql'] = sprintf($sqlString, $table);
        $infoData['numLimit'] = 20;
        $infoData['page'] = $this->input->get('page') == "" ? 1 : $this->input->get('page');
        $infoData['column'] = array(
            "code", "name", "description", "onHand", "allocated",
            "avalliable", "onOrder", "currentLevel", "minimumLevel", "warehouseID"
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
        //var_dump($query->result());
        $reInfoData = array();
        //封裝查詢結果
        foreach ($query->result() as $row) {
            $menuTypeData = array();
            foreach ($infoData['column'] as $val) {
                //array_push($menuTypeData,$row->$val);
                $result = "";
                switch ($val) {
                    case "purchaseOrderNo":
                        $sqlString = "SELECT * FROM purchaseOrder WHERE purchaseOrderID='%s'";
                        $query = $this->db->query(sprintf($sqlString, $row->purchaseOrderID));
                        $queryResult = $query->row();
                        $result = $queryResult->purchaseOrderNo;
                        break;
                    case "materialRequestNo":
                        $sqlString = "SELECT * FROM materialRequest WHERE materialRequestID='%s'";
                        $query = $this->db->query(sprintf($sqlString, $row->materialRequestID));
                        $queryResult = $query->row();
                        $result = $queryResult->materialRequestNo;
                        break;
                    case "poCDate":
                        $sqlString = "SELECT * FROM purchaseOrder WHERE purchaseOrderID='%s'";
                        $query = $this->db->query(sprintf($sqlString, $row->purchaseOrderID));
                        $queryResult = $query->row();
                        $result = $queryResult->cDate;
                        break;
                    case "amount":
                        $sqlString = "SELECT * FROM item WHERE itemID='%s'";
                        $query = $this->db->query(sprintf($sqlString, $row->itemID));
                        $queryResult = $query->row();
                        $result = $row->qty * $queryResult->unitCost;
                        break;
                    case "supplier":
                        $result = $this->supplier[$row->$val];
                        break;
                    case "poSupplier":
                        $sqlString = "SELECT * FROM purchaseOrder WHERE purchaseOrderID='%s'";
                        $query = $this->db->query(sprintf($sqlString, $row->purchaseOrderID));
                        $queryResult = $query->row();
                        $result = $this->supplier[$queryResult->supplierID];
                        break;
                    case "remark":
                        $sqlString = "SELECT * FROM purchaseOrder WHERE purchaseOrderID='%s'";
                        $query = $this->db->query(sprintf($sqlString, $row->purchaseOrderID));
                        $queryResult = $query->row();
                        $result = $queryResult->remark;
                        break;
                    case "materialRemark":
                        $sqlString = "SELECT * FROM materialRequest WHERE materialRequestID='%s'";
                        $query = $this->db->query(sprintf($sqlString, $row->materialRequestID));
                        $queryResult = $query->row();
                        $result = $queryResult->remark;
                        break;
                    case "location":
                        $result = $row->$val == '0' ? "Local" : "Overseas";
                        break;
                    case "gender":
                        $result = $row->$val == '0' ? "Male" : "Female";
                        break;
                    case "status":
                        $result = $row->$val == '0' ? "Active" : "Discontinued";
                        break;
                    case "allocated":
                        $allocatedNum = $this->getAllocated($row->itemID, $row->warehouseID);
                        $result = $allocatedNum;
                        break;
                    case "avalliable":
                        $allocatedNum = $this->getAllocated($row->itemID, $row->warehouseID);
                        $avalliable = $row->onHand - $allocatedNum;
                        $result = $avalliable;
                        break;
                    case "onOrder":
                        $onOrder = $this->getOnOrder($row->itemID, $row->warehouseID);
                        if ($onOrder['num'] != 0) {
                            $onOrderNum = $onOrder['orderNum']->onOrder;
                        } else {
                            $onOrderNum = '0';
                        }
                        $result = $onOrderNum;
                        break;
                    case "currentLevel":
                        $onOrder = $this->getOnOrder($row->itemID, $row->warehouseID);
                        if ($onOrder['num'] != 0) {
                            $onOrderNum = $onOrder['orderNum']->onOrder;
                        } else {
                            $onOrderNum = 0;
                        }
                        $result = $row->onHand + $onOrderNum;
                        break;
                    case "warehouseID":
                        $sqlString = "SELECT * FROM warehouse WHERE warehouseID='%s'";
                        $query = $this->db->query(sprintf($sqlString, $row->$val));
                        $warehouseResult = $query->row();
                        if ($query->num_rows() > 0) {
                            $result = $warehouseResult->name;
                        }
                        break;
                    case "requestDate":
                        $sqlString = "SELECT * FROM materialRequest WHERE materialRequestID='%s'";
                        $query = $this->db->query(sprintf($sqlString, $row->materialRequestID));
                        $queryResult = $query->row();
                        $result = $queryResult->cDate;
                        break;
                    case "projectCode":
                        $sqlString = "SELECT * FROM project WHERE projectID=(SELECT projectID FROM materialRequest WHERE materialRequestID='%s')";
                        $query = $this->db->query(sprintf($sqlString, $row->materialRequestID));
                        $queryResult = $query->row();
                        $result = $queryResult->projectNo;
                        break;
                    case "planNo":
                        $sqlString = "SELECT * FROM drawing WHERE drawingID=(SELECT planID FROM materialRequest WHERE materialRequestID='%s')";
                        $query = $this->db->query(sprintf($sqlString, $row->materialRequestID));
                        $queryResult = $query->row();
                        $result = $queryResult->drawingNo;
                        break;
                    default:
                        $result = $row->$val;
                        break;
                };
                $result = $result == '0' ? "0" : $result;
                array_push($menuTypeData, $result);
            }

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

    //取得項目下訂數
    private function getOnOrder($itemID, $warehouseID) {
        //echo "orderWarehouseID= >".$warehouseID."<br />";
        $sqlString = "SELECT SUM(qty) AS onOrder FROM purchaseDetail WHERE itemID='%s' AND purchaseRequestID IN(SELECT purchaseRequestID FROM purchaseRequest WHERE projectID=(SELECT projectID FROM warehouse WHERE warehouseID='%s') AND status!='1' AND inventoryPost != '1')";
        $query = $this->db->query(sprintf($sqlString, $itemID, $warehouseID));
        $result['num'] = $query->num_rows();
        if ($query->num_rows() > 0) {
            $result['orderNum'] = $query->row();
        }
        //echo sprintf($sqlString,$itemID,$warehouseID);
        return $result;
    }

    //取得項目使用數
    private function getAllocated($itemID, $warehouseID) {
        //echo $warehouseID."<br />";
        $sqlString = "SELECT SUM(qty) AS allocated FROM requestDetail WHERE itemID='%s' AND materialRequestID IN(SELECT materialRequestID FROM materialRequest WHERE projectID=(SELECT projectID FROM warehouse WHERE warehouseID='%s') AND inventoryPost = '1')";
        //echo sprintf($sqlString,$itemID,$warehouseID)."<br />";
        $query = $this->db->query(sprintf($sqlString, $itemID, $warehouseID));
        //$result['num'] = $query->num_rows();
        /* if($query->num_rows() > 0){
          $result = $query->row();
          //return $result;
          } */
        $result = $query->row();
        if ($query->num_rows() != 0 && isset($result->allocated)) {

            $allocatedNum = $result->allocated;
        } else {
            $allocatedNum = '0';
        }
        return $allocatedNum;
    }

    //查詢項目資料並回傳
    public function getItemData($table) {
        $tableID = $table . "ID";
        $sqlString = sprintf("SELECT * FROM %s WHERE %s=%s", $table, $tableID, $this->input->post('ID'));
        $row = $this->db->query($sqlString);
        $result = $row->row_array();
        if ($table == 'supplier') {
            $file = FCPATH . "upload/" . $result['photo'];
            if (file_exists($file)) {
                $result['photo'] = base_url() . "upload/" . $result['photo'];
            } else {                
                $result['photo'] = base_url() . "images/unknown-person.jpg";
            }
        };
        if ($table == 'item') {
            $file = FCPATH . "upload/" . $result['attachment'];
            if (file_exists($file)) {
                $result['attachment'] = base_url() . "upload/" . $result['attachment'];
            } else {
                $result['attachment'] = base_url() . "images/PRODUCT-icon.jpg";
            }
        };
        echo json_encode($result);
        //$this->session->set_userdata('thisAjaxPost',$this->input->post());//驗證post資料
        //$this->session->set_userdata('thisAjaxQuery',$result);//驗證Query資料
    }

    //資料庫操作
    public function modify($tar) {
        if ($tar == '') {
            $tar = $this->tableName['mainTable'];
        }
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = 'true';

        $this->load->library('upload', $config);
        switch ($tar) {
            case "supplier":
                $file_name = "photo";
                break;
            case "item":
            default:
                $file_name = "attachment";
                break;
        }
        $this->upload->do_upload($file_name);
        $uploadData = $this->upload->data();
        //var_dump($uploadData);
        //echo "this is post page";
        //載入資料寫入模組
        $this->load->model("modify");
        //取得表單傳入資料
        $post = $this->input->post();
        if ($uploadData['file_name'] != '') {
            switch ($tar) {
                case 'supplier':
                    $post['photo'] = $uploadData['file_name'];
                    break;
                case 'item':
                default:
                    $post['attachment'] = $uploadData['file_name'];
                    break;
            }
        }
        $post['managerID'] = $this->session->userdata('employeeID');
        //var_dump($post);
        $target = $tar;
        //var_dump($post);
        if ($post['oper'] == 'edit' && $tar == $this->tableName['mainTable']) {
            $dataDetail = array(
                "table" => $tar
                , "field" => "unitCost"
                , "sn" => $post['id']
                , "fieldData" => $post['unitCost']
            );
            $check = $this->modify->checkDataDifference($dataDetail);
            if ($check['difference']) {
                $data = array(
                    "cDate" => date("Y-m-d h:i:s", now())
                    , "previousPrice" => $check['previousData']
                    , "priceDifference" => $post['unitCost'] - $check['previousData']
                    , "oper" => "add"
                    , "link" => $post['id']
                );
                $this->modify->modify('priceHistory', $data);
            }
        }


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
        $tableName['mainTable'] = "item";
        $tableName['linkTable'] = array(
            'supplier' => 'supplier'
            , 'priceHistory' => 'priceHistory'
            , 'purchaseDetail' => 'purchaseDetail'
            , 'itemInventory' => 'itemInventory'
            , 'requestDetail' => 'requestDetail'
        );

        //取得供應商資料
        $sqlString = "SELECT * FROM supplier WHERE status=0 ORDER by name";
        $dbQuery = $this->db->query($sqlString);
        $supplier = array();
        foreach ($dbQuery->result() as $key => $val) {
            $supplier[$val->supplierID] = $val->name;
        }
        //取得成員資料
        $sqlString = "SELECT * FROM employee WHERE enable='1'";
        $dbQuery = $this->db->query($sqlString);
        $employee = array();
        foreach ($dbQuery->result() as $key => $val) {
            $employee[$val->employeeID] = $val->nameFirst . $val->nameLast;
        };
        $this->employee = $employee;
        $this->supplier = $supplier;
        $this->tableName = $tableName;
    }

}