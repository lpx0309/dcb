<?php
//print_r($_GET);//斯蒂芬 
$part_arr=explode('-',$_GET['part']);
$start_place=trim($part_arr[0]);
$end_place=trim($part_arr[1]);
$start_dcb=DB::Get_one('select dcb from dcb_all where id='.$start_place);
$end_dcb=DB::Get_one('select dcb from dcb_all where id='.$end_place);

$dcb_num=DB::Get_one('select count(*) from dcb_history');
$isset=DB::Get_one('select id from dcb_history where place between '.$start_place.' and '.$end_place.' order by id desc');
?>

<table class="table" style="text-align:center">
  <tr>
    <td>开始</td>
    <td><?php echo $dcb_num-$isset; ?></td>
    <td>结束</td>
  </tr>
  <tr>
    <td id="start_place"><?php echo $start_place; ?></td>
    <td>-</td>
    <td id="end_place"><?php echo $end_place; ?></td>
  </tr>
  <tr>
    <td><?php echo dc($start_dcb); ?></td>
    <td>-</td>
    <td><?php echo dc($end_dcb); ?></td>
  </tr>
  <tr>
    <td><button class="btn btn-default" onclick="partrand()">随机</button></td>
    <td>=</td>
    <td id="partrand"></td>
  </tr>
</table>

<script type="text/javascript">
function partrand(){
	$.ajax({
		url:'index.php?controller=model&model=dcb&function=partrand&time='+ new Date().getTime(),
		data:'start_place='+$('#start_place').html()+'&end_place='+$('#end_place').html(),
		type:'POST',
		async:true,
		beforeSend: function(){
			pop_loading();
		},
		success: function(text){
			pop_loading_close();
			if(text){
				//pop_alert(text);
				//console.log(text);
				$('#partrand').html(text);
			}else{
				//window.location.reload();
			}
		}
	});
}
</script>