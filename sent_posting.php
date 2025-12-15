<?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    $no_title = 1;
    $js_load = 1;
    //print_r($_POST);
    include $webroot."/meta.php";
    include $webroot."/header.php";
    $val = h($_POST['val'][0]);
	//var_dump($allow_tag);
    //print_r($_POST);
	
	if(mb_strlen($val) > 2048){
		//エラー、文字数が多すぎます
		$ret = array('word' => '文字数が多すぎます。','status' => 'err');
		$ret2 = json_encode($ret,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		echo $ret2;
		exit;
	}
	$val2 = $val;
	foreach($no_allow_str as $string){
		$val2 = mb_str_replace($string,'',$val2);
	}
	if($val2 == ''){
		//エラー、文字数が少なすぎます
		$ret = array('word' => '文字を入力してください。','status' => 'err');
		$ret2 = json_encode($ret,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		echo $ret2;
		exit;
	}
	$er = 0;
	if(!isset($data_me['rand_id'])){
		//ログインエラー
		$ret = array('word' => 'ログインエラー','status' => 'err');
		$er = 1;
	}elseif($data_me['rand_id'] == null){
		//ログインエラー
		$ret = array('word' => 'ログインエラー','status' => 'err');
		$er = 1;
	}else{
		$q = "select count(*) from sent_list where sent_owner='".$data_me['rand_id']."'";
		$q2 = $pdo ->query($q);
		$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
		$qc = $q3[0][0];
		if($qc === 0){
			//アカウントが見つからない
			$ret = array('word' => 'アカウントが見つかりませんでした','status' => 'err');
			$er = 2;
		}
	}
	if($er != 0){
		$ret2 = json_encode($ret,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		echo $ret2;
		exit;
	}
	if( filter_var( $_POST['link1'][0], FILTER_VALIDATE_URL ) ){
		//これはURL
		$link1 = $_POST['link1'][0];
	}else{
		//これはURLではない
		$link1 = '';
	}
	if( filter_var( $_POST['link2'][0], FILTER_VALIDATE_URL ) ){
		//これはURL
		$link2 = $_POST['link2'][0];
	}else{
		//これはURLではない
		$link2 = '';
	}
	$imgData[0] = '';
	$imgData[1] = '';
	$imgData[2] = '';
	$imgData[3] = '';
	if(isset($_POST['imgs'])){
		$imgs = $_POST['imgs'][0];
		//var_dump($imgs);
		/*$imgData[0] = $_POST['img1'][0];
		$imgData[1] = $_POST['img2'][0];
		$imgData[2] = $_POST['img3'][0];
		$imgData[3] = $_POST['img4'][0];*/
	}
	$time2 = time() - ( 5 );//5秒以内に同じ人の投稿があったらポストしない
	$sql = "select count(*) from sent_list where sent_owner=\"".$data_me['rand_id']."\" and sent_time > ".$time2.";";
	//echo "<br>".$sql."<br>";
	$q = $pdo -> query($sql);
	$history_post = $q -> fetchAll(PDO::FETCH_BOTH);
	$history_cnt = $history_post[0][0];
	//print_r($history_cnt);
	if($history_cnt != 0){
		//エラー、投稿が被っています
		$ret = array('word' => '5秒後に再度送信してみてください。','status' => 'err');
		$ret2 = json_encode($ret,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		echo $ret2;
		exit;
	}
	$time2 = time() - ( 60 * 60 * 3 );//3時間以内に同じ投稿があったらポストしない
	$sql = "select count(*) from sent_list where sent_owner=\"".$data_me['rand_id']."\" and sent_message=\"".$val."\" and reply='".$_POST['reply'][0]."' and inyou='".$_POST['inyou'][0]."' and sent_time>".$time2;
	//echo "<br>".$sql."<br>";
	$q = $pdo -> query($sql);
	$history_post = $q -> fetchAll(PDO::FETCH_BOTH);
	$history_cnt = $history_post[0][0];
	//print_r($history_cnt);
	if($history_cnt != 0){
		//エラー、投稿が被っています
		$ret = array('word' => '既に送信済みです。','status' => 'err');
		$ret2 = json_encode($ret,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		echo $ret2;
		exit;
	}
	
	$sent_rand_id = $_SESSION['id'].mt_rand(10000,99999).mt_rand(10000,99999).time();
	
	$ret = array();
	$cnt = 0;
	if(isset($imgs)){
		foreach($imgs as $image){
			if($image == '')continue;
			$filedir = $webroot."/user/buf_".$sent_rand_id;
			$filedir1 = "/user/img/".$sent_rand_id.'___'.$cnt;//アンダーバー三回
			$filedir2 = $webroot.$filedir1;//アンダーバー三回
			$image2 = strstr($image,',');
			$image3 = substr($image2,1);
			$dataFile = base64_decode($image3);
			file_put_contents($filedir,$dataFile);
			$ext = '';
			$delFlag = 0;
			if(file_exists($filedir)){
				$type = exif_imagetype($filedir);
				//画像ファイル
				switch($type){
					case IMAGETYPE_GIF:
						//GIFなので、ファイルサイズの確認のみ
						$ext = '.gif';
						break;
					case IMAGETYPE_JPEG:
						//拡張子を付けて圧縮
						$ext = '.jpg';
						break;
					case IMAGETYPE_PNG:
						//拡張子を付けて圧縮
						$ext = '.png';
						break;
					case IMAGETYPE_WEBP:
						//拡張子を付けて圧縮
						$ext = '.webp';
						break;
					case IMAGETYPE_BMP:
						//拡張子を付けて圧縮
						$ext = '.bmp';
						break;
					case IMAGETYPE_ICO:
						//拡張子を付けて圧縮
						$ext = '.ico';
						break;
					default:
						//エラー判定
						$delFlag = 1;
						break;
				}
				if($delFlag === 1){
					//unlink($filedir);
					$ret = $ret + array('word' => '読み込めない画像です。('.($cnt + 1).'枚目)','status' => 'err');
					$ret2 = json_encode($ret,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
					echo $ret2;
					exit;
				}
				$ret = $ret + array('image'.$cnt => $ext);
				$imgFilename = $filedir2.$ext;
				file_put_contents($imgFilename,$dataFile);
				unlink($filedir);
				$name = $filedir1.$ext;
				list($w, $h) = getimagesize($webroot.$name);
				$file_type = mime_content_type($webroot.$name);
				$skip = 0;
				switch($file_type){
					case 'image/png':
						$img = imagecreatefrompng($webroot.$name);
						break;
					case 'image/jpg':
						$img = imagecreatefromjpeg($webroot.$name);
						break;
					case 'image/bmp':
						$img = imagecreatefrombmp($webroot.$name);
						break;
					default:
						$skip = 1;
						break;
				}
				if($skip === 0){
					unlink($webroot.$name);
					$name = $name.'_jpeged.jpg';
					
					$w = imagesx( $img );
					$h = imagesy( $img );
					$w_max = 2600;
					$h_max = 2600;
					if( ($w <= $w_max) && ($h <= $h_max) ){
						$gd_out = imagecreatetruecolor( $w, $h );
						imagecopyresampled( $gd_out, $img, 0,0,0,0, $w,$h,$w,$h );
					}else{
						$gd_out = imagecreatetruecolor( $w_max, $h_max );
						if($w <= $w_max){
							//$hが問題
							$h2 = $h / $h_max;
							$w2 = $w / $h2;
							imagecopyresampled( $gd_out, $img, 0,0,0,0, $w2,$h_max,$w,$h );
						}else{
							//$wまたは両方が問題
							$w2 = $w / $w_max;
							$h2 = $h / $w2;
							if($w > $w_max){
								$w2 = $w_max;
							}else{
								$w2 = $w;
							}
							imagecopyresampled( $gd_out, $img, 0,0,0,0, $w2,$h2,$w,$h );
						}
					}
					imagejpeg($gd_out, $webroot.$name);
					imagedestroy( $img );
				}
				$imgData[$cnt] = $name;
			}else{
				//何らかのミスで読み込めない
			}
			//$ret = $ret + array('img'.$cnt => $blobc2);
			$cnt += 1;
		}
	}
	
	$sql = "insert into sent_list (sent_rand_id,sent_owner,sent_subowner,sent_message,sent_time,sent_genre,sent_sankou_link1,sent_sankou_link2,sent_img_url1,sent_img_url2,sent_img_url3,sent_img_url4,inyou,reply,place,ipAddress) values ('".$sent_rand_id."','".$data_me['rand_id']."','".$_POST['subowner'][0]."','".$val."',".time().",'".$_POST['genre'][0]."','".$link1."','".$link2."','".$imgData[0]."','".$imgData[1]."','".$imgData[2]."','".$imgData[3]."','".$_POST['inyou'][0]."','".$_POST['reply'][0]."','".$_POST['place'][0]."','".$_SERVER['REMOTE_ADDR']."');";
	$q = $pdo -> query($sql);
	$history_post = $q -> fetchAll(PDO::FETCH_BOTH);
	$reply_sonzai = false;
	if($_POST['reply'][0] != ''){
		$q = 'select * from sent_list where sent_rand_id = "'.$_POST['reply'][0].'" limit 1';
		$q2 = $pdo -> query($q);
		$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
		$reply_sonzai = $q3;
		if($q3 != false){
			$qid = $sent_rand_id.$data_me['rand_id'].time().'reply';
			$aq = 'insert into notif_list(id,for_rand_id,type,unixtime,content_id,from_rand_id)';
			$aq = $aq.' values("'.$qid.'","'.$q3[0]['sent_owner'].'","reply",'.time().',"'.$sent_rand_id.'","'.$data_me['rand_id'].'");';
			$aq2 = $pdo -> query($aq);
		}
	}
	$ret = $ret + array('word' => 'ポストを送信しました！','status' => 'ok', 'message' => $val, 'id' => $sent_rand_id);
	if($reply_sonzai != false){
		$ret = $ret + array('reply' => $_POST['reply'][0]);
	}
	$ret2 = json_encode($ret,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
	echo $ret2;
?>