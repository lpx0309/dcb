<?php
class sales{
	
	function sales(){
		$dcb_list=array();
		$dcb_history=mysqli_query($conn,'select time,sales from dcb_history order by id desc limit 0,10');
		while($dcb_arr=mysqli_fetch_assoc($dcb_history)){
			$dcb_list[]=$dcb_arr;
		}
		$dcb_list=array_reverse($dcb_list);
		echo json_encode($dcb_list);
		
	}
	
}
?>