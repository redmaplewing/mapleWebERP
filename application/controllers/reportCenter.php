<?php

//class Login extends CI_Controller {	
class ReportCenter extends MY_Controller {
    /*
     * type =1:Purchase Report Center
     * type=2:Inventory Report Center
     * 
     * purchase Report Center's SN
     * 1.Current Price List
     * product name,product code, unit cost, category, 
     * 2.Supplier List
     * 3.Price History of Products & Services
     * 4.Total Purchase Made
     * 5.Total Local Purchase
     * 6.Total Overseas Purchase
     * 7.Total Purchase per Product
     * 8.Total Purchase per Service
     * 9.Total Purchase Made from(supplier)
     * 10.Total Purchase Made for(Project)
     * 11.Duration of Processing Purchase Request
     * 12.Duration of Processing Purchase Order
     * 
     * inventory Report Centedr's SN
     * 1.Warehouse List
     * 2.Tools & Equipment List
     * 3.Tools & Equipment Usage History
     * 4.Tools & Equipment Repair History
     * 5.Tools & Equipment Calibration History
     * 6.Lost Tools & Equipment
     * 7.Inventory Level
     * 8.Restocking Report
     * 9.Slow-moving Stock
     * 10.Fast-moving Stock
     * 11.Inventory Received(Total IN from purchases)
     * 12.Inventory Usage per Project
     * 13.Inventory Transfer(total IN-OUT)
     * 14.Total Goods Return
     * 15.Loss from the Goods Returned
     * 16.Stock Adjsutment (generated from the provision of errors through physical count vs. recorded)
     * 
     */

    public function __construct() {
        parent::__construct(); //繼承父類別的涵數
        $this->_load();
    }

    public function index($type, $sn) {
        //echo $type . "," . $sn;
        $view = "reportCenter";
        $this->load->view($view);
    }

    //設定程式基本參數
    private function _load() {
        
    }

}