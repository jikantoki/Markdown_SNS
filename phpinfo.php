<h1>動作確認用ページ</h1>
<p>全て有効じゃないと動きません</p>
<p>Ueni Kaitearu Nihongo Yomenakattara Setting Machigaidane!</p>
PHPバージョン:<?php echo phpversion(); ?><br>
GD:<?php if(function_exists('imagecreatetruecolor')){ echo '有効'; }else{ echo '無効'; } ?><br>
JavaScript:<span id="js_ok" style="display: none;">有効</span><span id="js_ng">無効</span>
<script>
	var d = document;
	d.getElementById('js_ok').style.display = 'unset';
	d.getElementById('js_ng').style.display = 'none';
</script>