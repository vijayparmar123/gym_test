<?php
include('connection.php');
$id=$_REQUEST['id'];
$sql="SELECT `member_type` FROM `gym_member` WHERE `id`=$id";
$sql = mysqli_real_escape_string($conn,$sql);
$res=$conn->query($sql);
if($res != false)
{
	if ($res->num_rows > 0) {
		$result['status']='1';
		$result['error']='';
		$mType=$res->fetch_assoc()['member_type'];
		if($mType=='Member')
		{
			$result['result'][]="Paypal";
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