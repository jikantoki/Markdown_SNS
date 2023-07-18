<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    define("title","アカウント有効化");
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/meta.php"
    ?>
	<meta charset="UTF-8">
	<?php
		try{
			$now_url = $_SERVER['REQUEST_URI'];//現在のルートからのURLを取得できる
			$req_id = mb_substr($now_url,11);//URLからユーザーIDを特定
			//echo $req_id;
			$sql = "select count(*) from users_list where rand_id=:id";
			$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
			$params = array(':id' => $req_id); // 挿入する値を配列に格納する
			$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
			if($res){
				$user_kakunin = $stmt->fetch();
				echo"<pre>";
				//var_dump($user_kakunin);	//ユーザーが存在すれば1、なければ0
				echo"</pre>";
			}
			if($user_kakunin["count(*)"] == 0){
				//echo 'ユーザーが存在しません！';
				//echo "<a href=\"/login\">ログインページに戻る</a>";
				//exit(1);
				$sonzai = 0;
			}else{
				$sonzai = 1;
			}
			
			$sql = "select * from users_list where rand_id=:id";
			$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
			$params = array(':id' => $req_id); // 挿入する値を配列に格納する
			$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
			if($res){
				$data = $stmt->fetch();
				echo"<pre>";
				//var_dump($user_kakunin);	//ユーザーが存在すれば1、なければ0
				echo"</pre>";
			}
			$sql = "update users_list SET status=1 where users_list.rand_id=:id";
			$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
			$params = array(':id' => $req_id); // 挿入する値を配列に格納する
			$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
			if($res){
				$data_status = $stmt->fetch();
				echo"<pre>";
				//var_dump($data);			//ユーザー情報丸見えデバッグ
				echo"</pre>";
				if($sonzai == 1){
					//echo $data["id"];			//IDを取り出したい時はこうする
					$displayname = $data["id"];
					if($data["name"] != ''){
						$displayname = $data["name"];
					}
				}
			}
		}catch (PDOException $e) {
			//echo 'エラーが発生しました！'.$e->getMessage();
			//echo "<a href=\"/login\">ログインページに戻る</a>";
			//exit(1);
			$sonzai = 2;
		}
	?>
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
				<!-- ここに本文を入力 -->
				<h1 class="index_title">
					<?php if($sonzai == 0){ echo "認証に失敗しました";} ?>
					<?php if($sonzai == 1){ echo "アカウントが有効化されました";} ?>
					<?php if($sonzai == 2){ echo "不明なエラーです";} ?>
					<?php if($sonzai == 3){ echo "アカウントがロックされています";} ?>
				</h1>
				<?php if($sonzai == 1){
					echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton2\" href=\"/login\">ログイン</a>";
					echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton2\" href=\"/\">トップに戻る</a>";
				}else{
					echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton1\" href=\"/\">トップに戻る</a>";
				} ?>
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
