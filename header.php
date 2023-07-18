<?php /* ヘッダーやで */ ?>
<?php
	if(isset($_COOKIE['id'])){
		//echo "クッキーある";
		$now_url = $_SERVER['REQUEST_URI'];//現在のルートからのURLを取得できる
		if(strcmp($now_url,"/logout") == 0){//前のソース 
    		setcookie('id',"",time() - 30);
    		setcookie('pass',"",time() - 30,$httponly=true);
    		setcookie('mail',"",time() - 30,$httponly=true);
    		unset($_SESSION['id']);
		}else{
			$req_id = $_COOKIE['id'];
			$req_mail = $_COOKIE['mail'];
			$req_pass = $_COOKIE['pass'];
//			echo $req_id;
//			echo $req_mail;
			$sql = "select * from users_list where id=:id";
			$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
			$params = array(':id' => $req_id); // 挿入する値を配列に格納する
			$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
			if($res){
				$data_cookie = $stmt->fetch();
				//echo"<pre>";
//				var_dump($data_cookie);			//ユーザー情報丸見えデバッグ
				//echo"</pre>";
			}
		}
		if(isset($data_cookie['id'])){//クッキーに保存されてるメアドとIDある？
			//ありました
			if(password_verify($_COOKIE['pass'],$data_cookie['pass']) and (strcmp($_COOKIE['mail'],$data_cookie['mail'] == 0))){//パスワードは一致してる？
				//一致してる！
				$err = 0;
				$now_url = $_SERVER['REQUEST_URI'];//現在のルートからのURLを取得できる
				if(strcmp($now_url,"/logout") != 0){//ログアウトページでは働かせない
					$_SESSION['id'] = $_COOKIE['id'];//セッションを代入する
//					echo $_SESSION['id']."を代入";
				}
			}else{
//				echo $_COOKIE['mail'].$data_cookie['mail'];
				//アカウント情報にエラー
				unset($_SESSION['id']);
				setcookie('id',"",time() - 30);
				setcookie('pass',"",time() - 30,$httponly=true);
				setcookie('mail',"",time() - 30,$httponly=true);
			}
		}
	}else{
		//echo "クッキーない";
	}
	if(isset($_SESSION['id'])){
		if(isset($data_cookie['id'])){
			$req_id = $data_cookie['id'];
		}else{
			$req_id = $data['id'];
		}
		$sql = "select * from users_list where id=:id";
		$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
		$params = array(':id' => $req_id); // 挿入する値を配列に格納する
		$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
		if($res){
			$data_me = $stmt->fetch();
			//echo"<pre>";
//			var_dump($data);			//ユーザー情報丸見えデバッグ
			//echo"</pre>";
		}
        if(isset($data_me['mail'])){
            $displayname_me = $data_me["id"];
            if(strcmp($data_me["name"],"") != 0){
                $displayname_me = $data_me["name"];
            }
          //ちゃんとログイン出来てて偉い！
        }else{/*
            //別端末によってセッションIDが変えられてる
            unset($_SESSION['id']);//セッション抹消
            setcookie('id',"",time() - 30);//クッキーも消しちゃえ
            setcookie('pass',"",time() - 30,['httponly'=>true,]);
            setcookie('mail',"",time() - 30,['httponly'=>true,]);
        */}
	}
