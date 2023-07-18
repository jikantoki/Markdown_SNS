<script>
	cacheLoad();
	
	//辞書をスタート
	function st_sug(){
		if(typeof startSuggest !== 'undefined'){
			window.addEventListener ?
			  window.addEventListener('DOMContentLoaded', startSuggest, false) :
			  window.attachEvent('onload', startSuggest);
		}
	}
	function st_sug_l(){
		if(typeof startSuggest_left !== 'undefined'){
			window.addEventListener ?
			  window.addEventListener('DOMContentLoaded', startSuggest_left, false) :
			  window.attachEvent('onload', startSuggest_left);
		}
	}
	st_sug();
	st_sug_l();
	(function () {
		// ---------- serviceWorkerの使用
		if ('serviceWorker' in navigator) {
			window.addEventListener('load', () => {
				navigator.serviceWorker.register('sw.js');

			});
		}
		// ---------- アイコンをホーム画面に追加
		let deferredPrompt;
		if(document.getElementById('installButton') != null){
			window.addEventListener('beforeinstallprompt', (e) => {
				// ブラウザデフォルトの処理を抑制する
				event.preventDefault();
				// イベントを変数に保存する
				deferredPrompt = event;
				// インストールボタンを表示
				document.getElementById('installButton').classList.replace('d-none','d-block');

				//		// ↓このコードは動かない。直接promptを呼べない。
				//	e.prompt()
				//		.then(res => console.log(res))
				//		.catch(error => { console.log(`----> ${error}`) });
			});
			document.getElementById('installButton').addEventListener('click', async () => {
				// インストールボタンを非表示
				document.getElementById('installButton').classList.replace('d-block','d-none');
				// プロンプトを表示
				deferredPrompt.prompt();
				// ユーザー操作待ち
				const { outcome } = await deferredPrompt.userChoice;
				// deferredPromptをクリア
				deferredPrompt = null;
			});
			// ---------- インストール成功
			window.addEventListener('appinstalled', () => {
				// インストールボタンを非表示
				document.getElementById('installButton').classList.replace('d-block','d-none');
				// deferredPromptをクリア
				deferredPrompt = null;
			});
		}
	})();
	twemoji.parse(document.body);
	
	//tabキーの入力を有効にする
	function onTextAreaKeyDown(event, object) {
	    // キーコードと入力された文字列
	    var keyCode = event.keyCode;
	    var keyVal = event.key;

	    // カーソル位置
	    var cursorPosition = object.selectionStart;
	    // カーソルの左右の文字列値
	    var leftString = object.value.substr(0, cursorPosition);
	    var rightString = object.value.substr(cursorPosition, object.value.length);

	    // タブキーの場合
	    if(keyCode === 9) {
	        event.preventDefault();  // 元の挙動を止める
	        // textareaの値をカーソル左の文字列 + タブスペース + カーソル右の文字列にする
	        object.value = leftString + "\t" + rightString;
	        // カーソル位置をタブスペースの後ろにする
	        object.selectionEnd = cursorPosition + 1;
	    }
	    // かぎかっこの場合の自動補完
	    else if(keyVal === "{") {
	        event.preventDefault();  // 元の挙動を止める
	        // textareaの値をカーソル左の文字列 + {} + カーソル右の文字列にする
	        object.value = leftString + "{}" + rightString;
	        // カーソル位置をタブスペースの後ろにする
	        object.selectionEnd = cursorPosition + 1;
	    }
	    // かっこの場合の自動補完
	    else if(keyVal === "[") {
	        event.preventDefault();  // 元の挙動を止める
	        // textareaの値をカーソル左の文字列 + [] + カーソル右の文字列にする
	        object.value = leftString + "[]" + rightString;
	        // カーソル位置をタブスペースの後ろにする
	        object.selectionEnd = cursorPosition + 1;
	    }
	}

	// テキストエリアのキー入力時の関数を設定
	var txtar = document.getElementsByTagName('textarea');
	for(let i = 0; i < txtar.length ; i++){
		txtar[i].onkeydown = function(event) {onTextAreaKeyDown(event, this);}
	}
</script>
<?php
	//アクセスカウンター追加処理
	if(!isset($access_cnt)){
		$q = 'select access_cnt from server_info limit 1';
		$q2 = $pdo -> query($q);
		$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
		$qc = $q3[0][0];
		$qc += 1;
		$q = 'update server_info set access_cnt="'.$qc.'" limit 1';
		$q2 = $pdo -> query($q);
		$access_cnt = 1;
		//echo "fw89eihgfwieugbhwe";
	}
?>
<!--右のコンテンツやで-->
<div class="right_content">
	<div class="right_search">
		<h2 class="side_title right_search_h2">検索</h2>
		<form action="/search" method="get" class="right_search_form">
			<input class="searchbar" type="text" name="keyword" placeholder="話題を検索">
			<button class="search_submit" type="submit" name="search_submit" onclick="this.removeAttribute('name')">検索</button>
		</form>
	</div>
	<?php if(strcmp($youtube_url,"") != 0){ ?>
		<h2 class="side_title youtube_h2">独自PR</h2>
		<iframe width="445" height="250" src="https://www.youtube.com/embed/<?php echo $youtube_url;?>?autoplay=1&mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	<?php
		}
	?>
	<h2 class="side_title">最近のアカウント</h2>
	<?php
		$sql = "select count(*) from users_list";	//ユーザーが存在するか？
		$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
		$params = array(); // 挿入する値を配列に格納する
		$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
		if($res){
			$data_sonzai_right = $stmt->fetch();
		}
		$wo = '';
		if(isset($data_me)){
			$data_fl = $pdo -> query("select * from follow_list where rand_id_me='".$data_me['rand_id']."'");
			$i = 0;
			$wo = ' where rand_id != "'.$data_me['rand_id'].'"';
			foreach($data_fl as $df){
				$wo = $wo.' and rand_id != "'.$df['rand_id_aite'].'" ';
				$i += 1;
			}
		}
		$data_u_list = $pdo -> query("select * from users_list ".$wo."order by unixtime desc limit 3");
	?>
	<?php if($data_sonzai_right[0] >= 3){ ?>
		<div class="profile_left">
			<table class="userlist_table">
			<?php
				if(isset($icon_click)){
					unset($icon_click);
				}
				foreach($data_u_list as $row){
					$data = $row;
					$displayname = strcut($data['id'],20);
					if(strcmp($data['name'],"") != 0){
						$displayname = strcut($data['name'],20);
					}
					$yoko_follow_button = 1;
					$webroot = $_SERVER['DOCUMENT_ROOT'];
					?>
					<tr style="position:relative;" data-href="/u&quest;<?php echo $data['id']; ?>">
					<?php
					$right_button = 1;
					include $webroot."/profile_template.php";
				}
			?>
			</table>
		</div>
	<?php
	}
	?>
	<div class="serverinfo_ajax" id="serverinfo_ajax"></div>
	<div class="client_info" id="client_info"></div>
	<?php
		if($more_ads == 1)include $webroot."/adsense.php";
	?>
</div>