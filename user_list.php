<?php
include './lib/mysql_contral.php';
include './lib/class_other.php';
include './lib/session_mem.php';
include './lib/excel_io.php';
$db=new db_contral();
$db->connect_db();
if(isset($_SESSION['uid'])){
	$r=$db->db_query_n1('acc','uid',0,'!=',0);
 	echo json_encode($r);
}
else{
	$r[0]['error']=1;
}
?>