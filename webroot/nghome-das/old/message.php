<?php
include("connection.php");
if(isset($_REQUEST['mp_id'])){$id=$_REQUEST['mp_id'];}
$sql="SELECT * FROM `membership_payment` WHERE `mp_id`= $id";
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
			$result['result'][]=$row;
		}
	} 
	else
	{
		$result['status']='0';
		$result['error']='Username Or Password are wrong';
		$result['result']=array();
		
	}
}
else
{
	$result['status']='0';
	$result['error']='Username Or Password are wrong';
	$result['result']=array();
	
}
echo json_encode($result);
$conn->close();
?>