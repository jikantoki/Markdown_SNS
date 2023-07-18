if(typeof jsnotif_now === 'undefined'){
	var jsnotif_now = 0;
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
        ajax_notif();
    }
});
 
// ajaxコンテンツ追加処理
function ajax_notif() {
    if(jsnotif_now == false){
		jsnotif_now = true;
	    // 追加コンテンツ
	    var add_content = "";
	    // コンテンツ件数           
	    var count2 = $("#count").val();
	    var count = parseInt(count2);
	    
	    // ajax処理
	    $.ajax({
	        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
	        url: "/library/ajaxNotif.php",
	        type: 'POST',
	        datatype: "text",
	        //processData: false,
	        //cache: false,
	        //contentType: false,
	        timeout: 10000,
	        data:{
	        	'jscount' : [String(count)]
	        }
	    }).then(function(data){
	        add_content += "<div class=\"jsnotif\">"+data+"</div>";
	        // コンテンツ追加
	        $("#content").append(add_content);
	        //element2.appendChild(add_content);
	        // 取得件数を加算してセット
	        count += 1
	        $("#count").val(count);
		    jsnotif_now = false;
		    if(window.innerHeight * 4 + window.scrollY * 2 > document.getElementById('content').clientHeight){
		    	ajax_notif();
		    }
	    }).fail(function(e){
	        console.log(e);
	        console.log("notif yee_error");
	    	jsnotif_now = false;
		    if(window.innerHeight * 4 + window.scrollY * 2 > document.getElementById('content').clientHeight){
		    	ajax_notif();
		    }
	    })
    }else{
    	console.log("notif busy!count is " + $("#count").val());
    }
}