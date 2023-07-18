<!-- クラス名やID名にadsやad_が含まれているとダメらしい -->
<?php
	$noA = 0;
	foreach($noAdsUrl as $nau){
		if($_SERVER['REQUEST_URI'] == $nau){
			$noA = 1;
		}
	}
	if(isset($ad_cnt)){
		$ad_cnt += 1;
	}else{
		$ad_cnt = 0;
	}
	$ads_num = mt_rand(0,3);//0は残しておく、switchは1から使う
	if($noA !== 0){
		$ads_num = 1;
	}
	switch($ads_num){
		case 1:
?>
			<div class="original_azds">
				<h1 class="azds_title">ときえのき（広告）</h1>
				<p class="azds_p">曲を聞け！（自作広告のテストです）</p>
			</div>
	<?php
			break;
		default:
	?>
			<div class="azdspace">
				<!-- Google A_dsenseはここへ -->
				<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8459277046412894"
				     crossorigin="anonymous"></script>
				<ins class="adsbygoogle"
				     style="display:block"
				     data-ad-client="ca-pub-8459277046412894"
				     data-ad-slot="5423811324"
				     data-ad-format="auto"
				     data-full-width-responsive="true"></ins>
				<script>
				     (adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
			<script>
				if(adsBlocked !== 0){
					<?php
						$ad_c = 0;
						while(true){
					?>
							//広告ブロック時の処理
							var adword =	"<div class=\"<?php echo makeRandStr(8); ?>yaju114514 azdblocked\"> \n" +
												"<p class=\"<?php echo makeRandStr(8); ?>yaju114514 azdblocked_p\">Adblock使ってるの滑稽で草</p> \n" +
											"</div>";
							var azds = document.getElementsByClassName('azdspace');
							for(azds2 of azds){
								azds2.innerHTML = adword;
							}
							var pazds = document.getElementsByClassName('post_azds');
							for(pazds2 of pazds){
								pazds2.style.maxHeight = 'none';
							}
							//console.log("azds<?php echo $ad_c; ?> is UZAI, ad_cnt is <?php echo $ad_cnt; ?>");
					<?php
							$ad_c += 1;
							if($ad_c >= $ad_cnt){
								break;
							}
						}
					?>
						document.getElementById('client_info').innerHTML = '<p class="azds_right">Adblock is Enabled!<br>Fxxk!</p>';
				}
			</script>
<?php
	}
	$ads_enum += 1;
?>