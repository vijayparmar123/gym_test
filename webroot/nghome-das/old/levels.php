<?php
include('connection.php');
$sql="SELECT `id`, `level` FROM `gym_levels`";
$sql = mysqli_real_escape_string($conn,$sql);
$res=$conn->query($sql);
if($res != false)
{
	if ($res->num_rows > 0) {
		$result['status']='1';
		$result['error']='';
		while($row = $res->fetch_assoc()) 
		{
			$result['result']['levels'][]=$row;
		}
	}
	else
	{
		$result['status']='1';
		$result['error']='';
		$result['result']=array();
	}
}
else
{
	$result['status']='1';
	$result['error']='';
	$result['result']=array();
}
echo json_encode($result);
?>