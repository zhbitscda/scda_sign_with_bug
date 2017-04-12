<?php
include './lib/mysql_contral.php';
include './lib/class_other.php';
include './lib/session_mem.php';
include './lib/excel_io.php';
if(isset($_SESSION['uid'])){
	$db=new db_contral();
    $db->connect_db();
	$r=$db->db_query_n1('active', 'aid',0,'!=',0);
	//print_r($r);
	echo json_encode($r);
}else{
	$o=new other_func();
	$o->jref('login.php');
}
?>