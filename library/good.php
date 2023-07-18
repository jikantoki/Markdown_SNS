<?php
	$no_title = 1;
	$js_load = 1;
	$webroot = $_SERVER['DOCUMENT_ROOT'];
	include $webroot."/meta.php";
	include $webroot."/header.php";
	//good_or_badの追加
	//badはSEYANAボタンに仕様変更済み
	//var_dump($_POST);
	if(isset($data_me)){
		$id = $_POST['id'][0];
		$good_or_bad = $_POST['good_or_bad'][0];
		
		$q = 'select * from good_list where good_content="'.$id.'" and good_or_bad="'.$good_or_bad.'" and good_pusher_rand_id="'.$data_me['rand_id'].'"';
		$q2 = $pdo -> query($q);
		$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
		if(count($q3) == 0){
			//いいね歴がないので追加する
			$good_id = $data_me['rand_id'].$id.$good_or_bad.time();
			$q = 'insert into good_list(good_id,good_pusher_rand_id,good_content,good_unixtime,good_or_bad)';
			$q = $q.' values("'.$good_id.'","'.$data_me['rand_id'].'","'.$id.'",'.time().',"'.$good_or_bad.'");';
			$q2 = $pdo -> query($q);
			$jsoned = array('action' => 'add');
			//echo $q;
			//通知が無ければ追加する
			$q = 'select * from notif_list where type="'.$good_or_bad.'" and from_rand_id="'.$data_me['rand_id'].'" and content_id="'.$id.'" limit 1';
			$q2 = $pdo -> query($q);
			$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
			if($q3 == false){//追加しよう！
				$q = 'select * from sent_list where sent_rand_id="'.$id.'" limit 1';
				$q2 = $pdo -> query($q);
				$q4 = $q2 -> fetchAll(PDO::FETCH_BOTH);
				if($q4 != false){
					$qid = $id.$data_me['rand_id'].time().$good_or_bad;
					$q = 'insert into notif_list(id,for_rand_id,type,unixtime,content_id,from_rand_id)';
					$q = $q.' values("'.$qid.'","'.$q4[0]['sent_owner'].'","'.$good_or_bad.'",'.time().',"'.$id.'","'.$data_me['rand_id'].'");';
					$q2 = $pdo -> query($q);
				}else{
					//元ツイがない
				}
			}
		}else{
			//あるので削除する
			$q = 'delete from good_list where good_pusher_rand_id="'.$data_me['rand_id'].'" and good_content="'.$id.'" and good_or_bad="'.$good_or_bad.'"';
			$q2 = $pdo -> query($q);
			$jsoned = array('action' => 'remove');
		}
		
		$jsoned = $jsoned + array(
			'do' => $good_or_bad,
			'content' => $id,
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