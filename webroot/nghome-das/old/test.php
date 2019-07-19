<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
	$
});
</script>
<?php

if (!defined('DS')) {
define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT')) {
define('ROOT', dirname(dirname(dirname(__FILE__)))."\config");
}
if (!defined('APP_DIR')) {
define('APP_DIR', basename(dirname(dirname(__FILE__))));
}
if (!defined('WEBROOT_DIR')) {
define('WEBROOT_DIR', basename(dirname(__FILE__)));
}
if (!defined('WWW_ROOT')) {
define('WWW_ROOT', dirname(__FILE__) . DS);
}

// var_dump();
// echo ROOT;
// require_once(ROOT."\bootstrap.php");
// require_once('yourlocalpath/cakephp/app/Controller/AbsController.php');
// $user = new AbsController();
// $user->testfn('2');

  // $ch = curl_init(); 
    // curl_setopt($ch, CURLOPT_URL, "http://localhost/app/abs/testfn/1"); 
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    // $output = curl_exec($ch);  
    // curl_close($ch);
	// echo $output;
	$hash = '$2y$10$DU1UPr74XbMogMOqNNGqUOMhXIO2F5xcoERs8bWIcaG.G5PUWGBZC';
	$check = password_verify("viper",$hash);
	var_dump($check);