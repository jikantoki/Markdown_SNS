<?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    $no_title = 1;
    $js_load = 1;
    $jscount_i = 3;//この変数の件ずつ読み込み
    //print_r($_POST);
    include $webroot."/meta.php";
    include $webroot."/header.php";
	//var_dump($allow_tag);
    //print_r($_POST);
	if(isset($_POST["count"])){
		$count = (int)$_POST["count"];
	}else{
		$count = 0;
	}
	if(isset($_POST['no_showmore'])){
		$no_showmore = $_POST['no_showmore'][0];
	}
	if(isset($_POST['search'])){
		$search = $_POST['search'][0];
	}
	if(isset($_POST['keyword'])){
		$keyword = h($_POST['keyword'][0]);
	}
	if(isset($_POST['no_post_hannou'])){
		$no_post_hannou = $_POST['no_post_hannou'][0];
	}
	if(isset($_POST['no_mother_post'])){
		$no_mother_post = $_POST['no_mother_post'][0];
	}
	if(isset($_POST['with_img'])){
		$with_img = $_POST['with_img'][0];
	}
	if(isset($_POST['with_url'])){
		$with_url = $_POST['with_url'][0];
	}
	if(isset($_POST['with_reply'])){
		$with_reply = $_POST['with_reply'][0];
	}
	if(isset($_POST['with_inyou'])){
		$with_inyou = $_POST['with_inyou'][0];
	}
	if(isset($_POST['id'])){
		$id = $_POST['id'][0];
	}
	$ig = 0;
	if(isset($_POST['url'][0])){
		foreach($genre as $g){
			$sp = mb_strpos($_POST['url'][0],'genre'.$ig.'=on');
			//echo $sp.'<br>';
			if($sp !== false){
				$genrepost[$ig] = 1;
				//echo "geag".$ig;
			}else{
				$genrepost[$ig] = 0;
			}
			$ig += 1;
		}
	}
    //echo "   ".$count;
    //var_dump($_POST);
	//echo "int_jscount is ".$_POST["jscount"][0]."<br>";
	//var_dump($_POST);
	if(isset($_POST["jscount"])){
		$count = (int)$_POST["jscount"][0] * $jscount_i;
		//echo "count is ".$count;
	}else{
		//echo "count is 届いてないよ！";
	}
	if(isset($_POST["reply_flag"])){
		$reply_flag = 1;
	}
    //echo $enum_count_nowpost;
	if(isset($_POST["worldortop_id"])){
		$worldortop = (int)$_POST["worldortop_id"][0];
		//echo "ああああああああああworldortop is ";
		//echo $worldortop;
		//var_dump($_POST["worldortop_id"]);
	}else{
		$worldortop = 1;
		//echo "いいいいいいいいいいいいいい";
	}
	if(isset($_POST['post_id'])){
		//これは投稿を表示するフラグを兼ねている
		if(isset($_POST['showmore'])){
			//コンテンツをリプライに変える
			$showmore = 1;
			$q = "select * from sent_list where reply=\"".$_POST['post_id'][0]."\" order by sent_time desc limit 1";
			$q2 = $pdo -> query($q);
			$q3 = $q2 -> fetchAll(PDO::FETCH_BOTH);
			//print_r($q3);
			$post_id_sentcontent = $q3[0]['sent_rand_id'];
			//print_r($post_id_sentcontent);
		}else{
			$post_id_sentcontent = $_POST['post_id'][0];
		}
		//var_dump($_POST['post_id']);
	}
	//var_dump($_POST['worldortop_id'][0]);
	//var_dump($worldortop);
	if(isset($_POST["unixtime"])){
		$unixtime_post = (int)$_POST["unixtime"][0];
		if($unixtime_post == 0){
			unset($unixtime_post);
			unset($_POST["unixtime"]);
		}
		//var_dump($_POST['unixtime']);
		//var_dump($unixtime_post);
		//echo "BBB";
	}else{
		//echo "AAA";
	}
	if(isset($post_id_sentcontent)){
		if(isset($reply_flag)){
			//これはリプライです
			$no_reply_view = 0;
			$querep = "select * from sent_list where reply=\"".$post_id_sentcontent."\" order by sent_time desc limit ".$count.",".$jscount_i;
			$data_post = $pdo -> query($querep);
			$data_post_cnt = $data_post -> rowCount();
			foreach($data_post as $data_as){
				//var_dump($data_as);
				$sent_content = $data_as['sent_rand_id'];
				$clickable = 1;//1で投稿をクリックで投稿ページに飛ぶ
				$output_del_button = 1;
				unset($post_maxheight);//1ならポストを無駄に表示しない
				include $webroot."/sent_content.php";
			}
			if($data_post_cnt < $jscount_i){
				//class=loaderをdisplay:noneする
				?>
					<script>
						const target = document.getElementsByClassName("loader");
						for( let i = 0 ; i < target.length ; i ++ ) {
							//console.log( target[i] );
							target[i].style.display = 'none';
						}
						const target2 = document.getElementsByClassName("viewmore_ajax");
						for( let j = 0 ; j < target2.length ; j ++ ) {
							//console.log( target[i] );
							target2[j].style.display = 'none';
						}
					</script>
				<?php
			}
		}else{
			//これは投稿の表示です
			$que = "select * from sent_list where sent_rand_id=\"".$post_id_sentcontent."\"";
			//echo $post_id_sentcontent;
			$data_post = $pdo -> query($que);
			foreach($data_post as $data_as){
				//var_dump($data_as);
				$sent_content = $data_as['sent_rand_id'];
				$clickable = 0;//1で投稿をクリックで投稿ページに飛ぶ
				if(isset($showmore)){
					$no_reply_view = 0;
					$clickable = 1;
				}
				if(isset($_POST['once'])){
					$clickable = 1;
				}
				$output_del_button = 1;
				unset($post_maxheight);//1ならポストを無駄に表示しない
				include $webroot."/sent_content.php";
				//echo "AAAAAAAAAAAAAAAAAA";
			}
		}
	}else{
		if(isset($search)){
			//searchだね、探します
			//$_GET['with_○○']は '' か 'on' で判別
			$q = "select * ";
			$qc = "select count(*) ";
			$queue = "from sent_list where ";
			if($with_reply != ''){
				$queue = $queue."( reply LIKE '%' or reply='' ) ";//リプライを含む
			}else{
				$queue = $queue."reply='' ";//リプライを含まない
			}
			if(isset($unixtime_post)){
				$queue = $queue."and sent_time<=".$unixtime_post." ";
			}
			if(isset($id)){
				$id2 = $id;
				$queue = $queue."and sent_owner='".$id2."' ";
			}
			if(isset($keyword)){
				$i = 0;
				$keyw = explode(" ",$keyword);
				foreach($keyw as $kw){
					$queue = $queue."and sent_message LIKE '%".$kw."%' ";
					$i += 1;
				}
			}
			if(!isset($_POST['withrepost'])){
				//sent_messageがRTだけなら除外、ちなデフォで大文字小文字は区別しないらしい
				$queue = $queue."and sent_message != 'RT' and sent_message != 'RT ' and sent_message != ' RT' and sent_message != ' RT ' and sent_message != 'RT\n' ";
			}
			/* aaaaa20230601 */
			if(isset($genrepost)){
				$igp = 0;
				foreach($genrepost as $gg){
					if($gg === 1){
						$queue = $queue."and sent_genre=".$igp." ";
					}
					$igp += 1;
				}
			}
			if($with_img != ''){
				$queue = $queue."and sent_img_url1 != '' ";
			}
			if($with_url != ''){
				$queue = $queue."and sent_sankou_link1 != '' ";
			}
			if($with_inyou != ''){
				$queue = $queue."and inyou != '' ";
			}
			$queue = $queue."order by sent_time desc limit ".$count.",".$jscount_i;
			$q = $q.$queue;
			$qc = $qc.$queue;
			//var_dump($_POST);
			$data_post_list = $pdo -> query($q);
			$data_post_cnt = $data_post_list -> rowCount();
			$i_cnt = 0;
			foreach($data_post_list as $data_as){
				//var_dump($data_as);
				$sent_content = $data_as['sent_rand_id'];
				$clickable = 1;//1で投稿をクリックで投稿ページに飛ぶ
				$searching = 1;//サーチ中
				$post_maxheight = 1;//ポストを無駄に表示しない
				$i_cnt += 1;
				include $webroot."/sent_content.php";
			}
			if($i_cnt == 0){
				?>
					<input type="hidden" class="search_nothing" value="1">
				<?php
			}
			if($data_post_cnt < $jscount_i){
				//class=loaderをdisplay:noneする
				?>
					<script>
						const target = document.getElementsByClassName("loader");
						for( let i = 0 ; i < target.length ; i ++ ) {
							//console.log( target[i] );
							target[i].innerHTML = '<div class="last_search"><p class="last_search_p">最後まで検索しました！</p></div>';
							target[i].classList.remove("loader");
							var last_search = 1;
						}
						const target2 = document.getElementsByClassName("viewmore_ajax");
						for( let j = 0 ; j < target2.length ; j ++ ) {
							//console.log( target[i] );
							target2[j].style.display = 'none';
						}
					</script>
				<?php
			}
		}elseif($worldortop == 1){
			//worldページ、全部のポストを表示
			$queue = "select * from sent_list where reply=\"\" ";
			if(isset($unixtime_post)){
				$queue = $queue."and sent_time<=".$unixtime_post." ";
			}
			$queue = $queue."order by sent_time desc limit ".$count.",".$jscount_i;
			//var_dump($queue);
			$data_post_list = $pdo -> query($queue);
			$data_post_cnt = $data_post_list -> rowCount();
			foreach($data_post_list as $data_as){
				//var_dump($data_as);
				$sent_content = $data_as['sent_rand_id'];
				$clickable = 1;//1で投稿をクリックで投稿ページに飛ぶ
				$post_maxheight = 1;//ポストを無駄に表示しない
				$searching = 1;//サーチ中
				//$output_del_button = 1;//削除ボタンを表示
				include $webroot."/sent_content.php";
			}
			if($data_post_cnt < $jscount_i){
				//class=loaderをdisplay:noneする
				?>
					<script>
						const target = document.getElementsByClassName("loader");
						for( let i = 0 ; i < target.length ; i ++ ) {
							//console.log( target[i] );
							target[i].style.display = 'none';
						}
						const target2 = document.getElementsByClassName("viewmore_ajax");
						for( let j = 0 ; j < target2.length ; j ++ ) {
							//console.log( target[i] );
							target2[j].style.display = 'none';
						}
					</script>
				<?php
			}
		}else{
			//topページ
			if(isset($_SESSION['id'])){
				//フォローしている人+自分の投稿を表示
				
				$q = 'select distinct * from(select sent_list.* from sent_list inner join follow_list on sent_list.sent_owner = follow_list.rand_id_aite where (follow_list.rand_id_me="'.$data_me['rand_id'].'" or sent_list.sent_owner="'.$data_me['rand_id'].'") and reply="") U order by sent_time desc limit '.$count.','.$jscount_i;
				
				$data_post_list = $pdo -> query($q);
				
				$data_post_cnt = $data_post_list -> rowCount();
			}else{
				//ログインしてないアカウントからは、全部のポストを表示
				$quer = "select * from sent_list where reply=\"\" ";
				if(isset($unixtime_post)){
					$quer = $quer."and sent_time<=".$unixtime_post." ";
				}
				$quer = $quer."order by sent_time desc limit ".$count.",".$jscount_i;
				$data_post_list = $pdo -> query($quer);
				$data_post_cnt = $data_post_list -> rowCount();
			}
			foreach($data_post_list as $data_as){
			    if(!isset($enum_count_child)){
			    	$enum_count_child = 0;
			    }else{
			    	$enum_count_child++;
			    }
			    $enum_count_nowpost = $count + $enum_count_child;
				//var_dump($jscount_i);
				//echo "<br>";
				//var_dump($count);
				$sent_content = $data_as['sent_rand_id'];
				$clickable = 1;//1で投稿をクリックで投稿ページに飛ぶ
				$post_maxheight = 1;//ポストを無駄に表示しない
				$searching = 1;//サーチ中
				//$output_del_button = 1;//削除ボタンを表示
				include $webroot."/sent_content.php";
			}
			if($data_post_cnt < $jscount_i){
				//class=loaderをdisplay:noneする
				?>
					<script>
						const target = document.getElementsByClassName("loader");
						for( let i = 0 ; i < target.length ; i ++ ) {
							//console.log( target[i] );
							target[i].style.display = 'none';
						}
						const target2 = document.getElementsByClassName("viewmore_ajax");
						for( let j = 0 ; j < target2.length ; j ++ ) {
							//console.log( target[i] );
							target2[j].style.display = 'none';
						}
					</script>
				<?php
			}
		}
	}
?>
<script>
	twemoji.parse(document.body);
</script>