<?php /*
	//不正アクセスを対策しようPHP版
	$referer = parse_url($_SERVER['HTTP_REFERER']);
	$ref_url = $referer['host'];//$ref_urlは1つ前のページのドメイン
	$myhost = $_SERVER['HTTP_HOST'];//$myhostは今のページのドメイン
	if(strcmp($ref_url,$myhost) != 0){
		//不正アクセス乙
		header('Location:https://'.$myhost);
		exit;
	} */
?>
<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    define("title","削除完了");
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/meta.php";
    ?>
	<meta charset="UTF-8">
	<script>
		ref_check();//不正アクセス対策、metaの直後に入れる、重要な処理はこれより前に入れない
	</script>
</head>

<body>
    <header>
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/header.php"
    ?>
    </header>
	<?php
		//URLから削除したいポストを特定
		$req_id = mb_substr($now_url,8);
		//削除したいポストのオーナーは、ログインユーザーと一致するか？
		
		//ポストの投稿者を特定し、ログインしているユーザーと一致したら投稿を削除
		$sql = "delete from sent_list where sent_owner=:rid and sent_rand_id=:req_id";
		$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
		$params = array(':rid' => $data_me['rand_id'],':req_id' => $req_id); // 挿入する値を配列に格納する
		$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
		if($res){
			$data_del = $stmt->fetch();
			//echo"<pre>";
			//var_dump($data_owner);			//ユーザー情報丸見えデバッグ
			//echo"</pre>";
		}
	?>
	<main>
	<div class="col">
	<div class="left_menu">
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/left.php";
    ?>
    </div>
	<script>
		window.location.href = history.go(-1);
	</script>
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
