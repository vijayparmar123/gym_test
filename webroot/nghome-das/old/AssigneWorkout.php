<?php
include'connection.php';
$id=$_REQUEST['id'];
$sql="SELECT `id` FROM `gym_assign_workout` WHERE `user_id` =$id";
$sql = mysqli_real_escape_string($conn,$sql);
$select_query=$conn->query($sql);
if($select_query != false)
{
	if(mysqli_num_rows($select_query) > 0){
		$result['status']='1';
		$result['error']='';
		while($get_data=mysqli_fetch_assoc($select_query)){
				$id=$get_data['id'];
				$sql="SELECT `workout_name`,`day_name`,`reps`,`sets`,`kg`,`time` FROM `gym_workout_data` WHERE `workout_id`=$id";
				$query=$conn->query($sql);
				if(mysqli_num_rows($query) > 0)
				{
					while($r=mysqli_fetch_assoc($query))
					{
						$r['workout_name']=workout($r['workout_name']);
						$result['result'][]=$r;
					}
			}
	}
	}
	else
	{
		$result['status']='0';
		$result['error']='No Records!';
	}
}
else
{
	$result['status']='0';
	$result['error']='No Records!';
}
function workout($wid)
{
	global $conn;
	$sql="SELECT `title` FROM `activity` WHERE `id`=$wid";
	$sql = mysqli_real_escape_string($conn,$sql);
	$select_query=$conn->query($sql);
	$get_data=mysqli_fetch_assoc($select_query);
	return $get_data['title'];
}
echo json_encode($result);

?>



