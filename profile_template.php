<?php
	if(!isset($data)){
		$data = $data_me;
	}
	if( filter_var( $data['icon_url'], FILTER_VALIDATE_URL ) ){
		//これはURL
		$ico = $data['icon_url'];
	}else{
		//これはURLではない
		$ico = '';
	}
?>
<?php
	if( (isset($ajaxed_userinfo)) && ($ajaxed_userinfo == 1) ){
		$ajax_userinfo = 1;
		//OK!
	}else{
		$ajax_userinfo = 0;
	}
?>
<input type="hidden" <?php if($ajax_userinfo == 1)echo 'id="forajax_username"'; ?> value="<?php echo $data['rand_id'] ?>">
<div class="img_and_h1" style="background-image: url(<?php echo $data["bgimg_url"]; ?>); background-size: cover; background-position: center;" <?php if($ajax_userinfo == 1)echo 'id="ui_bgimg"'; ?> >
	<th style="display:flex;">
		<div class="img_and_h1_img">
			<?php
				if(isset($yoko_follow_button)){
				//	echo "<a class=\"divsmall_link\" href=\"/u&quest;".$data['id']."\">";
				}
			?>
			<?php 
				echo "<a rel=\"noopener\" ";
				if(isset($icon_click)){
					if($ico != ''){
						echo "href=\"".$ico."\"";
					}else{
						echo "href='javascript:void(0);'";
					}
				}else{
					echo "href=\"/u?".$data['id']."\"";
				}
				if($ajax_userinfo == 1){
					echo " data-lightbox='userico' ";
				}
				echo "><img class=\"profile_topimg\"";
				if($ajax_userinfo == 0){
					echo "src=\"".$data["icon_url"]."\"";
				}else{
					echo "src='/img/account_default.png'";
				}
				echo "onerror=\"this.src='/img/noimage.jpg'\" ";
				if($ajax_userinfo == 1)echo 'id="ui_icon"';
				echo " loading='lazy'></a>";
				
				if(!isset($displayname))$displayname = '';
			?>
		</div>
		<div class="img_and_h1_text" <?php if(!isset($yoko_follow_button)){echo "style=\"background-color: var(--profile_bgcolor);\"";} ?> >
			<h1 class="index_title user_id_temp" <?php if($ajax_userinfo == 1)echo 'id="forajax_user_dispname"'; ?>><?php if($ajax_userinfo == 0)echo '<span class="h_dispname">'.$displayname.'</span>';if($ajax_userinfo == 1)echo 'Loading...'; ?><?php if(isset($profile_temp_text)){echo $profile_temp_text;} ?></h1>
			<p class="normal_text profile_under_text prof_temp" <?php if($ajax_userinfo == 1)echo 'id="forajax_user_id"'; ?>><?php if($ajax_userinfo == 0)echo '@'.$data["id"]; ?></p>
		</div>
	</th>
	<td>
<?php 
	if(isset($follow_icon) or isset($setting_icon)){
		echo "</div>";
	}
