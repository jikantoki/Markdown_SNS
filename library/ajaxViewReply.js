// ajaxコンテンツ追加処理
function ajax_view_reply() {
    if(viewreply_now == false){
		viewreply_now = true;
	    // 追加コンテンツ
	    var add_content = "";
	    var worldtop_id = '0';
	    let post_id = document.getElementById('form_reply_left').value;
	    let post_inyou_id = document.getElementById('form_inyou_left').value;
	    
	    
	    // ajax処理
	    //console.log("ready");
	    if(post_id != ''){
		    $.ajax({
		        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		        url: "/sent_content2.php",
		        type: 'POST',
		        datatype: "text",
		        timeout: 10000,
		        data:{
		        	'jscount' : ['0'] ,
		        	'worldortop_id' : [String(worldtop_id)] ,
		        	'post_id' : [String(post_id)],
		        	'no_showmore' : ['1'],
		        	'no_post_hannou' : ['1'],
		        	'no_mother_post' : ['1'],
		        	'no_view_url' : ['1'],
		        }
		    }).then(function(data){
		        // コンテンツ生成
		        //変数dataにjsonファイルの中身が格納される
		        
		        add_content += "<div>"+data+"</div>";
		        // コンテンツ追加
		        document.getElementById("show_reply_left").innerHTML = add_content;
		        document.getElementById("post_close_title").innerHTML = 'リプライ';
		        // 取得件数を加算してセット
		        //count += 1;
		        //$("#count").val(count);
			    //viewreply_now = false;
		    }).fail(function(e){
		        console.log(e);
		        console.log("yee_error_viewreply");
		    	//viewreply_now = false;
		    })
		}else{
		        document.getElementById("show_reply_left").innerHTML = '';
		        document.getElementById("post_close_title").innerHTML = '';
		}
		add_content = "";
	    if(post_inyou_id != ''){
		    $.ajax({
		        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
		        url: "/sent_content2.php",
		        type: 'POST',
		        datatype: "text",
		        timeout: 10000,
		        data:{
		        	'jscount' : ['0'] ,
		        	'worldortop_id' : [String(worldtop_id)] ,
		        	'post_id' : [String(post_inyou_id)],
		        	'no_showmore' : ['1'],
		        	'no_post_hannou' : ['1'],
		        	'no_mother_post' : ['1'],
		        	'no_view_url' : ['1'],
		        }
		    }).then(function(data){
		        // コンテンツ生成
		        //変数dataにjsonファイルの中身が格納される
		        
		        add_content += "<div>"+data+"</div>";
		        // コンテンツ追加
		        document.getElementById("show_inyou_left").innerHTML = add_content;
		        document.getElementById("post_close_title").innerHTML = '引用リポスト';
		        // 取得件数を加算してセット
		        //count += 1;
		        //$("#count").val(count);
			    viewreply_now = false;
		    }).fail(function(e){
		        console.log(e);
		        console.log("yee_error_viewinyou");
		    	viewreply_now = false;
		    })
		}else{
		        document.getElementById("show_inyou_left").innerHTML = '';
		        document.getElementById("post_close_title").innerHTML = '';
		    	viewreply_now = false;
		}
    }else{
    	console.log("busy!viewreply");
    }
}
