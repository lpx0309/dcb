<?php 
for($i=$_GET['id'];$i<$_GET['id']+$_GET['colspan'];$i++){
	echo DB::Get_one('select time from dcb_history where id='.$i).'<br>';
}
?>

<script type="text/javascript">
$(function(){
	pop_buttons({
	  "确定":function(){
		  $('#pop_div_colspan').dialog("close");
	  }
	},'colspan');
});
</script>