<button id="installButton" class="btn btn-success d-none" type="button">
		アプリをインストールする
</button>
<div class="topbar">
	
	
	<?php
		//戻るボタンを表示
		//リファラが同一ドメインなら戻る、外部サイトならindexへ
		if(isset($_SERVER['HTTP_REFERER'])){
			$ref = $_SERVER['HTTP_REFERER'];
			$url = parse_url($ref);
			$ref_domain = $url['host'];
		}else{
			$ref_domain = '';
		}
			
		$host_name = $_SERVER['HTTP_HOST'];
		$url = parse_url($host_name);
		$host_domain = $url['path'];
		
		if(strcmp($ref_domain,$host_domain) == 0){
			$href = $ref;//同一ドメインなので、リファラに戻るボタン
		}else{
			$href = '/';
		}
		//echo $ref_domain;
		$href_code = "<a href='".$href."' ";
		if(isset($noback_button)){
			$href_code = $href_code."style='visibility:hidden;width:4px;' ";
		}
		$href_code = $href_code."class=\"backbutton\">←</a>";
		echo $href_code;
		
		//トップとかポストとか表示
		if(!isset($topbar_str))$topbar_str = title;
		echo "<p class='titlecall' id='titlecall'>".$topbar_str."</p>";
	?>
</div>