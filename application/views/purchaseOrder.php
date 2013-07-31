<style type="text/css">
    #tabs {
        font-size:12px;
        width:670px;
        position:relative;
        margin-left:auto;
        margin-right:auto;
    }
    .customForm input[type='text'] {
        width:95%;
    }
    .customForm  select {
        width:90%;
    }
    .customForm  textarea {
        width:90%;
    }
</style>
<div id="mainArea">
    <!--新增管理PR-->
    <div id="showPODetail" title="Purchase Order Detail">
        <div id="mode"></div>

        <form action="<?php echo base_url() . $menuInfo['link'] . "/modify" ?>" method="post" id="poDetailForm" name="poDetailForm"  class="customForm">
            <table>
                <tr>
                    <td>P.O. No. <input type="text" name="purchaseOrderNo" style="width:70%"/></td>
                    <td>
                        status:<select name="status" id="status" style="width:60%">
                            <option value="">Select Status</option>
                            <option value="0">Arriving/In-progress</option>
                            <option value="1">Completed</option>
                        </select>
                    </td>
                    <td>P.R/T.M No.</td>
                    <td>
                        <select name="purchaseRequestID" id="purchaseRequestID">
                            <option value="" selected>--Select P.R./T.M. No.--</option>
                            <?php foreach ($prNo as $key => $val): ?>
                                <option value="<?php echo $key; ?>"><?php echo $val['No']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr style="height:20px">
                    <td>Plan No.</td>
                    <td>
                        <div id="planNo"></div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr  style="height:20px"> 
                    <td>Project Code</td>
                    <td>
                        <div id="projectName"></div>
                        <input type="hidden" name="projectID" id="projectID"/>
                    </td>
                    <td>Creation Date</td>
                    <td>
                        <div id="showCDate"></div>
                        <input type="hidden" name="cDate" id="cDate" class="date"/>
                    </td>
                </tr>			
                <tr>
                    <td>Supplier Code</td>
                    <td>
                        <select name="supplierID" id="supplierID" disabled>
                            <option value="">----Select Supplier----</option>
                            <?php foreach ($supplier as $key => $val): ?>
                                <option value="<?php echo $key; ?>" supplierName="<?php echo $val['name']; ?>"><?php echo $val['no']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>Expected Date</td>
                    <td><input type="text" name="eDate" id="eDate" class="date" /></td>
                </tr>
                <tr>
                    <td>Supplier Name</td>
                    <td><input type="text" name="supplierName" id="supplierName" readonly/>

                    </td>
                    <td>Submitted Date</td>
                    <td>
                        <div id="showSubmitDate"></div>
                        <input type="hidden" id="submitDate" name="submitDate" class="date"/>
                    </td>
                </tr>
                <!--發票號碼-->
                <tr id="invoceInformation" style="display:none;">
                    <td colspan="4" style="width:100%;">
                        <table style="width:100%;">
                            <tr>
                                <td style="text-align:center;" colspan="4">Insert Invoice No./Delivery</td>
                            </tr>
                            <tr>
                                <td>Product/Service Code</td>
                                <td><div id="showItemCode"></div></td>
                                <td>Invoice No./Delivery</td>
                                <td>
                                    <input type="text" name="invoceNo" id="invoceNo" style="width:60%"/>
                                    <input type="hidden" name="itemID" id="itemID"/>
                                    <input type="button" name="sendInvoceNo" id="sendInvoceNo" value="send"/>
                                </td>
                            </tr>
                        </table>
                    </td>				
                </tr>
            </table>

            <div id="poTabs">
                <ul>
                    <li><a href="#poDetail" id="showDetail">P.O Detail</a></li>
                    <!--<li><a href="#poProcesses" id="showProcesses">Processes Tracking</a></li>-->
                    <li><a href="#poReceiving" id="showReceiving">Product/Service Receiving</a></li>
                    <li><a href="#poPayment" id="showPayment">Payment Details</a></li>
                </ul>
                <!--PO Detail-->
                <div id="poDetail">
                    <table id="tabPoDetail"></table>
                    <div id="PoDetailList"></div>
                    <div id="processesNote">
                        <h1>Processes's Nots</h1>
                        1.Submit approved P.O. to the Supplier (considered arriving/in-progress)<br />
                        2.Delivered by the supplier (considered under inspection by the receiving person)<br />
                        3.Returned Goods /unacceptable services (returned by UNI SUN to the supplier due to inspection result wrong specs. incomplete quantity, damaged goods or claim for liabilities in case it’s subcontracting services)<br />
                        4.Completed (supplier delivered all the required items in the P.O.)<br />
                        <table id="tabPoProcess"></table>
                        <div id="poProcessesList"></div>
                    </div>				
                    <div style="width:100%;height:200px;">
                        Remark:<br />
                        <textarea name="remark" id="remark" cols="30" rows="10" style="width:45%;float:left;"></textarea>
                        <table style="width:45%;margin-left:25px;float:left;">
                            <tr>
                                <td>Prepared by</td>
                                <td>
                                    <div id="managerName"></div>
                                    <input type="hidden" name="managerID" id="managerID"/>
                                </td>
                            </tr>
                            <tr>
                                <td>To Be Purchased by</td>
                                <td>
                                    <select name="purchase" id="purchase">
                                        <option value="">----Select Employee----</option>
                                        <?php foreach ($employee as $key => $val): ?>
                                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Checked by</td>
                                <td>
                                    <select name="check" id="check">
                                        <option value="">----Select Employee----</option>
                                        <?php foreach ($employee as $key => $val): ?>
                                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Approved by</td>
                                <td>
                                    <select name="approved" id="approved">
                                        <option value="">----Select Employee----</option>
                                        <?php foreach ($employee as $key => $val): ?>
                                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <?php if ($purchaseOrderLocalControl || $purchaseOrderOverseaControl): ?>
                            <div id="control" style="clear:both;">
                                <input type="hidden" name='oper' id="oper" value="add"/>
                                <input type="hidden" name="securityCode" id="securityCode" value=""/>
                                <input type="hidden" name='id' id="id" value=""/>
                                <input type="hidden" name='type' id="type" value="0"/>					
                                <input type="submit" value="save"/>
                                <input type="reset" value="cancel"/>
                                <input type="button" id="outputPO" name="outputPO" value="Print" style="display:none;"/>
                                <input type="button" id="submit" name="submit" value="Submit"/>
                            </div>
                        <?php endif; ?>
                    </div>				
                </div>
        </form>
        <!--
        <div id="poProcesses">
            <table style="width:100%">
                <tr>
                    <td>Processes</td>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                </tr>
                <tr>
                    <td>Execution Date(autoDate)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </div>
        -->
        <div id="poReceiving">
            <table id="tabPOReceiving"></table>
            <div id="poReceivingList"></div>
            <form action="<?php echo base_url() . $menuInfo['link'] . "/modify/purchaseDetail" ?>" method="post" id="poReceiveForm" name="poReceiveForm"  class="customForm">
                <table>
                    <tr>
                        <td>Delivered to the site by</td>
                        <td>
                            <select name="text" id="delivered" name="delivered">
                                <option value="" selected>Delivered by</option>
                                <option value="0">UNISUN Purchase Dept.</option>
                                <option value="1">Supplier</option>
                            </select>
                        </td>
                        <td>Prepared by</td>
                        <td><input type="text" name="prepared" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>To be Delivered by</td>
                        <td><input type="text" name="deliveredMan"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Received by</td>
                        <td><input type="text" name="received" /></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Inspected by</td>
                        <td><input type="text" name="inspected" /></td>
                    </tr>
                </table>
            </form>
        </div>
        <div id="poPayment">
            <form action="<?php echo base_url() . $menuInfo['link'] . "/modify/purchaseDetail" ?>" method="post" id="poPaymentForm" name="poPaymentForm"  class="customForm">
                <table>
                    <tr>
                        <td>Payment Term Agreement</td>
                        <td><input type="text" name="supplierCode" /></td>
                    </tr>
                    <tr>
                        <td>Payment Date</td>
                        <td><input type="text" name="paymentDate" class="date"/></td>
                    </tr>
                    <tr>
                        <td>Payment/Order Notes</td>
                        <td><input type="text" name="payNote" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>		
