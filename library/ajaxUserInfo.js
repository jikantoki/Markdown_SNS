// ajaxコンテンツ追加処理
function ajax_userinfo(id) {
	var username = id;
    // 追加コンテンツ
    var add_c = "";
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
        url: "/library/ajaxUserInfo.php",
        type: 'POST',
        datatype: "text",
        timeout: 10000,
        data:{
        	'name' : [username]
        }
    }).then(function(data){
        // コンテンツ生成
        //console.log("yeeeeeeeeeeeeee");
        data = JSON.parse(data);
        // コンテンツ追加
        //document.getElementById("content").innerHTML = add_c;
        document.getElementById('forajax_user_dispname').innerHTML = data.name;
        document.getElementById('forajax_user_id').innerHTML = data.id;
        document.getElementById('ui_message').innerHTML = data.message;
        document.getElementById('ui_icon').src = data.icon_url;
        
        
        if(document.getElementById('ui_message').clientHeight >= 350){
        	document.getElementById('u_showmore').style.display = 'block';
        	document.getElementById('ui_message').style.marginBottom = '0';
        }
    }).fail(function(e){
        console.log(e);
        console.log("userinfo yee_error");
    })
}
//セキュアな方
function ajax_userinfo_s(){
    return $.ajax({
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        url: "/library/ajaxUserInfoS.php",
        type: 'POST',
        datatype: "text",
        timeout: 10000,
        data:{
        }
    }).done(function(data, textStatus, jqXHR){
    	//console.log(data === jqXHR.responseJSON);
    	//console.log(data.message);
    }).fail(function(e){
        console.log(e);
        console.log("userinfoS yee_error");
    })
}