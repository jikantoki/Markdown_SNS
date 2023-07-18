// ajaxコンテンツ追加処理
function ajax_sent_post() {
	if(jssent_now == false){
		jssent_now = true;
		// 追加コンテンツ
		var add_content = "";
		let post_val = document.getElementById('post_textarea').value;
		let post_genre = document.getElementById('form_genre').value;
		let post_subowner = document.getElementById('form_subowner').value;
		let post_place = document.getElementById('form_place').value;
		let post_link1 = document.getElementById('form_link1').value;
		let post_link2 = document.getElementById('form_link2').value;
		let post_inyou = document.getElementById('form_inyou').value;
		let post_reply = document.getElementById('form_reply').value;
		document.getElementById('id_post_submit').disabled = true;
		document.getElementById('id_post_submit').value = '送信中…';
		let post_img_new = imgfileList;
		
		
		// ajax処理
		$.ajax({
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			url: "/sent_posting.php",
			type: 'POST',
			datatype: "json",
			timeout: 10000,
			data:{
				'val' : [String(post_val)] ,
				'genre' : [String(post_genre)] ,
				'subowner' : [String(post_subowner)] ,
				'place' : [String(post_place)] ,
				'link1' : [String(post_link1)] ,
				'link2' : [String(post_link2)] ,
				'inyou' : [String(post_inyou)] ,
				'reply' : [String(post_reply)] ,
				'imgs' : [imgfileList] ,
			}
		}).then(function(data){
			add_content += "<div>"+data+"</div>";
			// コンテンツ追加
			document.getElementById("sent_post_res").innerHTML = '';
			let objData = JSON.parse(data);
			if(objData.status == 'ok'){
				document.getElementById("post_textarea").value = '';
				document.getElementById('remaining-characters').textContent = maxLength - document.getElementById('post_textarea').value.length;
				document.getElementById('img_preview').innerHTML = '';
				ajaxServerInfo();
				imgfileList = [];
			}else{
				document.getElementById('id_post_submit').disabled = false;
			}
			toast(objData.word);
			if(typeof objData.reply == 'undefined'){
				if(typeof ajax_add_content_once != 'undefined'){
					ajax_add_content_once(objData.id);
				}
			}
			jssent_now = false;
		}).fail(function(e){
			console.log(e);
			console.log("yee_error");
			document.getElementById('id_post_submit').disabled = false;
			jssent_now = false;
			toast('エラー:サーバーがビジーです');
		}).always(function(f){
			document.getElementById('id_post_submit').value = 'ポスト';
		})
	}else{
		console.log("busy!sent");
		document.getElementById("sent_post_res").innerHTML = "<div>ネットワークエラー</div>";
		document.getElementById('id_post_submit').disabled = false;
		toast('ネットワークエラー');
		jssent_now = false;
	}
}

// ajaxコンテンツ追加処理_left
function ajax_sent_post_left() {
	if(jssent_now_left == false){
		jssent_now_left = true;
		// 追加コンテンツ
		var add_content = "";
		let post_val = document.getElementById('post_textarea_left').value;
		let post_genre = document.getElementById('form_genre_left').value;
		let post_subowner = document.getElementById('form_subowner_left').value;
		let post_place = document.getElementById('form_place_left').value;
		let post_link1 = document.getElementById('form_link1_left').value;
		let post_link2 = document.getElementById('form_link2_left').value;
		let post_inyou = document.getElementById('form_inyou_left').value;
		let post_reply = document.getElementById('form_reply_left').value;
		document.getElementById('id_post_submit_left_top').disabled = true;
		document.getElementById('id_post_submit_left').disabled = true;
		document.getElementById('id_post_submit_left_top').value = '送信中…';
		document.getElementById('id_post_submit_left').value = '送信中…';
		let post_img_new = imgfileList_left;
		
		
		// ajax処理
		$.ajax({
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			url: "/sent_posting.php",
			type: 'POST',
			datatype: "json",
			timeout: 10000,
			data:{
				'val' : [String(post_val)] ,
				'genre' : [String(post_genre)] ,
				'subowner' : [String(post_subowner)] ,
				'place' : [String(post_place)] ,
				'link1' : [String(post_link1)] ,
				'link2' : [String(post_link2)] ,
				'inyou' : [String(post_inyou)] ,
				'reply' : [String(post_reply)] ,
				'imgs' : [imgfileList_left] ,
			}
		}).then(function(data){
			
			add_content += "<div>"+data+"</div>";
			// コンテンツ追加
			document.getElementById("sent_post_res_left").innerHTML = '';
			let objData = JSON.parse(data);
			if(objData.status == 'ok'){
				document.getElementById("post_textarea_left").value = '';
				document.getElementById('remaining-characters_left').textContent = maxLength - document.getElementById('post_textarea_left').value.length;
				document.getElementById('img_preview_left').innerHTML = '';
				imgfileList_left = [];
				ajaxServerInfo();
			}else{
				document.getElementById('id_post_submit_left_top').disabled = false;
				document.getElementById('id_post_submit_left').disabled = false;
			}
			toast(objData.word);
			if(typeof objData.reply == 'undefined'){
				if(typeof ajax_add_content_once != 'undefined'){
					ajax_add_content_once(objData.id);
				}
			}
			post_left();
			jssent_now_left = false;
		}).fail(function(e){
			console.log(e);
			console.log("yee_error_left");
			jssent_now_left = false;
			document.getElementById('id_post_submit_left_top').disabled = false;
			document.getElementById('id_post_submit_left').disabled = false;
			toast('エラー:サーバーがビジーです');
		}).always(function(f){
			document.getElementById('id_post_submit_left_top').value = 'ポスト';
			document.getElementById('id_post_submit_left').value = 'ポスト';
		})
	}else{
		console.log("busy!sent_left");
		document.getElementById("sent_post_res_left").innerHTML = "<div>ネットワークエラー</div>";
		document.getElementById('id_post_submit_left_top').disabled = false;
		document.getElementById('id_post_submit_left').disabled = false;
		toast('ネットワークエラー');
		jssent_now = false;
	}
}