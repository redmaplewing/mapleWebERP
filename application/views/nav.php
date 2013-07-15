<nav>
<div id="menuList">
<?php foreach($this->session->userdata('menuType') as $key => $val):?>
	<h2><?php echo $val['name'];?></h2>
	<div>
		<ul>
		<?php foreach($val['menulist'] as $k => $v){
			
			if($v['link'] != ""){
				echo "<li>".anchor($v['link']."/index/".$v['id'],$v['name'])."</li>";
			}else{
				echo "<li class='nlData'>".$v['name']."</li>";
			}			
		}?>
        </ul>
	</div>
<?php endforeach;?>
</div>
<script type="text/javascript">
	$(function(){
		$("#menuList").accordion();		
	});
</script>
</nav>