<!DOCTYPE html>
<html lang="ja">
<?php
	$referer = parse_url($_SERVER['HTTP_REFERER']);
	$ref_url = $referer['host'];//$ref_urlは1つ前のページのドメイン
	$myhost = $_SERVER['HTTP_HOST'];//$myhostは今のページのドメイン
	if(strcmp($ref_url,$myhost) != 0){
		//不正アクセス乙
		header('Location:https://'.$myhost);
		exit;
	}
?>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    define("title","ポスト完了");
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/meta.php"
    ?>
	<meta charset="UTF-8">
</head>

<body>
    <header>
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/header.php";
	if(!isset($_SESSION['id'])){
		//ユーザーが存在しない
		//echo "いない";
		$title_defined = 1;
		http_response_code( 404 ) ;
		include $webroot."/error/404.php";//404を表示
		exit(1);
	}
  try{
	$sent_rand_id = $_SESSION['id'].mt_rand(10000,99999).mt_rand(10000,99999).time();
	$owner = $data_me['rand_id'];
	$sent_time = time();
	$genre_ans = h($_POST['genre']);
	$place = h($_POST['place']);
	$message = h($_POST['message']);
	$subowner = h($_POST['subowner']);
	$sankou_link1 = h($_POST['sankou_link1']);
	$sankou_link2 = h($_POST['sankou_link2']);
	$img_url1 = h($_POST['img_url1']);
	$img_url2 = h($_POST['img_url2']);
	$img_url3 = h($_POST['img_url3']);
	$img_url4 = h($_POST['img_url4']);
	$sent_inyou = h($_POST['inyou']);
	$sent_reply = h($_POST['reply']);
	$passerr = 0;
	
	$id = $_COOKIE['id'];
	$owner2 = $owner;
	$message2 = $message;
	$time2 = time() - ( 60 * 60 * 3 );//3時間以内に同じ投稿があったらポストしない
	
	$sql = "select count(*) from sent_list where sent_owner=:owner2 and sent_message=:message2 and sent_time>:time2";
    $stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
    $params = array(':owner2' => $owner2,':message2' => $message2,':time2' => $time2); // 挿入する値を配列に格納する
    $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
	if($res){
		$sent_kazu = $stmt->fetch();
		//echo"<pre>";
//		var_dump($data_cookie);			//ユーザー情報丸見えデバッグ
		//echo"</pre>";
	}
	if($sent_kazu[0] > 0){
		$passerr = 4;
	}elseif(mb_strlen($message) > 2048){
		$passerr = 5;
	}else{
		//	echo $area_ans;
		//    $count = $db->exec('INSERT INTO users_list (id,name,icon_url,twitter_id,pass) VALUES (:id,:name,:icon_url,:twitter_id,:pass)');
		$sql = "insert into sent_list (sent_rand_id,sent_owner,sent_subowner,sent_message,sent_time,sent_genre,sent_sankou_link1,sent_sankou_link2,sent_img_url1,sent_img_url2,sent_img_url3,sent_img_url4,inyou,reply,place) values (:sent_rand_id,:sent_owner,:sent_subowner,:sent_message,:sent_time,:sent_genre,:sent_sankou_link1,:sent_sankou_link2,:sent_img_url1,:sent_img_url2,:sent_img_url3,:sent_img_url4,:inyou,:reply,:place)";
		$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
		$params = array(':sent_rand_id' => $sent_rand_id,':sent_owner' => $owner,':sent_subowner' => $subowner,':sent_message' => $message,':sent_time' => $sent_time,':sent_genre' => $genre_ans,':sent_sankou_link1' => $sankou_link1,':sent_sankou_link2' => $sankou_link2,':sent_img_url1' => $img_url1,':sent_img_url2' => $img_url2,':sent_img_url3' => $img_url3,':sent_img_url4' => $img_url1,':inyou' => $sent_inyou,':reply' => $sent_reply,':place' => $place); // 挿入する値を配列に格納する
		$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
	}

//    mysqli_quary($pdo,$sql);
 	} catch (PDOException $e) {
		echo 'エラーが発生しました！'.$e->getMessage();
		//echo "<a href=\"/registar\">登録ページに戻る</a>";
		//exit(1);
		$passerr = 2;
	}
    
	$displayname = $data_me['name'];
    ?>
    </header>
	<main>
	<div class="col">
	<div class="left_menu">
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/left.php";
    ?>
    </div>
	<script>
		<?php if($passerr == 0){
			$http_host = 'https://'.$_SERVER['HTTP_HOST'];
			if(strcmp($_SERVER['HTTP_REFERER'],$http_host.'/post') == 0){
			?>
				window.location.href = history.go(-2);
			<?php
			}elseif(isset($_POST['no_post_jump'])){
			?>
				//window.location.href = history.go(0);
			<?php
			}else{
			?>
				window.location.href = history.go(-1);
			<?php } ?>
		<?php } ?>
	</script>
	<div class="main_c">
		<div class="top_form_mother">
			<div class="top_form">
				<h1 class="index_title"><?php if($passerr == 0){ echo "ポスト完了";}elseif($passerr == 4){ echo "ポストが重複しています";}elseif($passerr == 5){ echo "文字数が多すぎます";}else{echo "err-code:".$passerr."不明なエラーです";} ?></h1>
				<p class="desp1"><?php if($passerr == 0){echo $displayname."で投稿しました";}elseif($passerr == 4){ echo "文章を変えて再投稿してみてください";}else{ echo "もう一度、投稿しなおしてください";} ?></p>
				<div class="index_main1">
					<?php if($passerr == 0){ echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton1\" href=\"/\">トップページへ</a>";} ?>
					<?php echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton1\" href=".$_SERVER['HTTP_REFERER'].">投稿し直す</a>"; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="right_menu">
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/right.php";
    ?>
	</div>
	</div>
	<div class="space"></div>
	</main>
    <footer>
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/footer.php";
    ?>
    </footer>
</body>

</html>
