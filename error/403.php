<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    define("title","403 Forbidden");
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
				<h1 class="index_title">403 Forbidden</h1>
				<p class="desp1">このページにアクセスする権限がありません。</p>
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
