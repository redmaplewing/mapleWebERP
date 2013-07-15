<footer></footer>
</div>
</body>
<script type="text/javascript">
	$(window).load(function(){	
  		$("#loadLocation").fadeOut();
		$(":reset").click(function(){
			var tar = $(this).parents('form');
			var tarDialog = "";
			//alert(tar.attr('id'));
			tar.parents().each(function(){
				if(typeof $(this).attr('title') !== 'undefined'){
					//alert($(this).attr('id'));
					tarDialog = $(this);
				}				
			})
			//alert(tarDialog.attr('id'));
			tarDialog.dialog('close');
		});
  	})
</script>
</html>