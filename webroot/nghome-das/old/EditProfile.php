<?php
include'connection.php';
$id=$_REQUEST['id'];
$get_record="SELECT `first_name`,`last_name`,`birth_date`,`address`, `city`, `state`,`mobile`,`phone`,`email`,`username`,`password`, `image` FROM `gym_member` WHERE `id`='$id'";
$get_record = mysqli_real_escape_string($conn,$get_record);
$select_query=$conn->query($get_record);
$result=array();
if($select_query != false)
{
	if(mysqli_num_rows($select_query) > 0){
		$result['status']='1';
		$result['error']='';
		while($get_data=mysqli_fetch_assoc($select_query)){
		   $get_data['image']=$server_path.$image_pa.$get_data['image'];
			$result['result'][]=$get_data;
		}
	}else
	{
		$result['status']='0';
		$result['error']='Record Not Found';
		$result['result']=array();
	}
}else
{
	$result['status']='0';
	$result['error']='Record Not Found';
	$result['result']=array();
}
echo json_encode($result);

?>