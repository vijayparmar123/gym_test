<?php
include('connection.php');
if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
$query="SELECT DISTINCT `record_date` FROM `gym_daily_workout` WHERE `member_id`=$id ORDER BY `record_date` DESC";
$query = mysqli_real_escape_string($conn,$query);
$res=$conn->query($query);
if($res != false)
{
	if ($res->num_rows > 0) {
		$result['status']='1';
		$result['error']='';
		while($row = $res->fetch_assoc()) 
		{
		 $date = $row['record_date'];
			$query="SELECT `id` FROM `gym_daily_workout` WHERE `record_date`='$date' AND `member_id` = $id";
			$res1=$conn->query($query);
			while($r1 = $res1->fetch_assoc()) 
			{
				$wid=$r1['id'];
				$sql="SELECT  `id`,`workout_name`, `sets`, `reps`, `kg`,`rest_time` FROM `gym_user_workout` WHERE `user_workout_id`=$wid";
				$res2=$conn->query($sql);
				if ($res2->num_rows > 0) 
				{
					while($r2 = $res2->fetch_assoc()) 
					{
						$r2['workout_name']=workout_name($r2['workout_name']);
						$r2['date']=$date;
						$result['result'][]=$r2;
					}
				}
				else
				{
					
				}
			}
			
		}
	}
	else
	{
		$result['status']='0';
		$result['error']='No records!';
		$result['result']=array();
		
	}
}
else
{
	$result['status']='0';
	$result['error']='No records!';
	$result['result']=array();
	
}
function workout_name($id)
{
	include('connection.php');
	$sql="SELECT `title` FROM `activity` WHERE `id`=$id";
	return $conn->query($sql)->fetch_assoc()['title'];
} 

//echo $result['2016 August'][0];

echo json_encode($result);
$conn->close();
?>