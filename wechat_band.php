<?php
include './lib/mysql_contral.php';
include './lib/class_other.php';
include './lib/wechat_contral.php';
include './lib/session_mem.php';
$we=new wechat_contral();
$openid=$we->getOpenId_only();
$_SESSION['openid']=$openid();
$db=new db_contral();
switch($_GET['action']){
	case 'sumbit':
	$db->connect_db();
	$r=$db->db_query_normal('person', array('sid','name'), array($_POST['sid'],$_POST['name']), array('=','='), array('AND'));
	if(count($r)){
		include './template/was_band_2.html';
	}else{
        $db->updata_data_normal('person', array('openid'), array($openid), array('sid','name'), array('=','='), array($_POST['sid'],$_POST['name']), array('AND'));
		include './template/band_success.html';
	}
	break;
	default:
	$db->connect_db();
	$r=$db->db_query_n1('person', 'openid', $openid);
	if(count($r)){
		include './template/was_band.html';
	}
	else
	{
		include './template/wechat_band.html';
	}
}
?>