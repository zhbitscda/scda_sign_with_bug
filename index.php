<?php
include './lib/mysql_contral.php';
include './lib/class_other.php';
include './lib/session_mem.php';
if(isset($_SESSION['uid'])){
	$o=new other_func();
	$o->jref('list_act.html');
}
else
{
	$o=new other_func();
	$o->jref('login.php');
}
?>