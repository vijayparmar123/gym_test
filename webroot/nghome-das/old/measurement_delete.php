<?php
include('connection.php');
$id=$_REQUEST['id'];
$sql="DELETE FROM `gym_measurement` WHERE `id`=$id";
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