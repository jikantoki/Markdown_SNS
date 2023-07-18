// ajaxコンテンツ追加処理
if(typeof csserr == 'undefined'){
	var csserr = 1;
}
function ajax_css() {
    // ajax処理
    $.ajax({
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        url: "/library/ajaxCSS.php",
        type: 'POST',
        datatype: "text",
        timeout: 10000,
        data:{
        }
    }).then(function(data){
    	data2 = JSON.parse(data);
    	if(data2.status == 'ok'){
	    	document.getElementById('option_custom_css').innerHTML = data2.content[0];
    		document.getElementById('option_custom_css').disabled = false;
    		csserr = 0;
    	}
    }).fail(function(e){
        console.log(e);
    })
    if(csserr == 1){
    	document.getElementById('option_custom_css').innerHTML = 'データベースエラー';
        console.log("ajaxcss error");
    }
}
function ajax_cssload() {
    // ajax処理
    $.ajax({
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        url: "/library/ajaxCSS.php",
        type: 'POST',
        datatype: "text",
        timeout: 10000,
        data:{
        }
    }).then(function(data){
    	data2 = JSON.parse(data);
    	if(data2.status == 'ok'){
	    	document.getElementById('custom_css').innerHTML = data2.content[0];
    	}
    }).fail(function(e){
    })
}
function css_save() {
	let cssval = document.getElementById('option_custom_css').value;
	
    // ajax処理
    $.ajax({
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        url: "/library/ajaxCSSsave.php",
        type: 'POST',
        datatype: "text",
        timeout: 10000,
        data:{
        	value: [cssval]
        }
    }).then(function(data){
    	console.log('saved!');
    	document.getElementById('custom_css_submit').value = '保存しました！';
    }).fail(function(e){
        console.log(e);
        console.log("ajaxcss save error");
    })
}