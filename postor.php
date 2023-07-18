<script>
	var text2md_now<?php if(isset($post_left)){echo '_left';} ?> = false;
	var text2md_once<?php if(isset($post_left)){echo '_left';} ?> = 0;
</script>
<script src="/library/text2md.js"></script>
<form class="table_mother table_post" action="/posted" id="post_form<?php if(isset($post_left)){echo '_left';} ?>" method="post" name="edit_form">
	<table class="table_center table_center_post" style="width: auto;">
		<tr class="">
			<th align="right"><label class="form_label form_input_option" for="genre" style="border:none;">ジャンル</label></th>
			<td align="left">
				<select name="genre" class="form_select" id="form_genre<?php if(isset($post_left)){echo '_left';} ?>">
					<?php
						for ($i = 0; $i < count($genre); $i++) {
							echo "<option value=\"".$i." \">".$genre[$i][0]."</option>";
						}
					?>
				</select>
			</td>
		</tr>
	</table>
	<div class="submit_div submit_div_post">
		<?php if(!isset($post_left)){$post_left = 0;} ?>
		<?php /* echo $_SERVER['HTTP_REFERER']."<br>".$_SERVER['HTTP_HOST'].'/index'; */ ?>
		<label class="form_label form_center" for="message">本文（MD記法が使えます）</label><br>
		<div class="flextextarea">
			<?php
				echo "<textarea ";
				if(isset($small))echo "style=\"height-min:64px;\"";
				$str = '';
				if($post_left != 0){
					$str = '_left';
				}
				echo " oninput=\"document.getElementById('file_err_mes".$str."').innerHTML='';ajax_text2md";if($post_left != 0){echo '_left';} echo "();limitTextLength";if($post_left != 0){echo '_left';} echo "();\" id=\"post_textarea";if($post_left != 0){echo '_left';} echo "\" class=\"flextextarea_textarea form_input form_textarea form_center post_message\" name=\"message\" placeholder=\"全世界に発信だ！\nURLや画像の添付はオプションよりお願いします\" value=\"\" maxlength=".post_max." required>";
			?></textarea>
			<div class="nokori_len"><span id="remaining-characters<?php if($post_left != 0){echo '_left';} ?>"><?php echo post_max; ?></span>/<?php echo post_max; ?></div>
		</div>
		<div id="suggest<?php if($post_left != 0){echo '_left';} ?>" style="display: none;"></div>
		<div class="file_err_mes" id="file_err_mes<?php if($post_left != 0){echo '_left';} ?>">
		</div>
		<div class="uploader">
			<button type="button" id="file_button<?php if($post_left != 0){echo '_left';} ?>" class="post_file_button" onclick="file_input<?php if($post_left != 0){echo '_left';} ?>.click();"><svg><use xlink:href="/img/image.svg#svg"></use></svg></button>
			<input class="mp3-limit" id="music_input<?php if($post_left != 0){echo '_left';} ?>" type="file" accept=".mp3" onchange="music_filename_view<?php if($post_left != 0){echo '_left';} ?>(this);">
			<button type="button" id="music_button<?php if($post_left != 0){echo '_left';} ?>" class="post_file_button" onclick="music_input<?php if($post_left != 0){echo '_left';} ?>.click();"><svg><use xlink:href="/img/music.svg#svg"></use></svg></button>
			<div class="music_filename" id="music_filename<?php if($post_left != 0){echo '_left';} ?>"></div>
			<div class="upload_dd">
				<div class="upload_dd_child">
					<p class="upload_dd_p">ここをクリックか画像をドラッグしてアップロード</p>
				</div>
				<input class="img-limit file_img_dd" id="file_input<?php if($post_left != 0){echo '_left';} ?>" type="file" accept="image/gif,image/jpeg,image/png,image/bmp,.webp" onchange="img_view<?php if($post_left != 0){echo '_left';} ?>(this);" multiple>
			</div>
		</div>
		<div id="sent_post_res<?php if($post_left != 0){echo '_left';} ?>">
		</div>
		<div class="img_preview" id="img_preview<?php if($post_left != 0){echo '_left';} ?>">
			<!-- 画像プレビューエリア -->
		</div>
	</div>
	<?php if($post_left != 0){ ?>
		<div class="show_inyou_left" id="show_inyou_left">
			<?php /* ここに引用なら元ツイとか表示する */ ?>
		</div>
	<?php } ?>
	<div class="post_previewer" id="post_preview<?php if($post_left != 0){echo '_left';} ?>">
		<div class="form_label">プレビュー</div>
		<div class="form_previewarea" id="post_previewarea<?php if($post_left != 0){echo '_left';} ?>">
		</div>
	</div>
	<table class="table_center table_center_post" id="post_option<?php if($post_left != 0){echo '_left';} ?>">
		<tr class="">
			<th align="right"><label class="form_label" for="subowner">共同投稿者</label></th>
			<td align="left"><?php echo "<input class=\"form_input form_input_option\" type=\"text\" name=\"subowner\" placeholder=\"この投稿を共同管理するアカウントを指定します\" id=\"form_subowner";if($post_left != 0){echo '_left';} echo "\">"; ?></td>
		</tr>
		<tr class="">
			<th align="right"><label class="form_label" for="place">場所</label></th>
			<td align="left"><?php echo "<input class=\"form_input form_input_option\" type=\"text\" placeholder=\"思い出の場所を自慢しよう！\" name=\"place\" id=\"form_place";if($post_left != 0){echo '_left';} echo "\">"; ?></td>
		</tr>
		<tr class="" style="display: none;">
			<th align="right"><label class="form_label" for="sankou_link1">参考リンク</label></th>
			<td align="left"><?php echo "<input class=\"form_input form_input_option\" type=\"url\" name=\"sankou_link1\" id=\"form_link1";if($post_left != 0){echo '_left';} echo "\">"; ?></td>
		</tr>
		<tr class="" style="display: none;">
			<th align="right"><label class="form_label" for="sankou_link1">参考リンク2</label></th>
			<td align="left"><?php echo "<input class=\"form_input form_input_option\" type=\"url\" name=\"sankou_link2\" id=\"form_link2";if($post_left != 0){echo '_left';} echo "\">"; ?></td>
		</tr>
		<!--
		<tr class="">
			<th align="right"><label class="form_label" for="img_url1">添付画像URL1</label></th>
			<td align="left"><?php echo "<input class=\"form_input form_input_option\" type=\"url\" name=\"img_url1\" id=\"form_img1";if($post_left != 0){echo '_left';} echo "\">"; ?></td>
		</tr>
		<tr class="">
			<th align="right"><label class="form_label" for="img_url2">添付画像URL2</label></th>
			<td align="left"><?php echo "<input class=\"form_input form_input_option\" type=\"url\" name=\"img_url2\" id=\"form_img2";if($post_left != 0){echo '_left';} echo "\">"; ?></td>
		</tr>
		<tr class="">
			<th align="right"><label class="form_label" for="img_url3">添付画像URL3</label></th>
			<td align="left"><?php echo "<input class=\"form_input form_input_option\" type=\"url\" name=\"img_url3\" id=\"form_img3";if($post_left != 0){echo '_left';} echo "\">"; ?></td>
		</tr>
		<tr class="">
			<th align="right"><label class="form_label" for="img_url4">添付画像URL4</label></th>
			<td align="left"><?php echo "<input class=\"form_input form_input_option\" type=\"url\" name=\"img_url4\" id=\"form_img4";if($post_left != 0){echo '_left';} echo "\">"; ?></td>
		</tr>
		-->
		<tr class="">
			<th align="right"><label class="form_label" for="inyou">引用元の投稿</label></th>
			<td align="left"><input class="form_input form_input_option" type="text" name="inyou" id="form_inyou<?php if($post_left != 0){echo '_left';} ?>" placeholder="ここを触る必要は基本的にありません" value="<?php if(isset($_GET['inyou'])){ echo $_GET['inyou']; } ?>"></td>
		</tr>
		<tr class="">
			<th align="right"><label class="form_label" for="reply">返信先</label></th>
			<td align="left"><input class="form_input form_input_option" <?php if($post_left != 0){echo "oninput='ajax_view_reply()'";} ?> type="text" name="reply" id="form_reply<?php if($post_left != 0){echo '_left';} ?>" placeholder="ここを触る必要は基本的にありません" value="<?php if(isset($reply_id)){ echo $reply_id; } ?>"></td>
		</tr>
		<?php if(isset($no_post_jump)){ ?><input type="hidden" name="no_post_jump" value="1"><?php } ?>
	</table>
	<div class="submit_div submit_div_post" style="text-align: right;">
		<input style="background-color:var(--background1);" class="form_submit" type="button" value="オプション" onclick="post_option1<?php if($post_left != 0){echo '_left';} ?>()">
		<input style="background-color:var(--background1);" class="form_submit" type="button" value="プレビュー" onclick="post_preview1<?php if($post_left != 0){echo '_left';} ?>()">
		<input style="background-color:var(--hover_color2);" class="form_submit" id="id_post_submit<?php if($post_left != 0){echo '_left';} ?>" onclick="ajax_sent_post<?php if($post_left != 0){echo '_left';} ?>();" type="button" value="<?php if(isset($_GET['inyou'])){echo "リポスト";}else{echo "ポスト";} ?>" disabled>
		<!--<input style="background-color:var(--hover_color2);" class="form_submit" id="id_post<?php if($post_left != 0){echo '_left';} ?>" type="submit" value="<?php if(isset($_GET['inyou'])){echo "リポスト";}else{echo "ポスト";} ?>（旧）">-->
		<script>
			shortcut.add("Ctrl+Enter",function(){
				document.getElementById("id_post_submit<?php if($post_left != 0){echo '_left';} ?>").click();
			},{'target':'post_form<?php if($post_left != 0){echo "_left";} ?>'});
		</script>
	</div>
	<!--<script src="/library/Twemoji-Picker/js/twemoji-picker.js"></script>-->
	<script>
		var imgfileList<?php if($post_left != 0){echo "_left";} ?> = [];
		function img_view<?php if($post_left != 0){echo '_left';} ?>(elem, output = ''){
			var i2 = 0;
			let img_pre_div = document.getElementById('img_preview<?php if($post_left != 0){echo "_left";} ?>');
			let i = 0;
			let img_ov = 0;
			var fileimgs = null;
			Array.from(elem.files).map((file) => {
				if(i >= 4){
					//画像多スギィ！
					img_ov = 1;
					console.log("画像多すぎ");
				}
				if(img_ov == 0){
					if(file.size <= fileLimit){
						var fileReader = new FileReader();
						const blobUrl = window.URL.createObjectURL(file)
						output += `<div class='prev_img_mother' id='prev_img_m${i}<?php if($post_left != 0){echo "_left";} ?>'><img class='prev_img' id='prev_img${i}<?php if($post_left != 0){echo "_left";} ?>' onclick='rm(prev_img_m${i}<?php if($post_left != 0){echo "_left";} ?>);imgfileList<?php if($post_left != 0){echo "_left";} ?>[${i}] = null;' onerror='document.getElementById("prev_img_m${i}<?php if($post_left != 0){echo "_left";} ?>").remove();' src=${blobUrl}><div class="prev_img_font"><p>タップで削除</p></div></div>`
						document.getElementById('file_err_mes<?php if($post_left != 0){echo "_left";} ?>').innerHTML = '';
						fileReader.onload = (function (e){
							fileimgs = fileReader.result;
							imgfileList<?php if($post_left != 0){echo "_left";} ?>[i2] = fileimgs;
							console.log("fileimgs<?php if($post_left != 0){echo "_left";} ?>[" + i2 + "] is loaded");
							i2 += 1;
						});
						i += 1;
						var file2 = file;
						fileReader.readAsDataURL(file2);
					}else{
						document.getElementById('file_err_mes<?php if($post_left != 0){echo "_left";} ?>').innerHTML = '<p class="file_err_p">ファイル容量が<?php echo $img_limit2; ?>を超えています</p>';
					}
				}
			})
			img_pre_div.innerHTML = output
			if(img_ov == 1){
				document.getElementById('sent_post_res').innerHTML = '<div>{ "word" : "画像は4枚まで選択できます" , "status" : "err" }</div>';
			}
		}
		function music_filename_view<?php if($post_left != 0){echo '_left';} ?>(elem, output = ''){
			let music_pre_div = document.getElementById('music_filename<?php if($post_left != 0){echo "_left";} ?>');
			let file_prop = document.getElementById('music_input<?php if($post_left != 0){echo "_left";} ?>');
			let filename = '';
			let ov = 0;
			for(let i = 0; i< file_prop.files.length; i++){
				if(file_prop.files[0].size <= mp3Limit){
					filename = file_prop.files[0].name;
				}else{
					ov = 1;
					document.getElementById('file_err_mes<?php if($post_left != 0){echo "_left";} ?>').innerHTML = '<p class="file_err_p">ファイル容量が<?php echo $mp3_limit2; ?>を超えています</p>';
				}
			}
			if(ov === 0){
				document.getElementById('file_err_mes<?php if($post_left != 0){echo "_left";} ?>').innerHTML = '';
			}
			music_pre_div.innerHTML = '<div>' + filename + '</div>';
		}
		if(document.getElementById("post_textarea<?php if($post_left != 0){echo '_left'; } ?>") != null){
			document.getElementById("post_option<?php if($post_left != 0){echo '_left';} ?>").style.display = "none";
			function post_option1<?php if($post_left != 0){echo '_left';} ?>(){
				const post_option = document.getElementById("post_option<?php if($post_left != 0){echo '_left';} ?>");
				if(post_option.style.display == "block"){
					post_option.style.display = "none";
				}else{
					post_option.style.display = "block";
				}
			}
			document.getElementById("post_preview<?php if($post_left != 0){echo '_left';} ?>").style.display = "none";	//デフォルトでプレビューを非表示
			function post_preview1<?php if($post_left != 0){echo '_left';} ?>(){
				const post_option = document.getElementById("post_preview<?php if($post_left != 0){echo '_left';} ?>");
				if(post_option.style.display == "block"){
					post_option.style.display = "none";
				}else{
					post_option.style.display = "block";
				}
			}
			//サジェスト設定
			function startSuggest<?php if($post_left != 0){echo '_left';} ?>() {
			  new Suggest<?php if($post_left != 0){echo '_left';} ?>.LocalMulti(
			        "post_textarea<?php if($post_left != 0){echo '_left';} ?>",    // 入力のエレメントID
			        "suggest<?php if($post_left != 0){echo '_left';} ?>", // 補完候補を表示するエリアのID
			        emoji_list,      // 補完候補の検索対象となる配列
			        {dispMax: 10, interval: 300, prefix: false, highlight: true, dispAllLey: true, classMouseOver: 'select'}); // オプション
			}
			//jQuery('#post_textarea<?php if($post_left != 0){echo '_left';} ?>').twemojiPicker();
		}
		//document.getElementById("file_input<?php if($post_left != 0){echo '_left';} ?>").addEventListener("click", function(e){
		//	e.preventDefault();
		//},false);
		//$('#file_button<?php if($post_left != 0){echo "_left";} ?>').click(function(){
		//  $('#file_input<?php if($post_left != 0){echo "_left";} ?>').click();
		//  return false;
		//});
	</script>
</form>