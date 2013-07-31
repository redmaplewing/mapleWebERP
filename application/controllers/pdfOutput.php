<?php

//class Login extends CI_Controller {	
class PdfOutput extends MY_Controller {

    public $tableTitle = '';
    public $tableInformation = '';
    public $tableList = '';
    public $tableRemark = '';
    public $tableSign = '';

    /* public function __construct()
      {
      parent::__construct();//繼承父類別的涵數
      $this->_load();
      } */

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
        $text = $this->tableTitle . $this->tableInformation . $this->tableList . $this->tableRemark . $this->tableSign;
        return $text;
    }

    //取得採購單資料(國內/海外)Purchase Order
    private function getPOData($targetID) {
        $sqlString = "SELECT 
            a.purchaseOrderNo,
            b.purchaseRequestNo,
            c.projectNo,
            d.drawingNo,
            e.supplierNo,
            a.cDate,
            e.name,
            a.eDate, 
            a.type,
            a.remark
            FROM purchaseOrder AS a 
            INNER JOIN purchaseRequest AS b 
            INNER JOIN project As c 
            INNER JOIN drawing AS d 
            INNER JOIN supplier AS e
            WHERE a.purchaseOrderID='%s'
            AND a.purchaseRequestID = b.purchaseRequestID
            AND a.projectID = c.projectID
            AND b.planID = d.drawingID
            AND a.supplierID=e.supplierID";
        $Query = $this->db->query(sprintf($sqlString, $targetID));
        $purchaseqQuery = $Query->row();
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
                <td>' . $purchaseqQuery->drawingNo . '</td>
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
            <th>Code</th>
            <th>Product/Service Name</th>
            <th>Description</th>
            <th>Category</th>
            <th>Qty</th>
            <th>UoM</th>
            <th>Unit Cost</th>
            <th>Total Amount</th>
            </tr>';
        $tableListOption = "";
        for ($optCount = 1; $optCount <= 20; $optCount++) {
            $tableList .= '<tr>
                <td>'.$optCount.'</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>';
        }
        $tableList .="</table>";
        //計算總價
        $tableList .= '<span style="text-align:right">GRAND TOTAL:</span><br />';
        //設定表格備註
        $tableRemark = "Remark:<br />" . $purchaseqQuery->remark;
        //設定表格簽名處
        $tableSign = "";
        $this->tableTitle = $tableTitle; //設定表頭
        $this->tableInformation = $tableInformation; //設定表格資訊
        $this->tableList = $tableList; //設定表格列表
        $this->tableRemark = $tableRemark; //設定表格備註
        $this->tableSign = $tableSign; //設定表格簽名
    }

    //取得調貨單資料Material Request
    private function getMRData($targetID) {
        
    }

    //取得退貨單資料Goods Return
    private function getGRData($targetID) {
        
    }

    /* 取得維護單資料
     * Request for Repair維修
     * Request for Calibration校準
     * Request for Disposal處置(出售)
     */

    private function getTMRData($targetID) {
        
    }

}