<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
	<?php
			$no_title = 1;
		    define("title","ログインしてください");
		    $webroot = $_SERVER['DOCUMENT_ROOT'];
		    include $webroot."/meta.php";
	?>
    <?php
	    if(isset($_SESSION['id'])){
		    $req_id = $_SESSION['id'];
			$sql = "select * from users_list where id=:id";
			$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
			$params = array(':id' => $req_id); // 挿入する値を配列に格納する
			$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
			if($res){
				$data = $stmt->fetch();
	//			echo"<pre>";
	//			var_dump($data);			//ユーザー情報丸見えデバッグ
	//			echo"</pre>";
			}
			$displayname = $data["id"];
			if(strcmp($data["name"],"") != 0){
				$displayname = $data["name"];
			}
			$new_title = "<title>${displayname}で投稿 - ".sitename." ".corp."</title>";
			echo $new_title;	//このechoは消さない
		}
		echo "<title>".title." - ".sitename." ".corp."</title>";
    ?>
</head>

<body>
    <header>
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/header.php";
    $profile_edit = 1;
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
			<div class="top_form top_form_center">
				<?php
					if(isset($_SESSION['id'])){
//						var_dump($data);
						//ログインしているしSELECTも済んでいる
						if(isset($_GET['inyou'])){
							$profile_temp_text = "でリポスト";
						}else{
							$profile_temp_text = "で投稿";
						}
						$webroot = $_SERVER['DOCUMENT_ROOT'];
						include $webroot."/profile_template.php";
						if(isset($_GET['inyou'])){
							//引用元を特定
							$datac = $pdo -> query("select count(*) from sent_list where sent_rand_id=\"".$_GET['inyou']."\"");
							$data_c = $datac -> fetchAll(PDO::FETCH_BOTH);
							if($data_c[0][0] == 1){
								$clickable = 0;
								$no_post_hannou = 1;
								$sent_content = $_GET['inyou'];
								include $webroot."/sent_content.php";
								unset($no_post_hannou);
							}
						}
						include $webroot."/postor.php";
						$profile_temp_text = "";
					}else{
						//ログインを促す
						$webroot = $_SERVER['DOCUMENT_ROOT'];
						include $webroot."/login_prompt.php";
					}
				?>
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
