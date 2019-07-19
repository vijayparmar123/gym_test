<?php
include('connection.php');
$sql="SELECT `id`, `name` FROM `category`";
$sql = mysqli_real_escape_string($conn,$sql);
$res=$conn->query($sql);
if($res != false)
{
	if ($res->num_rows > 0) {
		$result['status']='1';
		$result['error']='';
		while($row = $res->fetch_assoc()) 
		{
			$row['name']=trim($row['name']);
			$result['result']['category'][]=$row;
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