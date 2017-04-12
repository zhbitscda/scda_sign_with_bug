<?php
include './lib/mysql_contral.php';
include './lib/class_other.php';
include './lib/wechat_contral.php';
include './lib/phpqrcode/phpqrcode.php';
include './lib/session_mem.php';
if(isset($_GET['actid'])){
	switch($_GET['action']){
		case 'monitor'://屏幕显示页面
		include './template/qrcode_monitor.html';
		break;
		case 'appointment'://签到模块
		if(($_GET['timestamp']+6)>time()){
			$m_key=md5($_GET['timestamp'].$_GET['key']);
			$memcache=new Memcache;
		    $memcache->connect($memcache_serv,$memcache_port);
			if($m_key==$memcache->get($_GET['timestamp']))//检验通过，进入签到模式
			{
				$openid=$we->getOpenId_only();
				$db=new db_contral();
				$db->connect_db();
				$db->update_data_basic($tab, $item_arr, $data_arr, $o_item, $typ, $o_val)
				include './template/qrcode_success.html';
			}
			else{//密匙错误，二维码校验保护，防止伪造码
				include './template/qrcode_checkerr.html';
			}
		}
		else{
			include './template/qrcode_expire.html';
		}
		break;
		case 'getnewcode'://获取新的二维码
		$o=new other_func();
		$o->delFile('./qrcodecache');//清空缓存目录避免爆菊花
		$n_time=time();
		$key=$o->random(16, 0);
	    $memcache=new Memcache;
		$memcache->connect($memcache_serv,$memcache_port);
		$md5_key=md5($n_time.$key);
		$memcache->set($n_time,$key,0,7);//7秒自动失效
		$code=QRcode::png('http://oa.zhbitscda.com/wechat_qrcode.php?action=appointment&timestamp='.$n_time.'&key='.$key.'&actid='.$_GET['actid'],false,Q,6,3);
		echo $code;
		break;
	}
}
else
{
	echo "ACT NOT FOUND";
}
?>