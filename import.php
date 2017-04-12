<?php
include './lib/mysql_contral.php';
include './lib/class_other.php';
include './lib/session_mem.php';
include './lib/excel_io.php';
if(isset($_SESSION['uid'])){
	if(isset($_POST['listname'])&&is_uploaded_file($_FILES['excel']['tmp_name'])){
		$excel=new excel_io();
		$o=new other_func();
		$re=$o->random(16, 0);
		$extend_a=explode('.', $_FILES['excel']['name']);
		$extend_n=count($extend_a);
		$_f=$re.'.'.$extend_a[$extend_n-1];
		move_uploaded_file($_FILES['excel']['tmp_name'], './upload/'.$_f);
		$arr=$excel->Toarray('./upload/', $_f);
		$json_data=json_encode($arr);
		$db=new db_contral();
		$db->connect_db();
		$db->ins_data('list', array('listname','listcontent'), array($_POST['listname'],$json_data));
	    $r_=$db->db_query_n1('list', 'listname', $_POST['listname']);
		$w[0]['new']=0;
		$w[0]['exist']=0;
	    for($i=1;$i<count($arr);$i++){
	    	$r=$db->db_query_normal('person',array('name','tel'), array($arr[$i][0],$arr[$i][2]), array('=','='), array('AND'));
			if(count($r)){//检测这个人是否已经exist。。。
			$w[0]['exist']++;
				$listid=$r[0]['listid'].$r_[0]['listid'].'<|>';				
				$db->update_data_basic('person', array('listid'), array($listid),'personid', '=', $r[0]['personid']);//加入到名单中
			}
			else
			{
				$w[0]['new']++;
				$listid='<|>'.$r_[0]['listid'].'<|>';
				$db->ins_data('person', array('name','listid','sid','tel','department','address'), array($arr[$i][0],$listid,$arr[$i][1],$arr[$i][2],$arr[$i][3],$arr[$i][4]));
			}
	    }
	    $w[0]['status']='一共添加'.$i.'人';
		echo json_encode($w);
	}
	else{
	   $r[0]['error']='1';
		echo json_encode($r);
	}
}else{
	   $r[0]['error']=1;
		echo json_encode($r);
}
?>