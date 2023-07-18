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
	$mail = h($_POST['mail']);
	$message = h($_POST['message']);
	$area_ans = h($_POST['area']);
	$mail_open_state = filter_input(INPUT_POST, 'mail_open');
	if(is_string($mail_open_state)){
		$mail_open2 = 1;
	}else{
		$mail_open2 = 0;
	}
	$birth_open_state = filter_input(INPUT_POST, 'birth_open');
	if(is_string($birth_open_state)){
		$birth_open2 = 1;
	}else{
		$birth_open2 = 0;
	}
	$idcard_open_state = filter_input(INPUT_POST, 'idcard_open');
	if(is_string($idcard_open_state)){
		$idcard_open2 = 1;
	}else{
		$idcard_open2 = 0;
	}
	$name = h($_POST['name']);
	$icon_url = h($_POST['icon_url']);
	if(strcmp($icon_url,"") == 0){
		$icon_url = "/img/account_default.png";
	}
	$bgimg_url = h($_POST['bgimg_url']);
	if(strcmp($bgimg_url,"") == 0){
		$bgimg_url = "/img/bgimg.jpg";
	}
	$twitter_id = h($_POST['twitter_id']);
	$passerr = 0;
	
	$id = $_COOKIE['id'];
//	echo $area_ans;
//    $count = $db->exec('INSERT INTO users_list (id,name,icon_url,twitter_id,pass) VALUES (:id,:name,:icon_url,:twitter_id,:pass)');
    $sql = "update users_list SET mail=:mail,mail_open=:mail_open,name=:name,icon_url=:icon_url,twitter_id=:twitter_id,message=:message,idcard_open=:idcard_open,area=:area,birth_y=:birth_y,birth_m=:birth_m,birth_d=:birth_d,birth_open=:birth_open,bgimg_url=:bgimg_url where users_list.id=:id";
    $stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
    $params = array(':mail' => $mail,':mail_open' => $mail_open2, ':name' => $name, ':icon_url' => $icon_url, ':twitter_id' => $twitter_id, ':message' => $message, ':id' => $_SESSION['id'], ':idcard_open' => $idcard_open2, ':area' => $area_ans, ':birth_y' => $_POST['birth_y'], ':birth_m' => $_POST['birth_m'], ':birth_d' => $_POST['birth_d'], ':birth_open' => $birth_open2, ':bgimg_url' => $bgimg_url); // 挿入する値を配列に格納する
    $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行

//    mysqli_quary($pdo,$sql);
 	} catch (PDOException $e) {
		echo 'エラーが発生しました！'.$e->getMessage();
		//echo "<a href=\"/registar\">登録ページに戻る</a>";
		//exit(1);
		$passerr = 2;
	}
    
	$displayname = $data_me['id'];
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
	<script>
		<?php if($passerr == 0){ ?>window.location.href = '/u?<?php echo $data_me['id']; ?>'<?php } ?>
	</script>
	<div class="main_c">
		<div class="top_form_mother">
			<div class="top_form">
				<h1 class="index_title"><?php if($passerr == 0){ echo "アカウント編集完了";}else{echo "err-code:".$passerr."不明なエラーです";} ?></h1>
				<p class="desp1"><?php if($passerr == 0){echo $displayname."のアカウント情報が変更されました";}else{ echo "もう一度、アカウントを編集してください";} ?></p>
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
    include $webroot."/footer.php";
    ?>
    </footer>
</body>

</html>
