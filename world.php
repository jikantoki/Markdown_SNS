<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    define("title","ワールド");
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/meta.php";
    ?><!--
    
	<meta property="og:description" content="<?php echo despri_seo; ?>" >-->
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
		<div class="main_c" id="pjax">
			<?php
			    $left_world = 1;
			?>
			<script src="/library/ajaxAddContent.js"></script>
			<div class="topbar_top">
				<?php if(!isset($no_page_title_view)){ ?>
					<!-- 上メニューの表示 -->
					<?php $noback_button = 1; ?>
					<?php include $webroot.'/topbar.php'; ?>
				<?php } ?>
			</div>
			<?php if(isset($_SESSION['id'])){ ?>
				<div class="top_form_mother top_form_margin top_postor_fix">
					<div class="post_img post_img_margin">
						<a href="u?<?php echo $data_me['id']; ?>">
							<img class="post_img" src="<?php echo $data_me['icon_url']; ?>" width="100px" loading="lazy">
						</a>
					</div>
					<div class="postor">
						<?php
							$small = 1;
							include $webroot."/postor.php";
							unset($small);
						?>
					</div>
				</div>
			<?php } ?>
			<p class="please_follow">ワールドページには、全てのユーザーのポストが表示されます。<br>フォローしたユーザーのみのポストは、トップページでご覧ください。</p>
			<?php
				$worldortop = 1;
				//topなら0、worldなら1
			?>
			<div class="new_post" id="new_post">
				<a class="new_post_a" id="new_post_a" href="./">
					n件の新しい投稿
				</a>
			</div>
			<div class="sent_content">
				<input type="hidden" id="count" value=0>
				<input type="hidden" id="worldortop_id" value=1>
				<?php
					if(isset($_GET['unixtime'])){
						echo "<input type=\"hidden\" id=\"unixtime\" value=".$_GET['unixtime'].">";
						//echo "UNIXTIME is ".$_GET['unixtime'];
						echo "<p class=please_follow>".date('Y/m/d H:i.s', $_GET['unixtime'])."時点でのポストを表示しています</p>";
					}
				?>
				<div id="content">
					<?php
						//スクロール読み込みajax
						//ここでsent_content2.phpを読み込む
						//javascriptでこの位置に勝手に入ってきます */
					 ?>
				</div>
			</div>
			<div class="loader">Loading...</div>
			<!--<input type="button" onclick="ajax_add_content();" class="viewmore_ajax" value="読み込まれない場合はクリック">-->
			<script>
				ajax_add_content();
			</script>
		</div><!-- pjax終了 -->
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
		    $under_world = 1;
		    include $webroot."/footer.php";
	    ?>
    </footer>
</body>

</html>