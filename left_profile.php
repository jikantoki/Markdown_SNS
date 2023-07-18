
	<!-- 新形式 -->
	<?php if(isset($data_me['mail'])){ ?>
		<?php
			if(!isset($data_me)){
				$data_me_null = 1;
				$data_me['id'] = 'ログイン';
				$data_me['icon_url'] = "/img/account_default.png";
				$displayname_me = 'ログイン';
			}
		?>
		
		<div class="sidebar_ul sidebar_hidden_nav">
			<div class="left_hidden_popup left_hidden_div" id="left_hidden" style="display: none;">
				<div class="left_color_pallet left_hidden_a">
					<p class="colorpallet_p">テーマカラー</p>
					<div class="color_pallet2">
						<!-- ここに色を並べる -->
						<!--
							想定図
							<div class="pallet_round colorname" onclick="javascript">丸くするクラスと色名を入れる
								<div class="pallet_ue">
									background=basecolor;
								</div>
								<div class="pallet_shita">
									background=accent_color;
								</div>
							</div>
							ここまでをテーマの数作る
						-->
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
				</div>
				<a class="left_myaccount_hidden left_hidden_a" href="/u?<?php echo $data_me['id']; ?>">
					<svg>
						<use xlink:href="/img/account.svg#svg"></use>
					</svg>
					<div class="left_setting_div">
						マイアカウント
					</div>
				</a>
				<a class="left_setting left_hidden_a" href="/option">
					<svg>
						<use xlink:href="/img/option.svg#svg"></use>
					</svg>
					<div class="left_setting_div">
						オプション
					</div>
				</a>
				<a class="left_setting left_hidden_a" href="/rule">
					<svg>
						<use xlink:href="/img/rule.svg#svg"></use>
					</svg>
					<div class="left_setting_div">
						利用規約
					</div>
				</a>
				<a class="left_credit left_hidden_a" href="/credit">
					<svg>
						<use xlink:href="/img/credit.svg#svg"></use>
					</svg>
					<div class="left_setting_div">
						クレジット
					</div>
				</a>
				<a class="left_buglist left_hidden_a" href="/buglist">
					<svg>
						<use xlink:href="/img/bug_list.svg#svg"></use>
					</svg>
					<div class="left_setting_div">
						バグリスト
					</div>
				</a>
				<a class="left_cache left_hidden_a" onclick="cacheclear();">
					<svg>
						<use xlink:href="/img/reload.svg#svg"></use>
					</svg>
					<div class="left_setting_div">
						キャッシュを削除
					</div>
				</a>
				<a class="left_logout left_hidden_a" href="/logout">
					<svg>
						<use xlink:href="/img/logout.svg#svg"></use>
					</svg>
					<div class="left_setting_div">
						ログアウト
					</div>
				</a>
			</div>
		</div>
		<nav class="sidebar_nav sidebar_nav_profile">
			<ul class="sidebar_ul">
				<li class="sidebar_li" id="left_option_menu">
					<div class="sidebar_a left_profile_a" href=<?php
						if(isset($data_me['pass'])){
							echo "\"/u?".$data_me['id']."\"";
						}else{
							echo "\"/login\"";
						}
					?>><!-- ここの＞は2つ -->
						<?php echo "<img class=\"top_profile_img left_profile_img\" src=\"".$data_me['icon_url']."\">"; ?>
						<div class="left_profile_mother">
							<div class="left_profile_mother2">
								<p class="left_profile_child1">
									<?php echo $displayname_me; ?>
								</p>
								<?php if(isset($data_me['mail'])){ ?>
									<p class="left_profile_child2">
										@<?php echo $data_me['id']; ?>
									</p>
								<?php } ?>
							</div>
						</div>
						<div class="left_profile_dot">
							<svg>
								<use xlink:href="/img/dot.svg#svg"></use>
							</svg>
						</div>
					</div>
				</li>
			</ul>
		</nav>
	<?php } ?>