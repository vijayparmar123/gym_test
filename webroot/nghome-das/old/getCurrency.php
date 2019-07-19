<?php
function getCurrency()
{
	include("connection.php");
	include("currency.php");
	$sql="SELECT `currency` FROM `general_setting`";
	$sql = mysqli_real_escape_string($conn,$sql);
	$res=$conn->query($sql);
	if($res != false)
	{
		if ($res->num_rows > 0) {
			
				$cur=mysqli_fetch_assoc($res)['currency'];
				return $currency_symbols[$cur];
		}
	}
}
?>