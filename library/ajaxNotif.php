<?php
	$no_title = 1;
	$js_load = 1;
	$webroot = $_SERVER['DOCUMENT_ROOT'];
	include $webroot."/meta.php";
	include $webroot."/header.php";
	
	$notif_once = 10;//一度に取得する通知の数
	$count = $_POST['jscount'][0];//今何回目？
	$count2 = $count * $notif_once;
	
	$q = 'select * from notif_list where for_rand_id="'.$data_me['rand_id'].'" order by unixtime desc limit '.$count2.','.$notif_once.' ';
	$q2 = $pdo -> query($q);
	$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
	
	if($q3 == false){
		$rtn = array('nothing' => 1);
	}else{
		$rtn = array();
		$res1 = [];
		$i = 0;
		foreach($q3 as $ans){
			$aq = 'select * from users_list where rand_id="'.$ans['from_rand_id'].'" limit 1';
			$aq2 = $pdo -> query($aq);
			$aq3 = $aq2 -> fetchAll(PDO::FETCH_BOTH);
			$res = array(
					'type' => $ans['type'],
					'from' => $aq3[0]['id'],
					'unixtime' => $ans['unixtime'],
					'content' => $ans['content_id']
			);
			$res1[$i] = $res;
			
			$i += 1;
		}
	}
	
	$rtn = $rtn + array(
		'status' => 'ok',
		'num' => $count2
	);
	if( (isset($res1)) && ($res1 != false) ){
		$rtn = $rtn + array(
			'mes' => $res1
		);
	}
	echo json_encode($rtn,JSON_UNESCAPED_UNICODE);
?>