<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    if(isset($title_defined)){
	//タイトルもうあるね
	}else{
	    define("title","検索");
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
			<script src="/library/ajaxSearch.js"></script>
			<div class="top_form">
				<h1 class="index_title">検索</h1>
				<!--
				<div class="index_main1">
					<a style="background-color:var(--accent_color1)" class="index_mainbutton index_mainbutton1" href="/">トップページへ</a>
				</div>
				-->
				<?php
					$val = "";
					if(isset($_GET['keyword']))$val = h($_GET['keyword']);
				?>
				<div class="serach_textarea_div">
					<form action="/search" method="get" class="search_form_main">
						<input class="searchbar" type="text" name="keyword" placeholder="話題を検索" value="<?php echo $val; ?>">
						<div class="search_optionbutton">
							<button style="background-color:var(--hover_right);" class="form_submit" type="button" name="search_option_view" onclick="view_search_opt();">詳しく検索</button>
						</div>
						<div class="search_option" id="search_option" style="display:none;">
							<script>
								function view_search_opt(){
									let b = document.getElementById("search_option");
									if(b.style.display == 'none'){
										b.style.display = 'block';
									}else{
										b.style.display = 'none';
									}
								}
							</script>
							<!-- ここにオプションを表示 -->
							<div class="search_table_bigmother">
								<div class="search_table_mother">
									<div class="search_title">
										基本設定
									</div>
									<table class="search_table">
										<tbody>
											<tr>
												<td>
													<p class="search_table_p">リプライを含める</p>
												</td>
												<td>
													<input type="checkbox" class="search_table_td" id="with_reply" name="with_reply" <?php if(isset($_GET['with_reply']))echo 'checked'; ?>>
												</td>
											</tr>
											<tr>
												<td>
													<p class="search_table_p">画像付きポストに限定する</p>
												</td>
												<td>
													<input type="checkbox" class="search_table_td" id="with_img" name="with_img" <?php if(isset($_GET['with_img']))echo 'checked'; ?>>
												</td>
											</tr>
											<tr>
												<td>
													<p class="search_table_p">引用ポストに限定する</p>
												</td>
												<td>
													<input type="checkbox" class="search_table_td" id="with_inyou" name="with_inyou" <?php if(isset($_GET['with_inyou']))echo 'checked'; ?>>
												</td>
											</tr>
											<tr>
												<td>
													<p class="search_table_p">URL付きポストに限定する</p>
												</td>
												<td>
													<input type="checkbox" class="search_table_td" id="with_url" name="with_url" <?php if(isset($_GET['with_url']))echo 'checked'; ?>>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="search_table_mother">
									<div class="search_title">
										ジャンル
									</div>
									<table class="search_table">
										<tbody>
											<?php
												$gcnt = 0;
												foreach($genre as $g){
													?>
														<tr>
															<td>
																<p class="search_table_p"><?php echo $g[0]; ?></p>
															</td>
															<td>
																<input type="checkbox" class="search_table_td" id="genre<?php echo $gcnt; ?>" name="genre<?php echo $gcnt; ?>" <?php if(isset($_GET['genre'.$gcnt]))echo 'checked'; ?>>
															</td>
														</tr>
													<?php
													$gcnt += 1;
												}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="form_search_div">
								<button style="background-color: var(--hover_right);" class="form_submit form_submit_search" type="submit" name="search_submit">検索</button>
							</div>
						</div>
					</form>
				</div>
				<?php
					if(isset($_GET['keyword'])){
						//echo "keyword is ".h($_GET['keyword']);
					}
				?>
			</div>
		</div>
		<?php if(count($_GET) != 0){ ?>
			<?php if(isset($_GET['keyword'])){ ?>
				<?php if($_GET['keyword'] != ''){ ?>
					<?php $ok = 1; ?>
				<?php } ?>
			<?php }else{ ?>
				<?php $ok = 1; ?>
			<?php } ?>
			<?php if(isset($_GET['with_reply']))$ok = 1; ?>
			<?php if(isset($_GET['with_inyou']))$ok = 1; ?>
			<?php if(isset($_GET['with_url']))$ok = 1; ?>
			<?php if(isset($_GET['with_img']))$ok = 1; ?>
			<?php
				$i = 0;
				foreach($genre as $genre1){
					if(isset($_GET['genre'.$i]))$ok = 1;
					$i += 1;
				}
			?>
			<?php if(isset($ok)){ ?>
				<div class="sent_content">
					<input type="hidden" id="count" value=0>
					<input type="hidden" id="count_a" value=0>
					<p class="index_title">アカウントを検索</p>
					<div id="account_content">
						<?php
							//類似するアカウントを表示
						?>
					</div>
					<div id="content">
						<?php
							//スクロール読み込みajax
							//ここでsent_content2.phpを読み込む
							//javascriptでこの位置に勝手に入ってきます */
						 ?>
					</div>
				</div>
				<div class="loader">Loading...</div>
				<!--<input type="button" onclick="ajax_search();" class="viewmore_ajax" value="読み込まれない場合はクリック">-->
				<script>
					ajax_search();
					ajax_asearch();
				</script>
			<?php }else{ ?>
				<p class="desp1">トレンド機能は作れないので、過去24時間のいいねが多いポストでも表示したいです</p>
			<?php } ?>
		<?php }else{ ?>
			<p class="desp1">トレンド機能は作れないので、過去24時間のいいねが多いポストでも表示したいです</p>
		<?php } ?>
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
