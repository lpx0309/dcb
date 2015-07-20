<?php 
$dcb=DB::Get_arr('select * from dcb_history where id='.$_GET['id']);
?>

<table class="table table-bordered">
  <tr>
    <td>开奖日期</td>
    <td><?php echo $dcb['time']; ?></td>
  </tr>
  <tr>
    <td>期号</td>
    <td><?php echo $dcb['code']; ?></td>
  </tr>
  <tr>
    <td>中奖号码</td>
    <td><?php dc($dcb['dcb']); ?></td>
  </tr>
  <tr>
    <td>销售额</td>
    <td><?php echo $dcb['sales']; ?></td>
  </tr>
  <tr>
    <td>一等奖</td>
    <td><?php echo $dcb['first']; ?></td>
  </tr>
  <tr>
    <td>二等奖</td>
    <td><?php echo $dcb['second']; ?></td>
  </tr>
  <tr>
    <td>位置</td>
    <td><?php echo $dcb['place']; ?></td>
  </tr>
</table>

<script type="text/javascript">
$(function(){
	pop_buttons({
	  "确定":function(){
		  $('#pop_div_dcb').dialog("close");
	  }
	},'dcb');
});
</script>