<?php /*<!-- メタ情報やで -->*/ ?>
<?php
	define("projectname","MDSNS");
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/settings.php";
	ini_set("session.cookie_secure", 1);
	session_name(session_name_i);
	session_start();
	session_regenerate_id(true);
    if(!isset($title_defined)){
	    define("corp","Created by ".projectname);
	}
?>
<?php 
	$title_temp = " - ".sitename." ".corp;
	if(!isset($no_title)){
	    echo "<title>".title.$title_temp."</title>";
		echo "<meta property=\"og:title\" content=\"".title.$title_temp."\">";
	}
	if((!isset($no_og_img)) && (!isset($js_load))){
		echo "<meta property=\"og:image\" content=\"".page_address.default_og_image."\">";
		echo "<meta property=\"twitter:image\" content=\"".page_address.default_og_image."\">";
	}
?>
<?php if(!isset($js_load)){ ?>
	<link rel="shortcut icon" href="/img/favicon.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/img/favicon512.png">
	<meta http-equiv="content-type" charset="UTF-8">
	<meta name="author" content="<?php echo author; ?>">
	<meta name="keywords" content="<?php echo author; ?>,ときえのき,jikantoki,homepage,ホームページ,OpenEC,エノキ電機,EC,C2C,商取引">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="twitter:card" content="summary_large_image" >
	<meta name="twitter:site" content="<?php echo meta_twitter_id; ?>" >
	<meta property="og:url" content="<?php echo page_address; ?>" >
	<meta property="og:sitename" content="<?php echo sitename; ?>" >
	<meta charset="UTF-8">
	<meta name="msapplication-TileImage" content="/img/favicon512.png" />
	<meta name="msapplication-TileColor" content="#FFFFFF"/>

	<link href="/library/lightbox/src/css/lightbox.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>
	<script src="https://cdn.jsdelivr.net/npm/@twemoji/api@latest/dist/twemoji.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
	<!--<script src="/library/vue/vue.js"></script>-->
	
	<!-- Twemoji Picker -->
	<!--<link rel="stylesheet" href="/library/Twemoji-Picker/css/twemoji-picker.css">-->
	<!--<script src="/library/Twemoji-Picker/js/twemoji-picker.js"></script>-->
	<!--<script>jQuery('#post_textarea').twemojiPicker();</script>-->
	
	<script src="/library/suggest.js"></script>

	<!--<link rel="stylesheet" href="/css/reset.css">-->
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/context.css">
	<link rel="stylesheet" href="/css/post.css">
	<link rel="stylesheet" href="/settings_css.css">
	<link rel="stylesheet" href="/css/header_style.css">
	<link rel="stylesheet" href="/css/footer_style.css">
	<link rel="stylesheet" href="/css/left_style.css">
	<link rel="stylesheet" href="/css/right_style.css">
	<link rel="stylesheet" href="/css/lightbox.css">
	<link rel="stylesheet" href="/css/mobile.css">
	<link rel="stylesheet" href="/css/loader.css">
	<link rel="stylesheet" href="/css/pwa.css">
	<link rel="stylesheet" href="/css/suggest.css">
	<link rel="stylesheet" href="/css/cssing.css">
	<!-- カスタムカラーの読み込み -->
<?php } ?>
<?php if(!isset($js_load)){ ?>
	<script>
		function rm(obj){
			obj.remove();
			console.log(obj + 'is removed');
		}
		function color_set(){
			var d = document;
			if(document.cookie.indexOf('color') === -1){//cookieにcolorがあるか？
				//ない
				console.log("Color is not defined");
				var css_color = '';
				var removeClassElement = function(className){
					var elements = document.getElementsByClassName(byjavascriptcss);
					for (var i = 0; i < elements.length; i++) {
						var e = elements[i];
						if (e) {
							e.parentNode.removeChild(e);
						}
					}
				};
				var css_color = 'default';
				var css_code = d.createElement("link");
				css_code.rel = 'stylesheet';
				css_code.type = 'text/css';
				var css_href = "/defaultcolor.css";
				css_code.href = css_href;
				var h = d.getElementsByTagName("head")[0];
				h.appendChild(css_code);
			}else{
				//ある
				const key = 'color';
				const cookievalue = document.cookie
					.split('; ')
					.find(row => row.startsWith(key))
					.split('=')[1];
				var css_color = cookievalue;
				console.log("Color is seted!" + css_color);
				var css_code = d.createElement("link");
				css_code.rel = 'stylesheet';
				css_code.type = 'text/css';
				var css_href = "/color/" + css_color + ".css";
				css_code.href = css_href;
				var h = d.getElementsByTagName("head")[0];
				h.appendChild(css_code);
			}
		};
		color_set();
		var time_month = 1 * 60 * 60 * 24 * 30;
		function colorchange(click_color){
			console.log("click_color is " + click_color);
			let cookieword = "color=" + click_color + ";max-age=" + time_month;
			console.log(cookieword);
			if(click_color == 'default'){
				console.log("cookie color is deleted");
				Cookies.remove('color');
				Cookies.set('max-age','0');
			}else{
				//document.cookie = cookieword;
				Cookies.set('color',click_color);
				Cookies.set('max-age',time_month);
			}
			color_set();
		}
		var bodyzoom = '';
		var bodyzoom_val = 1;
		//右クリックメニューの設定
	</script>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cherry+Bomb+One&family=DotGothic16&family=Shippori+Mincho&family=Zen+Maru+Gothic&family=Noto+Sans+JP&family=Roboto&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="/library/shortcut.js"></script>
	<script src="/library/ajaxCSS.js"></script>
	<script src="/library/ajaxSentPost.js"></script>
	<script src="/library/ajaxViewURL.js"></script>
	<script src="/library/ajaxUserInfo.js"></script>
	<script src="/library/good.js"></script>
<?php } ?>
<?php
	$ads_enum = 0;
	if(!isset($title_defined)){
		//var_dump($q3);
		//var_dump($qc);
		
		if(!isset($already_setting)){
			function h($s) {
				return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
			}
			function dh($s) {
				return htmlspecialchars_decode($s, ENT_QUOTES, "UTF-8");
			}
		}
		function login($i){//ログイン状態なら1、ログインしてなきゃ0
			if(isset($_SESSION['id'])){
				return isset($_SESSION['id']);
			}
		}
		function strcut($c,$i){// string $c, int $i 、文字列cの数がiバイト以上ならカットして三点を表示
			$i_c = strlen($c);
			if($i_c > $i + 2){
				$i_d = mb_substr($c,0,($i / 2) - 4);
				return $i_d."…";
			}else{
				return $c;
			}
		}
		function colorchange($colorpath){// string $colorname 、Webサイトの色を変える
			$webroot = $_SERVER['DOCUMENT_ROOT'];
			$cs = @file_get_contents($colorpath);
			if($cs == false){
				setcookie('color',"",time() - 30);
				return 1;
			}else{
			//	echo "ああああああああああああああああああああ";
				setcookie('color',$colorpath,time() + 60 * 60 * 24 * 365 * 5);
				return 0;
			}
		}
		//ソースを全部読み込ませる
		require $webroot.'/library/phpmailer/src/PHPMailer.php';
		require $webroot.'/library/phpmailer/src/SMTP.php';
		require $webroot.'/library/phpmailer/language/phpmailer.lang-ja.php';
		require $webroot.'/library/phpmailer/src/Exception.php';
		require $webroot.'/library/cebe_markdown/Parser.php';
		require $webroot.'/library/cebe_markdown/block/CodeTrait.php';
		require $webroot.'/library/cebe_markdown/block/FencedCodeTrait.php';
		require $webroot.'/library/cebe_markdown/block/HeadlineTrait.php';
		require $webroot.'/library/cebe_markdown/block/HtmlTrait.php';
		require $webroot.'/library/cebe_markdown/block/ListTrait.php';
		require $webroot.'/library/cebe_markdown/block/QuoteTrait.php';
		require $webroot.'/library/cebe_markdown/block/RuleTrait.php';
		require $webroot.'/library/cebe_markdown/block/TableTrait.php';
		require $webroot.'/library/cebe_markdown/inline/CodeTrait.php';
		require $webroot.'/library/cebe_markdown/inline/EmphStrongTrait.php';
		require $webroot.'/library/cebe_markdown/inline/LinkTrait.php';
		require $webroot.'/library/cebe_markdown/inline/StrikeoutTrait.php';
		require $webroot.'/library/cebe_markdown/inline/UrlLinkTrait.php';
		require $webroot.'/library/cebe_markdown/Markdown.php';
		require $webroot.'/library/cebe_markdown/GithubMarkdown.php';
		//require $webroot.'/library/htmlpurifier/library/HTMLPurifier.php';
		//require $webroot.'/library/htmlpurifier/library/HTMLPurifier.auto.php';
		//require $webroot.'/library/htmlpurifier/library/HTMLPurifier.autoload.php';
		require $webroot.'/library/htmlpurifier/library/HTMLPurifier.composer.php';
		//require $webroot.'/library/htmlpurifier/library/HTMLPurifier.func.php';
		require $webroot.'/library/htmlpurifier/library/HTMLPurifier.includes.php';
		//require $webroot.'/library/htmlpurifier/library/HTMLPurifier.kses.php';
		//require $webroot.'/library/htmlpurifier/library/HTMLPurifier.path.php';
		
		function htmlparse($str,$allow){
			$config = HTMLPurifier_Config::createDefault();
			$config->set('HTML.Allowed',$allow);
			$config->set('HTML.TargetBlank',true);
			$config->set('Attr.EnableID',true);
			$purifier = new HTMLPurifier($config);
			return $purifier->purify($str);
		}
		
		/**
		 マルチバイト対応str_replace
		*/
		function mb_str_replace($search, $replace, $haystack, $encoding="UTF-8")
		{
		    // 検索先は配列か？
		    $notArray = !is_array($haystack) ? TRUE : FALSE;
		    // コンバート
		    $haystack = $notArray ? array($haystack) : $haystack;
		    // 検索文字列の文字数取得
		    $search_len = mb_strlen($search, $encoding);
		    // 置換文字列の文字数取得
		    $replace_len = mb_strlen($replace, $encoding);

		    foreach ($haystack as $i => $hay){
		        // マッチング
		        $offset = mb_strpos($hay, $search);
		        // 一致した場合
		        while ($offset !== FALSE){
		            // 差替え処理
		            $hay = mb_substr($hay, 0, $offset).$replace.mb_substr($hay, $offset + $search_len);
		            $offset = mb_strpos($hay, $search, $offset + $replace_len);
		        }
		        $haystack[$i] = $hay;
		    }
		    return $notArray ? $haystack[0] : $haystack;
		}
		function not_space($s){//スペースとか改行を削除
			$s = mb_str_replace(' ','',$s);
			$s = mb_str_replace('　','',$s);
			$s = mb_str_replace("\n",'',$s);
			$s = mb_str_replace("\t",'',$s);
			return $s;
		}
		function hash_replace($s){//ハッシュタグ用前処理、markdownの前に実施
			global $hashtag_preg;
			preg_match_all($hashtag_preg, $s, $preg_result, PREG_SET_ORDER);
			foreach($preg_result as $p){
				//echo $p[0];
				if($p[0] == '#')continue;
				$p2 = substr_replace($p[0], '0', 1, 0);
				$s = mb_str_replace($p[0], $p2 ,$s);
			}
			return $s;
		}
		function emoji($parsed_message){//絵文字を変換
			$webroot = $_SERVER['DOCUMENT_ROOT'];
			$custom_emoji = glob($_SERVER['DOCUMENT_ROOT']."/emoji/*");
			$custom_aa = glob($_SERVER['DOCUMENT_ROOT']."/copypaste/*");
			$ex_mes = explode(":",$parsed_message);
			$igyo_mes = "";
			$emoji_all_cnt = 0;
			//var_dump($ex_mes);
			foreach($ex_mes as $ex_as){
				$turnend = 0;
				//$ex_asに「:」で分割したmessageがある
				if(mb_strlen($ex_as) <= 32){
					foreach($custom_emoji as $emoji_as){
						$turnend = 0;
						//$emoji_asにigyo.pngみたいなファイルが入ってる
						$emoji_filename = pathinfo($emoji_as)['filename'];
						$emoji_extension = pathinfo($emoji_as)['extension'];
						//echo "strcmpするべき<br>".$ex_as."<br>".$emoji_filename."<br>";//もし$ex_asと$emoji_filenameが同じなら$ex_asを<img>に置き換え
						if($ex_as === $emoji_filename){
							//$igyo_mes = substr($igyo_mes, 0, -1);
							$ex_as_edited = "<img class='custom_emoji' loading=\"lazy\" src='/emoji/".$emoji_filename.".".$emoji_extension."'>";
							$igyo_mes = $igyo_mes.$ex_as_edited;
							//echo $ex_as_edited."<br>";
							$turnend = 1;
							break;
						}elseif($ex_as === 'emoji_all'){
							if($emoji_all_cnt < 4){
								$k = 0;
								$ex_as_edited2 = '';
								foreach($custom_emoji as $emoji_as2){
									$emoji_filename2 = pathinfo($emoji_as2)['filename'];
									$emoji_extension2 = pathinfo($emoji_as2)['extension'];
									$ex_as_edited2 = $ex_as_edited2."<img class='custom_emoji' loading=\"lazy\" src='/emoji/".$emoji_filename2.".".$emoji_extension2."'>";
								}
								$igyo_mes = $igyo_mes.$ex_as_edited2;
								$turnend = 1;
								$emoji_all_cnt += 1;
							}
							break;
						}elseif($ex_as === 'emoji_all2'){
							if($emoji_all_cnt < 4){
								$k = 0;
								$ex_as_edited2 = '';
								foreach($custom_emoji as $emoji_as2){
									$emoji_filename2 = pathinfo($emoji_as2)['filename'];
									$emoji_extension2 = pathinfo($emoji_as2)['extension'];
									$ex_as_edited2 = $ex_as_edited2."<img class='custom_emoji' loading=\"lazy\" src='/emoji/".$emoji_filename2.".".$emoji_extension2."'>:".$emoji_filename2.":";
								}
								$igyo_mes = $igyo_mes.$ex_as_edited2;
								$turnend = 1;
								$emoji_all_cnt += 1;
							}
							break;
						}elseif($ex_as === 'emoji_all3'){
							if($emoji_all_cnt < 4){
								$k = 0;
								$ex_as_edited2 = '';
								foreach($custom_emoji as $emoji_as2){
									$emoji_filename2 = pathinfo($emoji_as2)['filename'];
									$emoji_extension2 = pathinfo($emoji_as2)['extension'];
									$ex_as_edited2 = $ex_as_edited2."<img class='custom_emoji' loading=\"lazy\" src='/emoji/".$emoji_filename2.".".$emoji_extension2."'>:".$emoji_filename2.":<br>";
								}
								$igyo_mes = $igyo_mes.$ex_as_edited2;
								$turnend = 1;
								$emoji_all_cnt += 1;
							}
							break;
						}elseif($ex_as === 'aa_all'){
							$i_aa = 0;
							foreach($custom_aa as $aa_as){
								$aa_filename = pathinfo($aa_as)['filename'];
								$aa_extension = pathinfo($aa_as)['extension'];
								$fp = "/copypaste/".$aa_filename.".".$aa_extension;
								$fullfp = $webroot.$fp;
								$text = file_get_contents($fullfp);
								$text2 = nl2br($text);
								$igyo_mes = $igyo_mes.'<br>'.$text2;
								$i_aa += 1;
							}
							$turnend = 1;
							$emoji_all_cnt += 1;
							break;
						}elseif($ex_as === 'aa_all2'){
							$i_aa = 0;
							foreach($custom_aa as $aa_as){
								$aa_filename = pathinfo($aa_as)['filename'];
								$aa_extension = pathinfo($aa_as)['extension'];
								$fp = "/copypaste/".$aa_filename.".".$aa_extension;
								$fullfp = $webroot.$fp;
								$text = file_get_contents($fullfp);
								$text2 = nl2br($text);
								$igyo_mes = $igyo_mes.':'.$aa_filename.':<br>'.$text2.'<br>';
								$i_aa += 1;
							}
							$turnend = 1;
							$emoji_all_cnt += 1;
							break;
						}else{
							//AAを探す
							$i_aa = 0;
							foreach($custom_aa as $aa_as){
								$aa_filename = pathinfo($aa_as)['filename'];
								$aa_extension = pathinfo($aa_as)['extension'];
								if($ex_as === $aa_filename){
									$fp = "/copypaste/".$aa_filename.".".$aa_extension;
									$fullfp = $webroot.$fp;
									$text = file_get_contents($fullfp);
									$text2 = nl2br($text);
									$igyo_mes = $igyo_mes.$text2;
									$turnend = 2;
									break;
								}
								$i_aa += 1;
							}
							if($turnend === 2){
								break;
							}
						}
					}
				}
				if($turnend == 0){
					if( (substr($ex_as, -4) == 'http') || (substr($ex_as, -5) == 'https') ){
						$ex_as = $ex_as.":";
					}
					$ex_as_edited = $ex_as;
					$igyo_mes = $igyo_mes.$ex_as_edited;
				}
			}
			$igyo_mes2 = substr($igyo_mes, 0, -1);
			
			//echo $parsed_message;//Markdownのパースのみ
			return $igyo_mes2;
		}
		
		function cssing($parsed_message){//文字にcss&spanを付ける
			$webroot = $_SERVER['DOCUMENT_ROOT'];
			$custom_css = glob($_SERVER['DOCUMENT_ROOT']."/cssing/*");
			$h_start = h("<");
			$h_end = h(">");
			foreach($custom_css as $cssing){
				//$cssingにファイル名がある
				$css_filename = pathinfo($cssing)['filename'];
				$css_extension = pathinfo($cssing)['extension'];
				$fp = "/cssing/".$css_filename.".".$css_extension;
				$fullfp = $webroot.$fp;
				$search_mes = $h_start.$css_filename.$h_end;
				$search_mes_end = $h_start."/".$css_filename.$h_end;
				if(strpos($parsed_message,$search_mes) !== false){
					$text = file_get_contents($fullfp);
					$parsed_message = mb_str_replace($search_mes, $text, $parsed_message);
				}
				if(strpos($parsed_message,$search_mes_end) !== false){
					$text = file_get_contents($fullfp);
					$text2 = mb_str_replace('<','</' , $text);
					$parsed_message = mb_str_replace($search_mes_end, $text2, $parsed_message);
				}
			}
			if(strpos($parsed_message,$h_start.'css_all'.$h_end) !== false){
				$text = '';
				foreach($custom_css as $cssing2){
					$css_filename = pathinfo($cssing2)['filename'];
					$css_extension = pathinfo($cssing2)['extension'];
					$fp = "/cssing/".$css_filename.".".$css_extension;
					$fullfp = $webroot.$fp;
					$word = file_get_contents($fullfp);
					$word2 = mb_str_replace('<','</' , $word);
					$text = $text.$h_start.$css_filename.$h_end.$word.'メッセージテストHello12345'.$word2.$h_start.'/'.$css_filename.$h_end.'<br>';
				}
				$parsed_message = mb_str_replace($h_start.'css_all'.$h_end, $text, $parsed_message);
			}
			/*global $allow_tag;
			foreach($allow_tag as $tag){
				if(strpos($parsed_message,$h_start.$tag) !== false){
					$parsed_message = preg_replace('/'.$h_start.$tag.'((".*?"|\'.*?\'|[^\'"])*?)'.$h_end.'/', '<'.$tag.' $1>', $parsed_message);
				}
				if(strpos($parsed_message,$h_start.'/'.$tag.$h_end) !== false){
					$parsed_message = mb_str_replace($h_start.'/'.$tag.$h_end, '</'.$tag.'>', $parsed_message);
				}
			}*/
			$parsed_message = mb_str_replace('<a href=', '<a noopener noreferrer target="_blank" href=', $parsed_message);
			return $parsed_message;
		}
	}
	function hashtag($s){//ハッシュタグ追加処理
		global $webroot;
		global $hashtag_preg;
		$s = mb_str_replace('&#', '&+-+-replace_hashtag', $s);
		preg_match_all($hashtag_preg, $s, $preg_result, PREG_SET_ORDER);
		foreach($preg_result as $p){
			$p1 = mb_str_replace('#','%23',$p[0]);
			$s = mb_str_replace($p[0], '<a href="/search?keyword='.$p1.'" class="post_hashtag">'.$p[0].'</a>', $s);
		}
		$s = mb_str_replace('#0','#',$s);
		$s = mb_str_replace('%230','%23',$s);
		$s = mb_str_replace('&+-+-replace_hashtag', '&#', $s);
		
		//ここからはメンション関係
		global $allow_id_pattern_at;
		preg_match_all($allow_id_pattern_at, $s, $preg_result, PREG_SET_ORDER);
		foreach($preg_result as $p){
			$s = mb_str_replace($p[0], '<a href="/u?'.$p[0].'" class="post_hashtag">'.$p[0].'</a>', $s);
		}
		
		return $s;
	}
	
	$img_limit2 = (string)$img_limit;
	if($img_limit > 1024){
		$str_lim = $img_limit / 1024;
		$img_limit2 = "".(string)$str_lim."kB";
		if($img_limit > 1024 * 1024){
			$str_lim = $img_limit / 1024 / 1024;
			$img_limit2 = "".(string)$str_lim."MB";
		}
	}
	$mp3_limit2 = (string)$mp3_limit;
	if($mp3_limit > 1024){
		$str_lim = $mp3_limit / 1024;
		$mp3_limit2 = "".(string)$str_lim."kB";
		if($mp3_limit > 1024 * 1024){
			$str_lim = $mp3_limit / 1024 / 1024;
			$mp3_limit2 = "".(string)$str_lim."MB";
		}
	}
	
	/**
	 * ランダム文字列生成 (英数字)
	 * $length: 生成する文字数
	 */
	function makeRandStr($length) {
	    $str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
	    $r_str = null;
	    for ($i = 0; $i < $length; $i++) {
	        $r_str .= $str[rand(0, count($str) - 1)];
	    }
	    return $r_str;
	}
	
	//引数のURLのHTTPステータスコードを返す
	if(!function_exists('get_http_status_code')){
		function get_http_status_code($url)
		{
		    $options=array
		    (
		        'http'=>array
		        (
		            'ignore_errors'=>true
		        )
		    );
		    $fp=fopen($url,'r',false,stream_context_create($options));
		    if($fp)
		    {
		        fclose($fp);
		        $pattern='#^HTTP/\d\.\d (\d+) .+$#';
		        if(preg_match($pattern,$http_response_header[0],$matches))
		        {
		            return (int)$matches[1];
		        }
		        else
		        {
		            false;
		        }
		    }
		    else
		    {
		        return false;
		    }
		}
	}
	session_start();
