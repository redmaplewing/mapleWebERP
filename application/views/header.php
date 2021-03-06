<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>UNI SUN Development Corp.</title>
<!--css重置歸零-->
<link rel="stylesheet" href="<?=base_url();?>css/reset.css"/>
<!--擴充js的css-->
<link rel="stylesheet" href="<?=base_url();?>css/jquery-ui-1.10.2.custom.min.css"/>
<link rel="stylesheet" href="<?=base_url();?>css/ui.jqgrid.css"/>
<link rel="stylesheet" href="<?=base_url();?>css/jquery-ui-timepicker-addon.css"/>
<link rel="stylesheet" href="<?=base_url();?>css/jquery.lightbox-0.5.css"/>
<!--預設css-->
<link rel="stylesheet" href="<?=base_url();?>css/mainStyle.css"/>
<script src="<?=base_url();?>js/jquery-1.9.1.min.js"></script><!--jQuery-->
<script src="<?=base_url();?>js/jquery-ui-1.10.2.custom.min.js"></script><!--jQuery UI-->
<script src="<?=base_url();?>js/jquery.lightbox-0.5.min.js"></script><!--暗箱秀圖lightbox-->
<script src="<?=base_url();?>js/jquery.validate.min.js"></script><!--表單驗證-->
<script src="<?=base_url();?>js/i18n/grid.locale-en.js"></script><!--jqGrid語系檔-->
<script src="<?=base_url();?>js/jquery.jqGrid.min.js"></script><!--jqGrid-->
<script src="<?=base_url();?>js/jquery.form.js"></script><!--AJAX表單-->
<script src="<?=base_url();?>js/jquery-ui-timepicker-addon.js"></script><!--增加時間的日期套件-->
<script type="text/javascript">
	$(function(){
		window.base_url='<?php echo base_url().$menuInfo['link'];?>';		
		window.localhost='<?php echo base_url();?>';		
		window.userID='<?php echo $this->session->userdata['employeeID'];?>';		
		window.userName='<?php echo $this->session->userdata['username'];?>';		
	})
</script>
<style type="text/css">
#log {
	position:absolute;
	top:30px;
	right:0px;
	color:#ffffff;
}

</style>
</head>
<body>
<div id="loadLocation" style="position:absolute; top:0px; left:0px; z-index:99;width:100%;height:100%;background-color:#f2f2f2;">
	<div id="loading" style="width:100px;height:100px;position:relative;margin-right:auto;margin-left:auto;margin-top:200px;">
		<img id="loadingBar" src="<?php echo base_url();?>images/ajax-loader.gif" alt="讀取條" />
	</div>
</div> 
<div id='content' name='content'>
<header>
<div id="log">
<?php echo $this->lang->line('choselanguage');//選擇語言?>
<select name="choseLanguage" id="choseLanguage">
<?php
	foreach($this->session->userdata('languageType') as $key => $val)://產生語言選項
	$selected = $key == $this->session->userdata('lang')?"selected":"";
?>
	<option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $val;?></option>
<?php endforeach;?>
</select><br />
<span id="welMessage">
<?php
	//輸出登入訊息
	$welComeMessage = sprintf($this->lang->line('welcomeMessage') ,$loginInfo['account'],date("Y-m-d h:i:s",$loginInfo['loginTime']),date("Y-m-d h:i:s",now()));
	echo $welComeMessage;
?>
</span>
</div>
<!--<?php echo anchor(base_url()."mainmenu", $this->lang->line('mainMenu'), '');//回首頁?>-->
<br />
<?php echo "<span class='top_parent'>".anchor(base_url(), $this->lang->line('login_out'), '')."</span>";//登出?>
<br />


<script type="text/javascript">
$(function(){
	$("#choseLanguage").change(function(){
		//alert($(this).val() + '<?php echo $_SERVER['PHP_SELF'];?>');
		location.href="<?php echo base_url()."mainmenu/changeLanguage";?>/"+$(this).val()+"/<?php echo $this->uri->segment(1);?>";
	})
})
</script>
</header>