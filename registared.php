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
    define("title","アカウント登録完了");
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/meta.php"
    ?>
<?php
  try{
	$mail = h($_POST['mail']);
	$mail_open2 = 0;//初期値ではメアド非公開
	$id = h($_POST['id']);
	foreach($cant_use_id as $cant_id){
		if(mb_strtolower($cant_id) == mb_strtolower($id))$passerr = 6;
	}
	$name = h($_POST['name']);
	$icon_url = icon_url_default;//アイコンURLの初期値
	$twitter_id = h($_POST['twitter_id']);
	$pass = $_POST['pass'];
	$pass_re = $_POST['pass_re'];
	$passed = password_hash($pass , PASSWORD_DEFAULT);
	$date = new DateTime('2018-01-01 00:00:00');
	$utime = $date->format('U');//UNIX時間を貰う
	$randomi = mt_rand(10000,30000);
	$randomi2 = mt_rand(10000,30000);
	$rand_id = "a1eno2".time().$randomi.$randomi2.$id."z";
	$unixtime = time();
	if(strcmp($pass,$pass_re) != 0){
		//echo "エラー、1つ目と2つ目のパスワードが違います。<br>";
		//echo "<a href=\"/registar\">登録ページに戻る</a>";
		//exit(1);
		$passerr = 1;
	}else{
		if(preg_match($allow_id_pattern,$id)){
			//全てうまくいけばここに来る
			if(!isset($passerr))$passerr = 0;
    		$webroot = $_SERVER['DOCUMENT_ROOT'];
		//	$cp = copy($webroot."/registared_user.txt",$webroot."/user/".$id.".php");
		}else{
			$passerr = 3;
		}
	}
	$displayname = $id;
	if(strcmp($name,'') != 0){
		$displayname = $name;
	}

	if($passerr == 0){
	//    $count = $db->exec('INSERT INTO users_list (id,name,icon_url,twitter_id,pass) VALUES (:id,:name,:icon_url,:twitter_id,:pass)');
	    $sql = "INSERT INTO users_list (mail,mail_open,id,name,icon_url,twitter_id,pass,status,rand_id,unixtime,ipAddress) VALUES (:mail,:mail_open,:id,:name,:icon_url,:twitter_id,:passed,0,:rand_id,:unixtime,:ipAddress)";
	    $stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
	    $params = array(':mail' => $mail,':mail_open' => $mail_open2,':id' => $id, ':name' => $name, ':icon_url' => $icon_url, ':twitter_id' => $twitter_id, ':passed' => $passed, ':rand_id' => $rand_id,':unixtime' => $unixtime, 'ipaddress' => $_SERVER['REMOTE_ADDR']
		); // 挿入する値を配列に格納する
	    $stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
	}
	
//    mysqli_quary($pdo,$sql);
  } catch (PDOException $e) {
	//echo 'エラーが発生しました！'.$e->getMessage();
	//echo "<a href=\"/registar\">登録ページに戻る</a>";
	//exit(1);
	$passerr = 2;
  }
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
		$mail_smtp -> Subject = "アカウント登録完了のお知らせ";
		$mail_smtp -> Body = sitename."をご利用いただきありがとうございます。<br>アカウント「".$displayname."」が登録されました。<br><a href=\"".page_address."/mail_auth?".$rand_id."\">こちら</a>のリンクをクリックして、アカウントを有効化してください。";
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
				<h1 class="index_title"><?php if($passerr == 0){ echo "アカウント登録完了";}elseif($passerr == 1){ echo "Error:パスワードを再確認してください";}elseif($passerr == 2){echo "アカウントIDが既に存在します";}elseif($passerr == 3){echo "IDに使用できない文字が含まれています";}elseif($passerr == 6){"そのIDは使用できません";}else{echo "不明なエラーです";} ?></h1>
				<p class="desp1"><?php if($passerr == 0){echo "ようこそ、".$displayname."さん！メールを確認し、ログインしてください<br>メールのURLを開くまで、アカウントは有効化されません";}else{ echo "もう一度、アカウントを登録しなおしてください";} ?></p>
				<div class="index_main1">
					<?php if($passerr == 0){ echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton1\" href=\"/\">トップページへ</a>";} ?>
					<?php if($passerr != 0){ echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton1\" href=\"/registar\">登録ページへ</a>";} ?>
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
