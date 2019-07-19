<?php
include("connection.php");
if(isset($_REQUEST['mp_id'])){$id=$_REQUEST['mp_id'];}
$sql="SELECT * FROM `gym_message` WHERE `receiver`= $id AND `status`=1";
$sql = mysqli_real_escape_string($conn,$sql);
 $result=array();
$result1=$conn->query($sql);
if($result1 != false)
{
	if ($result1->num_rows > 0) {
		$result['status']='1';
		$result['error']='';
		while($row = $result1->fetch_assoc()) 
		{
			$sender=$row['sender'];
			$sql="SELECT `email` FROM `gym_member` WHERE id= $sender";
			$r=$conn->query($sql)->fetch_assoc();
			$row['email']=$r['email'];
			$date = new DateTime($row['date']);
			$new_date = $date->format('d/m/Y,h:i:s a');
			$row['date']=$new_date;
			$result['result'][]=$row;
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
echo json_encode($result);
$conn->close();
?>