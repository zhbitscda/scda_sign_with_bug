<?php
include './lib/mysql_contral.php';
include './lib/class_other.php';
include './lib/session_mem.php';
switch($_GET['action']){
	case 'sumbit':
	$db=new db_contral();
	$db->connect_db();
	$r=$db->db_query_n1('acc','usr',$_POST['usr']);
	if(count($r)){
		$pwd=md5($_POST['pwd'].$r[0]['salt']);
		$r=$db->db_query_normal('acc',array('usr','pwd'),array($_POST['usr'],$pwd),array('=','='),array('AND'));
		if(count($r)){
			$_SESSION['usr']=$r[0]['usr'];
			$_SESSION['uid']=$r[0]['uid'];
			$o=new other_func();
			$o->jref("list_act.html");
		}
		else
		{
				$o=new other_func();
	        	$o->jsec('用户名或密码错误','login.php');
		}
	}else{
		$o=new other_func();
		$o->jsec('用户名或密码错误','login.php');
	}
    default:
    include './login.html';
}
?>