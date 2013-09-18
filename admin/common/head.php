<link rel="stylesheet" href="<?php echo ADMIN_CSS_URL;?>style.css" media="all" />
<script type="text/javascript" src="<?php echo ADMIN_JS_URL;?>jquery.js"></script>
<script type="text/javascript" src="<?php echo ADMIN_JS_URL;?>custom.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.SubMenu').each(function(index) {
		$("#SubMenu"+index).hide();
	});
});
function showsubmenu(id){
	$("#"+id).slideToggle("slow");
}
</script>