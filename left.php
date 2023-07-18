<!--左のコンテンツやで-->
<?php
	$top_url = $_SERVER['HTTP_HOST'];
?>
<div class="left_content">
	<nav class="sidebar_nav">
		<ul class="sidebar_ul">
			<li class="sidebar_li">
				<a class="sidebar_a" href="/" id="left_top" onclick="cacheClear('<?php echo $top_url.'/'; ?>');">
					<svg>
						<use xlink:href="/img/home.svg#svg"></use>
					</svg>
					トップ
				</a>
			</li>
			<?php
				if(isset($_SESSION['id'])){
			?>
				<li class="sidebar_li">
					<a class="sidebar_a" href="/world" id="left_world" onclick="cacheClear('<?php echo $top_url.'/world'; ?>');">
						<svg>
							<use xlink:href="/img/world.svg#svg"></use>
						</svg>
						ワールド
					</a>
				</li>
				<li class="sidebar_li">
					<a class="sidebar_a" href="/u&quest;<?php echo $data_me['id']; ?>" id="left_profile" onclick="cacheClear('<?php echo $top_url.'/u?'.$data_me['id'].'&post'; ?>');">
						<svg>
							<use xlink:href="/img/account.svg#svg"></use>
						</svg>
						プロフィール
					</a>
				</li>
			<?php
				}
			?>
			<li class="sidebar_li">
				<a class="sidebar_a" href="/search" id="left_search">
					<svg>
						<use xlink:href="/img/search.svg#svg"></use>
					</svg>
					検索
				</a>
			</li>
			<?php
				if(isset($_SESSION['id'])){
			?>
				<li class="sidebar_li">
					<a class="sidebar_a" href="/notif" id="left_notif">
						<svg>
							<use xlink:href="/img/notif.svg#svg"></use>
						</svg>
						通知
					</a>
				</li>
				<!--<li class="sidebar_li">
					<a class="sidebar_a" href="/dm" id="left_dm">
						<svg>
							<use xlink:href="/img/dm.svg#svg"></use>
						</svg>
						メッセージ
					</a>
				</li>-->
				<!--<li class="sidebar_li">
					<a class="sidebar_a post_button_color" href="/post">
						<svg>
							<use xlink:href="/img/post_small.svg#svg"></use>
						</svg>
						ポスト（旧）
					</a>
				</li>-->
				<li class="sidebar_li">
					<a class="sidebar_a post_button_color" id="post_left" onclick="post_left();">
						<svg>
							<use xlink:href="/img/post_small.svg#svg"></use>
						</svg>
						ポスト
					</a>
				</li>
			<?php
				}else{
			?>
				<li class="sidebar_li">
					<a class="sidebar_a" href="/rule" id="left_rule">
						<svg>
							<use xlink:href="/img/rule.svg#svg"></use>
						</svg>
						利用規約
					</a>
				</li>
				<li class="sidebar_li">
					<a class="sidebar_a" href="/credit" id="left_credit">
						<svg>
							<use xlink:href="/img/credit.svg#svg"></use>
						</svg>
						クレジット
					</a>
				</li>
				<li class="sidebar_li">
					<a class="sidebar_a" href="/buglist" id="left_buglist">
						<svg>
							<use xlink:href="/img/bug_list.svg#svg"></use>
						</svg>
						バグリスト
					</a>
				</li>
				<li class="sidebar_li">
					<a class="sidebar_a" onclick="cacheclear();" id="left_cacheclear">
						<svg>
							<use xlink:href="/img/reload.svg#svg"></use>
						</svg>
						キャッシュクリア
					</a>
				</li>
				<li class="sidebar_li">
					<a class="sidebar_a post_button_color" href="/login">
						<svg>
							<use xlink:href="/img/account.svg#svg"></use>
						</svg>
						ログイン
					</a>
				</li>
			<?php
				}
			?>
		</ul>
	</nav>
	<!-- アカウント情報 -->
			<?php
				include $webroot.'/left_profile.php';
			?>
	<!-- 旧型式 
	<div class="top_account right_content">
		<div class="header_profile">
			<?php
				include $webroot.'/account_show.php';
			?>
		</div>
	</div>
	<?php
		if($more_ads == 1)include $webroot."/adsense.php";
	?>
	-->
	<!--<input type="button" id="cacheclearbutton" onclick="cacheclear();" value="キャッシュクリアボタン">-->
</div>
<script>
</script>
<?php
	if(isset($data_me_null)){
		unset($data_me);
	}
?>