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
	if(!isset($_POST['otp'])){
		//不正アクセス乙
		header('Location:https://'.$myhost);
		exit;
	}elseif($_POST['otp'] === ''){
		//不正アクセス乙
		header('Location:https://'.$myhost);
		exit;
	}
?>
<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    define("title","パスワードをリセット");
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/meta.php"
    ?>
<?php
  $passerr = 0;
  try{
	$otp = h($_POST['otp']);
	$passwd = $_POST['pass'];
	$passed = password_hash($passwd , PASSWORD_DEFAULT);
	
//    mysqli_quary($pdo,$sql);
  } catch (PDOException $e) {
	//echo 'エラーが発生しました！'.$e->getMessage();
	//echo "<a href=\"/registar\">登録ページに戻る</a>";
	//exit(1);
	$passerr = 1;
  }
		//echo $id."    ".$mail;
  //echo $passerr;
  if($passerr == 0){
  	//ここにページの自動生成を入れる
  	//mb_language("Japanese");
	//mb_internal_encoding("UTF-8");
	//$mail_mes = sitename."をご利用いただきありがとうございます。\r\nアカウント「".$displayname."」が登録されました。\r\nログインページは<a href=\"".page_address."/login\">こちら</a>です。";
	//$mail_head = "From:".mail_address;
	//if(mb_send_mail($mail,"アカウント登録完了のお知らせ",$mail_mes,$mail_head)){echo $mail.$mail_mes.$mail_head;}else{echo "メール送信できてない";};	//開発環境では動かない
	//mb_send_mailは環境によって動かないので、phpmailerを使用
	try{
		$q = "update users_list set pass='".$passed."' where otp='".$otp."';";
		//echo $q;
		$q2 = $pdo -> query($q);
		$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
		$q = "update users_list set otp='' where otp='".$otp."';";
		//echo $q;
		$q2 = $pdo -> query($q);
		$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
	}catch(Exception $e){
		//IDが存在しない
		$passerr = 2;
		echo "<br>".$e->getMessage();
	}
  }
?>
	<meta charset="UTF-8">
</head>

<body>
    <header>
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/header.php"
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
				<h1 class="index_title"><?php if($passerr == 0){ echo "パスワードリセットを完了";}elseif($passerr == 1){ echo "Error:不明なエラーです";}elseif($passerr == 2){echo "入力に誤りがあります";}else{echo "不明なエラーです";} ?></h1>
				<p class="desp1"><?php if($passerr == 0){echo "新しいパスワードでログインしてください";}else{ echo "もう一度、入力しなおしてください";} ?></p>
				<div class="index_main1">
					<?php if($passerr == 0){ echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton1\" href=\"/login\">ログイン</a>";} ?>
					<?php if($passerr != 0){ echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton1\" href=\"/pwreset\">戻る</a>";} ?>
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
