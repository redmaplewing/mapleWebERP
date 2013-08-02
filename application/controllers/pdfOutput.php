<?php

//class Login extends CI_Controller {	
class PdfOutput extends MY_Controller {

    public $tableTitle = '';
    public $tableInformation = '';
    public $tableList = '';
    public $tableRemark = '';
    public $tableSign = '';
    public $employee = '';

    public function __construct() {
        parent::__construct(); //繼承父類別的涵數
        $this->_load();
    }

    public function index($target, $targetID) {
//echo 'pdf output test';
        $this->load->library('Pdf');
        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 003');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

// ---------------------------------------------------------
// set font
        $pdf->SetFont('times', '', 12);

// add a page
        $pdf->AddPage();

// set some text to print
        $txt = $this->getTargetData($target, $targetID);

// print a block of text using Write()
        //$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
        $pdf->writeHTML($txt, true, 10, true, true);
// ---------------------------------------------------------
//Close and output PDF document
        $pdf->Output('example_003.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
    }

    private function getTargetData($target, $targetID) {
        $text = "";
        switch ($target) {
            case 'po'://取得採購單資料(國內/海外)Purchase Order
                $this->getPOData($targetID);
                break;
            case 'mr'://取得調貨單資料Material Request
                $this->getMRData($targetID);
                break;
            case 'gr': //取得退貨單資料Goods Return
                $this->getGRData($targetID);
                break;
            //取得維護單資料
            case 'rr'://維修
            case 'rc'://校準
            case 'rd'://出售
                $this->getTMRData($targetID);
                break;
            default:
                $text = "";
                break;
        }
        /*
         * pdf內容=
         * 表格表頭$this->tableTitle + 
         * 表格資訊$this->tableInformation + 
         * 表格列表$this->tableList + 
         * 表格備註$this->tableRemark +
         * 表格簽名處$this->tableSign
         */
        //$text = $this->tableTitle . $this->tableInformation . $this->tableList . $this->tableRemark . $this->tableSign;
        $text = '<table>
            <tr>
                <td  height="50">' . $this->tableTitle . '</td>
            </tr>
            <tr>
                <td height="90">' . $this->tableInformation . '</td>
            </tr>
            <tr>
                <td>' . $this->tableList . '</td>
            </tr>
            <tr>
                <td height="140">' . $this->tableRemark . '</td>
            </tr>
            <tr>
                <td height="80">' . $this->tableSign . '</td>
            </tr>
        </table>';
        return $text;
    }

    //取得採購單資料(國內/海外)Purchase Order
    private function getPOData($targetID) {
        $sqlString = "SELECT 
            a.purchaseOrderNo,
            b.purchaseRequestNo,
            c.projectNo,            
            e.supplierNo,
            a.cDate,
            e.name,
            a.eDate, 
            a.type,
            a.remark,
            b.planID, 
            a.managerID,  
            a.purchase, 
            a.check, 
            a.approved, 
            a.purchaseOrderID 
            FROM purchaseOrder AS a 
            INNER JOIN purchaseRequest AS b 
            INNER JOIN project As c              
            INNER JOIN supplier AS e
            WHERE a.purchaseOrderID='%s'
            AND a.purchaseRequestID = b.purchaseRequestID
            AND a.projectID = c.projectID            
            AND a.supplierID=e.supplierID";
        /*
         * 採購單不一定會相依圖表
         * 移除兩句sql
         * d.drawingNo,
         * INNER JOIN drawing AS d
         * AND b.planID = d.drawingID
         */
        $Query = $this->db->query(sprintf($sqlString, $targetID));
        $purchaseqQuery = $Query->row();
        $drawingSql = "SELECT * FROM drawing WHERE drawingID='%s'";
        $drawingQuery = $this->db->query(sprintf($drawingSql, $purchaseqQuery->planID));
        $drawingNo = "";
        if ($drawingQuery->num_rows > 0) {
            $drawingResult = $drawingQuery->row();
            $drawingNo = $drawingResult->drawingNo;
        }
        //echo sprintf($sqlString,$targetID);
        //var_dump($purchaseqQuery);
        //建立採購單標頭
        $tableTitle = "";
        switch ($purchaseqQuery->type) {
            case '1'://海外
                $tableTitle = '<H1 style="text-align:center">OVERSEAS PURCHASE ORDER SLIP</H1>';
                break;
            case '0'://國內
            default:
                $tableTitle = '<H1 style="text-align:center">LOCAL PURCHASE ORDER SLIP</H1>';
                break;
        }
        //建立表格資訊
        //取得pr資料
        $tableInformation = '';
        $tableInformation = '<br /><table style="width:640px;">
            <tr>
                <td width="120">P.O. No:</td>
                <td width="200">' . $purchaseqQuery->purchaseOrderNo . '</td>
                <td width="120">P.R./T.M. No:</td>
                <td width="200">' . $purchaseqQuery->purchaseRequestNo . '</td>
            </tr>
            <tr>
                <td>Project Code:</td>
                <td>' . $purchaseqQuery->projectNo . '</td>
                <td>Plan No:</td>
                <td>' . $drawingNo . '</td>
            </tr>
            <tr>
                <td>Supplier Code:</td>
                <td>' . $purchaseqQuery->supplierNo . '</td>
                <td>Creation Date:</td>
                <td>' . $purchaseqQuery->cDate . '</td>
            </tr>
            <tr>
                <td>Supplier Name:</td>
                <td>' . $purchaseqQuery->name . '</td>
                <td>Expected Date:</td>
                <td>' . $purchaseqQuery->eDate . '</td>
            </tr>
        </table>';

        //設定表格列表
        $tableList = '<table border="1" style="margin-top:20px;"><tr>
            <th>No</th>
            <th width="80">Code</th>
            <th width="100">Product/Service Name</th>
            <th>Description</th>
            <th>Category</th>
            <th width="50">Qty</th>
            <th>UoM</th>
            <th>Unit Cost</th>
            <th>Total Amount</th>
            </tr>';
        $tableListOption = ""; //從資料庫取出列表用
        $detailSql = "SELECT * FROM purchaseDetail AS a
                INNER JOIN item AS b
                WHERE
                a.purchaseOrderID='%s' AND
                a.itemID = b.itemID";
        $detailQuery = $this->db->query(sprintf($detailSql, $purchaseqQuery->purchaseOrderID));
        if ($detailQuery->num_rows > 0) {
            $purchaseDetail = $detailQuery->result();
            $count = 1;
            foreach ($purchaseDetail as $val) {
                $tableListOption[$count] = $val;
                $count++;
            }
        }
        $orderTotalAmount = "";
        for ($optCount = 1; $optCount <= 20; $optCount++) {
            $itemCode = ""; //產品/服務編號
            $itemName = ""; //產品/服務名稱
            $itemDescription = ""; //產品/服務描述
            $itemCategory = ""; //產品/服務種類
            $itemQty = ""; //產品/服務數量
            $itemUoM = ""; //產品/服務單位
            $itemUnitCost = ""; //產品/服務單位成本
            $itemTotalAmount = ""; //產品/ 服務總成本(單位成本*數量)
            if (isset($tableListOption[$optCount])) {
                $itemCode = $tableListOption[$optCount]->code;
                $itemName = $tableListOption[$optCount]->name;
                $itemDescription = $tableListOption[$optCount]->description;
                $itemCategory = $tableListOption[$optCount]->cotegory;
                $itemQty = $tableListOption[$optCount]->qty;
                $itemUoM = $tableListOption[$optCount]->UoM;
                $itemUnitCost = $tableListOption[$optCount]->unitCost;
                $itemTotalAmount = $tableListOption[$optCount]->qty * $tableListOption[$optCount]->unitCost;
            }
            //加總總價
            $orderTotalAmount += $itemTotalAmount;
            $tableList .= '<tr>
                <td>' . $optCount . '</td>
                <td>' . $itemCode . '</td>
                <td>' . $itemName . '</td>
                <td>' . $itemDescription . '</td>
                <td>' . $itemCategory . '</td>
                <td>' . $itemQty . '</td>
                <td>' . $itemUoM . '</td>
                <td>' . $itemUnitCost . '</td>
                <td>' . $itemTotalAmount . '</td>
            </tr>';
        }
        $tableList .="</table>";
        //計算總價
        $tableList .= '<span style="text-align:right">GRAND TOTAL: $' . $orderTotalAmount . '</span><br />';
        //設定表格備註
        $tableRemark = "Remark:<br />" . $purchaseqQuery->remark;
        //設定表格簽名處
        //填表人
        $prepared = "";
        if (isset($this->employee[$purchaseqQuery->managerID])) {
            $prepared = $this->employee[$purchaseqQuery->managerID]['name'] . '(' . $this->employee[$purchaseqQuery->managerID]['position'] . ')';
        }
        //採購者
        $purchase = "";
        if (isset($this->employee[$purchaseqQuery->purchase])) {
            $purchase = $this->employee[$purchaseqQuery->purchase]['name'] . '(' . $this->employee[$purchaseqQuery->purchase]['position'] . ')';
        }
        //核表人
        $check = "";
        if (isset($this->employee[$purchaseqQuery->check])) {
            $check = $this->employee[$purchaseqQuery->check]['name'] . '(' . $this->employee[$purchaseqQuery->check]['position'] . ')';
        }
        //負責人
        $approved = "";
        if (isset($this->employee[$purchaseqQuery->approved])) {
            $approved = $this->employee[$purchaseqQuery->approved]['name'] . '(' . $this->employee[$purchaseqQuery->approved]['position'] . ')';
        }
        $tableSign = '<table border="1" style="text-align:center">
            <tr>
            <td height="100">
                Prepared by:<br />
                ' . $prepared . '
            </td>
            <td>
                To be Purchased by:<br />
                ' . $purchase . '
            </td>
            <td>
                Checked by:<br />
                ' . $check . '
            </td>
            <td>
                Approved by:<br />
                ' . $approved . '
            </td>
            </tr>
        </table>';
        $this->tableTitle = $tableTitle; //設定表頭
        $this->tableInformation = $tableInformation; //設定表格資訊
        $this->tableList = $tableList; //設定表格列表
        $this->tableRemark = $tableRemark; //設定表格備註
        $this->tableSign = $tableSign; //設定表格簽名
    }

    //取得調貨單資料Material Request
    private function getMRData($targetID) {
        $sqlString = "SELECT 
            a.materialRequestNo
            ,b.projectNo
            ,b.name
            ,b.clientName
            ,a.planID
            ,a.cDate
            ,a.eDate
            ,a.materialRequestID
            ,a.remark
            ,a.managerID
            ,a.checked
            ,a.approve
            FROM materialRequest AS a 
            INNER JOIN project As b              
            WHERE a.materialRequestID='%s'
            AND a.projectID = b.projectID";

        /*
         * 採購單不一定會相依圖表
         * 移除兩句sql
         * d.drawingNo,
         * INNER JOIN drawing AS d
         * AND b.planID = d.drawingID
         */
        $Query = $this->db->query(sprintf($sqlString, $targetID));
        $materialQuery = $Query->row();
        //取得圖表
        $drawingSql = "SELECT * FROM drawing WHERE drawingID='%s'";
        $drawingQuery = $this->db->query(sprintf($drawingSql, $materialQuery->planID));
        $drawingNo = "";
        if ($drawingQuery->num_rows > 0) {
            $drawingResult = $drawingQuery->row();
            $drawingNo = $drawingResult->drawingNo;
        }

        //echo sprintf($sqlString,$targetID);
        //var_dump($purchaseqQuery);
        //建立採購單標頭
        $tableTitle = '<H1 style="text-align:center">MATERIAL REQUEST SLIP</H1>';

        //建立表格資訊
        //取得pr資料
        $tableInformation = '';
        $tableInformation = '<br /><table style="width:640px;">
            <tr>
                <td width="120">M.R. No:</td>
                <td width="200">' . $materialQuery->materialRequestNo . '</td>
                <td width="120">Plan No:</td>
                <td width="200">' . $drawingNo . '</td>
            </tr>
            <tr>
                <td>Project Code:</td>
                <td>' . $materialQuery->projectNo . '</td>
                <td>Creation Date</td>
                <td>' . $materialQuery->cDate . '</td>
            </tr>
            <tr>
                <td>Project Name:</td>
                <td>' . $materialQuery->name . '</td>
                <td>Expected Date:</td>
                <td>' . $materialQuery->eDate . '</td>
            </tr>
            <tr>
                <td>Customer Name:</td>
                <td>' . $materialQuery->clientName . '</td>
                <td></td>
                <td></td>
            </tr>
        </table>';

        //設定表格列表
        $tableList = '<table border="1" style="margin-top:20px;"><tr>
            <th>No</th>
            <th width="80">Code</th>
            <th width="100">Product/Service Name</th>
            <th>Description</th>
            <th>Category</th>
            <th width="50">Qty</th>
            <th>UoM</th>
            <th>Unit Cost</th>
            <th>Total Amount</th>
            </tr>';
        $tableListOption = ""; //從資料庫取出列表用
        $detailSql = "SELECT * FROM requestDetail AS a
                INNER JOIN item AS b
                WHERE
                a.materialRequestID='%s' AND
                a.itemID = b.itemID";
        $detailQuery = $this->db->query(sprintf($detailSql, $materialQuery->materialRequestID));
        if ($detailQuery->num_rows > 0) {
            $requestDetail = $detailQuery->result();
            $count = 1;
            foreach ($requestDetail as $val) {
                $tableListOption[$count] = $val;
                $count++;
            }
        }
        $orderTotalAmount = "";
        for ($optCount = 1; $optCount <= 20; $optCount++) {
            $itemCode = ""; //產品/服務編號
            $itemName = ""; //產品/服務名稱
            $itemDescription = ""; //產品/服務描述
            $itemCategory = ""; //產品/服務種類
            $itemQty = ""; //產品/服務數量
            $itemUoM = ""; //產品/服務單位
            $itemUnitCost = ""; //產品/服務單位成本
            $itemTotalAmount = ""; //產品/ 服務總成本(單位成本*數量)
            if (isset($tableListOption[$optCount])) {
                $itemCode = $tableListOption[$optCount]->code;
                $itemName = $tableListOption[$optCount]->name;
                $itemDescription = $tableListOption[$optCount]->description;
                $itemCategory = $tableListOption[$optCount]->cotegory;
                $itemQty = $tableListOption[$optCount]->qty;
                $itemUoM = $tableListOption[$optCount]->UoM;
                $itemUnitCost = $tableListOption[$optCount]->unitCost;
                $itemTotalAmount = $tableListOption[$optCount]->qty * $tableListOption[$optCount]->unitCost;
            }
            //加總總價
            $orderTotalAmount += $itemTotalAmount;
            $tableList .= '<tr>
                <td>' . $optCount . '</td>
                <td>' . $itemCode . '</td>
                <td>' . $itemName . '</td>
                <td>' . $itemDescription . '</td>
                <td>' . $itemCategory . '</td>
                <td>' . $itemQty . '</td>
                <td>' . $itemUoM . '</td>
                <td>' . $itemUnitCost . '</td>
                <td>' . $itemTotalAmount . '</td>
            </tr>';
        }
        $tableList .="</table>";
        //計算總價
        $tableList .= '<span style="text-align:right">GRAND TOTAL: $' . $orderTotalAmount . '</span><br />';
        //設定表格備註
        $tableRemark = "Remark:<br />" . $materialQuery->remark;
        //設定表格簽名處
        //填表人
        $request = "";
        if (isset($this->employee[$materialQuery->managerID])) {
            $request = $this->employee[$materialQuery->managerID]['name'] . '(' . $this->employee[$materialQuery->managerID]['position'] . ')';
        }
        //核表人
        $check = "";
        if (isset($this->employee[$materialQuery->checked])) {
            $check = $this->employee[$materialQuery->checked]['name'] . '(' . $this->employee[$materialQuery->checked]['position'] . ')';
        }
        //負責人
        $approved = "";
        if (isset($this->employee[$materialQuery->approve])) {
            $approved = $this->employee[$materialQuery->approve]['name'] . '(' . $this->employee[$materialQuery->approve]['position'] . ')';
        }
        $tableSign = '<table border="1" style="text-align:center">
            <tr>
            <td height="100">
                Requested by:<br />
                ' . $request . '
            </td>
            <td>
                Checked by:<br />
                ' . $check . '
            </td>
            <td>
                Approved by:<br />
                ' . $approved . '
            </td>
            </tr>
        </table>';
        $this->tableTitle = $tableTitle; //設定表頭
        $this->tableInformation = $tableInformation; //設定表格資訊
        $this->tableList = $tableList; //設定表格列表
        $this->tableRemark = $tableRemark; //設定表格備註
        $this->tableSign = $tableSign; //設定表格簽名
    }

    //取得退貨單資料Goods Return
    private function getGRData($targetID) {
        $sqlString = "SELECT 
            a.goodReturnNo
            ,b.name
            ,b.warehouseID 
            ,b.name AS warehouseName
            ,c.name AS supplierName
            ,a.cDate
            ,a.returnDate
            ,a.goodReturnID
            ,a.remark
            ,a.reason 
            ,a.managerID
            ,a.approved
            ,a.inspected
            ,a.from 
            FROM goodReturn AS a 
            INNER JOIN warehouse As b                        
            INNER JOIN supplier As c                        
            WHERE a.goodReturnID='%s'
            AND a.from = b.warehouseID 
            AND a.to = c.supplierID";

        /*
         * 採購單不一定會相依圖表
         * 移除兩句sql
         * d.drawingNo,
         * INNER JOIN drawing AS d
         * AND b.planID = d.drawingID
         */
        $Query = $this->db->query(sprintf($sqlString, $targetID));
        $returnQuery = $Query->row();

        //echo sprintf($sqlString,$targetID);
        //var_dump($returnQuery);
        //建立採購單標頭
        $tableTitle = '<H1 style="text-align:center">MATERIAL REQUEST SLIP</H1>';

        //建立表格資訊
        //取得pr資料
        $tableInformation = '';
        $tableInformation = '<br /><table style="width:640px;">
            <tr>
                <td width="120">G.R. No:</td>
                <td width="200">' . $returnQuery->goodReturnNo . '</td>
                <td width="120">Cretaion Date:</td>
                <td width="200">' . $returnQuery->cDate . '</td>
            </tr>
            <tr>
                <td>From:</td>
                <td>' . $returnQuery->warehouseName . '</td>
                <td>To:</td>
                <td>' . $returnQuery->supplierName . '</td>
            </tr>
            <tr>
                <td>Reason:</td>
                <td>' . $returnQuery->reason . '</td>
                <td>Returned Date:</td>
                <td>' . $returnQuery->returnDate . '</td>
            </tr>
        </table>';

        //設定表格列表
        $tableList = '<table border="1" style="margin-top:20px;"><tr>
            <th>No</th>
            <th width="80">Code</th>
            <th width="100">Product</th>
            <th>Description</th>
            <th>Status</th>
            <th width="50">Qty</th>
            <th>UoM</th>
            <th>Unit Cost</th>
            <th>Total Amount</th>
            </tr>';
        $tableListOption = ""; //從資料庫取出列表用
        $detailSql = "SELECT * FROM returnDetail AS a
                INNER JOIN item AS b
                WHERE
                a.goodReturnID='%s' AND
                a.itemID = b.itemID";
        $detailQuery = $this->db->query(sprintf($detailSql, $returnQuery->goodReturnID));
        if ($detailQuery->num_rows > 0) {
            $requestDetail = $detailQuery->result();
            $count = 1;
            foreach ($requestDetail as $val) {
                $tableListOption[$count] = $val;
                $count++;
            }
        }
        $orderTotalAmount = "";
        for ($optCount = 1; $optCount <= 20; $optCount++) {
            $itemCode = ""; //產品/服務編號
            $itemName = ""; //產品/服務名稱
            $itemDescription = ""; //產品/服務描述
            $itemStatus = ""; //產品/服務種類
            $itemQty = ""; //產品/服務數量
            $itemUoM = ""; //產品/服務單位
            $itemUnitCost = ""; //產品/服務單位成本
            $itemTotalAmount = ""; //產品/ 服務總成本(單位成本*數量)
            if (isset($tableListOption[$optCount])) {
                $itemCode = $tableListOption[$optCount]->code;
                $itemName = $tableListOption[$optCount]->name;
                $itemDescription = $tableListOption[$optCount]->description;
                //$itemStatus = $tableListOption[$optCount]->cotegory;狀態條件不明，待確認
                $itemQty = $tableListOption[$optCount]->qty;
                $itemUoM = $tableListOption[$optCount]->UoM;
                $itemUnitCost = $tableListOption[$optCount]->unitCost;
                $itemTotalAmount = $tableListOption[$optCount]->qty * $tableListOption[$optCount]->unitCost;
            }
            //加總總價
            $orderTotalAmount += $itemTotalAmount;
            $tableList .= '<tr>
                <td>' . $optCount . '</td>
                <td>' . $itemCode . '</td>
                <td>' . $itemName . '</td>
                <td>' . $itemDescription . '</td>
                <td>' . $itemStatus . '</td>
                <td>' . $itemQty . '</td>
                <td>' . $itemUoM . '</td>
                <td>' . $itemUnitCost . '</td>
                <td>' . $itemTotalAmount . '</td>
            </tr>';
        }
        $tableList .="</table>";
        //計算總價
        $tableList .= '<span style="text-align:right">GRAND TOTAL: $' . $orderTotalAmount . '</span><br />';
        //設定表格備註
        $tableRemark = "Remark:<br />" . $returnQuery->remark;
        //設定表格簽名處
        //填表人
        $request = "";
        if (isset($this->employee[$returnQuery->managerID])) {
            $request = $this->employee[$returnQuery->managerID]['name'] . '(' . $this->employee[$returnQuery->managerID]['position'] . ')';
        }
        //負責人
        $approved = "";
        if (isset($this->employee[$returnQuery->approved])) {
            $approved = $this->employee[$returnQuery->approved]['name'] . '(' . $this->employee[$returnQuery->approved]['position'] . ')';
        }
        //接受人
        $inspected = "";
        if (isset($this->employee[$returnQuery->inspected])) {
            $inspected = $this->employee[$returnQuery->inspected]['name'] . '(' . $this->employee[$returnQuery->inspected]['position'] . ')';
        }
        $tableSign = '<table border="1" style="text-align:center">
            <tr>
            <td height="100">
                Returned by:<br />
                ' . $request . '
            </td>
            <td>
                Approved by:<br />
                ' . $approved . '
            </td>
            <td>
                Received & Inspected by:<br />
                ' . $inspected . '
            </td>
            </tr>
        </table>';
        $this->tableTitle = $tableTitle; //設定表頭
        $this->tableInformation = $tableInformation; //設定表格資訊
        $this->tableList = $tableList; //設定表格列表
        $this->tableRemark = $tableRemark; //設定表格備註
        $this->tableSign = $tableSign; //設定表格簽名
    }

    // 取得維護單資料,Request for Repair維修,Request for Calibration校準,Request for Disposal處置(出售)
    private function getTMRData($targetID) {
        $sqlString = "SELECT 
            a.itemHandleNo
            ,b.projectNo
            ,b.name
            ,a.type
            ,a.cDate
            ,a.eDate
            ,a.itemHandleID
            ,a.remark
            ,a.managerID
            ,a.checked
            ,a.approved
            FROM itemHandle AS a 
            INNER JOIN project As b              
            WHERE a.itemHandleID='%s'
            AND a.projectID = b.projectID";

        /*
         * 採購單不一定會相依圖表
         * 移除兩句sql
         * d.drawingNo,
         * INNER JOIN drawing AS d
         * AND b.planID = d.drawingID
         */
        $Query = $this->db->query(sprintf($sqlString, $targetID));
        $itemHandleQuery = $Query->row();

        //echo sprintf($sqlString,$targetID);
        //var_dump($purchaseqQuery);
        //建立採購單標頭
        $tableTitle = '<H1 style="text-align:center">MATERIAL REQUEST SLIP</H1>';

        //判斷輸出類別
        $purpose = "";
        switch($itemHandleQuery->type){
            case '1':
                $purpose = "Repair";
                break;
            case '2':
                $purpose = "Calibration";
                break;
            case '3':
                $purpose = "Disposal";
                break;
        }
        
        //建立表格資訊
        //取得pr資料
        $tableInformation = '';
        $tableInformation = '<br /><table style="width:640px;">
            <tr>
                <td width="120">T.M. No.:</td>
                <td width="200">' . $itemHandleQuery->itemHandleNo . '</td>
                <td width="120">Purpose:</td>
                <td width="200">' . $purpose . '</td>
            </tr>
            <tr>
                <td>Project Code:</td>
                <td>' . $itemHandleQuery->projectNo . '</td>
                <td>Creation Date</td>
                <td>' . $itemHandleQuery->cDate . '</td>
            </tr>
            <tr>
                <td>Project Name:</td>
                <td>' . $itemHandleQuery->name . '</td>
                <td>Expected Date:</td>
                <td>' . $itemHandleQuery->eDate . '</td>
            </tr>
        </table>';

        //設定表格列表
        $tableList = '<table border="1" style="margin-top:20px;"><tr>
            <th>No</th>
            <th width="80">Code</th>
            <th width="100">Tools & Equip. Name</th>
            <th>Description</th>
            <th width="50">Qty</th>
            <th>UoM</th>
            <th>Reason</th>
            </tr>';
        $tableListOption = ""; //從資料庫取出列表用
        $detailSql = "SELECT * FROM handleDetail AS a
                INNER JOIN item AS b
                WHERE
                a.itemHandleID='%s' AND
                a.itemID = b.itemID";
        $detailQuery = $this->db->query(sprintf($detailSql, $itemHandleQuery->itemHandleID));
        if ($detailQuery->num_rows > 0) {
            $requestDetail = $detailQuery->result();
            $count = 1;
            foreach ($requestDetail as $val) {
                $tableListOption[$count] = $val;
                $count++;
            }
        }
        for ($optCount = 1; $optCount <= 20; $optCount++) {
            $itemCode = ""; //產品/服務編號
            $itemName = ""; //產品/服務名稱
            $itemDescription = ""; //產品/服務描述
            $itemQty = ""; //產品/服務數量
            $itemUoM = ""; //產品/服務單位
            $itemReason = ""; //產品/服務維護原因
            if (isset($tableListOption[$optCount])) {
                $itemCode = $tableListOption[$optCount]->code;
                $itemName = $tableListOption[$optCount]->name;
                $itemDescription = $tableListOption[$optCount]->description;
                $itemQty = $tableListOption[$optCount]->qty;
                $itemUoM = $tableListOption[$optCount]->UoM;
                $itemReason = $tableListOption[$optCount]->reason;
            }
            //加總總價
            $tableList .= '<tr>
                <td>' . $optCount . '</td>
                <td>' . $itemCode . '</td>
                <td>' . $itemName . '</td>
                <td>' . $itemDescription . '</td>
                <td>' . $itemQty . '</td>
                <td>' . $itemUoM . '</td>
                <td>' . $itemReason . '</td>
            </tr>';
        }
        $tableList .="</table>";
        //設定表格備註
        $tableRemark = "Remark:<br />" . $itemHandleQuery->remark;
        //設定表格簽名處
        //填表人
        $request = "";
        if (isset($this->employee[$itemHandleQuery->managerID])) {
            $request = $this->employee[$itemHandleQuery->managerID]['name'] . '(' . $this->employee[$itemHandleQuery->managerID]['position'] . ')';
        }
        //核表人
        $check = "";
        if (isset($this->employee[$itemHandleQuery->checked])) {
            $check = $this->employee[$itemHandleQuery->checked]['name'] . '(' . $this->employee[$itemHandleQuery->checked]['position'] . ')';
        }
        //負責人
        $approved = "";
        if (isset($this->employee[$itemHandleQuery->approved])) {
            $approved = $this->employee[$itemHandleQuery->approved]['name'] . '(' . $this->employee[$itemHandleQuery->approved]['position'] . ')';
        }
        $tableSign = '<table border="1" style="text-align:center">
            <tr>
            <td height="100">
                Requested by:<br />
                ' . $request . '
            </td>
            <td>
                Checked by:<br />
                ' . $check . '
            </td>
            <td>
                Approved by:<br />
                ' . $approved . '
            </td>
            </tr>
        </table>';
        $this->tableTitle = $tableTitle; //設定表頭
        $this->tableInformation = $tableInformation; //設定表格資訊
        $this->tableList = $tableList; //設定表格列表
        $this->tableRemark = $tableRemark; //設定表格備註
        $this->tableSign = $tableSign; //設定表格簽名
    }

    private function _load() {
        $sqlString = "SELECT * FROM employee WHERE enable='1'";
        $query = $this->db->query($sqlString);
        $queryResult = $query->result();
        $employee = array();
        foreach ($queryResult as $val) {
            $employee[$val->employeeID]['name'] = $val->nameLast . " " . $val->nameFirst;
            $employee[$val->employeeID]['position'] = $val->position;
        }
        $this->employee = $employee;
    }

}