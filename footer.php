<!-- フッターやで -->
<div class="footer_body">
	<div class="footer_main">
		<div class="footer_left left_content">
			<?php include $webroot."/adsense.php"; ?>
			<script>
				console.log('after adsense cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
			</script>
		</div>
		<div class="footer_body_child">
			<div class="footer_body_p">
				<p>Created by <a target="_blank" class="footer_links" href="https://github.com/jikantoki/MDSNS"><?php echo projectname; ?></a></p><small translate="no">&copy; <?php echo producer; ?></small>
			</div>
			<div class="mobile">
				<?php /*include $webroot."/adsense.php";*/ ?>
			</div>
		</div>
		<div class="footer_right right_content">
			<?php /*include $webroot."/adsense.php";*/ ?>
		</div>
	</div>
			<script>
				console.log('after footermain cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
			</script>
</div>
<?php if( (!isset($no_post_button)) && (isset($data_me['id'])) ){ ?>
	<div class="post_mobile">
		<!-- モバイル表示時にポストボタンを表示 -->
		<a class="post_mobile_a" onclick="post_left()">
			<img src="/img/post.svg">
		</a>
	</div>
<?php } ?>
			<script>
				console.log('before mobile cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
			</script>
<div class="mobile">
	<!-- モバイル表示時のナビゲーションボタン -->
	<div class="mobile_under_button">
		<div class="mobile_under_box">
			<a class="under_a" href="/" id="footer_top" onclick="cacheClear('<?php echo $top_url.'/'; ?>');">
				<div class="under_home">
					<!-- ホームボタン -->
					<svg>
						<use xlink:href="/img/home.svg#svg"></use>
					</svg>
				</div>
			</a>
			<?php if(isset($_SESSION['id'])){ ?>
				<a class="under_a" href="/world" id="footer_world" onclick="cacheClear('<?php echo $top_url.'/world'; ?>');">
					<div class="under_notif">
						<!-- ワールド -->
					<svg>
						<use xlink:href="/img/world.svg#svg"></use>
					</svg>
					</div>
				</a>
			<?php } ?>
			<a class="under_a" href="/search" id="footer_search">
				<div class="under_search">
					<!-- 検索 -->
					<svg>
						<use xlink:href="/img/search.svg#svg"></use>
					</svg>
				</div>
			</a>
			<?php if(isset($_SESSION['id'])){ ?>
				<a class="under_a" href="/notif" id="footer_notif">
					<div class="under_notif">
						<!-- 通知 -->
					<svg>
						<use xlink:href="/img/notif.svg#svg"></use>
					</svg>
					</div>
				</a>
				<!--<a class="under_a" href="/dm" id="footer_dm">
					<div class="under_dm">
						<!-- DM --><!--
					<svg>
						<use xlink:href="/img/dm.svg#svg"></use>
					</svg>
					</div>
				<!--</a>-->
				<a class="under_a" href="/u?<?php echo $data_me['id']; ?>" id="footer_profile" onclick="cacheClear('<?php echo $top_url.'/u?'.$data_me['id'].'&post'; ?>');">
					<div class="under_account">
						<!-- マイアカウント -->
						<img class="under_myaccount <?php if(isset($under_myaccount_round))echo "under_myaccount_round"; ?>" loading="lazy" src="<?php echo $data_me['icon_url']; ?>" onerror="this.src='/img/noimage.jpg'">
					</div>
				</a>
			<?php }else{ ?>
				<a class="under_a" href="/login">
					<div class="under_account">
						<!-- ログインしろ -->
						<img class="under_myaccount" src="/img/account_default.png" loading="lazy">
					</div>
				</a>
			<?php } ?>
		</div>
	</div>
</div>
			<script>
				console.log('after mobile cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
			</script>
<script src="/library/lightbox/src/js/lightbox.js" type="text/javascript"></script>
<script src="/library/ajaxServerInfo.js"></script>
	<script>
		console.log('after dom cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
	</script>
<?php /* pjaxで読み込むもの、body>div.mainの最後に実行 */?>
<?php if(/*!isset($pjax_load)*/1){ ?>
	<script>
		lightbox.option({
			'alwaysShowNavOnTouchDevices' : true,
			'fadeDuration' : 100,
			'imageFadeDuration' : 100,
			'resizeDuration' : 100,
			'wrapArround' : true
		})
		const replaceHeadTags = target => {
		  const head = document.head
		  const targetHead = target.html.match(/<head[^>]*>([\s\S.]*)<\/head>/i)[0]
		  const newPageHead = document.createElement('head')
		  newPageHead.innerHTML = targetHead
		  const removeHeadTags = [
		    "meta[name='keywords']",
		    "meta[name='description']",
		    "meta[property^='fb']",
		    "meta[property^='og']",
		    "meta[name^='twitter']",
		    "meta[name='robots']",
		    'meta[itemprop]',
		    'link[itemprop]',
		    "link[rel='prev']",
		    "link[rel='next']",
		    "link[rel='canonical']",
		  ].join(',')
		  const headTags = [...head.querySelectorAll(removeHeadTags)]
		  headTags.forEach(item => {
		    head.removeChild(item)
		  })
		  const newHeadTags = [...newPageHead.querySelectorAll(removeHeadTags)]
		  newHeadTags.forEach(item => {
		    head.appendChild(item)
		  })
		}
		console.log('before left_menu_activate cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
		
		//画面左側の拡張
		function left_menu_activate(){
			if(document.getElementById("left_top").classList.contains("left_active")){
				let doc1 = document.getElementById("left_top");
				let doc2 = document.getElementById("footer_top");
				doc1.classList.remove("left_active");
				doc2.classList.remove("under_active");
			}
			if(document.getElementById("left_world") != null){
				if(document.getElementById("left_world").classList.contains("left_active")){
					let doc1 = document.getElementById("left_world");
					let doc2 = document.getElementById("footer_world");
					doc1.classList.remove("left_active");
					doc2.classList.remove("under_active");
				}
			}
			if(document.getElementById("left_profile") != null){
				if(document.getElementById("left_profile").classList.contains("left_active")){
					let doc1 = document.getElementById("left_profile");
					let doc2 = document.getElementById("footer_profile");
					doc1.classList.remove("left_active");
					doc2.classList.remove("under_active");
				}
			}
			if(document.getElementById("left_search").classList.contains("left_active")){
				let doc1 = document.getElementById("left_search");
				let doc2 = document.getElementById("footer_search");
				doc1.classList.remove("left_active");
				doc2.classList.remove("under_active");
			}
			if(document.getElementById("left_notif") != null){
				if(document.getElementById("left_notif").classList.contains("left_active")){
					let doc1 = document.getElementById("left_notif");
					let doc2 = document.getElementById("footer_notif");
					doc1.classList.remove("left_active");
					doc2.classList.remove("under_active");
				}
			}
			/*
			if(document.getElementById("left_dm") != null){
				if(document.getElementById("left_dm").classList.contains("left_active")){
					let doc1 = document.getElementById("left_dm");
					let doc2 = document.getElementById("footer_dm");
					doc1.classList.remove("left_active");
					doc2.classList.remove("under_active");
				}
			}
			*/
			
			console.log("Location Pathname is "+location.pathname);
			
			if(location.pathname == '/'){
				let doc1 = document.getElementById("left_top");
				let doc2 = document.getElementById("footer_top");
				doc1.classList.add("left_active");
				doc2.classList.add("under_active");
			}else if(location.pathname == '/world'){
				let doc1 = document.getElementById("left_world");
				let doc2 = document.getElementById("footer_world");
				doc1.classList.add("left_active");
				doc2.classList.add("under_active");
			<?php if(isset($data_me)){ ?>
				}else if((location.pathname == '/u') && (location.search == '?<?php echo $data_me["id"]; ?>')){
					let doc1 = document.getElementById("left_profile");
					let doc2 = document.getElementById("footer_profile");
					doc1.classList.add("left_active");
					doc2.classList.add("under_active");
			<?php } ?>
			}else if(location.pathname == '/search'){
				let doc1 = document.getElementById("left_search");
				let doc2 = document.getElementById("footer_search");
				doc1.classList.add("left_active");
				doc2.classList.add("under_active");
			}else if(location.pathname == '/notif'){
				let doc1 = document.getElementById("left_notif");
				let doc2 = document.getElementById("footer_notif");
				doc1.classList.add("left_active");
				doc2.classList.add("under_active");
			}/*else if(location.pathname == '/dm'){
				let doc1 = document.getElementById("left_dm");
				let doc2 = document.getElementById("footer_dm");
				doc1.classList.add("left_active");
				doc2.classList.add("under_active");
			}*/
		}
		left_menu_activate();
		console.log('after left_menu_activate cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
		(function(){
		  // テキストボックスのDOMを取得
		  if(document.getElementById("post_textarea") != null){
			  const username = document.getElementById("post_textarea");
			  // 活性/非活性を切り替えるボタンのDOMを取得
			  const button = document.getElementById("id_post_submit");
			  // 入力テキストのキーアップイベント
			  console.log("button disable is active");
			  username.addEventListener('keyup', function() {
			    // テキストボックスに入力された値を取得
			    const text = username.value;
			    //console.log(text);
			    // テキストが入力されている場合
			    if(text != '') {
			      // ボタンのdisabled属性を取り除く
			      button.disabled = null;
			    } else {
			      // ボタンにdisabledを設定する
			      button.disabled = "disabled";
			    }
			  })
		  }
		}());
		(function(){
		  // テキストボックスのDOMを取得
		  if(document.getElementById("post_textarea_left") != null){
			  const usernamel = document.getElementById("post_textarea_left");
			  // 活性/非活性を切り替えるボタンのDOMを取得
			  const buttonl = document.getElementById("id_post_submit_left");
			  const button2 = document.getElementById("id_post_submit_left_top");
			  // 入力テキストのキーアップイベント
			  console.log("button disable is active_left");
			  usernamel.addEventListener('keyup', function() {
			    // テキストボックスに入力された値を取得
			    const textl = usernamel.value;
			    //console.log(text);
			    // テキストが入力されている場合
			    if(textl != '') {
			      // ボタンのdisabled属性を取り除く
			      buttonl.disabled = null;
			      button2.disabled = null;
			    } else {
			      // ボタンにdisabledを設定する
			      buttonl.disabled = "disabled";
			      button2.disabled = "disabled";
			    }
			  })
		  }
		}());
		
		console.log('before cachedontsave cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
		//aタグを押すとキャッシュが保存される
		var cacheDontSave = 0;
		function cacheSave(){
			if(document.getElementById('pjax') != null){
				if(cacheDontSave == 0){
					let lh = location.href;//lhの値をキー名にしてキャッシュを保存
					let sd = document.getElementById('pjax').innerHTML;
					let sy = window.scrollY;
					localStorage.setItem(lh, sd);
					localStorage.setItem('scroll' + lh, sy);
				}
			}else{
				console.log('pjax非対応ページ');
			}
		}
		function cacheClear(url){
			cacheDontSave = 1;
			let lh = location.href;
			localStorage.removeItem('http://' + url);
			localStorage.removeItem('http://' + 'scroll' + url);
			localStorage.removeItem('https://' + url);
			localStorage.removeItem('https://' + 'scroll' + url);
			console.log(url + ' :::cache removed');
		}
		console.log('after cachedontsave cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
		//下のスクリプトで既存のページにはonclickにcachesaveを割り当てられた
		//スクロール後に読み込む部分は、onclick='cacheSave()'の書き込みが必須
		var a = document.querySelectorAll("a");
		a.forEach(function(target){
			target.addEventListener('click',function(){
				cacheSave();
			});
		});
		console.log('after footer_child cookie=' + document.cookie.split('; ').find(row => row.startsWith('id')));
		
		//右クリックメニューの設定
	    /*window.onload = function(){
	        bodyzoom = document.getElementsByTagName('body');
	        bodyzoom_val = getComputedStyle(bodyzoom[0]).zoom;
	        //console.log("Zoom is " + bodyzoom_val);
	        document.body.addEventListener('contextmenu',function (e){
	            document.getElementById('contextmenu').style.left=(e.clientX/bodyzoom_val)+"px";
	            document.getElementById('contextmenu').style.top=(e.clientY/bodyzoom_val)+"px";
	            console.log("pagey="+e.pageY+".pagex="+e.pageX+",bpdyzoom_val="+bodyzoom_val);
	            document.getElementById('contextmenu').style.display="block";
	        });
	        document.body.addEventListener('click',function (e){
	            document.getElementById('contextmenu').style.display="none";
	        });
	        window.addEventListener('scroll',function (){
	            document.getElementById('contextmenu').style.display="none";
	        });
	    }
	    function resize(){
	        bodyzoom = document.getElementsByTagName('body');
	        bodyzoom_val = getComputedStyle(bodyzoom[0]).zoom;
	        //console.log("resize!");
	    }
	    window.addEventListener('resize',function(){
	    	resize();
	    });
	    document.oncontextmenu = function () {return false;}
	    function menu1(){
	        alert("menu1がクリックされました。");
	    }
	    function menu2(){
	        alert("menu2がクリックされました。");
	    }
	    function menu3(){
	        alert("menu3がクリックされました。");
	    }*/
	</script>
<?php } ?>