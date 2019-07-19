<?php
include'connection.php';
$id=$_REQUEST['id'];
$get_record="SELECT gym_member.image,gym_member.member_id,gym_member.first_name,gym_member.address,
gym_member.email,gym_member.mobile,gym_member.gender,gym_member.birth_date,gym_member.username,
membership.membership_label,gym_member.membership_status,gym_member.membership_valid_to,
gym_member.intrested_area,gym_group.name FROM `gym_member` INNER JOIN membership ON membership.id=gym_member.selected_membership 
INNER JOIN gym_group ON gym_group.id=gym_member.activated WHERE gym_member.id='$id'";
$get_rec="SELECT class_schedule.class_name FROM `class_schedule` 
INNER JOIN gym_member_class ON gym_member_class.assign_class=class_schedule.id where gym_member_class.member_id='$id'";
//$get_staff="SELECT gym_member.first_name,gym_member.last_name FROM `gym_member` WHERE `id`='$id'";
$a="SELECT assign_staff_mem FROM `gym_member` where `id`='$id'";
$idd=mysqli_fetch_assoc(mysqli_query($conn,$a))['assign_staff_mem'];
$get_staff = "SELECT first_name,last_name FROM `gym_member` where `id` = '$idd' ";

$intreast="SELECT `intrested_area` FROM `gym_member` WHERE `id`='$id'";
$intr=mysqli_fetch_assoc(mysqli_query($conn,$intreast))['intrested_area'];
$get_intreast="SELECT `interest` FROM `gym_interest_area` WHERE `id`='$intr'";

$get_intreast = mysqli_real_escape_string($conn,$get_intreast);
$select_intreast=$conn->query($get_intreast);
$get_staff = mysqli_real_escape_string($conn,$get_staff);
$select_staff=$conn->query($get_staff);
$get_rec = mysqli_real_escape_string($conn,$get_rec);
$select_querys=$conn->query($get_rec);
$get_record = mysqli_real_escape_string($conn,$get_record);
$select_query=$conn->query($get_record);
$result=array();

if($select_intreast != false)
{
	if(mysqli_num_rows($select_intreast) > 0){
		$result['status']='1';
		$result['error']='';
		$staff_intreast="";
		while($get_data=mysqli_fetch_assoc($select_intreast)){
			//$get_data['image']=$server_path."GYM/gym_master/webroot/upload/".$get_data['image'];
			//$class=$class.$get_data;
			$staff_intreast.=$get_data['interest']."";
		}
	}else
	{
		$result['status']='0';
		$result['error']='Record not found';
		$result['result']=array();
	}
}else
{
	$result['status']='0';
	$result['error']='Record not found';
	$result['result']=array();
}

if($select_staff != false)
{
	if(mysqli_num_rows($select_staff) > 0){
		$result['status']='1';
		$result['error']='';
		$staff_member="";
		while($get_data=mysqli_fetch_assoc($select_staff)){
			//$get_data['image']=$server_path."GYM/gym_master/webroot/upload/".$get_data['image'];
			//$class=$class.$get_data;
			$staff_member.=$get_data['first_name']." ";
			$staff_member.=$get_data['last_name']."";
		}
	}else
	{
		$result['status']='0';
		$result['error']='Record not found';
		$result['result']=array();
	}
}else
{
	$result['status']='0';
	$result['error']='Record not found';
	$result['result']=array();
}

if($select_querys != false)
{
	if(mysqli_num_rows($select_querys) > 0){
		$result['status']='1';
		$result['error']='';
		$class="";
		while($get_data=mysqli_fetch_assoc($select_querys)){
			//$get_data['image']=$server_path."GYM/gym_master/webroot/upload/".$get_data['image'];
			//$class=$class.$get_data;
			$class.=$get_data['class_name'].",";
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

if($select_query != false)
{
	if(mysqli_num_rows($select_query) > 0 ){
		$result['status']='1';
		$result['error']='';
		while($get_data=mysqli_fetch_assoc($select_query)){
			$get_data['image']=$image_path.$get_data['image'];
			$get_data['class']=rtrim($class,",");
			$get_data['staff_member']=rtrim($staff_member,"");
			$get_data['intrested_area']=rtrim($staff_intreast,"");
			$result['result'][]=$get_data;
			
		
		}
	}else
	{
		$result['status']='0';
		$result['error']='Record not found';
		$result['result']=array();
	}
}else
{
	$result['status']='0';
	$result['error']='Record not found';
	$result['result']=array();
}

echo json_encode($result);
?>