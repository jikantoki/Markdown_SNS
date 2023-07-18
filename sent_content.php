<?php
	if(isset($enum_post)){//内部処理カウンタ、このページを読み込んだ回数-1が中身
		$enum_post++;
	}else{
		$enum_post = 0;
	}
	if(!isset($enum_reply))$enum_reply = 0;
	if(!isset($no_reply_view))$no_reply_view = 10;
	$rt = 0;
	/* $sent_contentで表示するポストのIDを指定 */
	//ポストの内容を取り出す
	$sql = "select * from sent_list where sent_rand_id=:sid";
	$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
	$params = array(':sid' => $sent_content); // 挿入する値を配列に格納する
	$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
	if($res){
		$data_content = $stmt->fetch();
		//echo"<pre>";
		//var_dump($data_content);			//ユーザー情報丸見えデバッグ
		//echo"</pre>";
	}
	if( (mb_strtoupper(not_space($data_content['sent_message'])) == 'RT') && ($data_content['inyou'] != '') ){
		$sql = "select * from sent_list where sent_rand_id=:sid";
		$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
		$params = array(':sid' => $data_content['inyou']); // 挿入する値を配列に格納する
		$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
		if($res){
			$data_content2 = $stmt->fetch();
			if($data_content2 != false){
				$rt_owner = $data_content['sent_owner'];
				$data_content = $data_content2;
				$rt = 1;
				
				//ポストの投稿者を特定
				$sql = "select * from users_list where rand_id=:rid";
				$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
				$params = array(':rid' => $rt_owner); // 挿入する値を配列に格納する
				$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
				if($res){
					$rt_data_owner = $stmt->fetch();
					if($rt_data_owner['name'] == ''){
						$rt_data_owner['name'] = $rt_data_owner['id'];
					}
				}
			}
		}
	}
	if(isset($adsense_post)){
		$data_content['sent_genre'] = 0;
		$data_content['sent_message'] = "これは自動生成の広告です。";
		$data_content['sent_edited'] = 0;
		$data_content['sent_sankou_link1'] = '';
		$data_content['sent_img_url1'] = '';
		$data_content['place'] = '';
		$data_content['inyou'] = '';
		$data_content['reply'] = '';
		$rt = 0;
	}
	//リプだったら元ポストを表示する
	if( ($data_content['reply'] != '') && (($no_reply_view > 5)) && (!isset($no_mother_post)) && (!isset($searching)) ){
		$qq = $pdo -> query("select count(*) from sent_list where sent_rand_id='".$data_content['reply']."'");
		$qqq = $qq -> fetchAll(PDO::FETCH_BOTH);
		//var_dump($qqq);
		if($qqq[0][0] != '0'){
			$enum_post++;
			//unset($adsense_post);
			if(isset($enum_reply)){
				$enum_reply += 1;
			}else{
				$enum_reply = 0;
			}
			$sent_content_backup[$enum_reply] = $sent_content;
			$sent_content = $data_content['reply'];
			$no_reply_view += 1;
			if(isset($clickable)){
				if($clickable == 1){
					$clickable_backup[$enum_reply] = 1;
				}else{
					$clickable_backup[$enum_reply] = 0;
				}
			}else{
				$clickable_backup[$enum_reply] = 0;
			}
			$clickable = 1;//1で投稿をクリックで投稿ページに飛ぶ
			//var_dump($sent_content_backup);
			//echo "<br>";
			//var_dump($enum_reply);
			//echo "<br>";
			include $webroot."/sent_content.php";
			$sent_content = $sent_content_backup[$enum_reply];
			if($clickable_backup[$enum_reply] == 0){
				$clickable = 0;
			}else{
				$clickable = 1;
			}
			//echo "After:";
			//var_dump($sent_content_backup);
			//echo "<br>";
			$no_reply_view = 0;
			$enum_reply -= 1;
			
			/* $sent_contentで表示するポストのIDを指定 */
			//ポストの内容を取り出す
			$sql = "select * from sent_list where sent_rand_id=:sid";
			$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
			$params = array(':sid' => $sent_content); // 挿入する値を配列に格納する
			$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
			if($res){
				$data_content = $stmt->fetch();
				//echo"<pre>";
				//var_dump($data_content);			//ユーザー情報丸見えデバッグ
				//echo"</pre>";
			}
		}
	}
	$s_url = "/i?".$sent_content;//ポストのURL
	
	//ポストの投稿者を特定
	$sql = "select * from users_list where rand_id=:rid";
	$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
	$params = array(':rid' => $data_content['sent_owner']); // 挿入する値を配列に格納する
	$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
	if($res){
		$data_owner = $stmt->fetch();
		//echo"<pre>";
		//var_dump($data_owner);			//ユーザー情報丸見えデバッグ
		//echo"</pre>";
	}
	if(isset($adsense_post)){
		$data_owner['name'] = "広告";
		$data_owner['id'] = "adsense";
		$data_owner['icon_url'] = "/img/ads.jpg";
	}
	
	//リプの数を特定
	$reply_kazu = $pdo -> query("select count(*) from sent_list where reply=\"".$data_content['sent_rand_id']."\"");
	$replykazu = $reply_kazu -> fetchAll(PDO::FETCH_BOTH);
	
	//ポストのサブオ－ナーを特定
	if(isset($data_subowner))unset($data_subowner);
	if(strcmp($data_content['sent_subowner'],'') != 0){
		$sql = "select count(*) from users_list where id=:srid";//存在確認
		$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
		$params = array(':srid' => $data_content['sent_subowner']); // 挿入する値を配列に格納する
		$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
		if($res){
			$data_owner_cnt = $stmt->fetch();
			//echo"<pre>";
			//var_dump($data_owner_cnt);			//ユーザー情報丸見えデバッグ
			//echo"</pre>";
		}
		if(($data_owner_cnt[0] == 1)&&(strcmp($data_content['sent_subowner'],$data_owner['id']) != 0)){//サブオーナーが存在する！
			$sql = "select * from users_list where id=:srid";
			$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
			$params = array(':srid' => $data_content['sent_subowner']); // 挿入する値を配列に格納する
			$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
			if($res){
				$data_subowner = $stmt->fetch();
				//echo"<pre>";
				//var_dump($data_subowner);			//ユーザー情報丸見えデバッグ
				//echo"</pre>";
			}
		}
	}
	if(isset($adsense_post)){
		unset($data_subowner);
	}
	
	//ポストの情報 => $data_content
	//投稿者 => $data_owner
	//サブオーナー => $data_subowner
	//ポストのURL => $s_url
	$r = makeRandStr(48);
