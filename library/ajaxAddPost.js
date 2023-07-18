// ajaxコンテンツ追加処理
function ajax_add_post() {
    if(jsload_now == false){
		jsload_now = true;
	    // 追加コンテンツ
	    var add_content = "";
	    // コンテンツ件数           
	    //var count2_post = $("#count").val();
	    //var count_post = parseInt(count2);
	    //console.log("count is "+count);
	    var worldtop_id = '0';
	    //console.log(worldtop_id);
	    let post_id = document.getElementById('post_id').value;
	    console.log("ID is " + post_id);
	    
	    let element2 = document.getElementById('content_post');
	    
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
	        	'jscount' : ['0'] ,
	        	'worldortop_id' : [String(worldtop_id)] ,
	        	'post_id' : [String(post_id)],
	        	'with_good_data' : ['1'],
	        	'no_showmore' : ['1'],
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
	        if(data == ''){
	        	window.location.href = '/';
	        }
	        add_content += "<div class=\"jsload\">"+data+"</div>";
	        // コンテンツ追加
	        document.getElementById("post_content").innerHTML = add_content;
	        //element2.appendChild(add_content);
	        // 取得件数を加算してセット
	        //count += 1;
	        //$("#count").val(count);
		    jsload_now = false;
	    }).fail(function(e){
	        console.log(e);
	        console.log("yee_error");
	    	jsload_now = false;
	    })
    }else{
    	console.log("busy!post");
    }
}

$(document).ready( function () {
   $("a[href^='http']:not([href*='" + location.hostname + "'])").attr('target', '_blank');
})