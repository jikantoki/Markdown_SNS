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
        ajax_add_reply();
    }
});
/*const allHeight = Math.max(
  document.body.scrollHeight, document.documentElement.scrollHeight,
  document.body.offsetHeight, document.documentElement.offsetHeight,
  document.body.clientHeight, document.documentElement.clientHeight
);
const mostBottom = allHeight - window.innerHeight;
//window.addEventListener('scroll', ()=> {
$(window).on("scroll", function () {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    console.log(scrollTop);
    console.warn(mostBottom)
    if (scrollTop >= mostBottom - 100) {
        // 最下部に到達したときに実行する処理
        ajax_add_content();
    }
});*/
 
// ajaxコンテンツ追加処理
function ajax_add_reply() {
    if(jsload_now_rep == false){
		jsload_now_rep = true;
	    // 追加コンテンツ
	    var add_content = "";
	    // コンテンツ件数           
	    var count2 = $("#count_reply").val();
	    var count = parseInt(count2);
	    //console.log("count is "+count);
	    var worldtop_id = '0';
	    //console.log(worldtop_id);
	    /*if(document.getElementById("unixtime") != null){
		    var unixtime = $("#unixtime").val();
		}else{
			var unixtime = 0;
		}*/
	    
	    let post_id = document.getElementById('post_id').value;
	    let element2 = document.getElementById('content_reply');
	    var reply_flag = 1;
	    
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
	        	'post_id' : [String(post_id)],
	        	'reply_flag' : [String(reply_flag)]
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
	        add_content += "<div class=\"jsload\">"+data+"</div>";
	        // コンテンツ追加
	        $("#content_reply").append(add_content);
	        //element2.appendChild(add_content);
	        // 取得件数を加算してセット
	        count += 1;
	        $("#count_reply").val(count);
		    jsload_now_rep = false;
	    }).fail(function(e){
	        console.log(e);
	        console.log("yee_error");
	    	jsload_now_rep = false;
	    })
    }else{
    	console.log("busy!count_reply is " + $("#count_reply").val());
    }
}
$(document).ready( function () {
   $("a[href^='http']:not([href*='" + location.hostname + "'])").attr('target', '_blank');
})