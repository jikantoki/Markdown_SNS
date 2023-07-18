<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
	<?php
    define("title","オプション");
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
				<h1 class="index_title">オプション</h1>
				<p class="desp1">なんか色々できるようにしたいなぁ！<br>APIやらカスタムCSSやら</p>
				<div class="index_main1">
					<a style="background-color:var(--accent_color1)" class="index_mainbutton index_mainbutton1" href="/">トップページへ</a>
				</div>
			</div>
			<div class="option_content_mother">
				<!-- オプションリスト -->
				<div class="option_content_child">
					<!-- オプション項目 -->
					<h1 class="option_h1">カスタムCSS</h1>
					<p class="option_p">アカウント毎に独自のCSSを適用できます。準備中</p>
					<textarea id="option_custom_css" class="option_textarea" onkeyup='cssOverWrite();' placeholder="ここにCSSを記述" disabled>ちょっと待ってね</textarea>
					<input type="button" id="custom_css_submit" style="background-color: var(--hover_right);" class="form_submit" value="CSS保存" onclick="css_save();">
				</div>
			</div>
		</div>
	</div>
	<script>
		ajax_css();
		function cssOverWrite(){
			let w = document.getElementById('option_custom_css').value;
			document.getElementById('custom_css').innerHTML = w;
			console.log(w);
		}
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
    include $webroot."/footer.php";
    ?>
    </footer>
</body>

</html>
