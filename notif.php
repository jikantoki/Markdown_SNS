<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
	<?php
	if(isset($title_defined)){
	//タイトルもうあるね
	}else{
		define("title","通知");
	}
	$webroot = $_SERVER['DOCUMENT_ROOT'];
	//$already_setting = 1;
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
				<script src="/library/ajaxNotif.js"></script>
				<div class="top_form">
					<h1 class="index_title">The 通知 is 準備中</h1>
					<p class="desp1">ごめんもうちょい待ってくれや</p>
					<div class="index_main1">
						<a style="background-color:var(--accent_color1)" class="index_mainbutton index_mainbutton1" href="/">トップページへ</a>
					</div>
				</div>
			</div>
			<div class="notifarea">
				<input type="hidden" value="0" id="count">
				<div id="content">
					<?php /* ここにコンテンツが入る */ ?>
				</div>
				<div class="loader">Loading...</div>
				<!--<input type="button" onclick="ajax_notif();" class="viewmore_ajax" value="読み込まれない場合はクリック">-->
			</div>
			<script>
				ajax_notif();
			</script>
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
