<?php
include("connection.php");
$sql="UPDATE `gym_member` SET `password`='$2y$10$2TS1CvbwxqVge7u0tjqUMunL9hkTs19j.ci99dAvzHD5q7ygGVI0e' WHERE `id` = 6";
$conn->query($sql);
?>