?>
<?php if(!isset($yoko_follow_button) and !isset($profile_edit)){ ?>
	<div class="normal_text birth_text">
		<p <?php if($ajax_userinfo == 1)echo 'id="ui_birth"'; ?>>生年月日:<?php if($data['birth_open'] == 1){echo $data['birth_y']."年".$data['birth_m']."月".$data['birth_d']."日";}else{echo "非公開";} ?>
	</div>
<?php } ?>
<div class="follow_ff">
	<div class="follow_form_div" <?php if(!isset($yoko_follow_button))echo "style=\"display: flex;\""; ?>>
		<?php
			if(((isset($follow_icon) and isset($_SESSION['id']) or (isset($yoko_follow_button) and isset($_SESSION['id'])) and !isset($right_button)))){
				if(strcmp($_COOKIE['id'],$data['id']) == 0){
					//同じアカウント
					echo "<form class=\"follow_form\" action=\"\" method=\"POST\" name=\"edit_button_post\"><input type=\"hidden\" name=\"edit\" value=\"true\"><a style=\"background-color:var(--font_color1);color:var(--background2);\" class=\"follow_button ";
					if(isset($yoko_follow_button)){
						echo "follow_button_yoko";
					}
					echo "\" href=\"/edit\">プロフィールを編集</a></form>";
				}else{
					//フォローボタンを表示する
					//その前にフォロー、フォローバックのどっちにするか決める
					$me_and_aite = $data_me['rand_id'].$data['rand_id'];
					$aite_and_me = $data['rand_id'].$data_me['rand_id'];//相手が自分をフォローしてるかわかる
					$sql = "select * from follow_list where me_and_aite=:me_and_aite";
					$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
					$params = array(':me_and_aite' => $me_and_aite); // 挿入する値を配列に格納する
					$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
					if($res){
						$data_follow = $stmt->fetch();
//						echo"<pre>";
//						var_dump($data);			//ユーザー情報丸見えデバッグ
//						echo"</pre>";
					}
					$sql = "select * from follow_list where me_and_aite=:aite_and_me";
					$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
					$params = array(':aite_and_me' => $aite_and_me); // 挿入する値を配列に格納する
					$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
					if($res){
						$data_followback = $stmt->fetch();
//						echo"<pre>";
//						var_dump($data);			//ユーザー情報丸見えデバッグ
//						echo"</pre>";
					}
					//$_POSTから受け取ったフォロー、アンフォローを実行する
					if(isset($_POST['follow'])){
						if(isset($data_follow['me_and_aite'])){
							//何もしない
						}else{
							if(strcmp($_POST['follow'],"true") == 0 and isset($_SESSION['id'])){
								$sql = "INSERT INTO follow_list (me_and_aite,rand_id_me,rand_id_aite,unix_time) VALUES (:me_and_aite,:rand_id_me,:rand_id_aite,:unix_time)";
								$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
								$params = array(':me_and_aite' => $me_and_aite, ':rand_id_me' => $data_me['rand_id'], ':rand_id_aite' => $_POST['follow_rand_id'], ':unix_time' => time()); // 挿入する値を配列に格納する
								$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
//								echo $_POST['follow_rand_id'];
							}
						}
						unset($_POST['follow']);
					}
					if(isset($_POST['unfollow'])){
						if(isset($data_follow['me_and_aite'])){
							if(strcmp($_POST['unfollow'],"true") == 0 and isset($_SESSION['id'])){
								$sql = "DELETE FROM follow_list where me_and_aite=:me_and_aite and rand_id_aite=:rand_id_aite";
								$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
								$params = array(':me_and_aite' => $me_and_aite, ':rand_id_aite' => $_POST['unfollow_rand_id']); // 挿入する値を配列に格納する
								$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
//								echo $_POST['unfollow_rand_id'];
							}
						}
						unset($_POST['unfollow']);
					}
					
					//最新の情報に更新
					$me_and_aite = $data_me['rand_id'].$data['rand_id'];
					$aite_and_me = $data['rand_id'].$data_me['rand_id'];//相手が自分をフォローしてるかわかる
					$sql = "select * from follow_list where me_and_aite=:me_and_aite";
					$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
					$params = array(':me_and_aite' => $me_and_aite); // 挿入する値を配列に格納する
					$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
					if($res){
						$data_follow = $stmt->fetch();
					}
					$sql = "select * from follow_list where me_and_aite=:aite_and_me";
					$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
					$params = array(':aite_and_me' => $aite_and_me); // 挿入する値を配列に格納する
					$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
					if($res){
						$data_followback = $stmt->fetch();
					}
					
					//ここからフォローボタンを表示
					if(!isset($right_button)){
						if(isset($data_follow['me_and_aite'])){
							//フォロー中
							echo "<form class=\"follow_form\" action=\"\" method=\"POST\" name=\"unfollow_button_post\"><input type=\"hidden\" name=\"unfollow\" value=\"true\"><input type=\"hidden\" name=\"unfollow_rand_id\" value=".$data['rand_id']."><input style=\"background-color:var(--font_color1);color:var(--background2);\" class=\"follow_button ";
							if(isset($yoko_follow_button)){
								echo "follow_button_yoko";
							}
							echo "\" type=\"submit\" value=\"";
							if(isset($data_followback['me_and_aite'])){
								echo "相互";//相互フォロー中になる
							}
							echo "フォロー中\"></form>";
						}elseif(isset($_SESSION['id'])){
							//フォローしてない
							//echo "フォローボタン";
							echo "<form class=\"follow_form\" action=\"\" method=\"POST\" name=\"follow_button_post\"><input type=\"hidden\" name=\"follow\" value=\"true\"><input type=\"hidden\" name=\"follow_rand_id\" value=".$data['rand_id']."><input style=\"background-color:var(--font_color1);color:var(--background2);\" class=\"follow_button ";
							if(isset($yoko_follow_button)){
								echo "follow_button_yoko";
							}
							echo "\" type=\"submit\" value=\"フォロー";
							if(isset($data_followback['me_and_aite'])){
								echo "バック";//フォローバックになる
							}
							echo "\"></form>";
							//echo $_POST['follow'];	//hidden要素の検証
						}
					}
				}
			}
			if(!isset($_SESSION['id']) and !isset($right_button)){
				//ログインしていないのでログインを促す
				echo "<form class=\"follow_form\" action=\"\" method=\"POST\" name=\"edit_button_post\"><input type=\"hidden\" name=\"login\" value=\"true\"><a style=\"background-color:var(--accent_color1);\" class=\"follow_button\" href=\"/login\">ログインしてフォロー</a></form>";
			}
			if(isset($follow_icon) and !isset($right_button)){
				include $webroot."/follow_icon.php";
			}
		?>
	</div>
	<?php 
		if(isset($follow_icon) or isset($setting_icon)){
		}else{
			echo "</div>";
		}
	?>
	</td>
</div>