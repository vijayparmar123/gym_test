<?php
include("connection.php");
if(isset($_REQUEST['id'])){$sender=$_REQUEST['id'];}
if(isset($_REQUEST['receiver'])){$receiver=$_REQUEST['receiver'];}
if(isset($_REQUEST['class'])){$class=$_REQUEST['class'];}
if(isset($_REQUEST['subject'])){$subject=$_REQUEST['subject'];}
if(isset($_REQUEST['msg_body'])){$msg_body=$_REQUEST['msg_body'];}
if($receiver=='-4'){$rec='member';}
else if($receiver=='-3'){$rec='staff_member';}
else if($receiver=='-2'){$rec='accountant';}
else if($receiver=='-1'){$rec='administrator';}
$result=array();
function send($id)
{
	global $sender,$subject,$msg_body,$date,$conn,$result;
	$sql="INSERT INTO `gym_message` (`sender`, `receiver`, `date`, `subject`, `message_body`, `status`) 
	VALUES ($sender,$id,CURRENT_TIMESTAMP,'$subject','$msg_body',1);";
	$sql = mysqli_real_escape_string($conn,$sql);
	if ($conn->query($sql)) {
		$result['status']='1';
		$result['error']='';
	}
	else
	{
		$result['status']='0';
		$result['error']='Something getting wrong!!';	
	}
}
$Temp=array();
if($receiver<0)
{
	$sql="SELECT `id` FROM `gym_member` WHERE `role_name`='$rec'";
	$sql = mysqli_real_escape_string($conn,$sql);
	$res=$conn->query($sql);
	if($res != false)
	{
		if ($res->num_rows > 0) 
		{
			while($row = $res->fetch_assoc())
			{
				array_push($Temp,$row['id']);
				send($row['id']);
			}
		}
	}
}
else
{
	array_push($Temp,$receiver);
	send($receiver);
}
if($class=='-2')
{
	$sql="SELECT DISTINCT `member_id` FROM `gym_member_class`";
	$sql = mysqli_real_escape_string($conn,$sql);
	$res=$conn->query($sql);
	if($res != false)
	{
		if ($res->num_rows > 0) 
		{
			while($row1 = $res->fetch_assoc())
			{
				if (!in_array($row1['member_id'], $Temp))
				{
					send($row1['member_id']);
				}
			}
		
		}
	}
	
}
else if($class>=0)
{
	$sql="SELECT `member_id` FROM `gym_member_class` WHERE `assign_class`=$class";
	$sql = mysqli_real_escape_string($conn,$sql);
	$res=$conn->query($sql);
	if($res != false)
	{
		if ($res->num_rows > 0) 
		{
			while($row2 = $res->fetch_assoc())
			{
				if (!in_array($row2['member_id'], $Temp))
				{
					send($row2['member_id']);
				}
			}
		}
	}
}
echo json_encode($result);
$conn->close();
//SELECT `member_id` FROM `gym_member_class` WHERE `assign_class`
?>
