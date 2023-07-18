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
    define("title","パスワードをリセット");
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/meta.php"
    ?>
<?php
  $passerr = 0;
  try{
	$mail = h($_POST['mail']);
	$id = h($_POST['id']);
	$date = new DateTime('2018-01-01 00:00:00');
	$utime = $date->format('U');//UNIX時間を貰う
	$randomi = mt_rand(10000,30000);
	$randomi2 = mt_rand(10000,30000);
	$otp = "pwreset".time().$randomi.$randomi2.$id.makeRandStr(16)."z";
	$unixtime = time();
	
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
		$q = "update users_list set otp='".$otp."' where id='".$id."' and mail='".$mail."';";
		//echo $q;
		$q2 = $pdo -> query($q);
		$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
	}catch(Exception $e){
		//IDが存在しない
		$passerr = 2;
		echo "<br>".$e->getMessage();
	}
	try{
		//なんでPHPMailerはfunctionできないんだ…
		$mail_smtp = new PHPMailer\PHPMailer\PHPMailer(true);	//これはおまじない
		$mail_smtp -> CharSet = 'utf-8';			//UTF8使うよ！
		$mail_smtp -> isSMTP();	//メールでSMTP使うよ～って宣言
		$mail_smtp -> SMTPAuth = true;	//SMTP認証ちゃんとやるよ！
		$mail_smtp -> Host = $smtp_host;	//SMTPサーバー
		$mail_smtp -> Username = $smtp_user;	//SMTP鯖のユーザー名
		$mail_smtp -> Password = $smtp_pass;	//SMTP鯖のパスワード
		$mail_smtp -> Port = 587;	//基本はこの数値で問題ない
		$mail_smtp -> setFrom($smtp_from);	//配信メールの送信元
		$mail_smtp -> isHTML(true);	//HTMLメールの有効化
		$mail_smtp -> FromName = sitename;	//メール配信者名を変更
		$mail_smtp -> addAddress($_POST['mail']);	//宛先
		$mail_smtp -> Subject = "パスワードをリセットします";
		$mail_smtp -> Body = sitename."をご利用いただきありがとうございます。<br>アカウント「@".$id."」で、パスワードリセットのリクエストがありました。<br><a href=\"".page_address."/pwform?q=".$otp."\">こちら</a>のリンクをクリックして、パスワードをリセットします。<br>身に覚えのないリクエストの場合は、悪意を持ったユーザーからの攻撃を受けている可能性があるのでご注意ください。<br>また、同じメールが複数回送信されている場合は新しい方のURLを使用してください。";
		$mail_smtp -> send();//メールを確定して送信
	}catch(Exception $e){
		echo "メール送信の設定どこか間違ってるよ".$mail_smtp -> Errorinfo;
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
				<h1 class="index_title"><?php if($passerr == 0){ echo "リセットリクエストを送信完了";}elseif($passerr == 1){ echo "Error:不明なエラーです";}elseif($passerr == 2){echo "入力に誤りがあります";}else{echo "不明なエラーです";} ?></h1>
				<p class="desp1"><?php if($passerr == 0){echo "メールを確認し、パスワードをリセットしてください";}else{ echo "もう一度、入力しなおしてください";} ?></p>
				<div class="index_main1">
					<?php if($passerr == 0){ echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton1\" href=\"/\">トップページへ</a>";} ?>
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
