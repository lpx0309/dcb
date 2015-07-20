<?php
//分段
$all=17721088;
if(isset($_GET['split'])){
	$split=$_GET['split'];
}else{
	$split=32;
}
$part=$all/$split;
//分期
if(isset($_GET['colspan'])){
	$colspan=$_GET['colspan'];
}else{
	$colspan=3;
}
//期数
if(isset($_GET['codenum'])){
	if($_GET['codenum']%$colspan==0){
		$codenum=$_GET['codenum'];
	}else{
		$codenum=$colspan*8;
	}
}else{
	$codenum=$colspan*8;
}
$dcb_num=DB::Get_one('select count(*) from dcb_history');
$soonest=$dcb_num-$codenum;
//分页
if(isset($_GET['start'])){
	$start=$_GET['start'];
}else{
	$start=0;
}

$dcb_list=array();
$dcb_history=mysqli_query($conn,'select * from dcb_history order by id desc limit '.$start.','.$codenum);
while($dcb_arr=mysqli_fetch_assoc($dcb_history)){
	$dcb_list[]=$dcb_arr;
}
$dcb_list=array_reverse($dcb_list);

$title='总体走势';
?>

<?php require(FILE_ROOT.'/view/header.php'); ?>

<style>
#trend{
	width:100%;
	border-collapse:separate; 
	border-spacing:2px;
}
#trend td{
	text-align:center;
	/*border-radius:5px;*/
}
.place{
	background:#ccc;
	border-radius:5px;
	cursor:pointer;
}
.pointer{
	cursor:pointer
}
</style>

<div class="row">
  <form>
    <!--分段-->
    <div class="col-md-2">
      <select class="form-control" id="split" onchange="url_change('replace','index.php','split',this.value)">
      <?php
	  for($i=1;$i<=256;$i*=2){
		  ?>
          <option value="<?php echo $i; ?>" <?php if($i==$split){ ?> selected="selected" <?php } ?>><?php echo $i; ?></option>
          <?php
	  }
	  ?>
      </select>
    </div>
    <!--分期-->
    <div class="col-md-2">
      <select class="form-control" id="colspan" onchange="url_change('replace','index.php','colspan',this.value)">
      <?php
	  for($i=1;$i<=10;$i++){
		  ?>
          <option value="<?php echo $i; ?>" <?php if($i==$colspan){ ?> selected="selected" <?php } ?>><?php echo $i; ?></option>
          <?php
	  }
	  ?>
      </select>
    </div>
    <!--期数-->
    <div class="col-md-2">
      <select class="form-control" id="codenum"  onchange="url_change('replace','index.php','codenum',this.value)">
      <?php
	  for($i=1;$i<=10;$i++){
		  ?>
          <option value="<?php echo $i*$colspan; ?>" <?php if($i*$colspan==$codenum){ ?> selected="selected" <?php } ?>><?php echo $i*$colspan; ?></option>
          <?php
	  }
	  ?>
      </select>
    </div>
    <div class="col-md-3">
    </div>
    <!--分页-->
    <div class="col-md-3">
      <div class="form-group">
        <button class="btn btn-default" onclick="url_change('replace','index.php','start','<?php echo $soonest; ?>');return false">尾页</button>
        <button class="btn btn-default" onclick="url_change('replace','index.php','start','<?php echo $start+1 ;?>');return false" <?php if($start==$soonest){echo 'disabled';} ?>>&larr;</button>
        <button class="btn btn-default" onclick="url_change('replace','index.php','start','<?php echo $start-1; ?>');return false" <?php if($start==0){echo 'disabled';} ?>>&rarr;</button>
        <button class="btn btn-default" onclick="url_change('replace','index.php','start',0);return false">首页</button>
      </div>
    </div>
  </form>
</div>

<div class="row">
  <div class="col-md-12">
    <table border="1" class="table-hover" id="trend">
      <?php
      $none=0;
      $k=1;
      for($i=0;$i<$all;$i+=$part){
          $j=$i+$part;
          ?>
          <tr>
            <?php
            $has=0;
            for($x=0;$x<$codenum;$x++){
                if($dcb_list[$x]['place']>$i&&$dcb_list[$x]['place']<=$j){
                    $has++;
                ?>
                    <td class="place" onclick="pop_div(500,420,'DCB-<?php echo $dcb_list[$x]['id']; ?>','dcb','id=<?php echo $dcb_list[$x]['id']; ?>');" id="dcb_<?php echo $dcb_list[$x]['id']; ?>">&nbsp;</td>
                <?php
                }else{
                ?>
                    <td>&nbsp;</td>
                <?php	
                }
            }
            ?>
            <td width="2%" class="<?php if($has==0){ $none++;echo 'place';  }else{ echo 'pointer';  } ?>" onclick="pop_div(600,300,'分段-<?php echo $k; ?>','part','part=<?php echo $i.'-'.$j; ?>')">
			  <?php echo $k; ?>
            </td>
          </tr>
          <?php
          $k++;
      }
      ?>
      <tr>
        <?php
        for($x=0;$x<$codenum;$x+=$colspan){
        ?>
            <td colspan="<?php echo $colspan; ?>" class="pointer" onclick="pop_div(200,300,'分期','colspan','id=<?php echo $dcb_list[$x]['id']; ?>&colspan=<?php echo $colspan; ?>')">
              <?php echo $dcb_list[$x]['time']; ?><br />
              <?php echo $dcb_list[$x+$colspan-1]['time']; ?>
            </td>
        <?php
        }
        ?>
        <td><?php echo $none; ?></td>
      </tr>
    </table>
  </div>
</div>

<script type="text/javascript">
$(function(){
	/*$('.pointer').popover({
		content:'right',
		placement:'top',
		trigger:'hover',
	});*/
	$('.place').click(function(){
		$('.place').css('background','#ccc');		
		$(this).css('background','red');					   
	});
});
function dcb_show(id){
	//$('#'+id).popover('show');
	//pop_div(400,300,'DCB','dcb','id='+id.replace('dcb_',''));
}
</script>

<?php require(FILE_ROOT.'/view/footer.php'); ?>
