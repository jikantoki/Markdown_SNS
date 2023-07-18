// ajaxコンテンツ追加処理
function ajax_text2md() {
    if(/*text2md_now == false*/true){
		text2md_now = true;
	    // 追加コンテンツ
	    var add_content = "";
	    // コンテンツ           
	    var content = $("#post_textarea").val();
	    if(content == null || content == ''){
	    	content = "";
	    }
	    //console.log("count is "+count);
	    
	    //let element2 = document.getElementById('content');
	    
	    // ajax処理
	    //console.log("ready");
	    $.ajax({
	        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
	        url: "/library/text2md.php",
	        type: 'POST',
	        datatype: "text",
	        //processData: false,
	        //cache: false,
	        //contentType: false,
	        timeout: 10000,
	        data:{
	        	'text' : [content]
	        }
	    }).then(function(data){
	        // コンテンツ生成
	        //console.log("yeeeeeeeeeeeeee");
	        data2 = JSON.parse(data);
	        //echo data.content;
	        /*$.each(data,function(key, val){
	        	console.log("yee2");
	            add_content += "<div>"+val.content+"</div>";
	        })*/
	        // コンテンツ追加
	        $("#post_previewarea").html(data2.word);
	        if(data2.genre != 0){
	        	console.log("Genre is " + data2.genre);
	        	document.getElementById('form_genre').options[data2.genre].selected = true;
	        }
	        if(data2.word == ''){
	        	document.getElementById('form_genre').options[0].selected = true;
	        	document.getElementById('post_preview').style.display = 'none';
	        }else if(data2.word + '\n' != data2.old_word){
	        	document.getElementById('post_preview').style.display = 'block';
	        }
	        //element2.appendChild(add_content);
		    text2md_now = false;
	    }).fail(function(e){
	        console.log(e);
	        console.log("yee_error");
	    	text2md_now = false;
	    })
    }else{
    	console.log("text2md is busy!");
    }
}
if(text2md_once == 0){
	ajax_text2md();
	text2md_once = 1;
}

// ajaxコンテンツ追加処理_left
function ajax_text2md_left() {
    if(/*text2md_now_left == false*/true){
		text2md_now_left = true;
	    // 追加コンテンツ
	    var add_content = "";
	    // コンテンツ           
	    var content = $("#post_textarea_left").val();
	    if(content == null || content == ''){
	    	content = "";
	    }
	    //console.log("count is "+count);
	    
	    //let element2 = document.getElementById('content');
	    
	    // ajax処理
	    //console.log("ready");
	    $.ajax({
	        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
	        url: "/library/text2md.php",
	        type: 'POST',
	        datatype: "text",
	        //processData: false,
	        //cache: false,
	        //contentType: false,
	        timeout: 10000,
	        data:{
	        	'text' : [content]
	        }
	    }).then(function(data){
	        // コンテンツ生成
	        //console.log("yeeeeeeeeeeeeee");
	        data2 = JSON.parse(data);
	        //echo data.content;
	        /*$.each(data,function(key, val){
	        	console.log("yee2");
	            add_content += "<div>"+val.content+"</div>";
	        })*/
	        // コンテンツ追加
	        $("#post_previewarea_left").html(data2.word);
	        if(data2.genre != 0){
	        	console.log("Genre left is " + data2.genre);
	        	document.getElementById('form_genre_left').options[data2.genre].selected = true;
	        }
	        if(data2.word == ''){
	        	document.getElementById('form_genre_left').options[0].selected = true;
	        	document.getElementById('post_preview_left').style.display = 'none';
	        }else if(data2.word + '\n' != data2.old_word){
	        	document.getElementById('post_preview_left').style.display = 'block';
	        }
	        //element2.appendChild(add_content);
		    text2md_now_left = false;
	    }).fail(function(e){
	        console.log(e);
	        console.log("yee_error_left");
	    	text2md_now_left = false;
	    })
    }else{
    	console.log("text2md is busy!_left");
    }
}
if(text2md_once_left == 0){
	ajax_text2md_left();
	text2md_once_left = 1;
}