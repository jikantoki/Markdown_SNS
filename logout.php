<?php
    if(isset($_SESSION['id']))unset($_SESSION['id']);
    setcookie('id',"",time() - 30);
    setcookie('pass',"",time() - 30);
    setcookie('mail',"",time() - 30);
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    define("title","ログアウト");
    include $webroot."/meta.php";
    ?>
<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
	<script>
		cacheclear();
	</script>
</head>

<body>
    <header>
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    $logout_flag = 1;
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
		<div class="top_form_mother">
			<div class="top_form">
				<h1 class="index_title">ログアウトしました</h1>
				<p class="desp1">商品の登録や購入には、再度ログインが必要です</p>
				<div class="index_main1">
				<?php echo "<a style=\"background-color:var(--accent_color1);\" class=\"index_mainbutton index_mainbutton1\" href=\"/\">トップページへ</a>"; ?>
				</div>
			</div>
		</div>
	</div>
	<script>
		location.href = "/";
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
