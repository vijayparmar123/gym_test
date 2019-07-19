<?php
include('connection.php');
$sql="SELECT `id`, `name` FROM `category`";
$res=$conn->query($sql);
if ($res->num_rows > 0) {
	$result['status']='1';
	$result['error']=custom_http_response_code(200);
    while($row = $res->fetch_assoc()) 
	{
		$row['name']=trim($row['name']);
		$result['result']['category'][]=$row;
	}
}
else
{
	$result['status']='0';
	//$result['error']=custom_http_response_code(404);
	$result['result']=array();
	$result['error'] = "Opps! Category not display..";
}
echo json_encode($result);
?>