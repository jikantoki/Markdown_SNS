<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    define("title","アカウント");
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    $no_title = 1;
    $no_og_img = 1;
    include $webroot."/meta.php";
    ?>
    
    <?php
		$now_url = $_SERVER['REQUEST_URI'];//現在のルートからのURLを取得できる
		$req_id = mb_substr($now_url,3);//URLからユーザーIDを特定
		$req_id2 = explode('&',$req_id);
//		echo $now_url;
//		echo "<br>";
//		echo $req_id;
		
		$sql = "select * from users_list where id=:id";
		$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
		$params = array(':id' => $req_id2[0]); // 挿入する値を配列に格納する
		$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
		if($res){
			$data = $stmt->fetch();
			//echo"<pre>";
//			var_dump($data);			//ユーザー情報丸見えデバッグ
			//echo"</pre>";
		}
		$sql = "select count(*) from users_list where id=:id";	//ユーザーが存在するか？
		$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
		$params = array(':id' => $req_id2[0]); // 挿入する値を配列に格納する
		$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
		if($res){
			$data_sonzai = $stmt->fetch();
			//echo"<pre>";
//			var_dump($data);			//ユーザー情報丸見えデバッグ
			//echo"</pre>";
		}
		if($data_sonzai[0] == 0){
			//ユーザーが存在しない
			//echo "いない";
			$title_defined = 1;
			http_response_code( 404 ) ;
			//include $webroot."/error/404.php";//404を表示
			echo "<script>window.location.href = '/';</script>";
			exit(1);
		}else{
			$under_check = $data['id'];
			$displayname = $data["id"];
			if(strcmp($data["name"],"") != 0){
				$displayname = $data["name"];
			}
			echo "<meta property=\"og:title\" content=\"".$displayname.$title_temp."\">";
		}
		$req_id2[0] = '';
		foreach($req_id2 as $r2){
			if($r2 === 'reply'){
				$tab_reply = 1;
			}
			if($r2 === 'media'){
				$tab_media = 1;
			}
			if($r2 === 'good'){
				$tab_good = 1;
			}
		}
		
//		echo $displayname;	//確認用
		
		$new_title = "<title>${displayname} - ".sitename." ".corp."</title>";
		echo $new_title;	//このechoは消さない
		
    ?>
    <meta property="og:image" content="<?php echo $data['icon_url']; ?>">
    <meta property="twitter:image" content="<?php echo $data['icon_url']; ?>">
</head>

