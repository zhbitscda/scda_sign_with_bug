<?php
include './lib/mysql_contral.php';
include './lib/class_other.php';
include './lib/session_mem.php';
if(isset($_SESSION['uid'])){
	$status['usr']=$_SESSION['usr'];
	echo json_encode($status);
}
?>