<?php
include("connection.php");
$id=$_REQUEST['id'];

$sql="SELECT COUNT(*)  FROM `gym_member` WHERE `role_name` = 'member'";
$sql = mysqli_real_escape_string($conn,$sql);
$res=$conn->query($sql);
if($res != false)
{
	$result['member'] = mysqli_fetch_array($res)[0];
}
else
{
	$result['member'] = '';
}
$sql="SELECT COUNT(*)  FROM `gym_member` WHERE `role_name` = 'staff_member'";
$sql = mysqli_real_escape_string($conn,$sql);
$res=$conn->query($sql);
if($res != false)
{
	$result['staff_member'] = mysqli_fetch_array($res)[0];
}
else
{
	$result['staff_member'] = '';
}

$sql="SELECT COUNT(*) FROM `gym_group`";
$sql = mysqli_real_escape_string($conn,$sql);
$res=$conn->query($sql);
$result['group'] = mysqli_fetch_array($res)[0];
$sql="SELECT COUNT(*) FROM `gym_message` WHERE `receiver`=$id";
$sql = mysqli_real_escape_string($conn,$sql);
$res=$conn->query($sql);
if($res != false)
{
	$result['message'] = mysqli_fetch_array($res)[0];
}
else
{
	$result['message'] = '';
}

$sql="SELECT `birth_date`,`first_name`,`last_name` FROM `gym_member`";
$sql = mysqli_real_escape_string($conn,$sql);
$res=$conn->query($sql);
if($res != false)
{
	if($res->num_rows>0)
	{
		while($r=$res->fetch_assoc())
		{
			$row['name']=$r['first_name']." ".$r['last_name'];
			$time=strtotime($r['birth_date']);
			$month=date("m",$time);
			$day=date("d",$time);
			$year=date("Y");
			$row['birth_date']=$year."-".$month."-".$day;
			$result['Birthdate'][]=$row;
		}
	}
}

$sql="SELECT `notice_title`,`start_date`,`end_date` FROM `gym_notice` WHERE `notice_for`='member'";
$sql = mysqli_real_escape_string($conn,$sql);
$res=$conn->query($sql);
if($res != false)
{
	if($res->num_rows>0)
	{
		while($r=$res->fetch_assoc())
		{
			$begin = new DateTime($r['start_date']);
			$end = new DateTime($r['end_date']);
			$end = $end->modify( '+1 day' ); 
			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval ,$end);
			foreach($daterange as $date){
				 $r1['date']=$date->format("Y-m-d");
				 $r1['title']=$r['notice_title'];
				 $result['notice'][]=$r1;
			}
		}
		
	}
}

$sql="SELECT `event_name`,`event_date`,`start_time`,`end_time`,gym_event_place.place FROM `gym_reservation` 
LEFT JOIN gym_event_place ON gym_reservation.`place_id` = gym_event_place.id ";
$sql = mysqli_real_escape_string($conn,$sql);
$res=$conn->query($sql);
if($res != false)
{
	if($res->num_rows>0)
	{
		while($r=$res->fetch_assoc())
		{
				if (is_null($r['place']))  
					$r['place']="undefined";
				 $result['reservation'][]=$r;
		}
		
	}
}

echo json_encode($result);

?>