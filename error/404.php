
<?php
	function h($s) {
		return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
	}
	$webroot = $_SERVER['DOCUMENT_ROOT'];
	include $webroot.'/settings.php';
?>
<?php
	$nowurl = $_SERVER['REQUEST_URI'];//トップページからの絶対パス
	$nowurl_parsed = explode('/',$nowurl,3);//スラッシュでURLを区切った配列
	$id = $nowurl_parsed[1];
	
	$sql = "select count(*) from users_list where id=:id";
	$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
	$params = array(':id' => $id); // 挿入する値を配列に格納する
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
		$nowurl2 = mb_substr($nowurl,1);
		$correct_url = '/u?'.$nowurl2;
		$redirect = 'http://'.$_SERVER['HTTP_HOST'].$correct_url;
		header('Location: '.$redirect);
	}
?>
<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    if(isset($title_defined)){
	//タイトルもうあるね
	}else{
	    define("title","404 Not Found");
	}
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    $already_setting = 1;
    include $webroot."/meta.php";
    ?>
</head>

<body>
    <header>
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/header.php";
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
		<?php include $webroot.'/topbar.php'; ?>
		<div class="top_form_mother top_form_margin">
			<div class="top_form">
				<h1 class="index_title">404 Not found</h1>
				<p class="desp1">お探しのページは存在しないか、削除されています。</p>
				<div class="index_main1">
					<a style="background-color:var(--accent_color1)" class="index_mainbutton index_mainbutton1" href="/">トップページへ</a>
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
