<script type="text/javascript">
    $(function() {

    })
</script>

<div id="mainArea">
    <!--Recruitment 浮動視窗-->
    <div id="showattRecordInterface" title="Human Resource">

        <div id="mode" style="width:100%;text-align:center;">Employee Leave</div>
        <form action="<?php echo base_url() . $menuInfo['link'] . "/modify/employeeAttendance" ?>" method="post" id="attForm" name="attForm"  class="customForm">
            <table style="width:100%;">
                <tr>
                    <td colspan='2' style="width:30%;">Employee Name</td>
                    <td colspan='4' style="width:70%;">
                        <select name="employeeID" id="employeeID">
                            <option value="">====Select Employee====</option>
                            <?php foreach ($employee as $key => $val): ?>
                                <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Start Date</td>
                    <td>
                        <input type="text" name="startDay" id="startDay" class="date"/>
                    </td>
                    <td>End Date</td>
                    <td>
                        <input type="text" name="endDay" id="endDay" class="date"/>
                    </td>
                    <td>Type</td>
                    <td>
                        <select name="leaveType" id="leaveType">
                            <option value="">====Select LeaveType====</option>
                            <!--
                            1.Unpaid Leave 事假
                            2.Sick Leave 病假
                            3.Visit Leave 公出
                            4.Matemity Leave 產假
                            5.Marriage Leave 婚假
                            6.Beravement Leave 喪假
                            -->
                            <option value="1">Unpaid Leave </option>
                            <option value="2">Sick Leave </option>
                            <option value="3">Visit Leave </option>
                            <option value="4">Matemity Leave </option>
                            <option value="5">Marriage Leave </option>
                            <option value="6">Beravement Leave </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Employee Signature</td>
                    <td>
                        <select name="signCheck" id="signCheck">
                            <option value="">====Check====</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </td>
                    <td>Admin/Hr Dept.</td>
                    <td>
                        <select name="hrDeptCheck" id="hrDeptCheck">
                            <option value="">====Check====</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </td>
                    <td>Checked By</td>
                    <td>
                        <select name="checked" id="checked">
                            <option value="">====Select Employee====</option>
                            <?php foreach ($employee as $key => $val): ?>
                                <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Approved by</td>
                    <td>
                        <select name="approved" id="approved">
                            <option value="">====Select Employee====</option>
                            <?php foreach ($employee as $key => $val): ?>
                                <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            </table>
            <?php if ($attRecord): ?>	
                <input type="hidden" name="oper" id="oper"/>
                <input type="hidden" name="managerID" id="managerID"/>
                <input type="hidden" name="id" id="id"/>
                <input type="submit" id="save" value="Save"/>
                <input type="reset" id="cancel" value="Cancel"/>
            <?php endif; ?>
        </form>
    </div>


    <!--主視窗-->
    <div id="menuLocation">
        <?php echo $menuInfo['parent'] . "=>" . anchor($menuInfo['link'] . "/index/" . $menuInfo['menuID'], $menuInfo['menuName']); //輸出功能所在位置?>
    </div>
    <br />
    <div id="employeeListInterface">
        <ul>			
            <li><a href="#attendance" id="headLink">Attendance Summary</a></li>
            <li><a href="#employeeLeave" id="siteLink">Employee Leave</a></li>
        </ul>
        <div id="attendance">
            <table id="attendanceTable"></table>
            <div id="attendanceList"></div>			
        </div>
        <div id="employeeLeave">
            <table>
                <tr>
                    <td>Name :</td>
                    <td><div id="employeeName"></div></td>
                    <td>Gender:</td>
                    <td><div id="employeeGender"></div></td>
                    <td>Employee No:</td>
                    <td><div id="employeeNo"></div></td>
                </tr>
                <tr>
                    <td>Department:</td>
                    <td><div id="employeeDepartment"></div></td>
                    <td>Position:</td>
                    <td><div id="employeePosition"></div></td>
                    <td>Employment Date:</td>
                    <td><div id="employeeEmploymentDate"></div></td>			
                </tr>
                <tr>
                    <td colspan="6">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="6">
                        <table id="employeeLeaveTable"></table>
                        <div id="employeeLeaveList"></div>
                    </td>
                </tr>
            </table>				
            <?php if ($attRecord): ?>			
                <input type="button" name="addAttRecord" id="addAttRecord" value="Add Attendance"/>
                <input type="button" name="delAttRecord" id="delAttRecord" value="Delete Selected Attendance"/>
            <?php endif; ?>
            <input type="button" name="editAttRecord" id="editAttRecord" value="View/Edit Selected Attendance"/>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        //nav側邊欄對應控制
        $("#menuList").accordion("option", "active",<?php echo $active; ?>);
        //alert(base_url);
    })
</script>
<script src="<?= base_url(); ?>js/<?php echo $menuInfo['link']; ?>.js"></script><!--此頁面的js-->