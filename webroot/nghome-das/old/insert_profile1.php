<?php
include'connection.php';
$id=$_REQUEST['id'];
$username=$_REQUEST['username'];
$first_name=$_REQUEST['first_name'];
$last_name=$_REQUEST['last_name'];
$address=$_REQUEST['address'];
$email=$_REQUEST['email'];
$birth_date=$_REQUEST['birth_date'];
$password=$_REQUEST['password'];
$password = password_hash($password,PASSWORD_DEFAULT);
//$sql="UPDATE `gym_member` SET `username`='$username' WHERE id=10";
$sql="UPDATE `gym_member` SET `username`='$username',`first_name`='$first_name',`last_name`='$last_name',`address`='$address', 
`email`='$email',`birth_date`='$birth_date',`password`='$password' WHERE id=$id";
if($conn->query($sql))
{
	$result['status']="1";
	$result['error']="Insert Record";
}
else
{
	$result['status']="0";
	$result['error']="Something getting wrong!";
}
echo json_encode($result);
?>