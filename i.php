<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    define("title","ポスト");
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    $no_title = 1;
    $no_og_img = 1;
    include $webroot."/meta.php";
    ?>
    
    <?php
		$now_url = $_SERVER['REQUEST_URI'];//現在のルートからのURLを取得できる
		$req_id = mb_substr($now_url,3);//URLから投稿ポストを特定
//		echo $now_url;
//		echo "<br>";
//		echo $req_id;
		
		$sql = "select * from sent_list where sent_rand_id=:id";
		$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
		$params = array(':id' => $req_id); // 挿入する値を配列に格納する
		$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
		if($res){
			$data_content = $stmt->fetch();
			//echo"<pre>";
//			var_dump($data);			//ユーザー情報丸見えデバッグ
			//echo"</pre>";
		}
		$sql = "select * from users_list where rand_id=:id";
		$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
		$params = array(':id' => $data_content['sent_owner']); // 挿入する値を配列に格納する
		$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
		if($res){
			$data_owner = $stmt->fetch();
			//echo"<pre>";
//			var_dump($data);			//ユーザー情報丸見えデバッグ
			//echo"</pre>";
		}
		$sql = "select count(*) from sent_list where sent_rand_id=:id";	//ポストが存在するか？
		$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
		$params = array(':id' => $req_id); // 挿入する値を配列に格納する
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
			$under_check = $data_owner['id'];
			$displayname = $data_owner["id"];
			if(strcmp($data_owner["name"],"") != 0){
				$displayname = $data_owner["name"];
			}
			echo "<meta property=\"og:title\" content=\"".$displayname."の投稿".$title_temp."\">";
		}
		
//		echo $displayname;	//確認用
		
		$new_title = "<title>${displayname}の投稿 - ".sitename." ".corp."</title>";
		echo $new_title;	//このechoは消さない
		
    ?>
    <meta property="og:image" content="<?php echo $data['icon_url']; ?>">
    <meta property="twitter:image" content="<?php echo $data['icon_url']; ?>">
    <script src="/library/ajaxAddPost.js"></script>
    <script src="/library/ajaxAddReply.js"></script>
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
    if(isset($_SESSION['id'])){
    	if(strcmp($under_check,$data_me['id']) == 0){
    		$left_myaccount = 1;
    	}
    }
    include $webroot."/left.php";
    ?>
    </div>
	<div class="main_c">
		<?php include $webroot.'/topbar.php'; ?>
		<div class="reply_content">
			<div class="top_form_mother">
				<div class="top_form">
					<!-- ここに本文を入力 -->
					<input type="hidden" id="post_id" value="<?php echo $data_content['sent_rand_id']; ?>">
					<div class="sent_reply" id="post_content">
						<div class="loader">Loading...</div>
						<?php /*
							$sent_content = $data_content['sent_rand_id'];
							$clickable = 0;
							$output_del_button = 1;
							include $webroot."/sent_content.php";
							unset($output_del_button);*/
						?>
					</div>
				</div>
				<script>
					ajax_add_post();
				</script>
				<?php if(isset($_SESSION['id'])){ ?>
					<div class="reply_p">
						<p>返信する</p>
					</div>
					<div class="reply_reply">
						<div class="top_form_mother top_form_margin top_postor_fix" style="display: flex;">
							<div class="post_img post_img_margin">
								<a href="u?<?php echo $data_me['id']; ?>">
									<img class="post_img" src="<?php echo $data_me['icon_url']; ?>" width="100px" loading="lazy">
								</a>
							</div>
							<div class="postor">
								<?php
									$small = 1;
								//	$no_post_jump = 1;
									$reply_id = $data_content['sent_rand_id'];
									include $webroot."/postor.php";
									unset($small);
									unset($reply_id);
								//	unset($no_post_jump);
								?>
							</div>
						</div>
					</div>
				<?php } ?>
				<div class="reply_p">
					<p>返信を表示</p>
				</div>
				<input type="hidden" value="0" id="count_reply">
				<div class="sent_content" id="content_reply">
					<?php /*
						//全部のポストを表示
						$no_reply_view = 1;
						$data_post_list = $pdo -> query("select * from sent_list where reply=\"".$data_content['sent_rand_id']."\" order by sent_time desc limit 100");
						foreach($data_post_list as $data_as){
							//var_dump($data_as);
							$sent_content = $data_as['sent_rand_id'];
							$clickable = 1;//1で投稿をクリックで投稿ページに飛ぶ
							include $webroot."/sent_content.php";
						}*/
					?>
				</div>
				<div class="loader">loading...</div>
				<input type="button" onclick="ajax_add_reply();" class="viewmore_ajax" value="読み込まれない場合はクリック">
				<script>
					ajax_add_reply();
				</script>
			</div>
		</div>
	</div>
	<div class="right_menu">
        <?php
		    $webroot = $_SERVER['DOCUMENT_ROOT'];
		    include $webroot."/right.php";
	    ?>
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