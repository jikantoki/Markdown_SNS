<!DOCTYPE html>
<html lang="ja">

<head>
    <?php
    define("title","トップ");
    $webroot = $_SERVER['DOCUMENT_ROOT'];
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
	<div class="left_menu">
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/left.php";
    ?>
	</div>
	<div class="top_form_mother">
		<div class="top_form">
			<h1 class="index_title"><?php echo sitename ?></h1>
			<p class="desp1"><?php echo despri ?></p>
			<div class="index_main1">
				<a class="index_mainbutton index_mainbutton1" href="/login">ログイン</a>
				<a class="index_mainbutton index_mainbutton2" href="/registar">登録</a>
				<a class="index_mainbutton index_mainbutton3" href="/view">商品を見る</a>
			</div>
		</div>
	</div>
	<div class="right_menu">
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/right.php";
    ?>
	</div>
	</main>
    <footer>
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/footer.php";
    ?>
    </footer>
</body>

</html>
