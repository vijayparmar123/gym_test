<?php
include('connection.php');
$id=$_REQUEST['id'];
$name=$_REQUEST['measurement'];
$result=$_REQUEST['result'];
$sql="UPDATE `gym_measurement` SET `result_measurment`='$name',`result`=$result WHERE `id`=$id";
$sql = mysqli_real_escape_string($conn,$sql); 
$result=array();
if ($conn->query($sql)) {
	$result['status']='1';
	$result['error']='';
} 
else
{
	$result['status']='0';
	$result['error']='Something getting wrong!!';
}
echo json_encode($result);
$conn->close();
?>