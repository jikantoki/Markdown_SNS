<?php
    $no_title = 1;
	$js_load = 1;
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/meta.php";
	//POSTに文字を入れたらMDにしてechoする
	if(isset($_POST['text'])){
		$s_message = h($_POST['text'][0]);
	}else{
		$s_message =	"# Hello World!\n".
						"* * Hello";
	}
	$s_message = hash_replace($s_message);
	$parser = new \cebe\markdown\GithubMarkdown();
	$parser -> html5 = true;
	$parser->enableNewlines = true;
	$parsed_message = $parser -> parse($s_message);
	
	$cnt = 0;
	$end_flag = 0;
	foreach($genre as $content){
		if(isset($content[2])){
			//言葉狩りを開始
			foreach($content[2] as $content_child){
				//文字列が含まれているか？
				if( mb_stripos($parsed_message,$content_child) != FALSE ){
					$end_flag = $cnt;
					break;
				}
			}
		}
		if($end_flag != 0)break;
		$cnt++;
	}
	
	$jsoned = array(
		'word' => hashtag(cssing(emoji($parsed_message))),
		'old_word' => $parsed_message,
		'genre' => $end_flag,
	);
	echo json_encode($jsoned,JSON_UNESCAPED_UNICODE);
?>