<?php
include'connection.php';
$id=$_REQUEST['id'];
$get_record="SELECT membership.membership_label,membership_payment.membership_amount,
membership_payment.paid_amount,membership_payment.start_date,membership_payment.end_date,
membership_payment.payment_status FROM `membership_payment` INNER JOIN membership ON 
membership_payment.membership_id=membership.id WHERE member_id='$id'";
$get_record = mysqli_real_escape_string($conn,$get_record);
$select_query=$conn->query($get_record);
$result=array();
if($select_query != false)
{
	if(mysqli_num_rows($select_query) > 0){
		$result['status']='1';
		$result['error']='';
		while($get_data=mysqli_fetch_assoc($select_query)){
			$get_data['due_amount']=$get_data['membership_amount']-$get_data['paid_amount']."";
		if($get_data['membership_amount']==$get_data['paid_amount'])
			{
				$get_data['payment_status']="Paid";
			}
			else if($get_data['paid_amount']>0 && $get_data['paid_amount']<$get_data['membership_amount'])
			{
				$get_data['payment_status']="Partially Paid";
			}
			else
			{
				$get_data['payment_status']="Not Paid";
			}
			$result['result'][]=$get_data;
			
		}
	}else
	{
		$result['status']='0';
		$result['error']='Record Not Found';
		$result['result']=array();
	}
}
else
{
	$result['status']='0';
	$result['error']='Record Not Found';
	$result['result']=array();
}
echo json_encode($result);

?>