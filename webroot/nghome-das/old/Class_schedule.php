<?php
include'connection.php';
$id=$_REQUEST['id'];
$get_record="SELECT class_schedule_list.days,class_schedule.class_name,class_schedule_list.start_time,
class_schedule_list.end_time FROM `class_schedule_list` INNER JOIN 
class_schedule ON class_schedule_list.class_id=class_schedule.id WHERE class_id=(SELECT `assign_class` FROM `gym_member` WHERE `id`=$id)";
$get_record = mysqli_real_escape_string($conn,$get_record);
    $select_query=$conn->query($get_record);
    $result=array();
if($select_query != false)
{   
	if(mysqli_num_rows($select_query) > 0){
		$result['status']='1';
		$result['error']='';
		while($get_data=mysqli_fetch_assoc($select_query)){
			$new_days=implode(",",json_decode($get_data['days']));
			$get_data['days']=$new_days;
			$result['result'][]=$get_data;
		}
		
	}else{
		$result['status']='0';
		$result['error']='Record Not Found';
		$result['result']=array();
	}
}else{
	$result['status']='0';
	$result['error']='Record Not Found';
	$result['result']=array();
}

echo json_encode($result);
?>