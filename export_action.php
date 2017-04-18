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
    $table[0]['appid']='申请ID';
	$table[0]['personid']='统一人员ID';
	$table[0]['name']='名称';
	$table[0]['tel']='电话';
		$table[0]['address']='地址/展位号';
		$table[0]['department']='部门';
	$table[0]['status']='签到状态';
	$table[0]['status_exit']='签退状态';
	$sta[0]='未到';$sta[1]='已到';
	$p=1;
	foreach($r as $k=>$v){
		foreach($v as $key=>$d){
			$table[$p][$key]=$d;
		if($key=='status'||$key=='status_exit'){
				$table[$p][$key]=$sta[$d];
			}
		}
		$p++;
	}
	$o=new other_func();
	$ro=$o->random(5, 0);
	$fname='export_'.time().$ro.'.xls';
	//print_r($r);
	$exl->Toxls($table, $fname);
}
else{//默认情况下导出全部
    echo 'No ID!';
}
?>