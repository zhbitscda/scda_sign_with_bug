<?php
include './lib/mysql_contral.php';
include './lib/class_other.php';
include './lib/session_mem.php';
if(isset($_SESSION['uid'])){
	if(!isset($_GET['aid'])){
		 $o=new other_func();
	     $o->jref('active.php');
	     exit();
	}
	$db=new db_contral();
	$db->connect_db();
	switch($_GET['action']){
		case 'search':
		if(isset($_GET['searchtext'])){
			$searchtext='%'.$_GET['searchtext'].'%';
			$r=$db->all_query_stmt("SELECT appid,name,tel,address,department,apply.personid FROM apply,person where apply.personid=person.personid AND apply.status_exit=0 AND apply.actid=? AND apply.searchinfo LIKE ?",array($_GET['aid'],$searchtext));
            echo json_encode($r);
		}
		break;
		case 'confirm'://修改参数
		$db->update_data_basic('apply',array('status_exit'),array('1'),'appid','=',$_GET['appid']);
		$o->jref('sign_exit.html?aid='.$_GET['aid']);
		//include './template/sign.html';
		break;
		case 'edit':
		$r=$db->update_data_basic('apply',array('status_exit'),array('0'),'appid','=',$_GET['appid']);
		$o->jref('sign_exit.html?aid='.$_GET['aid']);
		break;
		default://无参数自动显示签到列表
	     $r=$db->all_query_stmt('SELECT appid,name,tel,address,department,apply.personid FROM apply,person where apply.personid=person.personid AND apply.status_exit=0 AND apply.actid=?', array($_GET['aid']));
	    //echo $_GET['aid'];
	    echo json_encode($r);
	    //include './template/sign_list_exit.html';
	}
}
else{
     $arr[0]['error']=1;
     echo json_encode($arr);
}
?>