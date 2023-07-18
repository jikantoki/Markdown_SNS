if(typeof jsserch_now === 'undefined'){
	var jssearch_now = 0;
}
let url = new URL(window.location.href);
let params = url.searchParams;

// スクロールされた時に実行
$(window).on("scroll", function () {
	// スクロール位置
	var document_h = $(document).height();			  
	var window_h = $(window).height() + $(window).scrollTop();	
	var scroll_pos = (document_h - window_h) / document_h ;   
	
	//console.log("scroll_pos is "+scroll_pos+",document_h is "+document_h+",window_h is "+window_h);
	
	// 画面最下部にスクロールされている場合
	if (scroll_pos <= 0.4) {
		// ajaxコンテンツ追加処理
		//ajaxAddContent();
		//console.warn("yeeeee");
		ajax_search();
	}
});
 
// ajaxコンテンツ追加処理
function ajax_search() {
	if( (typeof last_search == 'undefined') && (document.getElementById('content') != null) ){
		var keyword = params.get('keyword');
		var with_reply = params.get('with_reply');
		var with_img = params.get('with_img');
		var with_inyou = params.get('with_inyou');
		var with_url = params.get('with_url');
		//存在はnull判定する
		if( ((keyword !== null) && (keyword !== '')) || (with_reply !== '') || (with_img !== '') || (with_inyou !== '') || (with_url !== '') ){
			if(jssearch_now == false){
				jssearch_now = true;
				// 追加コンテンツ
				var add_content = "";
				// コンテンツ件数		   
				var count2 = $("#count").val();
				var count = parseInt(count2);
				if(document.getElementById("unixtime") != null){
					var unixtime = $("#unixtime").val();
				}else{
					var unixtime = 0;
				}
				
				let element2 = document.getElementById('content');
				
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
						'jscount' : [String(count)] ,
						'worldortop_id' : ['0'] ,
						'unixtime' : [String(unixtime)],
						'search' : ['1'],
						'keyword' : [keyword],
						'with_reply' : [with_reply],
						'with_img' : [with_img],
						'with_inyou' : [with_inyou],
						'with_url' : [with_url],
						'url' : [location.href]
					}
				}).then(function(data){
					add_content += "<div class=\"jsload jsload_search\">"+data+"</div>";
					// コンテンツ追加
					$("#content").append(add_content);
					//element2.appendChild(add_content);
					// 取得件数を加算してセット
					count += 1
					$("#count").val(count);
					jssearch_now = false;
					if(document.getElementsByClassName('search_nothing')[0] == 'undefined'){
						if(window.innerHeight * 4 + window.scrollY * 2 > document.getElementById('content').clientHeight){
							if(typeof last_search == 'undefined'){
								ajax_search();
							}
						}
					}else{
						break;
						return false;
					}
				}).fail(function(e){
					console.log(e);
					console.log("search yee_error");
					jssearch_now = false;
					if(window.innerHeight * 4 + window.scrollY * 2 > document.getElementById('content').clientHeight){
						if(typeof last_search == 'undefined'){
							ajax_search();
						}
					}
				})
			}else{
				console.log("search busy!count is " + $("#count").val());
			}
		}
	}
}

function ajax_asearch(followOnly = 0){
	var keyword = params.get('keyword');
	if( ((keyword !== null) && (keyword !== '')) || (with_reply !== '') || (with_img !== '') || (with_inyou !== '') || (with_url !== '') ){
		// 追加コンテンツ
		var add_content = "";
		$.ajax({
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			url: "/library/ajaxAccountSearch.php",
			type: 'POST',
			datatype: "text",
			timeout: 10000,
			data:{
				'keyword' : [keyword],
				'followOnly' : [followOnly]
			}
		}).then(function(data){
			add_content = '<div class="ac_search_child">' + data + '</div>';
			document.getElementById('account_content').innerHTML = add_content;
		}).fail(function(e){
			console.log(e);
			console.log("Ac search yee_error");
			ajax_asearch(followOnly);
		})
	}
}