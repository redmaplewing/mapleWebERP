<style type="text/css">

    .outputBtn{
        cursor: pointer;
    }

</style>
<div id="mainArea">
    <!--主視窗-->
    <div id="menuLocation">
        <?php echo $menuInfo['parent'] . "=>" . anchor($menuInfo['link'] . "/index/" . $menuInfo['menuID'], $menuInfo['menuName']); //輸出功能所在位置?>
    </div>
    <br />
    <div id="purchaseReportInterface">
        <table style='width: 100%;font-size: 16px;line-height: 20px;'>
            <tr>
                <td colspan='2' style='text-align:center;'>Report Center</td>
            </tr>
            <tr>
                <?php foreach ($reportTool as $key => $val): ?>
                    <td>
                        <a href="<?php echo base_url() . 'index.php/reportCenter/index/1/' . ($key+1); ?>" target='_blank'>
                            <div class="outputBtn">
                                <?php echo $val; ?>
                            </div>
                        </a>
                    </td>

                    <?php
                    if (($key + 1) % 2 == 0) {
                        echo "</tr><tr>";
                    }
                endforeach;
                ?>
            </tr>
        </table>
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