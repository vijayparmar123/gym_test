<?php
include'connection.php';
$id=$_REQUEST['id'];
$get_record="SELECT `attendance_date`,`status` FROM `gym_attendance` WHERE `user_id`='$id'";
$get_record = mysqli_real_escape_string($conn,$get_record);
$select_query=$conn->query($get_record);
$result=array();
if($select_query != false)
{
if(mysqli_num_rows($select_query) > 0){
	$result['status']='1';
	$result['error']='';
	while($get_data=mysqli_fetch_assoc($select_query)){
		$day=date("l",strtotime($get_data['attendance_date']));
		$get_data['day']=$day;
		$result['result'][]=$get_data;
	}
}else
{
	$result['status']='0';
	$result['error']='Record not found';
	$result['result']=array();
}
}
else
{
	$result['status']='0';
	$result['error']='Record not found';
	$result['result']=array();
}
echo json_encode($result);
?>