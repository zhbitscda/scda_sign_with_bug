<?php
include './lib/mysql_contral.php';
include './lib/class_other.php';
include './lib/session_mem.php';
include './lib/excel_io.php';
if(isset($_SESSION['uid'])){
	if(is_uploaded_file($_FILES['excel']['tmp_name'])){
		$o=new other_func();
		$o->random(16, 0);
		$extend_a=explode('.', $_FILES['excel']['name']);
		$extend_n=count($extend_a);
		$_f=$o.$extend_a[$extend_n-1];
		move_uploaded_file($_FILES['excel']['tmp_name'], './upload/'.$_f);
	    $j[0]['filename']=$_f;
		echo json_encode($j);
	}
}else{
	$j[0]['error']=1;
    echo json_encode($j);
}
?>