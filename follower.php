<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    define("title","フォロワー");
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/meta.php";
    ?><!--
    
	<meta property="og:description" content="<?php echo despri_seo; ?>" >-->
	<?php
		
	?>
</head>

<body>
    <header>
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/header.php";
		//$_POSTから受け取ったフォロー、アンフォローを実行する
		if(isset($_POST['follow']) and isset($_SESSION['id'])){
			if(isset($data_follow['me_and_aite'])){
				//何もしない
			}else{
				if(strcmp($_POST['follow'],"true") == 0 and isset($_SESSION['id'])){
					$sql = "select count(*) from follow_list where me_and_aite=:me_and_aite";
					$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
					$params = array(':me_and_aite' => $data_me['rand_id'].$_POST['follow_rand_id']); // 挿入する値を配列に格納する
					$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
//					echo $_POST['follow_rand_id'];
					if($res){
						$data_cnt_f = $stmt->fetch();
//						var_dump($data_cnt_f);
					}
					if($data_cnt_f[0] == 0){
						$sql = "INSERT INTO follow_list (me_and_aite,rand_id_me,rand_id_aite,unix_time) VALUES (:me_and_aite,:rand_id_me,:rand_id_aite,:unix_time)";
						$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
						$params = array(':me_and_aite' => $data_me['rand_id'].$_POST['follow_rand_id'], ':rand_id_me' => $data_me['rand_id'], ':rand_id_aite' => $_POST['follow_rand_id'], ':unix_time' => time()); // 挿入する値を配列に格納する
						$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
//						echo $_POST['follow_rand_id'];
					}
				}
			}
			unset($_POST['follow']);
		}
		if(isset($_POST['unfollow']) and isset($_SESSION['id'])){
			$req_id = $_COOKIE['id'];
			$sql = "select * from users_list where id=:id";
			$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
			$params = array(':id' => $req_id); // 挿入する値を配列に格納する
			$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
			if(strcmp($_POST['unfollow'],"true") == 0 and isset($_SESSION['id'])){
				$me_and_aite = $data_me['rand_id'].$_POST['unfollow_rand_id'];
				$sql = "DELETE FROM follow_list where me_and_aite=:me_and_aite and rand_id_aite=:rand_id_aite";
				$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
				$params = array(':me_and_aite' => $me_and_aite, ':rand_id_aite' => $_POST['unfollow_rand_id']); // 挿入する値を配列に格納する
				$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
//				echo $_POST['unfollow_rand_id'];
			}
			unset($_POST['unfollow']);
		}
		
		$now_url = $_SERVER['REQUEST_URI'];//現在のルートからのURLを取得できる
		$req_id = mb_substr($now_url,10);//URLからユーザーIDを特定
		//ランダムIDの取得
		$sql = "select * from users_list where id=:id";	//ユーザーが存在するか？
		$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
		$params = array(':id' => $req_id); // 挿入する値を配列に格納する
		$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
		if($res){
			$data_reqid = $stmt->fetch();
//			echo"<pre>";
//			var_dump($data);			//ユーザー情報丸見えデバッグ
//			echo"</pre>";
		}
		if(isset($data_reqid['id'])){
			$displayname_req = $data_reqid['id'];
			if(strcmp($data_reqid['name'],"") != 0){
				$displayname_req = $data_reqid['name'];
			}
			$req_rand_id = $data_reqid['rand_id'];
		}else{
			//ページのURLから間違えてるんで404を出す
			$title_defined = 1;
			http_response_code( 404 ) ;
			include $webroot."/error/404.php";//404を表示
			exit(1);
		}
		//ユーザー数のカウント
		$sql = "select count(*) from follow_list where rand_id_aite=:id";	//ユーザーが存在するか？
		$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
		$params = array(':id' => $req_rand_id); // 挿入する値を配列に格納する
		$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
		if($res){
			$data_sonzai = $stmt->fetch();
//			echo"<pre>";
//			var_dump($data);			//ユーザー情報丸見えデバッグ
//			echo"</pre>";
		}
		//情報を取得
		$data_f_list = $pdo -> query("select * from follow_list where rand_id_aite=\"".$req_rand_id."\" order by follow_list.unix_time DESC");	//ユーザーが存在するか？
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
				<div class="follow_me_profile">
					<div class="follow_me_icon" style="zoom:80%;margin-left:8px;margin-right:16px;">
						<a href="/u&quest;<?php echo $data_reqid['id']; ?>"><img class="profile_topimg" src="<?php echo $data_reqid['icon_url']; ?>" loading="lazy"></a>
					</div>
					<div class="follow_me_yoko">
						<h1 class="index_title"><a class="profile_no_under_a" href="/u&quest;<?php echo $data_reqid['id']; ?>"><?php echo $displayname_req ?></a>のフォロワー</h1>
						<p class="desp1 desp1_mobile"><?php if($data_sonzai[0] == 0){ echo "まだ誰もフォローしていません";}else{ echo $data_sonzai[0]."人にフォローされています";} ?></p>
					</div>
				</div>
				<div class="index_main1">
				</div>
				<div class="profile_left">
					<table class="userlist_table">
					<?php
//						echo $req_id;
//						echo "<pre>";
//						echo "</pre>";
						foreach($data_f_list as $row){
							$sql = "select * from users_list where rand_id=:rand_id";	//ユーザーが存在するか？
							$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
							$params = array(':rand_id' => $row['rand_id_me']); // 挿入する値を配列に格納する
							//echo $row['rand_id_me'];
							//echo $sql;
							$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
							if($res){
								$data = $stmt->fetch();
//								echo"<pre>";
//								var_dump($data);			//ユーザー情報丸見えデバッグ
//								echo"</pre>";
							}
//							var_dump($data);
							if(!isset($data['id'])){
								continue;
							}
							$displayname = strcut($data['id'],36);
							if(strcmp($data['name'],"") != 0){
								$displayname = strcut($data['name'],36);
							}
							//echo "<div class=\"small\">";
							$yoko_follow_button = 1;
							$webroot = $_SERVER['DOCUMENT_ROOT'];
							?>
							<tr style="position:relative;" data-href="/u&quest;<?php echo $data['id']; ?>">
							<?php
//							echo "<pre>";
//							var_dump($row);
//							echo "あ";
//							var_dump($data_f_list);
//							echo "</pre>";
							include $webroot."/profile_template.php";
							//echo "</div>";
//							echo "</tr>";
						}
					?>
					</table>
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
    $no_post_button = 1;
    include $webroot."/footer.php";
    ?>
    </footer>
</body>

</html>
