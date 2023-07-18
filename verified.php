<?php
	//不正アクセスを対策しよう
	$referer = parse_url($_SERVER['HTTP_REFERER']);
	$ref_url = $referer['host'];//$ref_urlは1つ前のページのドメイン
	$myhost = $_SERVER['HTTP_HOST'];//$myhostは今のページのドメイン
	if(strcmp($ref_url,$myhost) != 0){
		//不正アクセス乙
		header('Location:https://'.$myhost);
		exit;
	}
?>
<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    define("title","アカウント編集完了");
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/meta.php"
    ?>
<?php
?>
	<meta charset="UTF-8">
</head>

<body>
    <header>
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/header.php";
  try{
	$req_id = $_COOKIE['id'];
	$sql = "select * from users_list where id=:id";
	$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
	$params = array(':id' => $req_id); // 挿入する値を配列に格納する
	$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
	if($res){
		$data_me = $stmt->fetch();
		echo"<pre>";
//		var_dump($data);			//ユーザー情報丸見えデバッグ
		echo"</pre>";
	}
	$verify_url = h($_POST['verify_url']);
	$verify_url2 = h($_POST['verify_url2']);
	$passerr = 0;
	
	$id = $_SESSION['id'];
//	echo $area_ans;
//    $count = $db->exec('INSERT INTO users_list (id,name,icon_url,twitter_id,pass) VALUES (:id,:name,:icon_url,:twitter_id,:pass)');
    $sql = "update users_list SET verify_url=:verify_url,verify_url2=:verify_url2 where users_list.id=:id";
    $stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
    $params = array(':verify_url' => $verify_url,':verify_url2' => $verify_url2, ':id' => $id); // 挿入する値を配列に格納する
    $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行

	if(strcmp($verify_url,"") != 0){
    	$sql = "update users_list SET certification=:certification where users_list.id=:id";
    	$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
    	$params = array(':certification' => 1,':id' => $id); // 挿入する値を配列に格納する
    	$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
	}else{
		$passerr = 1;
	}

//    mysqli_quary($pdo,$sql);
  } catch (PDOException $e) {
	echo 'エラーが発生しました！'.$e->getMessage();
	//echo "<a href=\"/registar\">登録ページに戻る</a>";
	//exit(1);
	$passerr = 2;
  }
    
	$displayname = $data_me['id'];
	$name = $data_me['name'];
	if(strcmp($name,'') != 0){
		$displayname = $name;
	}
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
	<div class="main_c">
		<div class="top_form_mother">
			<div class="top_form">
				<h1 class="index_title"><?php if($passerr == 0){ echo "本人確認の受付完了";}else{echo "err-code:".$passerr."不明なエラーです";} ?></h1>
				<p class="desp1"><?php if($passerr == 0){echo $displayname."の本人確認を受け付けました。数日以内に管理者が内容を確認し、身分を確認できなかった場合は本人確認を取り消させて頂く場合がございます。";}else{ echo "もう一度、本人確認を行ってください";} ?></p>
				<div class="index_main1">
					<?php if($passerr == 0){ echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton1\" href=\"/\">トップページへ</a>";} ?>
					<?php echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton1\" href=\"/u&quest;".$data_me['id']."\">マイアカウント</a>"; ?>
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
    $no_post_button = 1;
    include $webroot."/footer.php";
    ?>
    </footer>
</body>

</html>
