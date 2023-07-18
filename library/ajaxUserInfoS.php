<?php
    $no_title = 1;
	$js_load = 1;
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/meta.php";
    include $webroot."/header.php";
	$q = 'select * from users_list where rand_id="'.$data_me['rand_id'].'" limit 1';
	$q2 = $pdo -> query($q);
	$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
	if(isset($q3[0])){
		$rtn = $q3[0];
		echo json_encode($rtn,JSON_UNESCAPED_UNICODE);
	}else{
		$rtn = array(
			'status' => 'err',
			'message' => 'notfound',
		);
		echo json_encode($rtn,JSON_UNESCAPED_UNICODE);
		exit;
	}
?>