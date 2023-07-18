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
        ajax_userpost();
    }
});

if(typeof userpost_now == 'undefined')var userpost_now = false;

// ajaxコンテンツ追加処理
function ajax_userpost() {
    //存在はnull判定する
    if(userpost_now == false){
		userpost_now = true;
		var id = document.getElementById('for_ajaxUser').value;
	    // 追加コンテンツ
	    var add_content = "";
	    // コンテンツ件数           
	    var count2 = $("#up_count").val();
	    var count = parseInt(count2);
	    
	    let element2 = document.getElementById('up_content');
	    
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
	        	'unixtime' : [0],
	        	'search' : ['1'],
	        	'keyword' : [''],
	        	'id' : [id],
	        	'with_reply' : [''],
	        	'with_img' : [''],
	        	'with_inyou' : [''],
	        	'with_url' : [''],
	        	'url' : [''],
	        	'withrepost' : ['']
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
	        add_content += "<div class=\"jsload jsload_search\">"+data+"</div>";
	        // コンテンツ追加
	        $("#up_content").append(add_content);
	        //element2.appendChild(add_content);
	        // 取得件数を加算してセット
	        count += 1
	        $("#up_count").val(count);
		    userpost_now = false;
			if(document.getElementsByClassName('search_nothing')[0] == 'undefined'){
			    if(window.innerHeight * 4 + window.scrollY * 2 > document.getElementById('tab_content').clientHeight){
			    	ajax_userpost();
			    }
			}else{
				return;
			}
	    }).fail(function(e){
	        console.log(e);
	        console.log("search userpost yee_error");
	    	userpost_now = false;
		    if(window.innerHeight * 4 + window.scrollY * 2 > document.getElementById('tab_content').clientHeight){
		    	ajax_userpost();
		    }
	    })
    }else{
    	console.log("userpost busy!count is " + $("#up_count").val());
    }
}