<body>
	<?php $topbar_str = $displayname; ?>
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
		    if(isset($_SESSION['id'])){
		    	if(strcmp($under_check,$data_me['id']) == 0){
		    		$left_myaccount = 1;
		    	}
		    }
		    include $webroot."/left.php";
	    ?>
    </div>
	<div class="main_c" id="pjax">
		<?php include $webroot.'/topbar.php'; ?>
		<div class="top_form_mother">
			<div class="top_form">
				<!-- ここに本文を入力 -->
				<?php
					$icon_click = 1;
					$setting_icon = 1;
					$follow_icon = 1;
					$ajaxed_userinfo = 1;
					$webroot = $_SERVER['DOCUMENT_ROOT'];
					include $webroot."/profile_template.php";
					unset($ajaxed_userinfo);
				?>
				<script src="/library/ajaxUserPost.js"></script>
				<script src="/library/ajaxAddContent.js"></script>
				<div class="u_margin">
					<div class="account_status">
							<?php if($data["certification"] == 1){echo "<div class=\"margin_account_status\"><p style=\"background-color:".$status_color0.";\" class=\"normal_text account_status_text account_status_0\">";} ?><?php if($data["certification"] == 1){ echo "&#10004;本人確認済み</div>"; } ?></p>
							<?php if($data["mail_open"] == 1){echo "<div class=\"margin_account_status\"><p style=\"background-color:".$status_color1.";\" class=\"normal_text account_status_text account_status_1\">";} ?><?php if($data["mail_open"] == 1){ echo "メールでの取引が可能</div>"; } ?></p>
							<?php if($data["idcard_open"] == 1){echo "<div class=\"margin_account_status\"><p style=\"background-color:".$status_color2.";\" class=\"normal_text account_status_text account_status_2\">";} ?><?php if($data["idcard_open"] == 1){ echo "取引時、身分証の開示が可能</div>"; } ?></p>
							<?php if($data["birth_y"] < date('Y') - 18 and !empty($data['birth_y'])){echo "<div class=\"margin_account_status\"><p style=\"background-color:".$status_color3.";\" class=\"normal_text account_status_text account_status_3\">";} ?><?php if($data["birth_y"] < date('Y') - 18 and !empty($data['birth_y'])){ echo "成人済み</div>"; } ?></p>
						<div class="margin_account_status">
							<?php
								if($data['area'] != 0){
									echo "<p style=\"background-color:".$area[$data['area']][1].";\" class=\"normal_text account_status_text account_status_4\">";
									echo $area[$data['area']][0]."在住</p>";
								}
							?>
						</div>
					</div>
					<div class="account_birth">
						<p <?php if($ajax_userinfo == 1)echo 'id="ui_unixtime"'; ?>>
							<?php echo "アカウント作成日時".date('Y/m/d',$data['unixtime']); ?>
						</p>
					</div>
					<div class="profile_md_box">
						<p class="normal_text account_message" <?php if($ajax_userinfo == 1)echo 'id="ui_message"'; ?> style="max-height: 350px;">
							<?php
								if($ajax_userinfo == 0){
									if(strcmp($data["message"],"") != 0){
										$message = $data["message"];
										$message = hash_replace($message);
										$parser = new \cebe\markdown\GithubMarkdown();
										$parser -> html5 = true;
										$parser->enableNewlines = true;
										$parsed_message = $parser -> parse($message);
										echo hashtag(cssing(emoji($parsed_message)));
									}else{
										echo "自己紹介文がまだ登録されていません。";
									}
								}else{
									echo "情報取得中…";
								}
							?>
						</p>
						<?php
							if($ajax_userinfo == 1){
								?>
									<div id="u_showmore" style="display:none;" class="u_showmore" onclick="document.getElementById('ui_message').style.maxHeight='none';document.getElementById('ui_message').style.marginBottom='32px';document.getElementById('u_hidden').style.display='block';document.getElementById('u_showmore').style.display='none';">
										もっと見る
									</div>
									<div id="u_hidden" style="display:none;" class="u_showmore" onclick="document.getElementById('ui_message').style.maxHeight='350px';document.getElementById('ui_message').style.marginBottom='0';document.getElementById('u_showmore').style.display='block';document.getElementById('u_hidden').style.display='none';">
										閉じる
									</div>
								<?php
							}
						?>
					</div>
					<?php
						if(strcmp($data["twitter_id"],"") != 0){
							echo "<a onclick='cacheSave();' style=\"background-color:var(--accent_color1); font-size:16px;\" class=\"index_mainbutton index_mainbutton1\" target=\"_blank\" rel=\"noopener\" href=\"https://twitter.com/",$data["twitter_id"],"\">Twitterで連絡する</a>";
						}
						if($data["mail_open"] == 1){
							echo "<a onclick='cacheSave();' style=\"background-color:var(--accent_color1); font-size:16px;\" class=\"index_mainbutton index_mainbutton1\" target=\"_blank\" rel=\"noopener\" href=\"mailto:",$data["mail"],"\">メールで連絡する</a>";
						}
					?>
				</div>
			</div>
		</div>
		<div class="tabs">
			<!-- タブ切り替えで、ポストとかいいねの一覧を見る -->
			<!-- Divのonclickで実装 -->
			<!--
				以下のphp変数が定義されていたらデフォルトの表示を変える
				$tab_reply
				$tab_media
				$tab_good
			-->
			<script>
				<?php
					$tabset = 'post';
					echo 'var tabset = "post";';
					if(isset($tab_reply)){
						$tabset = 'reply';
						echo 'tabset = "reply";';
					}
					if(isset($tab_media)){
						$tabset = 'media';
						echo 'tabset = "media";';
					}
					if(isset($tab_good)){
						$tabset = 'good';
						echo 'tabset = "good";';
					}
				?>
				function tabActivate(str){
					let d = document;
					d.getElementById('tab_post').style.backgroundColor = 'transparent';
					d.getElementById('tab_reply').style.backgroundColor = 'transparent';
					d.getElementById('tab_media').style.backgroundColor = 'transparent';
					d.getElementById('tab_good').style.backgroundColor = 'transparent';
					d.getElementById('tab_' + str).style.backgroundColor = 'var(--accent_color1)';
					tabset = str;
					history.replaceState('', null, '/u?<?php echo $data["id"]; ?>&' + str);
				}
				document.addEventListener('DOMContentLoaded',function(){
					tabActivate('<?php echo $tabset; ?>');
				});
			</script>
			<input type="hidden" value="<?php echo $data['rand_id']; ?>" id="for_ajaxUser">
			<div class="user_tab">
				<div class="user_tab_child">
					<div class="user_tab_p" id="tab_post" onclick="tabActivate('post');" <?php if($tabset == 'post')echo 'style="background-color:var(--accent_color1);"'; ?>>
						ポスト
					</div>
				</div>
				<div class="user_tab_child">
					<div class="user_tab_p" id="tab_reply" onclick="tabActivate('reply');" <?php if($tabset == 'reply')echo 'style="background-color:var(--accent_color1);"'; ?>>
						ポストと返信
					</div>
				</div>
				<div class="user_tab_child">
					<div class="user_tab_p" id="tab_media" onclick="tabActivate('media');" <?php if($tabset == 'media')echo 'style="background-color:var(--accent_color1);"'; ?>>
						メディア
					</div>
				</div>
				<div class="user_tab_child">
					<div class="user_tab_p" id="tab_good" onclick="tabActivate('good');" <?php if($tabset == 'good')echo 'style="background-color:var(--accent_color1);"'; ?>>
						ええなぁ
					</div>
				</div>
			</div>
			<div class="tab_content" id="tab_content">
				<!-- この中のコンテンツはjsで作る…と思う -->
				<div class="tc_child" id="tc_up">
					<input type="hidden" value="0" id="up_count">
					<div class="tab_content_child" id="up_content">
					</div>
					<div class="loader" id="l_up">Loading...
					</div>
				</div>
				<div class="tc_child" id="tc_ur">
					<input type="hidden" value="0" id="ur_count">
					<div class="tab_content_child" id="ur_content">
					</div>
					<div class="loader" id="l_ur">Loading...
					</div>
				</div>
				<div class="tc_child" id="tc_um">
					<input type="hidden" value="0" id="um_count">
					<div class="tab_content_child" id="um_content">
					</div>
					<div class="loader" id="l_um">Loading...
					</div>
				</div>
				<div class="tc_child" id="tc_ug">
					<input type="hidden" value="0" id="ug_count">
					<div class="tab_content_child" id="ug_content">
					</div>
					<div class="loader" id="l_ug">Loading...
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		ajax_userinfo("<?php echo $data['id']; ?>");
		ajax_userpost();
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
    		//echo $under_check.$data_me['id'];
    		if(isset($_SESSION['id'])){
	    		if(strcmp($under_check,$data_me['id']) == 0){
	    			$under_myaccount_round = 1;
	    		}
	    	}
    		include $webroot."/footer.php";
    	?>
    </footer>
</body>

</html>
