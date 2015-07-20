<?php
//数据库
class DB{
	public static function Connect(){
		$conn=mysqli_connect(_DB_SERVER_,_DB_USER_,_DB_PASSWD_);
		mysqli_select_db($conn,_DB_NAME_);
		mysqli_query($conn,'set names utf8');
		return $conn;
	}
	public static function Get_arr($sql,$is_num=false){
		global $conn;
		$result=mysqli_query($conn,$sql);
		if($is_num){
			$db_arr=mysqli_fetch_array($result,$is_num);
		}else{
			$db_arr=mysqli_fetch_array($result,MYSQLI_ASSOC);
		}
		return $db_arr;
	}
	public static function Get_one($sql){
		global $conn;
		$result=mysqli_query($conn,$sql);
		/*if (!$result) {
		 printf("Error: %s\n", mysqli_error($conn));
		 exit();
		}*/
		$arr=mysqli_fetch_array($result,MYSQLI_NUM);
		return $arr[0];
	}
}

//分页
class Page{
	private $nums;
	private $page;
	private $pagesize;
	private $pages;
	
	public function __construct($nums,$page,$pagesize,$index){
		//获取记录数
		$this->nums=$nums;
		//设定每页的记录数
		$this->pagesize=$pagesize;
		//索引页名称
		$this->index=$index;
		
		//获取页数
		$pages=ceil($this->nums/$this->pagesize);
		//设定总页数至少1页
		if($pages<1){
			$this->pages=1;
		}else{
			$this->pages=$pages;
		}
		//如果传递过来的页数比总页数还大，就让它等于总页数，如果传递过来的页数小于1，就让他等于1
		if($page>$this->pages){
			$this->page=$this->pages;
		}elseif($page<1){
			$this->page=1;
		}else{
			$this->page=$page;
		}
	}
	//获得开始数
	public function Page_start(){
		$start=($this->page-1)*$this->pagesize;
		return $start;
	}
	//获得分页
	public function Page_bottom(){
		$page_bottom='';
		//上一个
		if($this->page==1){
			$page_bottom.='<li class="disabled"><a href="javascript:;">&laquo;</a></li>';
		}else{
			$prev=$this->page-1;
			if($prev==1){
				$page_bottom.='<li><a href="javascript:;" onclick=url_change("all","'.$this->index.'","pg")>&laquo;</a></li>';
			}else{
				$page_bottom.='<li><a href="javascript:;" onclick=url_change("replace","'.$this->index.'","pg",'.$prev.')>&laquo;</a></li>';
			}
		}
		
		/*
		//页码
		$col=2;
		$first_page=$this->page-$col;
		$last_page=$this->page+$col;
		//开始
		if($first_page>1){
			$page_bottom.='<li><a href="javascript:;" onclick=url_change("all","'.$this->index.'","pg")>1</a></li>';
			if($first_page>2){
				$page_bottom.='<li><span>...</span></li>';
			}
		}
		//中间
		if($first_page<1){
			$first_page=1;
		}
		if($last_page>$this->pages){
			$last_page=$this->pages;
		}
		for($i=$first_page;$i<=$last_page;$i++){
			if($this->page==$i){
				$page_bottom.='<li class="active"><a href="javascript:;">'.$i.'</a></li>';
			}else{
				if($i==1){
					$page_bottom.='<li><a href="javascript:;" onclick=url_change("all","'.$this->index.'","pg")>'.$i.'</a></li>';
				}else{
					$page_bottom.='<li><a href="javascript:;" onclick=url_change("replace","'.$this->index.'","pg",'.$i.')>'.$i.'</a></li>';
				}
			}
		}
		//结尾
		if($last_page<$this->pages){
			if($last_page<($this->pages-1)){
				$page_bottom.='<li><span>...</span></li>';
			}
			$page_bottom.='<li><a href="javascript:;" onclick=url_change("replace","'.$this->index.'","pg",'.$this->pages.')>'.$this->pages.'</a></li>';
		}
		*/
		
		//页码
		$col=4;
		$end=($col+1)*2;
		$start=$end+1;
		$omit='<li><span>...</span></li>';
		$first='<li><a href="javascript:;" onclick=url_change("all","'.$this->index.'","pg")>1</a></li>'.$omit;
		$last=$omit.'<li><a href="javascript:;" onclick=url_change("replace","'.$this->index.'","pg",'.$this->pages.')>'.$this->pages.'</a></li>';
		
		if($this->pages<=$start){
			//数据少
			for($i=1;$i<=$this->pages;$i++){
				if($this->page==$i){
					$page_bottom.='<li class="active"><a href="javascript:;">'.$i.'</a></li>';
				}else{
					if($i==1){
						$page_bottom.='<li><a href="javascript:;" onclick=url_change("all","'.$this->index.'","pg")>'.$i.'</a></li>';
					}else{
						$page_bottom.='<li><a href="javascript:;" onclick=url_change("replace","'.$this->index.'","pg",'.$i.')>'.$i.'</a></li>';
					}
				}
			}
		}elseif($this->page<$start){
			//开始
			for($i=1;$i<=$start;$i++){
				if($this->page==$i){
					$page_bottom.='<li class="active"><a href="javascript:;">'.$i.'</a></li>';
				}else{
					if($i==1){
						$page_bottom.='<li><a href="javascript:;" onclick=url_change("all","'.$this->index.'","pg")>'.$i.'</a></li>';
					}else{
						$page_bottom.='<li><a href="javascript:;" onclick=url_change("replace","'.$this->index.'","pg",'.$i.')>'.$i.'</a></li>';
					}
				}
			}
			$page_bottom.=$last;
		}elseif($this->page>($this->pages-$end)){
			//结尾
			$page_bottom.=$first;
			for($i=($this->pages-$end);$i<=$this->pages;$i++){
				if($this->page==$i){
					$page_bottom.='<li class="active"><a href="javascript:;">'.$i.'</a></li>';
				}else{
					$page_bottom.='<li><a href="javascript:;" onclick=url_change("replace","'.$this->index.'","pg",'.$i.')>'.$i.'</a></li>';
				}
			}
		}else{
			//中间
			$page_bottom.=$first;
			for($i=($this->page-$col);$i<=($this->page+$col);$i++){
				if($this->page==$i){
					$page_bottom.='<li class="active"><a href="javascript:;">'.$i.'</a></li>';
				}else{
					$page_bottom.='<li><a href="javascript:;" onclick=url_change("replace","'.$this->index.'","pg",'.$i.')>'.$i.'</a></li>';
				}
			}
			$page_bottom.=$last;
		}
		
		//下一个
		if($this->page==$this->pages){
			$page_bottom.='<li class="disabled"><a href="javascript:;">&raquo;</a></li>';
		}else{
			$page_bottom.='<li><a href="javascript:;" onclick=url_change("replace","'.$this->index.'","pg",'.($this->page+1).')>&raquo;</a></li>';
		}
		return $page_bottom;
	}
}

function dc($dcb){
	?>
	<style>
    .ball{
        width:30px;
        border-radius:30px; 
        padding:5px;
        color:#fff;
    }
    </style>
    <?php
	$ball_arr=explode(',',$dcb);
	foreach($ball_arr as $key=>$ball){
		?>
        <span class="ball" style="background:#<?php if($key==6){echo '00e';}else{echo 'e00';} ?>"><?php if($ball<10){echo '&nbsp;';}echo $ball;if($ball<10){echo '&nbsp;';} ?></span>
        <?php
	}
	//echo $dcb;
}
?>