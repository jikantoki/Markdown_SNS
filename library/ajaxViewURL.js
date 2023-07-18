// ajaxコンテンツ追加処理
function ajaxViewURL(id,url1,url2,r) {
    if(/*viewurl_now[id] == false*/1){
		viewurl_now[id] = true;
	    // 追加コンテンツ
	    var add_content = "";
	    
	    
	    // ajax処理
	    //console.log("ready");
	    $.ajax({
	        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
	        url: "/url_ajax.php",
	        type: 'POST',
	        datatype: "text",
	        timeout: 10000,
	        data:{
	        	'id' : [id] ,
	        	'url1' : [url1] ,
	        	'url2' : [url2] ,
	        }
	    }).then(function(data){
	        // コンテンツ生成
	        //変数dataにjsonファイルの中身が格納される
	        
	        add_content += "<div>"+data+"</div>";
	        // コンテンツ追加
	        document.getElementById("url_view_" + id + r).innerHTML = add_content;
	        // 取得件数を加算してセット
	        //count += 1;
	        //$("#count").val(count);
		    viewurl_now[id] = false;
	    }).fail(function(e){
	        console.log(e);
	        console.log("yee_error_viewurl" + id);
	    	viewurl_now[id] = false;
	    })
    }else{
    	console.log("busy!viewurl" + id);
    }
}
