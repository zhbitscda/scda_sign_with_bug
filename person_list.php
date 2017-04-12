<?php
include './lib/mysql_contral.php';
include './lib/class_other.php';
include './lib/session_mem.php';
if(isset($_SESSION['uid'])){
	$db=new db_contral();
	$db->connect_db();
	$o=new other_func();
	switch($_GET['action']){
		case 'del':
		$db->del_data('list', array('listid'), array('='), array($_GET['listid']), array());
		$o->jsec('删除成功','person_list.php');
		break;
		case 'edit':
	    include './template/list_edit.html';
		break;
		case 'edit_sumbit':
		$db->update_data_basic('list',array('listname'), array($_POST['listname']), 'listid', '=', $_GET['listid']);
		$o->jsec('修改成功','person_list.php');
		break;
		default:
		$r=$db->db_query_n1('list', 'listid',0,'!=',0);
	    echo json_encode($r);
		//include './template/list.html';
	}
}
else{
	$o=new other_func();
	$o->jref('login.php');
}
?>