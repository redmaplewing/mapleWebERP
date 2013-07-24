<div id="mainArea">
    <!--主視窗-->
    <div id="menuLocation">
        <?php echo $menuInfo['parent'] . "=>" . anchor($menuInfo['link'] . "/index/" . $menuInfo['menuID'], $menuInfo['menuName']); //輸出功能所在位置?>
    </div>
    <br />
    <div id="purchaseReportInterface">
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