<?php
class dcb{
	public function __construct($item=false){
		$this->item=$item;
		global $conn;
		$this->conn=$conn;
	}
	//更新
	public function update(){
		if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
			$ping='n';
		}else{
			$ping='c';
		}
		exec('ping 123.125.114.144 -'.$ping.' 1',$ouput,$value);
		//echo $value;exit;
		if($value==0){
		//if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
			$file_url='http://kaijiang.zhcw.com/zhcw/html/ssq/list_';
			$html_start=42;
		}else{
			$file_url=FILE_ROOT.'/list_';
			$html_start=32;
		}
		$p=1;
		$stop=0;
		$last_code=2003001;
		
		//当前记录最后的期数
		$current_code=DB::Get_one('select code from dcb_history order by id desc');
		if(!isset($current_code)){
			$current_code=0;
		}
		
		//获取需要更新的数组
		$dcb_list=array();
		do{
			try{
				$dcb_history=file($file_url.$p.'.html');
				for($i=$html_start;$i<count($dcb_history)-20;$i+=30){
					$dcb=array();
					
					$dcb['time']=trim(strip_tags($dcb_history[$i]));
					$dcb['code']=intval(strip_tags($dcb_history[$i+1]));
					
					if($dcb['code']==$current_code){
						$stop=1;
						break;
					}
					
					$ball_arr=array();
					for($j=4;$j<=16;$j+=2){
						$ball_arr[]=intval(strip_tags($dcb_history[$i+$j]));
					}
					$dcb['dcb']=implode(',',$ball_arr);
					
					$dcb['place']=0;//$this->place($dcb['dcb']);//DB::Get_one('select id from dcb_all where dcb="'.$dcb['dcb'].'" ');//
					
					$dcb['sales']=intval(str_replace(',','',trim(strip_tags($dcb_history[$i+17]))));
					$dcb['first']=intval(strip_tags($dcb_history[$i+18]));
					$dcb['second']=intval(strip_tags($dcb_history[$i+21]));
				
					$dcb_list[]=$dcb;
					
					if($dcb['code']==$last_code){
						$stop=1;
						break;
					}
				}
				$p++;
				/*if($p%5==0){
					sleep(1);
				}*/
			}catch(Exception $e){
				//throw new Exception('');
			}
		}while($stop==0);
		
		//插入数据库
		if($dcb_list){
			$dcb_list=array_reverse($dcb_list);
			foreach($dcb_list as $dcb){
				mysqli_query($this->conn,'insert into dcb_history set time="'.$dcb['time'].'",
														 code="'.$dcb['code'].'",
														 dcb="'.$dcb['dcb'].'",
														 place="'.$dcb['place'].'",
														 sales="'.$dcb['sales'].'",
														 first="'.$dcb['first'].'",
														 second="'.$dcb['second'].'"
														 ');
				
			}
		}else{
			echo '已经是最新的了！';
		}
	}
	//获取位置
	public function place($dcb){
		if(!isset($_SESSION['dcb_all'])){
			$_SESSION['dcb_all']=array();
			//$key=1;
			for($i=1;$i<=33;$i++){
				for($j=$i+1;$j<=33;$j++){
					for($k=$j+1;$k<=33;$k++){
						for($l=$k+1;$l<=33;$l++){
							for($m=$l+1;$m<=33;$m++){
								for($n=$m+1;$n<=33;$n++){
									for($x=1;$x<=16;$x++){
										/*if($dcb==$i.','.$j.','.$k.','.$l.','.$m.','.$n.','.$x){
											return $key;
											exit;
										}
										$key++;*/
										$_SESSION['dcb_all'][]=$i.','.$j.','.$k.','.$l.','.$m.','.$n.','.$x;
									}
								}
							}
						}
					}
				}
			}
		}else{
			return array_search($dcb,$_SESSION['dcb_all']);
		}
		/*$place=array();
		$dcb='1,3,6,15,16,19,15';
		$ball_arr=explode(',',$dcb);
		foreach($ball_arr as $key=>$ball){
			if($key<6){
				$min=$key+1;
				$max=$key+28;
				$place[]=$ball-$min+1;
			}else{
				$min=1;
				$max=16;
				$place[]=$ball;
			}
			//echo $min;
		}
		print_r($place);*/
	}
	//生成
	public function alldcb(){
		for($i=1;$i<=33;$i++){
			for($j=$i+1;$j<=33;$j++){
				for($k=$j+1;$k<=33;$k++){
					for($l=$k+1;$l<=33;$l++){
						for($m=$l+1;$m<=33;$m++){
							for($n=$m+1;$n<=33;$n++){
								for($x=1;$x<=16;$x++){
									mysqli_query($this->conn,"insert into dcb_all (dcb) values ('".$i.",".$j.",".$k.",".$l.",".$m.",".$n.",".$x."')");
								}
							}
						}
					}
				}
			}
		}
		
		//http://kaijiang.zhcw.com/zhcw/inc/ssq/ssq_wqhg.jsp?pageNum=
		/*$file_url='http://kaijiang.zhcw.com/zhcw/html/ssq/list_';
		$html_start=42;
		$p=1;
		$stop=0;
		$last_code=2014100;
		do{
			try{
				$dcb_history=file($file_url.$p.'.html');
				for($i=$html_start;$i<count($dcb_history)-20;$i+=30){
					$code=intval(strip_tags($dcb_history[$i+1]));
					echo $code.' ';
					
					$sales=intval(str_replace(',','',trim(strip_tags($dcb_history[$i+17]))));
					$first=intval(strip_tags($dcb_history[$i+18]));
					$second=intval(strip_tags($dcb_history[$i+21]));
					mysqli_query($this->conn,'update dcb_history set sales='.$sales.',first='.$first.',second='.$second.' where code='.$code);
					
					if($code==$last_code){
						$stop=1;
						break;
					}
				}
				$p++;
				if($p%5==0){
					sleep(1);
				}
			}catch(Exception $e){
				//throw new Exception('');
			}
			//echo $stop;
		}while($stop==0);*/
	}
	public function del(){
		$id=DB::Get_one('select id from dcb_history order by id desc');

		mysqli_query($this->conn,'delete from dcb_history where id>'.($id-$this->item['delnum']));
		mysqli_query($this->conn,'ALTER TABLE  dcb_history AUTO_INCREMENT ='.($id-$this->item['delnum']+1));
	}
	public function trunset(){
		//mysqli_query($this->conn,'update dcb_history set sales=0');
		mysqli_query($this->conn,'truncate table dcb_history');
		//echo '/opt/lampp/bin/mysql -uadmin -padmin -e "use dcb" < '.FILE_ROOT.'/dcb_history.sql';
		//echo exec('/opt/lampp/bin/mysql -uadmin -padmin < '.FILE_ROOT.'/dcb_history.sql',$output,$value).' ';
		//echo $output.' ';
		//echo $value.' ';
		/*$sql_arr=file(FILE_ROOT.'/dcb_history.sql');
		foreach($sql_arr as $key=>$sql){
			echo $key.'=>'.$sql;
			mysqli_query($this->conn,$sql);
		}*/
	}
	public function partrand(){
		$is_exists=false;
		do{
			$partrand=mt_rand($this->item['start_place'],$this->item['end_place']);
			$is_exists=DB::Get_one('select id from dcb_history where place='.$partrand);
		}while($is_exists);
		echo dc(DB::Get_one('select dcb from dcb_all where id='.$partrand));
	}
}