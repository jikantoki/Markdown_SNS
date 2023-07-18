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
		ajax_add_content();
	}
});
 
// ajaxコンテンツ追加処理
function ajax_add_content() {
	if(jsload_now == false){
		jsload_now = true;
		// 追加コンテンツ
		var add_content = "";
		// コンテンツ件数		   
		var count2 = $("#count").val();
		var count = parseInt(count2);
		//console.log("count is "+count);
		var worldtop_id = $("#worldortop_id").val();
		//console.log(worldtop_id);
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
				'worldortop_id' : [String(worldtop_id)] ,
				'unixtime' : [String(unixtime)]
			}
		}).then(function(data){
			// 取得件数を加算してセット
			var counta2 = $("#count").val();
			var counta = parseInt(counta2);
			if(counta <= count){
				count += 1
				$("#count").val(count);
				add_content += "<div class=\"jsload\">"+data+"</div>";
				// コンテンツ追加
				$("#content").append(add_content);
			}
			
			jsload_now = false;
			if(document.getElementById('content') != null){
				if(window.innerHeight * 4 + window.scrollY * 2 > document.getElementById('content').clientHeight){
					ajax_add_content();
				}
			}else{
				if(window.innerHeight * 4 + window.scrollY * 2 > document.getElementById('tab_content').clientHeight){
					ajax_add_content();
				}
			}
		}).fail(function(e){
			console.log(e);
			console.log("yee_error");
			jsload_now = false;
			if(document.getElementById('content') != null){
				if(window.innerHeight * 4 + window.scrollY * 2 > document.getElementById('content').clientHeight){
					ajax_add_content();
				}
			}else{
				if(window.innerHeight * 4 + window.scrollY * 2 > document.getElementById('tab_content').clientHeight){
					ajax_add_content();
				}
			}
		})
	}else{
		console.log("busy!count is " + $("#count").val());
	}
}
function ajax_add_content_once(id){
	var add_content = "";
	$.ajax({
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		url: "/sent_content2.php",
		type: 'POST',
		datatype: "text",
		timeout: 10000,
		data:{
			'jscount' : ['0'] ,
			'worldortop_id' : ['0'] ,
			'post_id' : [String(id)],
			'once' : ['1']
		}
	}).then(function(data){
		add_content += "<div class=\"jsload\">"+data+"</div>";
		if(document.getElementById('content') != null){
			document.getElementById("content").innerHTML = add_content + document.getElementById("content").innerHTML;
		}else{
			document.getElementById("tab_content").innerHTML = add_content + document.getElementById("tab_content").innerHTML;
		}
	}).fail(function(e){
		console.log(e);
		console.log("ajax_add_content_once_error");
		ajax_add_content_once(id);
	})
}