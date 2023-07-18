<form class="table_mother" action="/edited" method="post" name="edit_form">
	<table class="table_center">
		<tr class="">
			<p class="form_caution">*の付いている項目は必須入力です。</p>
		</tr>
		<tr class="">
			<th align="right"><label class="form_label" for="mail">メールアドレス*</label></th>
			<td align="left"><input class='form_input' type='email' name='mail' required id="f_email" disabled></td>
		</tr>
		<tr class="">
			<th align="right"><label class="form_label" for="mail_open">メールアドレスを公開する</label></th>
			<td align="left"><input class='form_input' type='checkbox' name='mail_open' value='mail_open' id="f_mail_open" disabled></td>
		</tr>
		<tr class="">
			<th align="right"><label class="form_label" for="name">ユーザー名</label></th>
			<td align="left"><input class='form_input' type='text' name='name' id="f_name" disabled></td>
		</tr>
		<tr class="">
			<th align="right"><label class="form_label" for="icon_url">アイコンURL</label></th>
			<td align="left"><input class='form_input' placeholder='httpsで始まる画像のURLを入力' type='url' name='icon_url' id='f_icon_url' disabled></td>
		</tr>
		<tr class="">
			<th align="right"><label class="form_label" for="icon_url">カバー画像URL</label></th>
			<td align="left"><input class='form_input' placeholder='httpsで始まる画像のURLを入力' type='url' name='bgimg_url' id="f_cover_url" disabled></td>
		</tr>
		<tr class="">
			<th align="right"><label class="form_label" for="twitter_id">Twitter ID</label></th>
			<td align="left"><input class='form_input' type='text' name='twitter_id' pattern='^([a-zA-Z0-9_]{5,})$' placeholder='@を除いたIDのみ入力' id="f_twitter_id" disabled></td>
		</tr>
		<tr class="">
			<th align="right"><label class="form_label" for="area">在住地域</label></th>
			<td align="left">
				<select name="area" class="form_select" id="f_area" disabled>
					<?php
						for ($i = 0; $i < count($area); $i++) {
							echo "<option value='".$i."'>".$area[$i][0]."</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr style="white-space: nowrap;" class="">
			<th align="right"><label class="form_label" for="birth_y">*生年月日</label></th>
			<td align="left">
				<input style='width: 6em;' class='form_input form_6em' type='tel' name='birth_y' maxlength='4' required id="f_birth_y" disabled>年
				<input style='width: 3em;' class='form_input' type='tel' name='birth_m' maxlength='2' required id="f_birth_m" disabled>月
				<input style='width: 3em;' class='form_input' type='tel' name='birth_d' maxlength='2' required id="f_birth_d" disabled>日
			</td>
		</tr>
		<tr class="">
			<th align="right"><label class="form_label" for="mail_open">生年月日を公開する</label></th>
			<td align="left"><input class='form_input' type='checkbox' name='birth_open' value='birth_open' id="f_birth_open" disabled></td>
		</tr>
	</table>
			<div class="submit_div">
				<label class="form_label form_center" for="message">詳細メッセージ（MD記法が使えます）</label><br></th>
				<textarea class='form_input form_textarea form_center' name='message' placeholder='自己紹介を書いてみよう！' id="f_message" disabled></textarea></td>
			</div>
			<div class="submit_div">
				<input style='background-color:var(--accent_color1);' class='form_submit' type='submit' value='プロフィールを更新' disabled id="edit_submit">
			</div>
		</tr>
</form>
<script>
	us = ajax_userinfo_s();
	$(document).ajaxStop(function(){
		let d = document;
		if( (typeof data_s == 'undefined') || (data_s != 'no') ){
			data_s = JSON.parse(us.responseText);
			//console.log(data_s);
			d.getElementById('f_email').value = data_s['mail'];
			d.getElementById('f_name').value = data_s['name'];
			d.getElementById('f_icon_url').value = data_s['icon_url'];
			d.getElementById('f_cover_url').value = data_s['bgimg_url'];
			d.getElementById('f_twitter_id').value = data_s['twitter_id'];
			d.getElementById('f_area').value = data_s['area'];
			d.getElementById('f_birth_y').value = data_s['birth_y'];
			d.getElementById('f_birth_m').value = data_s['birth_m'];
			d.getElementById('f_birth_d').value = data_s['birth_d'];
			d.getElementById('f_message').innerHTML = data_s['message'];
			d.getElementsByClassName('h_dispname').innerHTML = data_s['name'];
			
			d.getElementById('f_message').style.height = "auto";
			d.getElementById('f_message').style.height = `${d.getElementById('f_message').scrollHeight}px`;
			
			if(data_s['mail_open'] == 1){
				d.getElementById('f_mail_open').checked = true;
			}
			if(data_s['birth_open'] == 1){
				d.getElementById('f_birth_open').checked = true;
			}
			d.getElementById('f_email').disabled = false;
			d.getElementById('f_name').disabled = false;
			d.getElementById('f_icon_url').disabled = false;
			d.getElementById('f_cover_url').disabled = false;
			d.getElementById('f_twitter_id').disabled = false;
			d.getElementById('f_area').disabled = false;
			d.getElementById('f_birth_y').disabled = false;
			d.getElementById('f_birth_m').disabled = false;
			d.getElementById('f_birth_d').disabled = false;
			d.getElementById('f_message').disabled = false;
			
			d.getElementById('f_mail_open').disabled = false;
			d.getElementById('f_birth_open').disabled = false;
			d.getElementById('edit_submit').disabled = false;
			
			us = '';
			data_s = 'no';
		}
	});
</script>