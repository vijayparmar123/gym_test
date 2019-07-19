<?php
include('connection.php');
if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
$query="SELECT `record_date` FROM `gym_daily_workout` WHERE `member_id`=6";
$query = mysqli_real_escape_string($conn,$query);
$res=$conn->query($query);
if($res != false)
{
	if ($res->num_rows > 0) {
		$result['status']='1';
		$result['error']='';

		while($row = $res->fetch_assoc()) 
		{
			$d = date_parse_from_format("Y-m-d", $row['record_date']);
		
			//$result[$d['year']][$d['month']][][$d['day']]=$d['month'];.
			$dateObj   = DateTime::createFromFormat('!m', $d['month']);
			$monthName = $dateObj->format('F');
			$month[]=$d['year'].' '.$monthName;
			//$result[$d['year'].' '.$monthName][]=$d['day'];
			
		}
		$month=array_unique($month);
		$result['result']=array_values($month);
		
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
//echo $result['2016 August'][0];
echo json_encode($result);
$conn->close();
?>