</div>

<!--主視窗-->
<div id="menuLocation">
    <?php echo $menuInfo['parent'] . "=>" . anchor($menuInfo['link'] . "/index/" . $menuInfo['menuID'], $menuInfo['menuName']); //輸出功能所在位置?>
</div>
<br />
<div id="purOrderMainInterface">
    <ul>			
        <?php if ($purchaseOrderLocal): ?>
            <li><a href="#poLocal" id="poLocalTabs">Local</a></li>
        <?php endif; ?>
        <?php if ($purchaseOrderOversea): ?>
            <li><a href="#poOverseas" id="poOverseasTabs">Overseas</a></li>
        <?php endif; ?>
    </ul>
    <!--採購Local-->
    <?php if ($purchaseOrderLocal): ?>
        <div id="poLocal">
            <ul class="subTabs">
                <li><a href="#localNewPO" id="localNewPOTabs">New P.O. </a></li>
                <li><a href="#localApproval" id="localApprovalTabs">Waiting for Approval</a></li>
                <li><a href="#localArriving" id="localArrivingTabs">Arriving/In-progress</a></li>
                <li><a href="#localComplete" id="localCompleteTabs">Completed</a></li>
            </ul>
            <div id="localNewPO">
                <table id="tabPOLocal" class="localPOTab"></table>
                <div id="poLocalList"></div>
                <br />
                <!--新增按扭-->
                <?php if ($purchaseOrderLocalControl): ?>
                    <input type="button" id="addLocalPo" value="New Local Purchase Order"/>					
                    <input type="button" id="delLocalPo" value="Delete Select Local Purchase Order"/>
                <?php endif; ?>
                <input type="button" id="editLocalPo" value="View/Edit Select Local Purchase Order"/>
                <!--刪除按扭-->
                <!--<input type="button" id="delDetail" value="Delete Item"/>-->
            </div>
            <div id="localApproval">
                <table id="tabLocalApproval" class="localPOTab"></table>
                <div id="localApprovalList"></div>
            </div>
            <div id="localArriving">
                <table id="tabLocalArriving" class="localPOTab"></table>
                <div id="localArrivingList"></div>
            </div>
            <div id="localComplete">
                <table id="tabLocalComplete" class="localPOTab"></table>
                <div id="localCompleteList"></div>
            </div>

        </div>
    <?php endif; ?>
    <!--採購Overseas-->
    <?php if ($purchaseOrderOversea): ?>
        <div id="poOverseas">
            <ul class="subTabs">
                <li><a href="#overseasNewPO" id="overseasNewPOTabs">New P.O. </a></li>
                <li><a href="#overseasApproval" id="overseasApprovalTabs">Waiting for Approval</a></li>
                <li><a href="#overseasArriving" id="overseasArrivingTabs">Arriving/In-progress</a></li>
                <li><a href="#overseasComplete" id="overseasCompleteTabs">Completed</a></li>
            </ul>
            <div id="overseasNewPO">
                <table id="tabPOOverseas"></table>
                <div id="poOverseasList"></div>
                <br />
                <!--新增按扭-->
                <?php if ($purchaseOrderOverseaControl): ?>
                    <input type="button" id="addOverPo" value="New Overseas Purchase Order"/>				
                    <input type="button" id="delOverPo" value="Delete Select Overseas Purchase Order"/>
                <?php endif; ?>
                <input type="button" id="editOverPo" value="View/Edit Select Overseas Purchase Order"/>
                <!--刪除按扭-->
                <!--<input type="button" id="delDetail" value="Delete Item"/>-->
            </div>
            <div id="overseasApproval">
                <table id="taboverseasApproval" class="overseasPOTab"></table>
                <div id="overseasApprovalList"></div>
            </div>
            <div id="overseasArriving">
                <table id="taboverseasArriving" class="overseasPOTab"></table>
                <div id="overseasArrivingList"></div>
            </div>
            <div id="overseasComplete">
                <table id="taboverseasComplete" class="overseasPOTab"></table>
                <div id="overseasCompleteList"></div>
            </div>
        </div>
    <?php endif; ?>
</div>
</div>
<script type="text/javascript">
    $(function() {
        //nav側邊欄對應控制
        $("#menuList").accordion("option", "active",<?php echo $active; ?>);
        //alert(base_url);
    })
</script>
<script src="<?= base_url(); ?>js/purchaseOrder.js"></script><!--此頁面的js-->