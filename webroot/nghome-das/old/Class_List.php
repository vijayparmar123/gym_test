<?php
include'connection.php';
$id=$_REQUEST['id'];
$sql="SELECT `assign_class` FROM `gym_member_class` WHERE `member_id`=$id";
$sql = mysqli_real_escape_string($conn,$sql);
$select_query=$conn->query($sql);
$result=array();
$r = array();
if($select_query != false)
{
	if(mysqli_num_rows($select_query) > 0){
		while($get_data=mysqli_fetch_assoc($select_query)){
			$r[]=$get_data['assign_class'];
		}
	}
}
else{
		$result['status']='0';
		$result['error']='Record Not Found';
		$result['result']=array();
		}
for($i=0;$i<sizeof($r);$i++)
{
$get_record="SELECT class_schedule.class_name,gym_member.first_name,gym_member.last_name,
class_schedule.start_time,class_schedule.end_time,class_schedule.location FROM 
`class_schedule` INNER JOIN gym_member ON gym_member.id=class_schedule.assign_staff_mem WHERE 
class_schedule.id ='".$r[$i]."'";
$get_record = mysqli_real_escape_string($conn,$get_record);
$select_query=$conn->query($get_record);
if($res != false)
{
	if(mysqli_num_rows($select_query) > 0){
		$result['status']='1';
		$result['error']='';
		while($get_data=mysqli_fetch_assoc($select_query)){
			$result['result'][]=$get_data;
		}
	}else{
		$result['status']='0';
		$result['error']='Record Not Found';
		$result['result']=array();
		}
}
else{
		$result['status']='0';
		$result['error']='Record Not Found';
		$result['result']=array();
		}
}
echo json_encode($result);
?>