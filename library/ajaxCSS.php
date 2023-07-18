<?php
	$no_title = 1;
	$js_load = 1;
	$webroot = $_SERVER['DOCUMENT_ROOT'];
	include $webroot."/meta.php";
	include $webroot."/header.php";
	
	$q = 'select custom_css from users_list where id="'.$data_me['id'].'"';
	$q2 = $pdo -> query($q);
	$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
	if(isset($q3[0])){
		if($q3[0] == null){
			$q3[0] = '';
		}
		$jsoned = array(
			'content' => $q3[0],
			'status' => 'ok'
		);
	}else{
		$jsoned = array(
			'status' => 'err',
			'reason' => 'account not defined'
		);
	}
	echo json_encode($jsoned,JSON_UNESCAPED_UNICODE);
?>