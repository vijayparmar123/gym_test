<?php
include'connection.php';
$id=$_REQUEST['id'];
$r="SELECT `selected_membership` FROM `gym_member` WHERE `id`= $id";
$r = mysqli_real_escape_string($conn,$r);
$res=$conn->query($r);
if($res != false)
{
	$id=mysqli_fetch_assoc($res)['selected_membership'];
}
else
{
	$id = '';
}
$get_record="SELECT c.first_name,c.last_name,b.title,d.name FROM membership_activity a 
LEFT JOIN activity b ON a.activity_id = b. id
LEFT JOIN  gym_member c ON b.assigned_to = c.id
LEFT JOIN category d ON b.cat_id=d.id
where a.membership_id=$id";
$get_record = mysqli_real_escape_string($conn,$get_record);
$select_query=$conn->query($get_record);
$result=array();
if($select_query != false)
{
	if(mysqli_num_rows($select_query) > 0){
		$result['status']='1';
		$result['error']='';
		while($get_data=mysqli_fetch_assoc($select_query)){
			$result['result'][]=$get_data;
		}
	}else
	{
		$result['status']='0';
		$result['error']='Record not found';
		$result['result']=array();
	}
}else{
	$result['status']='0';
	$result['error']='Record not found';
	$result['result']=array();
}
echo json_encode($result);
?>