?>
<div class="<?php if(!isset($inyou_now))echo 'content_table_mother'; ?>" id="<?php if(!isset($inyou_now)){ echo 'mother_'.$data_content['sent_rand_id'].$r;if(isset($adsense_post))echo '_ads'; } ?>"><!-- リプを表示ボタンとか作る用 -->
	<?php
		//リツイートだよ！みたいな情報を表示
		if($rt == 1){
			?>
				<div class="rt_now">
					<svg><use xlink:href="/img/repost.svg#svg"></use></svg><a class="rt_now_a" href="/u?<?php echo $rt_data_owner['id']; ?>"><?php echo $rt_data_owner['name']; ?></a>によるリポスト
				</div>
			<?php
		}
	?>
	<div class="content_table" loading="lazy" <?php if(isset($no_inyou))echo "style=\"border-bottom:none;\""; ?>>
		<?php if($clickable == 1){ ?>
			<a <?php if(!isset($adsense_post)){ ?> onclick="cacheSave();" class="content_link" href="/i?<?php echo $data_content['sent_rand_id']; ?>"<?php } ?>></a>
		<?php } ?>
		<div class="post_icon">
			<div class="owner_icon">
				<!-- 投稿者のアイコンを表示 -->
				<a onclick="cacheSave();" <?php if(!isset($adsense_post)){ ?>href="u?<?php echo $data_owner['id']; ?>"<?php } ?>>
					<img class="post_img post_img_cover <?php if(isset($no_inyou))echo "post_img_mini"; ?>" src="<?php echo $data_owner['icon_url']; ?>" width="100px" loading="lazy" onerror="this.src='/img/noimage.jpg'">
				</a>
			</div>
			<?php if(isset($data_subowner)){ ?>
				<div class="subowner_icon">
					<!-- サブオーナーのアイコンを表示 -->
					<a onclick="cacheSave();" href="u?<?php echo $data_subowner['id']; ?>">
						<img class="post_img post_img_cover <?php if(isset($no_inyou))echo "post_img_mini"; ?>" src="<?php echo $data_subowner['icon_url']; ?>" width="100px" loading="lazy" onerror="this.src='/img/noimage.jpg'">
					</a>
				</div>
			<?php } ?>
		</div>
		<div class="post_main">
			<?php
				if(isset($searching)){
					if($data_content['reply'] != ''){
						$sql = $pdo -> query("select * from sent_list where sent_rand_id='".$data_content['reply']."'");
						$sql2 = $sql -> fetchAll(PDO::FETCH_BOTH);
						if(isset($sql2[0])){
							$sql = $pdo -> query("select * from users_list where rand_id='".$sql2[0]['sent_owner']."'");
							$sql2 = $sql -> fetchAll(PDO::FETCH_BOTH);
							?>
								<div class="with_reply_search">
									<p class="with_reply_search_p">
										@<?php echo $sql2[0]['id']; ?> への返信
									</p>
								</div>
							<?php
						}
					}
				}
			?>
			<div class="post_name">
				<div class="post_nameid">
					<div class="post_dispname">
						<!-- 投稿者の名前を表示 -->
						<a onclick="cacheSave();" <?php if(!isset($adsense_post)){ ?>href=<?php echo "\"u?".$data_owner['id']."\""; ?><?php } ?>>
							<?php
								echo $data_owner['name'];
								if(isset($data_subowner)){
									echo "</a>と<a onclick='cacheSave();' href=\"/u?".$data_subowner['id']."\">".$data_subowner['name'];
								}
							?>
						</a>
					</div>
					<div class="post_id">
						<!-- 投稿者のIDを表示 -->
						<a onclick="cacheSave();" <?php if(!isset($adsense_post)){ ?>href="u?<?php echo $data_owner['id']; ?>"<?php } ?>>
							@<?php
								echo $data_owner['id'];
								if(isset($data_subowner)){
									echo "</a>/<a onclick='cacheSave();' href=\"/u?".$data_subowner['id']."\">@".$data_subowner['id'];
								}
							?>
						</a>
					</div>
				</div>
				<?php if($data_content['sent_genre'] != 0){ ?>
					<div class="post_genre">
						<!-- 投稿ジャンルを表示 -->
						<?php
							//genreテーブルの数を超えたら0と見なす必要がある
							if(isset($genre_count)){
								if($genre[$data_content['sent_genre']] > $genre_count)$genre[$data_content['sent_genre']] = 0;
							}
						?>
						<a onclick="cacheSave();" href="/search?genre<?php echo $data_content['sent_genre']; ?>=on" style="background-color:<?php echo $genre[$data_content['sent_genre']][1] ?>">
							<?php
								echo $genre[$data_content['sent_genre']][0];
								//echo "<pre>";
								//var_dump($genre);
								//echo "</pre>";
							?>
						</a>
					</div>
				<?php } ?>
				<?php if((!isset($no_view_time))&&(!isset($adsense_post))){ ?>
					<div class="post_time">
						<!-- 投稿時間を表示 -->
						<a id="<?php echo $data_content['sent_rand_id'].$r; ?>_time_parsed" onclick="document.getElementById('<?php echo $data_content['sent_rand_id'].$r; ?>_time_parsed').style.display='none';document.getElementById('<?php echo $data_content['sent_rand_id'].$r; ?>_time').style.display='block';">
							<?php
								$time_sa = time() - $data_content['sent_time'];
								if($time_sa < 60){
									echo $time_sa."秒前";
								}elseif($time_sa < 3600){
									echo floor($time_sa / 60)."分前";
								}elseif($time_sa < (3600 * 24) ){
									$time_sa2 = $time_sa;
									$c = 0;
									while(true){
										$time_sa2 -= 3600;
										$c += 1;
										if($time_sa2 < 3600)break;
									}
									echo $c."時間と".floor($time_sa2 / 60)."分前";
								}elseif($time_sa < (3600 * 24 * 7) ){
									$cont_d = (int)date('d',$data_content['sent_time']);
									$unix_d = (int)date('d',time());
									switch($unix_d - $cont_d){
										case 7:
											$w = "七日前、";
											break;
										case 6:
											$w = "六日前、";
											break;
										case 5:
											$w = "五日前、";
											break;
										case 4:
											$w = "四日前、";
											break;
										case 3:
											$w = "三日前、";
											break;
										case 2:
											$w = "一昨日、";
											break;
										default:
											$w = "昨日、";
											break;
									}
									$content_time = date("H:i.s",$data_content['sent_time']);
									echo $w.$content_time;
								}else{
									$cont_y = (int)date('Y',$data_content['sent_time']);
									$unix_y = (int)date('Y',time());
									if( ($unix_y - $cont_y) == 0){
										$w = "今年、";
									}elseif( ($unix_y - $cont_y) == 1){
										$w = "去年、";
									}else{
										$w = $cont_y."年、";
									}
									$content_time = date("m/d H:i.s",$data_content['sent_time']);
									echo $w.$content_time;
								}
								//echo "　　".date("Y/m/d H:i.s",$data_content['sent_time']);
							?>
						</a>
						<a id="<?php echo $data_content['sent_rand_id'].$r; ?>_time" style="display:none;" onclick="document.getElementById('<?php echo $data_content['sent_rand_id'].$r; ?>_time').style.display='none';document.getElementById('<?php echo $data_content['sent_rand_id'].$r; ?>_time_parsed').style.display='block';">
							<?php echo date("Y/m/d H:i.s",$data_content['sent_time']); ?>
						</a>
					</div>
				<?php } ?>
			</div>
			<div <?php if(isset($post_maxheight))echo "id='post_content_more".$enum_post.$r."'"; ?> class="post_content <?php if(isset($post_maxheight))echo 'post_maxheight'; ?>">
				<!-- 投稿した文章を表示 -->
				<?php
					//echo $data_content['sent_message']; //MDを適用しない原文はこう表示する
				?>
				<?php
					$s_message = $data_content["sent_message"];
					$s_message = hash_replace($s_message);
					$parser = new \cebe\markdown\GithubMarkdown();
					$parser -> html5 = true;
					$parser->enableNewlines = true;
					$parsed_message = $parser -> parse($s_message);
					echo hashtag(cssing(emoji($parsed_message)));
				?>
			</div>
			<div class="view_more_button_div" id="viewmore_button_div<?php echo $enum_post.$r; ?>">
				<button class="view_more_button_a" type="button" id="viewmore_button<?php echo $enum_post.$r; ?>" onclick="post_viewmore_click<?php echo $enum_post.$r; ?>();">もっと見る</button>
			</div>
			<?php if(strcmp($data_content['place'],'') != 0){ ?>
				<!-- ポストの場所を表示 -->
				<div class="post_place">
					<a onclick="cacheSave();" href="/place?<?php echo $data_content['place']; ?>">
						場所:<?php echo $data_content['place']; ?>
					</a>
				</div>
			<?php } ?>
			<?php
				if(isset($post_maxheight)){
					?>
						<script>
							let client_w<?php echo $enum_post.$r; ?><?php if(isset($no_inyou))echo "a"; ?><?php if(isset($adsense_post))echo "b"; ?> = document.getElementById('post_content_more<?php echo $enum_post.$r; ?>').clientWidth;
							let client_h<?php echo $enum_post.$r; ?><?php if(isset($no_inyou))echo "a"; ?><?php if(isset($adsense_post))echo "b"; ?> = document.getElementById('post_content_more<?php echo $enum_post.$r; ?>').clientHeight;
							/* console.log(client_w<?php echo $enum_post; ?> + 'px ' + client_h<?php echo $enum_post; ?> + 'px'); */
							/* もしclient_hが300を超えていたらもっと見るボタン */
							/* ここの数値は/css/post.cssの.post_maxheightと同期してね */
							if(client_h<?php echo $enum_post.$r; ?><?php if(isset($no_inyou))echo "a"; ?><?php if(isset($adsense_post))echo "b"; ?> >= 350 /* CSSと同期してね */){
								//もっと見るボタンが必要！！！
								target = document.getElementById("viewmore_button_div<?php echo $enum_post.$r; ?>");
								target.style.display='block';
								
							}
							function post_viewmore_click<?php echo $enum_post.$r; ?>(){
								console.log("clicked!");
								target = document.getElementById("post_content_more<?php echo $enum_post.$r; ?>");
								target.style.maxHeight='initial';
								target = document.getElementById("viewmore_button_div<?php echo $enum_post.$r; ?>");
								target.style.display='none';
							}
						</script>
					<?php
				}
			?>
			<?php
				$inyou_que = $pdo -> query("select count(*) from sent_list where sent_rand_id='".$data_content['inyou']."'");
				$inyouque = $inyou_que -> fetchAll(PDO::FETCH_BOTH);
			?>
			<?php if((strcmp($data_content['inyou'],'') != 0)&&(!(isset($no_inyou)))&&($inyouque[0][0] == 1)){ ?>
				<!-- 引用を表示 -->
				<div class="post_inyou">
					<?php
						//引用関係
						$data_content_original = $data_content;
						$data_owner_original = $data_owner;
						if(isset($data_subowner))$data_subowner_original = $data_subowner;
						$clickable_original = $clickable;
						$clickable = 1;
						$no_inyou = 1;
						$inyou_now = 1;
						$no_reply_view = 0;
						$sent_content_original = $sent_content;
						$sent_content = $data_content['inyou'];
						if(isset($output_del_button)){
							$output_del_button_original = 1;
							unset($output_del_button);
						}
						if(isset($searching)){
							$searching_original = $searching;
						}else{
							$searching_original = 0;
						}
						$searching = 1;
						$no_view_time = 1;
						$r_o = $r;
						
						include $webroot.'/sent_content.php';
						
						$r = $r_o;
						$sent_content = $sent_content_original;
						$data_content = $data_content_original;
						$data_owner = $data_owner_original;
						if(isset($data_subowner_original))$data_subowner = $data_subowner_original;
						$clickable = $clickable_original;
						if($searching_original != 0){
							$searching = $searching_original;
						}else{
							unset($searching);
						}
						unset($no_inyou);
						if(isset($output_del_button_original)){
							$output_del_button = 1;
						}
						unset($no_view_time);
					?>
				</div>
			<?php }else{  } ?>
			<?php
				//引用された数を数える
				$inyou_kazu = $pdo -> query("select count(*) from sent_list where inyou=\"".$data_content['sent_rand_id']."\"");
				$inyoukazu = $inyou_kazu -> fetchAll(PDO::FETCH_BOTH);
				//リプ数を数える
				$reply_kazu2 = $pdo -> query("select count(*) from sent_list where reply=\"".$data_content['sent_rand_id']."\"");
				$replykazu2 = $reply_kazu2 -> fetchAll(PDO::FETCH_BOTH);
			?>
			<?php
				$img_cnt = 0;
				if(strcmp($data_content['sent_img_url1'],'') != 0){
					$img_cnt++;
					if(strcmp($data_content['sent_img_url2'],'') != 0){
						$img_cnt++;
						if(strcmp($data_content['sent_img_url3'],'') != 0){
							$img_cnt++;
							if(strcmp($data_content['sent_img_url4'],'') != 0){
								$img_cnt++;
							}
						}
					}
				}
			?>
			<?php if(isset($adsense_post)){ ?>
				<div class="post_azds">
					<!-- 広告 -->
					<?php
						include $webroot.'/adsense.php';
					?>
				</div>
			<?php } ?>
			<?php if($img_cnt != 0){ ?>
				<div class="post_opt_img">
					<div class="post_img_12 <?php if($img_cnt >= 3)echo 'img_half'; ?>">
						<div class="post_img_1">
							<!-- 画像1枚目 -->
							<a href="<?php echo $data_content['sent_img_url1']; ?>" data-lightbox="post_img_<?php echo $data_content['sent_rand_id'].$enum_post; ?>" target="_blank" id="myimage1a<?php echo $enum_post.$r; ?>">
								<img class="post_opt_img post_opt_img1" src="<?php echo h($data_content['sent_img_url1']); ?>" loading="lazy" onerror="this.src='/img/noimage.jpg';myimage1a<?php echo $enum_post; ?>.setAttribute('href', '/img/noimage.jpg');">
							</a>
						</div>
						<?php if($img_cnt >= 2){ ?>
							<div class="post_img_2">
								<!-- 画像2枚目 -->
								<a href="<?php echo $data_content['sent_img_url2']; ?>" data-lightbox="post_img_<?php echo $data_content['sent_rand_id'].$enum_post; ?>" target="_blank" id="myimage2a<?php echo $enum_post.$r; ?>">
									<img class="post_opt_img post_opt_img2" src="<?php echo h($data_content['sent_img_url2']); ?>" loading="lazy" onerror="this.src='/img/noimage.jpg';myimage2a<?php echo $enum_post; ?>.setAttribute('href', '/img/noimage.jpg');">
								</a>
							</div>
						<?php } ?>
					</div>
					<?php if($img_cnt >= 3){ ?>
						<div class="post_img_34 img_half">
							<div class="post_img_3">
								<!-- 画像3枚目 -->
								<a href="<?php echo $data_content['sent_img_url3']; ?>" data-lightbox="post_img_<?php echo $data_content['sent_rand_id'].$enum_post; ?>" target="_blank" id="myimage3a<?php echo $enum_post.$r; ?>">
									<img class="post_opt_img post_opt_img3" src="<?php echo h($data_content['sent_img_url3']); ?>" loading="lazy" onerror="this.src='/img/noimage.jpg';myimage3a<?php echo $enum_post; ?>.setAttribute('href', '/img/noimage.jpg');">
								</a>
							</div>
							<?php if($img_cnt == 4){ ?>
								<div class="post_img_4">
									<!-- 画像4枚目 -->
									<a href="<?php echo $data_content['sent_img_url4']; ?>" data-lightbox="post_img_<?php echo $data_content['sent_rand_id'].$enum_post; ?>" target="_blank" id="myimage4a<?php echo $enum_post.$r; ?>">
										<img class="post_opt_img post_opt_img4" src="<?php echo h($data_content['sent_img_url4']); ?>" loading="lazy" onerror="this.src='/img/noimage.jpg';myimage4a<?php echo $enum_post; ?>.setAttribute('href', '/img/noimage.jpg');">
									</a>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			<?php } ?>
			<?php
				/* かつてURLを表示していた場所 */
				preg_match_all('(https?://[-_.!~*\'()a-zA-Z0-9;/?:@&=+$,%#]+)', $data_content['sent_message'], $data_urls);
				//$data_urlsにURLの配列を格納
				if(isset($data_urls[0][0])){
					$data_content['sent_sankou_link1'] = $data_urls[0][0];
					if(isset($data_urls[0][1])){
						$data_content['sent_sankou_link2'] = $data_urls[0][1];
					}
				}
			?>
			<?php if( (!isset($adsense_post)) && (!isset($_POST['no_view_url'][0])) ){ ?>
				<div class="url_view_mother" id="url_view_<?php echo $data_content['sent_rand_id'].$r; ?>">
					<?php
						$url_ajax_phpinclude = 1;
						include $webroot."/url_ajax.php";
					?>
				</div>
				<script>
					ajaxViewURL(<?php echo "'".$data_content['sent_rand_id']."','".$data_content['sent_sankou_link1']."','".$data_content['sent_sankou_link2']."','".$r."'"; ?>);
				</script>
			<?php } ?>
			<?php if((!isset($no_post_hannou))&&(!isset($adsense_post))){ ?>
				<?php
					//いいねを既に押しているか
					if(isset($data_me)){
						$q = 'select * from good_list where good_content="'.$data_content['sent_rand_id'].'" and good_pusher_rand_id="'.$data_me['rand_id'].'" and good_or_bad="good"';
						$q2 = $pdo -> query($q);
						$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
						if(count($q3) == 0){
							//押してない
							$addClassActive = '';
						}else{
							//押している
							$addClassActive = 'good_active';
						}
					}else{
						$addClassActive = '';
					}
					$q = 'select count(*) from good_list where good_content="'.$data_content['sent_rand_id'].'" and good_or_bad="good"';
					$q2 = $pdo -> query($q);
					$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
					$good_kazu = $q3[0][0];
				?>
				<?php
					//SEYANAを既に押しているか
					if(isset($data_me)){
						$q = 'select * from good_list where good_content="'.$data_content['sent_rand_id'].'" and good_pusher_rand_id="'.$data_me['rand_id'].'" and good_or_bad="seyana"';
						$q2 = $pdo -> query($q);
						$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
						if(count($q3) == 0){
							//押してない
							$SaddClassActive = '';
						}else{
							//押している
							$SaddClassActive = 'seyana_active';
						}
					}else{
						$SaddClassActive = '';
					}
					$q = 'select count(*) from good_list where good_content="'.$data_content['sent_rand_id'].'" and good_or_bad="seyana"';
					$q2 = $pdo -> query($q);
					$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
					$seyana_kazu = $q3[0][0];
				?>
				<?php if(isset($_POST['with_good_data'])){ ?>
					<!-- 詳細データ（誰がいいねしたか？）とかを表示 -->
					<div class="post_hannou_shousai">
						<div class="shousai_repost">
							<a onclick="cacheSave();" href="/repost?<?php echo $data_content['sent_rand_id']; ?>">
								<span class="shousai_f"><?php echo $inyoukazu[0][0]; ?></span><span class="shousai_t">件のリポスト</span>
							</a>
						</div>
						<div class="shousai_repost">
							<a onclick="cacheSave();" href="/repost?<?php echo $data_content['sent_rand_id']; ?>">
								<span class="shousai_f"><?php echo $inyoukazu[0][0]; ?></span><span class="shousai_t">件の引用</span>
							</a>
						</div>
						<div onclick="cacheSave();" class="shousai_good">
							<a href="/good?<?php echo $data_content['sent_rand_id']; ?>">
								<span class="shousai_f"><?php echo $good_kazu; ?></span><span class="shousai_t">件のええなぁ</span>
							</a>
						</div>
						<div class="shousai_seyana mobile_hidden_shousai">
							<span class="shousai_f"><?php echo $seyana_kazu; ?></span><span class="shousai_t">件のSEYANA</span>
						</div>
						<div class="shousai_bookmark mobile_hidden_shousai">
							<span class="shousai_f">0</span><span class="shousai_t">件のブックマーク</span>
						</div>
					</div>
				<?php } ?>
				<div class="post_hannou">
					<a class="post_hannou_li post_hannou_reply" <?php if(isset($data_me)){ ?>onclick="post_left('<?php echo $data_content['sent_rand_id']; ?>')"<?php } ?>>
						<div>
							<!-- リプの数を表示 -->
							<svg>
								<use xlink:href="/img/reply.svg#svg"></use>
							</svg>
							<p>
								<?php echo $replykazu2[0][0]; ?>
							</p>
						</div>
					</a>
					<a class="post_hannou_li post_hannou_repost" <?php if(isset($data_me)){ ?>onclick="post_left('','<?php echo $data_content['sent_rand_id']; ?>')"<?php } ?>>
						<div>
							<!-- リポストの数を表示 -->
							<svg>
								<use xlink:href="/img/repost.svg#svg"></use>
							</svg>
							<p>
								<?php echo $inyoukazu[0][0]; ?>
							</p>
						</div>
					</a>
					<a class="post_hannou_li post_hannou_good good_<?php echo $data_content['sent_rand_id']; ?> <?php echo $addClassActive; ?>" onclick="good('<?php echo $data_content['sent_rand_id']?>');">
						<div>
							<!-- いいねの数を表示 -->
							<svg class="good_svg_<?php echo $data_content['sent_rand_id']; ?>">
								<use xlink:href="/img/good<?php if($addClassActive != '')echo 'ed'; ?>.svg#svg"></use>
							</svg>
							<p class="good_kazu_<?php echo $data_content['sent_rand_id']; ?>">
								<?php echo $good_kazu; ?>
							</p>
						</div>
					</a>
					<?php if(!isset($no_view_time)){ ?>
						<a class="post_hannou_li post_hannou_seyana seyana_<?php echo $data_content['sent_rand_id']; ?> <?php echo $SaddClassActive; ?>" onclick="seyana('<?php echo $data_content['sent_rand_id']?>');"">
							<div>
								<!-- SEYANAの数を表示 -->
								SEYANA
								<!--<svg>
									<use xlink:href="/img/bad.svg#svg"></use>
								</svg>-->
								<p class="seyana_kazu_<?php echo $data_content['sent_rand_id']; ?>">
									<?php echo $seyana_kazu; ?>
								</p>
							</div>
						</a>
					<?php } ?>
					<?php
						//echo $parsed_message;
						$striped_message = strip_tags($parsed_message);
						//echo $striped_message;
						$cuted_message = strcut($striped_message,160);
						//echo $cuted_message;
					?>
					<a onclick="cacheSave();" class="post_hannou_li post_hannou_shere" href="http://twitter.com/intent/tweet?text=<?php echo $cuted_message; ?>%20<?php echo $data_owner['name'].'は'.sitename; ?>を使っています<?php echo $_SERVER['SERVER_NAME'].'/i?'.$data_content['sent_rand_id']; ?>&related=jikantoki&hashtags=<?php echo sitename; ?>" target="_blank">
						<div>
							<!-- シェアボタン -->
							<svg>
								<use xlink:href="/img/shere.svg#svg"></use>
							</svg>
						</div>
					</a>
					<?php if(isset($data_me)){ ?>
						<?php if(($data_content['sent_owner'] === $data_me['rand_id'])&&(isset($output_del_button))){ ?>
							<a class="post_hannou_li post_hannou_trash" href="/delete?<?php echo $data_content['sent_rand_id']; ?>">
								<div>
									<!-- 削除ボタン -->
									<svg>
										<use xlink:href="/img/trash.svg#svg"></use>
									</svg>
								</div>
							</a>
						<?php } ?>
					<?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php if( (!isset($adsense)) && (!isset($adsense_post)) && ($replykazu2[0][0] != 0) && (!isset($no_showmore)) && (!isset($inyou_now)) ){ ?>
		<div class="show_div" id="reply_<?php echo $data_content['sent_rand_id'].$r; ?>">
			<p class="show_div_p"onclick="showmore_reply('<?php echo $data_content['sent_rand_id']; ?>','<?php echo $r; ?>');">返信を表示</p>
		</div>
	<?php } ?>
</div>
<?php if(isset($data_subowner))unset($data_subowner); ?>
<?php
	//echo $enum_post;
	//echo $enum_count_nowpost;
	if( ((!isset($adsense_post)) && ($enum_post % 5 == 4) && (!isset($no_inyou)) ) || ((!isset($adsense_post)) && (isset($enum_count_nowpost)) && ($enum_count_nowpost % 6 == 5)) && ($enum_post % 5 == 4) && (!isset($no_inyou)) ){
		//ポスト15個表示に付き広告を1つ付ける
		$adsense_post = 1;
		$enum_post--;
		include $webroot.'/sent_content.php';
		unset($adsense_post);
	}
	unset($inyou_now);
?>