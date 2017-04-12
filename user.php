<?php
include './lib/mysql_contral.php';
include './lib/class_other.php';
include './lib/session_mem.php';
include './lib/excel_io.php';
$db=new db_contral();
$db->connect_db();
if(isset($_SESSION['uid'])){
	switch($_GET['action']){
		case 'del':
		$db->del_data('acc',array('uid'),array('='), array($_GET['uid']), array());
		break;
		case 'add':
		if($_POST['pwd']!=''&&$_POST['usr']!=''){
		$r=$db->db_query_n1('acc', 'usr', $_POST['usr']);
		if(!count($r)){
		$o=new other_func();
		$salt=$o->random(8, 0);
		$pwd=md5($_POST['pwd'].$salt);
		$db->ins_data('acc',array('usr','pwd','salt'), array($_POST['usr'],$pwd,$salt));
		}
		else{
			$err[0]['error']=2;
			echo json_encode($err);
		}
		}
		else{
			$err[0]['error']=1;
			echo json_encode($err);
		}
		break;
		case 'change_pwd':
		$r=$db->db_query_n1('acc', 'uid', $_GET['uid']);
		$salt=$r[0]['salt'];
		$pwd=md5($_POST['pwd'].$salt);
		$db->update_data_basic('acc', array('pwd'), array($pwd), 'uid', '=', $_GET['uid']);
		break;
	}
}
else{
			$err[0]['error']=1;
			echo json_encode($err);
}
?>