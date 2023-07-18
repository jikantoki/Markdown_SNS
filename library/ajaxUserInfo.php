<?php
    $no_title = 1;
	$js_load = 1;
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/meta.php";
	//POSTに文字を入れたらMDにしてechoする
	if(isset($_POST['name'])){
		$s = h($_POST['name'][0]);
	}else{
		$rtn = array(
			'status' => 'err',
			'message' => 'posterr',
		);
		echo json_encode($rtn,JSON_UNESCAPED_UNICODE);
		exit;
	}
	$q = 'select * from users_list where id="'.$s.'"';
	$q2 = $pdo -> query($q);
	$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
	//var_dump($q3[0]);
	$parser = new \cebe\markdown\GithubMarkdown();
	$parser -> html5 = true;
	$parser->enableNewlines = true;
	//$parsed_message = $parser -> parse($s_message);
	
	if(isset($q3[0])){
		$result = array_flip(array_keys($q3[0]));
		$q3[0][$result['pass']] = '';
		$q3[0][$result['pass'] + 1] = '';
		$q3[0][$result['mail']] = '';
		$q3[0][$result['mail'] + 1] = '';
		$q3[0][$result['rand_id']] = '';
		$q3[0][$result['rand_id'] + 1] = '';
		$q3[0][$result['verify_url']] = '';
		$q3[0][$result['verify_url'] + 1] = '';
		$q3[0][$result['verify_url2']] = '';
		$q3[0][$result['verify_url2'] + 1] = '';
		$q3[0][$result['birth_y']] = '';
		$q3[0][$result['birth_y'] + 1] = '';
		$q3[0][$result['birth_m']] = '';
		$q3[0][$result['birth_m'] + 1] = '';
		$q3[0][$result['birth_d']] = '';
		$q3[0][$result['birth_d'] + 1] = '';
		$q3[0][$result['otp']] = '';
		$q3[0][$result['otp'] + 1] = '';
		$q3[0][$result['custom_css']] = '';
		$q3[0][$result['custom_css'] + 1] = '';
		
		if($q3[0]['name'] == '')$q3[0]['name'] = $q3[0]['id'];
		
		if(strcmp($q3[0]["message"],"") != 0){
			$message = $q3[0]["message"];
			$parser = new \cebe\markdown\GithubMarkdown();
			$parser -> html5 = true;
			$parser->enableNewlines = true;
			$parsed_message = $parser -> parse($message);
			$q3[0]['message'] = cssing(emoji($parsed_message));
		}else{
			$q3[0]['message'] = "自己紹介文がまだ登録されていません。";
		}
		
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