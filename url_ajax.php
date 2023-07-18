<?php
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
	
	if(!isset($getPageTitle1)){
		function getPageTitle($url){
		    static $regex = '@<title>([^<]++)</title>@i';
		    static $order = 'ASCII,JIS,UTF-8,CP51932,SJIS-win';
		    static $ch;
		    if(!$ch){
		        $ch = curl_init();
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    }
		    curl_setopt($ch, CURLOPT_URL, $url);
		    $html = mb_convert_encoding(curl_exec($ch), 'UTF-8', $order);
		    return preg_match($regex, $html, $m) ? $m[1] : '';
		}
		$getPageTitle1 = 1;
	}
	if(!isset($url_ajax_phpinclude)){
		function h($s) {
			return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
		}
		if( filter_var( $_POST['url1'][0], FILTER_VALIDATE_URL ) ){
			//これはURL
			$link1 = $_POST['url1'][0];
		}else{
			//これはURLではない
			$link1 = '';
		}
		if( filter_var( $_POST['url2'][0], FILTER_VALIDATE_URL ) ){
			//これはURL
			$link2 = $_POST['url2'][0];
		}else{
			//これはURLではない
			$link2 = '';
		}
		$url_cnt = 0;
		if(strcmp($link1,'') != 0){
			//use WWW::Favicon qw/detect_favicon_url/;
			$url_cnt = 1;
			//$meta1 = @get_meta_tags($link1);
			$ogp_file1 = mb_convert_encoding(file_get_contents($link1), "utf-8", "auto");
			preg_match('/<meta property="og:image" content="(.*?)"/', $ogp_file1, $ogpimg1);
			preg_match('/<meta property="og:title" content="(.*?)"/', $ogp_file1, $ogptitle1);
			preg_match('/<meta property="og:description" content="(.*?)"/', $ogp_file1, $ogpdesc1);
			preg_match('/<title>(.*?)<\/title>/i', $ogp_file1, $ogptitlesub1);
			if(isset($ogpimg1[1])){
				$og_image1 = $ogpimg1[1];
			}else{
				$og_image1 = '/img/link.png';
			}
			if(!isset($ogptitle1[1])){
				$gh1 = @get_http_status_code($link1);
				if($gh1 === false){
					$gh1a = '(404 Not found)';
				}elseif($gh1 === 200){
					$gh1a = '(LINK)';
				}else{
					$gh1a = '('.$gh1.')';
				}
				$link1_1 = parse_url($link1);
				$ogptitle1[1] = $gh1a.'外部URL:'.$link1_1['host'];
				if(isset($ogptitlesub1[1])){
					$ogptitle1[1] = $ogptitlesub1[1];
				}else{
					$ogptitle1n = getPageTitle($link1);
					if($ogptitle1n != ''){
						$ogptitle1[1] = $ogptitle1n;
					}
				}
			}
			if(!isset($ogpdesc1[1])){
				$ogpdesc1[1] = 'このURLの詳細情報を取得できませんでした。';
			}
			if(strcmp($link2,'') != 0){
				$url_cnt = 2;
				//$meta2 = get_meta_tags($link2);
				$ogp_file2 = mb_convert_encoding(file_get_contents($link2), "utf-8", "auto");
				preg_match('/<meta property="og:image" content="(.*?)"/', $ogp_file2, $ogpimg2);
				preg_match('/<meta property="og:title" content="(.*?)"/', $ogp_file2, $ogptitle2);
				preg_match('/<meta property="og:description" content="(.*?)"/', $ogp_file2, $ogpdesc2);
				preg_match('/<title>(.*?)<\/title>/i', $ogp_file2, $ogptitlesub2);
				if(isset($ogpimg2[1])){
					$og_image2 = $ogpimg2[1];
				}else{
					$og_image2 = '/img/link.png';
				}
				if(!isset($ogptitle2[1])){
					$gh2 = @get_http_status_code($link2);
					if($gh2 === false){
						$gh2a = '(404 Not found)';
					}else{
						$gh2a = '('.$gh2.')';
					}
					$link2_1 = parse_url($link2);
					$ogptitle2[1] = $gh2a.'外部URL:'.$link2_1['host'];
					if(isset($ogptitlesub2[1])){
						$ogptitle2[1] = $ogptitlesub2[1];
					}else{
						$ogptitle2n = getPageTitle($link2);
						if($ogptitle2n != ''){
							$ogptitle2[1] = $ogptitle2n;
						}
					}
				}
				if(!isset($ogpdesc2[1])){
					$ogpdesc2[1] = 'このURLの詳細情報を取得できませんでした。';
				}
			}
		}
	}else{
		//phpのincludeによる読み込み
		if( filter_var( $data_content['sent_sankou_link1'], FILTER_VALIDATE_URL ) ){
			//これはURL
			$link1 = $data_content['sent_sankou_link1'];
		}else{
			//これはURLではない
			$link1 = '';
		}
		if( filter_var( $data_content['sent_sankou_link2'], FILTER_VALIDATE_URL ) ){
			//これはURL
			$link2 = $data_content['sent_sankou_link2'];
		}else{
			//これはURLではない
			$link2 = '';
		}
		$url_cnt = 0;
		if(strcmp($link1,'') != 0){
			$url_cnt = 1;
			$og_image1 = '/img/link.png';
			$ogptitle1[1] = 'Loading...';
			$ogpdesc1[1] = '少々お待ちください…';
			if(strcmp($link2,'') != 0){
				$url_cnt = 2;
				$og_image2 = '/img/link.png';
				$ogptitle2[1] = 'Loading...';
				$ogpdesc2[1] = '少々お待ちください…';
				
			}
		}
	}
?>
<?php if((!isset($no_view_url))&&($url_cnt != 0)){ ?>
	<!-- URLを表示 -->
	<div class="url_view_cover">
		<a class="url_view_a" href="<?php try{echo $link1;}catch(Exception $e){} ?>" target="_blank">
			<div class="url_view" <?php if($url_cnt == 2)echo 'style="border-bottom: solid 1px var(--hover_color1);"'; ?>>
				<div class="url_view_img_cover">
					<img class="url_view_img" src="<?php echo h($og_image1); ?>" loading="lazy" onerror="this.src='/img/link.png'">
				</div>
				<div class="url_view_title_desc">
					<div class="url_view_title">
						<p><?php echo h($ogptitle1[1]); ?></p>
					</div>
					<div class="url_view_url">
						<p><?php echo h($link1); ?></p>
					</div>
					<div class="url_view_desc">
						<p><?php echo h($ogpdesc1[1]); ?></p>
					</div>
				</div>
			</div>
		</a>
		<?php if($url_cnt == 2){ ?>
			<a class="url_view_a" href="<?php try{echo $link2;}catch(Exception $e){} ?>" target="_blank">
				<div class="url_view">
					<div class="url_view_img_cover">
						<img class="url_view_img" src="<?php echo h($og_image2); ?>" loading="lazy" onerror="this.src='/img/link.png'">
					</div>
					<div class="url_view_title_desc">
						<div class="url_view_title">
							<p><?php echo h($ogptitle2[1]); ?></p>
						</div>
						<div class="url_view_url">
							<p><?php echo h($link2); ?></p>
						</div>
						<div class="url_view_desc">
							<p><?php echo h($ogpdesc2[1]); ?></p>
						</div>
					</div>
				</div>
			</a>
		<?php } ?>
	</div>
<?php } ?>