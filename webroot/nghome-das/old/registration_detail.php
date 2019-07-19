<?php
include("connection.php");

$query="SELECT `username` FROM `gym_member` ";
$query = mysqli_real_escape_string($conn,$query);
$sql=$conn->query($query);
$result['status']="1";
$result['error']="";
if($sql != false)
{
	if($sql->num_rows > 0)
	{
		while($row=$sql->fetch_assoc())
		{
			$result['username'][]=$row['username'];
		}
	}
	else{
			$result['username'][]=array();
	}
}
else{
		$result['username'][]=array();
}
$query1="SELECT `id` FROM `gym_member` ORDER BY `id` DESC LIMIT 1";
$query1 = mysqli_real_escape_string($conn,$query1);
$res=$conn->query($query1);
$lastid=$res->fetch_assoc()['id'];
$lastid = ($lastid != null) ? $lastid + 1 : 01 ;
$m = date("d");
$y = date("y");
$prefix = "M".$lastid;
$member_id = $prefix.$m.$y;
$result['result']['member_id']=$member_id;
//Class List
$sql="SELECT `id`,`class_name` FROM `class_schedule`";
$sql = mysqli_real_escape_string($conn,$sql);
$res=$conn->query($sql);
if($res != false)
{
	if($res->num_rows > 0)
	{
		while($row=$res->fetch_assoc())
		{
			$result['result']['class'][]=$row;
		}
	}
	else
	{
		$result['result']['class']=array();
	}
}
else
{
	$result['result']['class']=array();
}
//Group list
$sql="SELECT `id`,`name` FROM `gym_group`";
$sql = mysqli_real_escape_string($conn,$sql);
$res=$conn->query($sql);
if($res != false)
{
	if($res->num_rows > 0)
	{
		while($row=$res->fetch_assoc())
		{
			$result['result']['group'][]=$row;
		}
	}
	else
	{
		$result['result']['group']=array();
	}
}
else
{
	$result['result']['group']=array();
}
//Interest area
$sql="SELECT * FROM `gym_interest_area`";
$sql = mysqli_real_escape_string($conn,$sql);
$res=$conn->query($sql);
if($res != false)
{
	if($res->num_rows > 0)
	{
		while($row=$res->fetch_assoc())
		{
			$result['result']['interest_area'][]=$row;
		}
	}
	else
	{
		$result['result']['interest_area']=array();
	}
}
else
{
	$result['result']['interest_area']=array();
}
//Membership
$sql="SELECT `id`,`membership_label` FROM `membership`";
$sql = mysqli_real_escape_string($conn,$sql);
$res=$conn->query($sql);
if($res != false)
{
	if($res->num_rows > 0)
	{
		while($row=$res->fetch_assoc())
		{
			$result['result']['membership'][]=$row;
		}
	}
	else
	{
		$result['result']['membership']=array();
	}
}
else
{
	$result['result']['membership']=array();
}
echo json_encode($result);

?>