<!DOCTYPE html>
<html lang="zh_tw">
<head>
  <meta charset="utf-8" />

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <title>Welcome-UNI SUN Development Corp.</title>
  <meta name="description" content="" />
  <meta name="author" content="danny" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />

  <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="images/favicon.ico" />
  <link rel="apple-touch-icon" href="images/apple-touch-icon.png" />
  <!--css重置歸零-->
  <link rel="stylesheet" href="<?=base_url();?>css/reset.css"/>
  <!--預設css-->
  <link rel="stylesheet" href="<?=base_url();?>css/mainStyle.css"/>
  
  <style type="text/css">
	.error {
		color:red;
	}
	#control {
		position:absolute;
		margin-top:420px;
		margin-left:550px;
	}
	#content {
		background:url(<?php echo base_url();?>images/loginBG.jpg);
	}
	#loginBox {
		position:absolute;
		margin-top:280px;
		margin-left:530px;
	}
	#loginBox input {
		width:182px;
		height:24px;
		position:absolute;
		border:none;
	}
	#loginBox img {
		position:absolute;
		top:65px;
		left:190px;
	}
	#loginBox select {
		position:absolute;
		top:105px;
		left:-5px;
		font-size:16px;
	}
	.errMsg{
		width:300px;
		position:absolute;
		left:200px;
	}
  </style>
	<script src="<?=base_url();?>js/jquery-1.9.1.min.js"></script>
	<script src="<?=base_url();?>js/jquery-ui-1.10.2.custom.min.js"></script>
	<script src="<?=base_url();?>js/jquery.lightbox-0.5.min.js"></script>
	<script src="<?=base_url();?>js/jquery.validate.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$("#login").validate({
				errorPlacement: function(error,element){
					//alert(error);
					element.next('div').append(error);
				}
			});
		})
	</script>
</head>
<body>
	<div id="content" style="height:620px;">		
			<form action="<?php echo base_url();?>login/checkLogin" id="login" name="login" method="post">
				<div id="loginBox">
					<input type="text" class="required" id="account" name="account" style="top:4px;"/>
					<div class="errMsg" style="top:5px;"></div><br/>					
					<input type="password" class="required" id="passwd" name="passwd" style="top:37px;"/>
					<div class="errMsg" style="top:35px;"></div>					
					<input type="text" class="required" id="check" name="check" style="top:70px;"/><br />
					<select name="selectLang" id="selectLang" class="required">
						<option value=""><?php echo $this->lang->line('selLang');?></option>
						<?php
							foreach($langType as $key => $val):
								$selected = $key == $lang?"selected":"";
						?>
						<option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $val;?></option>
						<?php endforeach;?>
					</select>
					<?=$cap['image'];?>
				</div>				
			<div id="control">				
				<?=form_reset('reset',$this->lang->line('login_reset'));?>
				<?=form_submit('checkLogin',$this->lang->line('login_submit'));?>
			</div>
			</form>	
	</div>
	
	<script type="text/javascript">
/* 		$("#selectLang").change(function(){
			location.href="<?php echo base_url()."login/index/";?>"+$(this).val();
		}); */
	</script>
</body>
</html>