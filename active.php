<?php
include './lib/mysql_contral.php';
include './lib/class_other.php';
include './lib/session_mem.php';
if(isset($_SESSION['uid'])){
	$db=new db_contral();
	$db->connect_db();
	switch($_GET['action']){
		case 'add':
			$r=$db->db_query_n1('list','listid', 0,'!=',0);
			echo json_encode($r);
		//include './template/add_activity.html';
		break;
		case 'del':
		if(isset($_GET['aid']))
		$db->del_data('active',array('aid'),array('='),array($_GET['aid']),array());
		$o=new other_func();
	    $o->jref('active.php');
		break;
	    case 'edit':
	    if(isset($_GET['aid']))
		{
			include './template/edit_activity.html';
		}
		break;
		case 'add_sumbit':
		$db->ins_data('active',array('name','listid','actime'),array($_POST['name'],$_POST['listid'],$_POST['actime']));
		$rx=$db->db_query_n1('active','name', $_POST['name']);
		$aid=$rx[0]['aid'];
		$r=$db->db_query_n1('person', 'listid', '%<|>'.$_POST['listid'].'<|>%',LIKE,0);
		echo json_encode($r);
		if(count($r)){
			foreach($r as $k=>$v){
				$searchinfo=$v['name'].'|'.$v['sid'].'|'.$v['tel'].'|'.$v['department'].'|'.$v['address'];
				$db->ins_data('apply',array('actid','status','status_exit','personid','searchinfo'), array($aid,0,0,$v['personid'],$searchinfo));
			}
		}
		break;
		case 'edit_sumbit':
		$db->update_data_basic('active',array('name','listid'),array($_POST['name'],$_POST['listid']),array('aid'),array('='),array($_GET['aid']));
		$o=new other_func();
	    $o->jref('active.php');
		break;
		case 'del':
		$db->del_data('active',array('aid'),array('='),array($_GET['aid']),array());
/*		$o=new other_func();
	    $o->jref('active.php');*/
		break;
		default://无参数时直接显示所有活动
		$r=$db->db_query_n1('active','aid',0,'!=',0);
		echo json_encode($r);
	}
}
else{
$error[0]['error']=1;
json_encode($error);
}
?>
