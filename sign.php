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
			//echo $searchtext;
			$r=$db->all_query_stmt("SELECT appid,name,tel,address,department,apply.personid FROM apply,person where apply.personid=person.personid AND apply.status=0 AND apply.actid=? AND apply.searchinfo LIKE ?",array($_GET['aid'],$searchtext));
            echo json_encode($r);
		//    include './template/sign.html';
		}
		break;
		case 'confirm'://修改参数
		$db->update_data_basic('apply',array('status'),array('1'),'appid','=',$_GET['appid']);
		break;
		case 'edit':
		$r=$db->update_data_basic('apply',array('status'),array('0'),'appid','=',$_GET['appid']);
		break;
		default://无参数自动显示签到列表
	    $r=$db->all_query_stmt('SELECT appid,name,tel,address,department,apply.personid FROM apply,person where apply.personid=person.personid AND apply.status=0 AND apply.actid=?', array($_GET['aid']));
		echo json_encode($r);
	}
}
else{
    $r[0]['error']=1;
	echo json_encode($r);
}
?>