?>
<?php if(!isset($js_load)){ ?>
	<script>
		//ファイルサイズ制限
		const fileLimit = <?php echo $img_limit; ?>;
		const mp3Limit = <?php echo $mp3_limit; ?>;
		var fileLimit2 = fileLimit;
		if(fileLimit > 1024){
			fileLimit2 = fileLimit / 1024 + "kB";
			if(fileLimit > 1024 * 1024){
				fileLimit2 = fileLimit / 1024 / 1024 + "MB";
			}
		}
		var mp3Limit2 = mp3Limit;
		if(mp3Limit > 1024){
			mp3Limit2 = mp3Limit / 1024 + "kB";
			if(mp3Limit > 1024 * 1024){
				mp3Limit2 = mp3Limit / 1024 / 1024 + "MB";
			}
		}
		window.addEventListener('DOMContentLoaded', (event) => {
			const fileUploads = document.querySelectorAll('.img-limit');
			fileUploads.forEach(fileUpload => {
			  fileUpload.addEventListener('change', () => {
			    const files = fileUpload.files;
			    for (const file of files) {
			      if (file.size > fileLimit) {
			        //alert('ファイルサイズが' + fileLimit2 + 'を超えています');
			        fileUpload.value = "";
			        return;
			      }
			    }
			  })
			});
			const mp3Uploads = document.querySelectorAll('.mp3-limit');
			mp3Uploads.forEach(mp3Upload => {
			  mp3Upload.addEventListener('change', () => {
			    const mp3files = mp3Upload.mp3files;
			    for (const mp3file of mp3files) {
			      if (mp3file.size > mp3Limit) {
			        //alert('ファイルサイズが' + mp3Limit +'を超えています');
			        mp3Upload.value = "";
			        return;
			      }
			    }
			  })
			});
		});
		const eventDelete = e => {
		  if (e.currentTarget.href === window.location.href) {
		    e.preventDefault()
		    e.stopPropagation()
		    return
		  }
		}
		const links = [...document.querySelectorAll('a[href]')]
		links.forEach(link => {
		  link.addEventListener('click', e => {
		    eventDelete(e)
		  }, false)
		})
		var opt_hid = 0;
		var jsload_now = false;
		var jsload_now_rep = false;
		var jssent_now = false;
		var jssent_now_left = false;
		var jsshowmore_now = false;
		var viewreply_now = false;
		var viewurl_now = false;
		jQuery( function($) {
		    $('tbody tr[data-href]').addClass('clickable').click( function() {
		        window.location = $(this).attr('data-href');
		    }).find('a').hover( function() {
		        $(this).parents('tr').unbind('click');
		    }, function() {
		        $(this).parents('tr').click( function() {
		            window.location = $(this).attr('data-href');
		        });
		    });
		});
		function showMore(btn) {
		    var targetId = btn.getAttribute("href").slice(1);          // 表示対象のid名をhref属性値から得る
		    document.getElementById(targetId).style.display = "block"; // 表示対象の非表示状態を解除
		    btn.parentNode.style.display = "none";                     // 続きを読むボタンを消す
		    return false;                                                        // リンクとして機能しないようfalseを返す
		}
		
		//キャッシュクリアスクリプト
		function cacheclear(){
			localStorage.clear();  //全データを消去
			navigator.serviceWorker.getRegistrations().then(function(registrations) {
			  for(let registration of registrations) {
			    registration.unregister();
			  }
			});
			caches.keys().then(function(keys) {
			  let promises = [];
			  keys.forEach(function(cacheName) {
			    if (cacheName) {
			      promises.push(caches.delete(cacheName));
			    }
			  });
			});
			if((location.pathname != '/logout') && (location.pathname != '/userinfo') && (location.pathname != '/userinfo.php')){
				location.reload();
			}else{
				console.log("cache!!!!!");
				//リファラを見て違うページならリロード
				var cref = document.referrer;             // リファラ情報を得る
				var chereHost = window.location.href; 
				if(cref != chereHost){
					location.reload();
				}
			}
			//document.getElementById("cacheclearbutton").value = "キャッシュがクリアされました！";
		}
		//不正アクセスを対策しようJS版
		function ref_check(){
			var ref = document.referrer;
			var nowhost = window.location.hostname;
			var sStr = "^https?://" + nowhost;
			var rExp = new RegExp( sStr, "i");
			if(ref.match(rExp)){
				//リファラが同じドメイン
			}else{
				//リファラが外部ドメインか無し、追い出す
				console.log("myhost is " + nowhost);
				console.log("referrer is " + ref);
				location.href = '/';
			}
		}
		let maxLength = 1;
		const limitTextLength = () => {//残りの文字数を表示
		  maxLength = <?php echo post_max; ?>; // 文字数の上限
		  let enteredCharacters = document.getElementById('post_textarea');
		  let remainingCharacters = document.getElementById('remaining-characters');

		  if (enteredCharacters.value.length > maxLength) {
		    enteredCharacters.value = enteredCharacters.value.substr(0, maxLength);
		    remainingCharacters.classList.add('max');
		  } else {
		    remainingCharacters.classList.remove('max');
		  }

		  remainingCharacters.textContent = maxLength - enteredCharacters.value.length;
		};
		const limitTextLength_left = () => {//残りの文字数を表示
		  maxLength = <?php echo post_max; ?>; // 文字数の上限
		  let enteredCharacters = document.getElementById('post_textarea_left');
		  let remainingCharacters = document.getElementById('remaining-characters_left');

		  if (enteredCharacters.value.length > maxLength) {
		    enteredCharacters.value = enteredCharacters.value.substr(0, maxLength);
		    remainingCharacters.classList.add('max');
		  } else {
		    remainingCharacters.classList.remove('max');
		  }

		  remainingCharacters.textContent = maxLength - enteredCharacters.value.length;
		};
		// ajaxコンテンツ追加処理
		function showmore_reply(post_id_str,r){
		    if(jsshowmore_now == false){
				jsshowmore_now = true;
			    // 追加コンテンツ
			    var add_content = "";
			    // コンテンツ件数           
			    //var count2_post = $("#count").val();
			    //var count_post = parseInt(count2);
			    //console.log("count is "+count);
			    var worldtop_id = '0';
			    //console.log(worldtop_id);
			    let post_id = post_id_str;
			    console.log("Showmore ID is " + post_id);
			    
			    //let element2 = document.getElementById('content_post');
			    
			    // ajax処理
			    //console.log("ready");
			    $.ajax({
			        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			        url: "/sent_content2.php",
			        type: 'POST',
			        datatype: "text",
			        //processData: false,
			        //cache: false,
			        //contentType: false,
			        timeout: 10000,
			        data:{
			        	'jscount' : ['0'] ,
			        	'worldortop_id' : [String(worldtop_id)] ,
			        	'post_id' : [String(post_id)],
			        	'showmore' : ['1'],
			        }
			    }).then(function(data){
			        // コンテンツ生成
			        //console.log("yeeeeeeeeeeeeee");
			        //data = JSON.parse(data);
			        //echo data.content;
			        /*$.each(data,function(key, val){
			        	console.log("yee2");
			            add_content += "<div>"+val.content+"</div>";
			        })*/
			        add_content += "<div class=\"jsload_showmore\">"+data+"</div>";
			        // コンテンツ追加
			        $("#mother_" + post_id + r).append(add_content);
			        document.getElementById('reply_' + post_id + r).style.display = "none";
			        //element2.appendChild(add_content);
			        // 取得件数を加算してセット
			        //count += 1;
			        //$("#count").val(count);
				    jsshowmore_now = false;
			    }).fail(function(e){
			        console.log(e);
			        console.log("yee_showmore_error");
			    	jsshowmore_now = false;
			    })
		    }else{
		    	console.log("showmore is busy!post");
		    }
		}
		//head側のpostフォームを表示
		function post_left(reply='', inyou=''){
			let url = new URL(window.location.href);
			let pm = url.searchParams;
			let getkw = pm.get('keyword');
			let pl_mother = document.getElementById("post_left_mother");
			let pl_display = pl_mother.style.display;
			//console.log(pl_display);
			let reply_id = document.getElementById("form_reply_left");
			let inyou_id = document.getElementById("form_inyou_left");
			if(pl_display == 'none'){
				pl_mother.style.display = 'block';
				reply_id.value = reply;
				inyou_id.value = inyou;
				var e = document.getElementById('post_textarea_left');
				if(e) {
					if(getkw !== null){
						e.value = ' ' + getkw;
					}else{
						e.value = '';
					}
					e.focus();
					e.setSelectionRange(0, 0);
					document.getElementById('form_genre_left').value = '0 ';
					document.getElementById('form_subowner_left').value = '';
					document.getElementById('form_place_left').value = '';
					document.getElementById('form_link1_left').value = '';
					document.getElementById('form_link2_left').value = '';
				}
			}else{
				pl_mother.style.display = 'none';
				reply_id.value = '';
				inyou_id.value = '';
		        document.getElementById("post_close_title").innerHTML = '';
			}
			ajax_view_reply();
		}
		window.addEventListener("DOMContentLoaded", () => {
		  // textareaタグを全て取得
		  const textareaEls = document.querySelectorAll("textarea");

		  textareaEls.forEach((textareaEl) => {
		    // デフォルト値としてスタイル属性を付与
		    textareaEl.setAttribute("style", `height: 88px;`);
		    // inputイベントが発生するたびに関数呼び出し
		    textareaEl.addEventListener("input", setTextareaHeight);
		  });

		  // textareaの高さを計算して指定する関数
		  function setTextareaHeight() {
		    this.style.height = "auto";
		    this.style.height = `${this.scrollHeight}px`;
		  }
		});
		var adsBlocked = 0;
		window.addEventListener('load', function(){
			let elms = document.getElementsByClassName('adsbygoogle');
			if(elms.length == 0)return;
			if(!elms[0].getElementsByTagName('iframe').length){
				console.log("Google Ads is blocked");
				adsBlocked = 1;
			}
		});
		
		//数秒間だけ出てくるやつ
		function ts(){
			document.getElementById('toast').style.display = 'none';
		}
		function toast(str='Toast!',color='var(--hover_color2)',err=0){
			let d = document;
			d.getElementById('toast_text').innerHTML = str;
			d.getElementById('toast').style.backgroundColor = color;
			d.getElementById('toast').style.display = 'block';
			setTimeout(ts,5000);//5秒待って消す
		}
		
		//zoom非対応ブラウザ対応
		function zoom_check(){
			let div = document.createElement('div');
			div.style.cssText = 'zoom: 0.5';
			if(div.style.length){
				//zoom対応
				return 0;
			}else{
				console.log('CSSのzoomプロパティ非対応');
				return 1;
			}
		}
		if(zoom_check() == 1){
			window.addEventListener("DOMContentLoaded", () => {
				document.getElementsByClassName('profile_left')[0].style.display = 'none';
			});
		}
		// setIntervalを使う方法
		function sleep(waitSec, callbackFunc) {
		 
		    // 経過時間（秒）
		    var spanedSec = 0;
		 
		    // 1秒間隔で無名関数を実行
		    var id = setInterval(function () {
		 
		        spanedSec++;
		 
		        // 経過時間 >= 待機時間の場合、待機終了。
		        if (spanedSec >= waitSec) {
		 
		            // タイマー停止
		            clearInterval(id);
		 
		            // 完了時、コールバック関数を実行
		            if (callbackFunc) callbackFunc();
		        }
		    }, 1000);
		 
		}
		
		//辞書を作る
		<?php
			//PHPの力を借りる
			$emoji_list_php = glob($webroot."/emoji/*");
			//var_dump($emoji_list_php);
			$i = 0;
			//var_dump($emoji_list_php);
			foreach($emoji_list_php as $emoji_i){
				//フルパスからファイル名だけを貰い、：をつける
				//var_dump($emoji_i);
				$emoji_converted = pathinfo($emoji_i);
				$emoji_list_php[$i] = ":".$emoji_converted['filename'].":";
				$i += 1;
			}
			foreach($suggest_list as $suggest_child){
				$emoji_list_php[$i] = $suggest_child;
				$i += 1;
			}
			$emoji_list_php[$i] = ':emoji_all:';
			$i += 1;
			$emoji_list_php[$i] = ':emoji_all2:';
			$i += 1;
			$emoji_list_php[$i] = ':emoji_all3:';
			$i += 1;
			$emoji_list_php[$i] = ':aa_all:';
			$i += 1;
			$emoji_list_php[$i] = ':aa_all2:';
			$i += 1;
			$emoji_list_php[$i] = '<css_all>';
			$i += 1;
			
			$aa_list_php = glob($webroot."/copypaste/*");
			foreach($aa_list_php as $aa_i){
				//フルパスからファイル名だけを貰い、：をつける
				//var_dump($aa_i);
				$aa_converted = pathinfo($aa_i);
				$emoji_list_php[$i] = ":".$aa_converted['filename'].":";
				$i += 1;
			}
			$cssing_list_php = glob($webroot."/cssing/*");
			foreach($cssing_list_php as $cssing_i){
				//フルパスからファイル名だけを貰い、<>をつける
				//var_dump($cssing_i);
				$cssing_converted = pathinfo($cssing_i);
				$emoji_list_php[$i] = "<".$cssing_converted['filename'].">";
				$i += 1;
			}
			$emoji_output = json_encode($emoji_list_php, JSON_UNESCAPED_UNICODE);
		?>
		var emoji_list = JSON.parse('<?php echo $emoji_output; ?>');
		
		//画面クリックイベント
		document.addEventListener('click', (e) => {
			if(!e.target.closest('.left_profile_a')){
				if(!e.target.closest('.sidebar_hidden_nav')){
					//要素外をクリック
					opt_hid = 0;
					if(document.getElementById("left_hidden") != null){
						document.getElementById("left_hidden").style.display = "none";
					}
				}
			}else{
				//要素内をクリック
				if(opt_hid == 0){
					//オプションを表示
					opt_hid = 1;
					if(document.getElementById("left_hidden") != null){
						document.getElementById("left_hidden").style.display = "block";
					}
				}else{
					//オプションを非表示
					opt_hid = 0;
					if(document.getElementById("left_hidden") != null){
						document.getElementById("left_hidden").style.display = "none";
					}
				}
			}
		})
	</script>
	<script language="JavaScript">
		$(document).ready( function () {
		   $("a[href^='http']:not([href*='" + location.hostname + "'])").attr('target', '_blank');
		})
	</script>
	<?php include $webroot."/start.php"; ?>
	<style id="custom_css">
	</style>
<?php } ?>