<?php
include './lib/mysql_contral.php';
include './lib/class_other.php';
include './lib/session_mem.php';
include './lib/excel_io.php';
$exl=new excel_io();
if(isset($_GET['active'])&&isset($_SESSION['uid'])){
	$db=new db_contral();
	$db->connect_db();
	$sql="SELECT appid,apply.personid,name,tel,address,department,status,status_exit FROM apply,person where apply.personid=person.personid AND apply.actid=?";	
    $r=$db->all_query_stmt($sql,array($_GET['active']));
	$o=new other_func();
	$ro=$o->random(5, 0);
	$fname='export_'.time().$ro.'.xls';
	$exl->Toxls($r, $fname);
}
else{//默认情况下导出全部
    echo 'No ID!';
}
?>