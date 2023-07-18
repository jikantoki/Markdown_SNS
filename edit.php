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
			$new_title = "<title>${displayname}を編集 - ".sitename." ".corp."</title>";
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
		<div class="topbar_top">
			<?php if(!isset($no_page_title_view)){ ?>
				<!-- 上メニューの表示 -->
				<?php include $webroot.'/topbar.php'; ?>
			<?php } ?>
		</div>
		<div class="top_form_mother">
			<div class="top_form top_form_center">
				<?php
					if(isset($_SESSION['id'])){
//						var_dump($data);
						//ログインしているしSELECTも済んでいる
						$profile_temp_text = "の編集";
						$webroot = $_SERVER['DOCUMENT_ROOT'];
						include $webroot."/profile_template.php";
						include $webroot."/editor.php";
						$profile_temp_text = "";
						echo "<p class=\"normal_text\">アカウントのIDとパスワードの変更、または退会はこちら<p>";
					}else{
						//ログインを促す
						$webroot = $_SERVER['DOCUMENT_ROOT'];
						include $webroot."/login_prompt.php";
					}
				?>
			</div>
			<script>
				document.getElementById('mobile_title_a').innerHTML = 'アカウント編集';
				document.getElementById('titlecall').innerHTML = 'アカウント編集';
			</script>
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
