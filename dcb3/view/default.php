<?php
//搜索
$sql='';
if(isset($_GET['kw'])){
	$sql.=' and (dcb like "'.trim($_GET['kw']).'%" ) ';
}
//排序
if(isset($_GET['st'])){
	$od=explode('_',$_GET['st']);
	$od=$od[0];
	$by=explode('_',$_GET['st']);
	$by=$by[1];
}else{
    $od='id';
    $by='desc';
}
$sql.=' order by '.$od.' '.$by;
$asc='<img src="'.LINK_ROOT.'/images/sort-ascending.png" />';
$desc='<img src="'.LINK_ROOT.'/images/sort-descending.png" />';
$not='<img src="'.LINK_ROOT.'/images/sort-not-sorted.png" />';

//分页
$dcb_num=DB::Get_one('select count(*) from dcb_history where id!=0'.$sql);
if(isset($_GET['pg'])){
	$page=$_GET['pg'];
}else{
	$page=1;
}
$pagesize=15;
$Page=new Page($dcb_num,$page,$pagesize,'index.php');//新建分页类
$start=$Page->Page_start();//加分页limit
$page_bottom=$Page->Page_bottom();//获取分页底部	
$sql.=' limit '.$start.','.$pagesize;

//获取数据
$dcb_list=array();
$dcb_history=mysqli_query($conn,'select * from dcb_history where id!=0'.$sql);
while($dcb_arr=mysqli_fetch_assoc($dcb_history)){
	if(isset($_GET['kw'])){
		$dcb_arr['dcb']=str_replace(trim($_GET['kw']),'<font color=red>'.trim($_GET['kw']).'</font>',$dcb_arr['dcb']);
	}
	$dcb_list[]=$dcb_arr;
}

$title='历史记录';
?>

<?php require(FILE_ROOT.'/view/header.php'); ?>

<style>
#banner{
	margin-bottom:20px;
}
#history{
	/*text-align:center;*/
}
</style>

