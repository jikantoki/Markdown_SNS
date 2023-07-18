<?php
	//不正アクセスを対策しよう
	$referer = parse_url($_SERVER['HTTP_REFERER']);
	$ref_url = $referer['host'];//$ref_urlは1つ前のページのドメイン
	$myhost = $_SERVER['HTTP_HOST'];//$myhostは今のページのドメイン
	if(strcmp($ref_url,$myhost) != 0){
		//不正アクセス乙
		//header('Location:https://'.$myhost);
		console.log("aaaaaaaaa");
		exit;
	}
?>
<?php
		function h($s) {
			return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
		}
    	$webroot = $_SERVER['DOCUMENT_ROOT'];
		include $webroot.'/settings.php';
	?>
	<?php
		try{
			$id = h($_POST['id']);
			$mail = h($_POST['mail']);
			$pass = h($_POST['pass']);
			$sql = "select count(*) from users_list where id=:id and mail=:mail";
			$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
			$params = array(':id' => $id, ':mail' => $mail); // 挿入する値を配列に格納する
			$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
			if($res){
				$user_kakunin = $stmt->fetch();
				//echo"<pre>";
				//var_dump($user_kakunin);	//ユーザーが存在すれば1、なければ0
				//echo"</pre>";
			}
			if($user_kakunin["count(*)"] == 0){
				//echo 'ユーザーが存在しません！';
				//echo "<a href=\"/login\">ログインページに戻る</a>";
				//exit(1);
				$sonzai = 0;
			}else{
				$sonzai = 1;
			}
			if($sonzai != 0){
				$sql = "select * from users_list where id=:id and mail=:mail";
				$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
				$params = array(':id' => $id, ':mail' => $mail); // 挿入する値を配列に格納する
				$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
				if($res){
					$data = $stmt->fetch();
					//echo"<pre>";
					//var_dump($data);			//ユーザー情報丸見えデバッグ
					//echo"</pre>";
					if($sonzai == 1){
						//echo $data["id"];			//IDを取り出したい時はこうする
						$displayname = $data["id"];
						if($data["name"] != ''){
							$displayname = $data["name"];
						}
						//ここからメアドとパスワードを確認する
						//echo $data["mail"];
						//echo $mail;
						if(strcmp($mail,$data["mail"]) != 0){
							//メアド不一致
							//echo $mail.$data['mail'];
							$sonzai = 0;
							//echo "メアドちゃう";
						}else{
							//IDとメアドは合ってる
							if(password_verify($pass,$data["pass"])){
								if($data["status"] != 1){
									$sonzai = 3;//垢バンしたやつはこれ
								}
								//全部OK
								//$sonzai = 1;	//ここ必要なかった
								//echo "パスOK";
								//echo $data['mac_json'];
								$mac_json = json_decode($data['mac_json'],true);
								//echo var_dump($mac_json);
								
								$session_id = $id.rand(10000,30000).rand(10000,30000);//ランダムなセッションIDを生成
								$sql = "update users_list set session_id=:session_id where users_list.id=:id";
								$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
								$params = array(':id' => $id, ':session_id' => $session_id); // 挿入する値を配列に格納する
								$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
								
								
								$_SESSION['id'] = $session_id;//セッション与えちゃう
								//echo "START";
								setcookie('id',$data['id'],time() + 60 * 60 * 24 * 30);
								setcookie('pass',$pass,time() + 60 * 60 * 24 * 30);
								setcookie('mail',$data['mail'],time() + 60 * 60 * 24 * 30);//クッキーも与えてみる、30日は保存できる
								//echo "AAAAAAAAAA";
								//echo "クッキーセット！";
								//ここにページの自動生成を入れる
								$meta_ok = 1;
								define("title","ログイン完了");
								$webroot = $_SERVER['DOCUMENT_ROOT'];
								$already_setting = 1;
								include $webroot."/meta.php";
								
								
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
									$mail_smtp -> addAddress($data['mail']);	//宛先
									$mail_smtp -> Subject = $logined_mail_title;
									$logined_mail_body2 = str_replace('*sitename',sitename,$logined_mail_body);
									$logined_mail_body3 = str_replace('*displayname',$displayname,$logined_mail_body2);
									$logined_mail_body4 = str_replace('*page_address',page_address,$logined_mail_body3);
									$mail_smtp -> Body = $logined_mail_body4;
									$mail_smtp -> send();//メールを確定して送信
								}catch(Exception $e){
									echo "Webサイト管理者へ:メール送信の設定どこか間違ってるよ".$mail_smtp -> Errorinfo;
								}
							}else{
								//パスワード不一致
								$sonzai = 0;
								//echo "パスちゃう";
							}
						}
					}
				}
			}
		}catch (PDOException $e) {
			//echo 'エラーが発生しました！'.$e->getMessage();
			//echo "<a href=\"/login\">ログインページに戻る</a>";
			//exit(1);
			$sonzai = 2;
		}
		if(!isset($meta_ok)){
			$meta_ok = 1;
			define("title","ログイン完了");
			$webroot = $_SERVER['DOCUMENT_ROOT'];
			$already_setting = 1;
			include $webroot."/meta.php";
		}
	?>
	
<meta charset="UTF-8">
<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
	<script>
		console.log('before cacheclear cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
		cacheclear();
		console.log('after cacheclear cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
	</script>
</head>

<body>
	<script>
		console.log('before header cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
	</script>
    <header>
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/header.php"
    ?>
    </header>
	<script>
		console.log('after header cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
	</script>
	<main>
	<div class="col">
	<div class="left_menu">
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/left.php";
    ?>
	<script>
		console.log('after left cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
	</script>
    </div>
	<script>
		<?php if($sonzai == 1){ ?>/* window.location.href = '/u?<?php echo $data['id']; ?>' */<?php } ?>
	</script>
	<div class="main_c">
		<div class="top_form_mother">
			<div class="top_form">
				<!-- ここに本文を入力 -->
				<h1 class="index_title">
					<?php if($sonzai == 0){ echo "ログインに失敗しました";} ?>
					<?php if($sonzai == 1){ echo "こんにちは、",h($displayname),"さん";} ?>
					<?php if($sonzai == 2){ echo "不明なエラーです";} ?>
					<?php if($sonzai == 3){ echo "認証メールを確認してください";} ?>
				</h1>
				<?php if($sonzai == 1){
					echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton1\" href=\"/u?".$data["id"]."\">".$displayname."の詳細ページへ</a>";
					echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton2\" href=\"/\">トップに戻る</a>";
				}else{
					echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton1\" href=\"/login\">ログインページに戻る</a>";
				} ?>
			</div>
		</div>
	</div>
	<div class="right_menu">
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/right.php";
    ?>
	<script>
		console.log('after right cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
	</script>
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
	<script>
		console.log('after footer cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
	</script>
</body>

</html>
