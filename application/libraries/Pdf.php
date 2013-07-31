<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF {

    function __construct() {
        parent::__construct();
    }

    //Page header
    public function Header() {
        // Logo
        $image_file = base_url() . 'images/UNISUN-logoTable.jpg';
        $this->Image($image_file, 10, 10, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', '', 10);
        // Title
        $titleStr = '<table style="padding-left:10px;">
            <tr>
                <td colspan="2">No. 228, Norodom Boulevard, Khan Chamcarmon, Phnom Penh, Cambodia</td>
           </tr>
            <tr>
                <td>Tel: (855) 23 996 997</td>
                <td>Fax: (855) 23 944 118</td>
            </tr>
        </table>';
        $this->writeHTML($titleStr, true, 10, true, true);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */