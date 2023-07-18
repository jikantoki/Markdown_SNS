<?php
	$no_title = 1;
	$js_load = 1;
	$webroot = $_SERVER['DOCUMENT_ROOT'];
	include $webroot."/meta.php";
	include $webroot."/header.php";
	
	$ac_once = 5;//取得する通知の数
	$ky = $_POST['keyword'][0];
	$ky_a = not_space(mb_str_replace('@', '', $ky));
	$fo = $_POST['followOnly'][0];
	
	$q_origin = $follower_cnt_word;//settings.phpに書いてある、フォロワー数を取得してフォロワー多い順で返ってくる
	
	if($ky_a != ''){
		$q = $q_origin.' where ( name = "'.$ky_a.'" or id = "'.$ky_a.'" )';//完全一致を優先して検索
		$q2 = $pdo -> query($q);
		$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
		$i = 0;
		if($q3 != false){
			foreach($q3 as $qq3){
				$i += 1;
			}
		}
		$nokori = $ac_once - $i;
		if($nokori < 0){
			$nokori = 0;
		}
	}else{
		$q3 = false;
		$nokori = $ac_once;
	}
	
	$q = $q_origin.' where ( name like "%'.$ky_a.'%" or id like "%'.$ky_a.'%" or message like "%'.$ky_a.'%" ) ';//あいまい検索
	if($q3 != false){
		foreach($q3 as $qu){
			$q = $q.'and id != "'.$qu['id'].'"';//完全一致を除外
		}
	}
	$q = $q.' limit '.$nokori;
	$q2 = $pdo -> query($q);
	$q4 = $q2 -> fetchAll(PDO::FETCH_BOTH);
	
	if($q3 != false){
		$ret = array_merge($q3, $q4);//最終的な結果配列
	}else{
		$ret = $q4;
	}
	
	if($ret != false){
		foreach($ret as $r){
			$s_message = $r["message"];
			$s_message = hash_replace($s_message);
			$parser = new \cebe\markdown\GithubMarkdown();
			$parser -> html5 = true;
			$parser->enableNewlines = true;
			$parsed_message = $parser -> parse($s_message);
			?>
				<a class="sacc_a" href="/u?<?php echo $r['id']; ?>">
					<div class="search_ac_child_child">
						<div class="sacc_img">
							<img src="<?php echo $r['icon_url']; ?>" onerror='this.src="/img/account_default.png"'>
						</div>
						<div class="sacc_nameid">
							<div class="sacc_name">
								<?php echo $r['name']; ?>
							</div>
							<div class="sacc_id">
								@<?php echo $r['id']; ?>
							</div>
						</div>
					</div>
					<div class="sacc_shousai">
						<div class="sacc_mes">
							<?php echo ((($r['message']))); ?>
						</div>
					</div>
				</a>
			<?php
		}
	}
?>