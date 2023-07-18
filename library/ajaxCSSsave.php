<?php
	$no_title = 1;
	$js_load = 1;
	$webroot = $_SERVER['DOCUMENT_ROOT'];
	include $webroot."/meta.php";
	include $webroot."/header.php";
	$val = $_POST['value'][0];
	$val = str_replace("\n",'\n',$val);
	$q = 'update users_list set custom_css="'.$val.'" where id="'.$data_me['id'].'" limit 1';
	$q2 = $pdo -> query($q);
?>