?>
<?php if(!isset($js_load)){ ?>
	<div class="agent_info" id="agent_info"></div>
	<script>
		if(zoom_check() == 1){
			var agent_text = '<p class="browser_err">このブラウザはCSSのzoomプロパティをサポートしていません。<br>表示が乱れるため、Chromeでのアクセスをおすすめします。</p>';
			document.getElementById("agent_info").innerHTML = agent_text;
		}
	</script>
	<div class="fixed">
		<div class="header_mother">
			
			<?php if(isset($data_me)){ ?>
				<script>
					//カスタムCSS
					//headの$data_me定義後すぐに記述
					ajax_cssload();
				</script>
			<?php } ?>
			<div class="hamburger-menu">
				<input type="checkbox" id="menu-btn-check">
				<label for="menu-btn-check" class="menu-btn"><span></span></label>
		        <!--ここからメニュー-->
		        <div class="menu-content">
		            <ul>
		                <li>
		                	<div class="header_profile">
		                    	<?php include $webroot.'/account_show.php'; ?>
		                	</div>
		                </li>
		                <li>
		                    <a class="ham" href="/">トップ</a>
		                </li>
		                <?php if(isset($_SESSION['id'])){ ?>
		                	<li>
		                	    <a class="ham" href="/u?<?php echo $data_me['id']; ?>">マイアカウント</a>
		                	</li>
		                <?php } ?>
		                <li>
		                    <a class="ham" href="/rule">利用規約</a>
		                </li>
		                <li>
		                    <a class="ham" href="/credit">クレジット</a>
		                </li>
		                <li>
		                    <a class="ham" href="/buglist">バグリスト</a>
		                </li>
		                <li>
		                    <a class="ham ham_cache" onclick="cacheclear();">キャッシュを削除</a>
		                </li>
		                <li>
		                    <a class="ham" href="/option">オプション</a>
		                </li>
		                <!--
		                <li>
		                    <a class="ham ham_post" href="/post">ポスト</a>
		                </li>
		                -->
		                
						<p class="colorpallet_p">テーマカラー</p>
						<div class="color_pallet2">
							<?php
								$color_shurui = glob($webroot.'/color/*');
								foreach($color_shurui as $color_i){
									$color_i2 = basename($color_i,'.css');
									echo "<div class='pallet_round_mother'><div class='pallet_round pallet_".$color_i2."' onclick='colorchange(\"".$color_i2."\");'>";
										//$color_i にcssのフルパス
										//$color_i2にcssのファイル名拡張子なし
										//var_dump($color_i);
										//var_dump($color_i2);
										$thiscolor = file_get_contents($color_i);
										//var_dump($thiscolor);
										$color_str1 = mb_strstr($thiscolor,'--hover_color2:');
										$color_str2 = mb_substr($color_str1, 0 , mb_strpos($color_str1, ';'));
										$color_str3 = mb_strstr($color_str2,'#');
										$color_str21 = mb_strstr($thiscolor,'--background2:');
										$color_str22 = mb_substr($color_str21, 0 , mb_strpos($color_str21, ';'));
										$color_str23 = mb_strstr($color_str22,'#');
										//echo $color_i2.$color_str3.$color_str23;
										echo "<div class=\"pallet_ue pallet_inner\" style=\"background-color:".$color_str23."\"></div><div class=\"pallet_shita pallet_inner\" style=\"background-color:".$color_str3."\"></div>";
									echo "</div></div>";
								}
							?>
							<div class="pallet_round_mother">
								<div class="pallet_round pallet_default" onclick="colorchange('default');">
									<?php
										$thiscolor = file_get_contents($webroot.'/defaultcolor.css');
										$color_str1 = mb_strstr($thiscolor,'--hover_color2:');
										$color_str2 = mb_substr($color_str1, 0 , mb_strpos($color_str1, ';'));
										$color_str3 = mb_strstr($color_str2,'#');
										$color_str21 = mb_strstr($thiscolor,'--background2:');
										$color_str22 = mb_substr($color_str21, 0 , mb_strpos($color_str21, ';'));
										$color_str23 = mb_strstr($color_str22,'#');
										echo "<div class=\"pallet_ue pallet_inner\" style=\"background-color:".$color_str23."\"></div><div class=\"pallet_shita pallet_inner\" style=\"background-color:".$color_str3."\"></div>";
									?>
								</div>
							</div>
						</div>
						
		                <!-- バグが多いため広告を停止
		                <li>
		                	<p class="ham_ads">広告</p>
		                	<iframe id="header_ads" title="ads_t" src="/adsense.php" onload="func1()"></iframe>
							<script>
							    const sub = document.getElementById("sub");
							    function func1() {
							      sub.style.width = sub.contentWindow.document.body.scrollWidth + "px";
							      sub.style.height = sub.contentWindow.document.body.scrollHeight + "px";
							    }
							</script>
		                </li>
		                -->
		                <?php
		                	//include $webroot."/server_info.php";
		                ?>
		                <div class="serverinfo_head_ajax" id="serverinfo_head_ajax"></div>
		            </ul>
		        </div>
		        <!--ここまでメニュー-->
			</div>
			<div class="mobile_title mobile">
				<?php if(!isset($topbar_str))$topbar_str = title; ?>
				<p class="mobile_title_a" id="mobile_title_a"><?php echo $topbar_str; ?></p>
			</div>
			<?php /*
			<div class="migiue_mobile mobile">
				<?php
					$color_shurui = glob($webroot.'/color/*');
				?>
				<!--<form action="" name="pallet" method="POST">-->
				<div class="colorpallet">
					<input type="button" class="colorchange" name="color" value="Mint" onclick="colorchange('default');"></a>
					<?php
						foreach($color_shurui as $color_list){
							$color_list2 = basename($color_list,'.css');
							?>
								<input type="button" class="colorchange" name="color" value="<?php echo $color_list2; ?>" onclick="colorchange('<?php echo $color_list2; ?>');"></a>
							<?php
						}
					?>
				<!--</form>-->
				<!-- 現在用途未定 -->
				</div>
			</div> */ ?>
		</div>
	</div>
	<?php include $webroot."/context.php"; ?>
	<div class="header_after">
	</div>
	<div class="toast" id="toast">
		<div class="toast_text" id="toast_text"></div>
	</div>
<?php } ?>
<?php
	if(!isset($js_load)){
		include $webroot."/post_left.php";
	}
?>
<?php
	if(!isset($js_load)){
		?>
			<script>
				var cacheLoaded = 0;
				document.getElementById('post_left_child').addEventListener("click", function(e){
					e.stopPropagation();
					let b = document.getElementById("contextmenu");
					let b_val = getComputedStyle(b).display;
					if(b_val != 'none'){
						b.style.display = 'none';
					}
				});
				function cacheLoad(){//あとで自動実行されます
					if(document.getElementById('pjax') != null){
						let lh = location.href;
						let ls = localStorage.getItem(lh);
						if(ls != null){
							//データあった
							cacheLoaded = 1;
							document.getElementById('pjax').innerHTML = ls;
							let sc = localStorage.getItem('scroll' + lh);
							if(sc != null){
								scrollTo(0 , sc);
							}
						}
					}else{
						console.log('pjax not defined!');
					}
				}
			</script>
		<?php
	}
?>