<div class="row" id="banner">
  <div class="col-md-4">
    <form class="form-inline" role="form">
      <!--<div class="form-group has-feedback">-->
        <label class="sr-only" for="dcb_keyword">search</label>
        <input type="text" class="form-control" id="dcb_keyword" placeholder="请输入关键字" value="<?php if(isset($_GET['kw'])){echo $_GET['kw'];} ?>">
        <!--<span class="glyphicon glyphicon-search form-control-feedback"></span>
      </div>-->
      <button type="submit" class="btn btn-default" onclick="list_search('dcb');return false"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;搜索</button>
    </form>
  </div>
  <div class="col-md-2"></div>
  <div class="col-md-4">
    <form class="form-inline" role="form">
      <label class="sr-only" for="search">search</label>
      <input type="text" class="form-control" id="delnum" value="10" />
      <button type="submit" class="btn btn-default" onclick="del();return false"><span class="glyphicon glyphicon-trash"></span>&nbsp;&nbsp;删除</button>
      <button class="btn btn-default" onclick="trunset();return false"><span class="glyphicon glyphicon-remove-circle"></span>&nbsp;&nbsp;清空</button>
    </form>
  </div>
  <div class="col-md-2">
    <button class="btn btn-default" onclick="alldcb()"><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;生成</button>
    <button class="btn btn-default" onclick="update()" style="float:right"><span class="glyphicon glyphicon-download"></span>&nbsp;&nbsp;更新</button>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <table class="table table-hover table-bordered" id="history">
      <th><a href="javascript:;" onclick="list_sort('id','asc')">ID&nbsp;<?php if($od=='id'){if($by=='asc'){echo $asc; }else{echo $desc;}}else{echo $not;} ?></a></th>
      <th><a href="javascript:;" onclick="list_sort('time','asc')">开奖日期&nbsp;<?php if($od=='time'){if($by=='asc'){echo $asc; }else{echo $desc;}}else{echo $not;} ?></a></th>
      <th><a href="javascript:;" onclick="list_sort('code','asc')">期号&nbsp;<?php if($od=='code'){if($by=='asc'){echo $asc; }else{echo $desc;}}else{echo $not;} ?></a></th>
      <th><a href="javascript:;" onclick="list_sort('dcb','asc')">中奖号码&nbsp;<?php if($od=='dcb'){if($by=='asc'){echo $asc; }else{echo $desc;}}else{echo $not;} ?></a></th>
      <th><a href="javascript:;" onclick="list_sort('sales','asc')">销售额&nbsp;<?php if($od=='sales'){if($by=='asc'){echo $asc; }else{echo $desc;}}else{echo $not;} ?></a></th>
      <th><a href="javascript:;" onclick="list_sort('first','asc')">一等奖&nbsp;<?php if($od=='first'){if($by=='asc'){echo $asc; }else{echo $desc;}}else{echo $not;} ?></a></th>
      <th><a href="javascript:;" onclick="list_sort('second','asc')">二等奖&nbsp;<?php if($od=='second'){if($by=='asc'){echo $asc; }else{echo $desc;}}else{echo $not;} ?></a></th>
      <th><a href="javascript:;" onclick="list_sort('place','asc')">位置&nbsp;<?php if($od=='place'){if($by=='asc'){echo $asc; }else{echo $desc;}}else{echo $not;} ?></a></th>
      <?php
	  if($dcb_list){
		  foreach($dcb_list as $dcb){
			  ?>
			  <tr>
				<td><?php echo $dcb['id']; ?></a></td>
				<td><?php echo $dcb['time']; ?></td>
				<td><?php echo $dcb['code']; ?></td>
				<td><?php echo $dcb['dcb'];//dc($dcb['dcb']); ?></td>
				<td><?php echo $dcb['sales']; ?></td>
				<td><?php echo $dcb['first']; ?></td>
				<td><?php echo $dcb['second']; ?></td>
				<td><?php echo $dcb['place']; ?></td>
			  </tr>
			  <?php
		  }
      }else{
      ?>
          <tr>
            <td colspan="8">暂无任何记录</td>
          </tr>
      <?php
	  }
	  ?>
    </table>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <nav>
      <ul class="pagination">
        <?php echo $page_bottom; ?>
      </ul>
    </nav>
  </div>
</div>

<script type="text/javascript">
$(function(){
		   
		   
});

function update(){
	$.ajax({
		url:'index.php?controller=model&model=dcb&function=update&time='+ new Date().getTime(),
		data:'',
		type:'POST',
		async:true,
		beforeSend: function(){
			pop_loading();
		},
		success: function(text){
			pop_loading_close();
			if(text){
				pop_alert(text);
				console.log(text);
			}else{
				window.location.reload();
			}
		}
	});
}
function alldcb(){
	$.ajax({
		url:'index.php?controller=model&model=dcb&function=alldcb&time='+ new Date().getTime(),
		data:'',
		type:'POST',
		async:true,
		beforeSend: function(){
			pop_loading();
		},
		success: function(text){
			pop_loading_close();
			if(text){
				alert(text);
				console.log(text);
			}else{
				window.location.reload();
			}
		}
	});
}
function del(){
	$.ajax({
		url:'index.php?controller=model&model=dcb&function=del&time='+ new Date().getTime(),
		data:'delnum='+$('#delnum').val(),
		type:'POST',
		async:true,
		beforeSend: function(){
			pop_loading();
		},
		success: function(text){
			pop_loading_close();
			if(text){
				alert(text);
				console.log(text);
			}else{
				window.location.reload();
			}
		}
	});
}
function trunset(){
	$.ajax({
		url:'index.php?controller=model&model=dcb&function=trunset&time='+ new Date().getTime(),
		data:'',
		type:'POST',
		async:true,
		beforeSend: function(){
			pop_loading();
		},
		success: function(text){
			pop_loading_close();
			if(text){
				alert(text);
				console.log(text);
			}else{
				window.location.reload();
			}
		}
	});
}
</script>

<?php require(FILE_ROOT.'/view/footer.php'); ?>
