<?php
include './lib/mysql_contral.php';
include './lib/class_other.php';
include './lib/session_mem.php';
$db=new db_contral();
$db->connect_db();
if(isset($_SESSION['uid'])){
	if(!isset($_GET['aid'])){
		$o=new other_func();
		$o->jref('login.php');	
		exit();
	}
	if($_GET['action']=='cancel'){
		$db->update_data_basic('apply', array('status_exit'), array(0), 'appid', '=', $_GET['appid']);
	}
	switch($_GET['type']){
		case 1://未到
		//$db_header=$db->db_header;
        $r=$db->all_query_stmt('SELECT appid,name,tel,address,department,apply.personid FROM apply,person where apply.personid=person.personid AND apply.status_exit=0 AND apply.actid=?', array($_GET['aid']));	
		break;
		case 2://已到
		//$db_header=$db->db_header;
		//$number_of_all=$db->db_query_n1_count('apply', 'actid', $_GET['actid'],'=');
        $r=$db->all_query_stmt('SELECT appid,name,tel,address,department,apply.personid FROM apply,person where apply.personid=person.personid AND apply.status_exit=1 AND apply.actid=?', array($_GET['aid']));	
		break;
		default:
		//$db_header=$db->db_header;
		//$number_of_all=$db->db_query_n1_count('apply', 'actid', $_GET['actid'],'=');
		$r=$db->all_query_stmt('SELECT appid,name,tel,address,department,apply.personid FROM apply,person where apply.personid=person.personid AND apply.status_exit=1 AND apply.actid=?', array($_GET['aid']));	
	}
	//print_r($r);
    echo json_encode($r);
}
else
{
$e[0]['error']=1;
echo json_encode($e);
}
?>