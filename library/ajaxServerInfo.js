let c = "";
function ajaxserverinfo_end(){
	//console.log(c);
	const d = document.getElementById('serverinfo_ajax');
	const d2 = document.getElementById('serverinfo_head_ajax');
	d.innerHTML = c;
	d2.innerHTML = c;
}
function ajaxServerInfo(){
	let ajaxserverinfo = 0;
	$.ajax({
	    contentType: "application/x-www-form-urlencoded; charset=UTF-8",
	    url: "/server_info.php",
	    type: 'POST',
	    datatype: "text",
	    //processData: false,
	    //cache: false,
	    //contentType: false,
	    timeout: 10000
	}).then(function(data){
		c = data;
		//console.log("ajaxServerInfo is OK " + c);
		ajaxserverinfo_end();
	}).fail(function(e){
		c = "<div class='cant_read_serverinfo'>Can't read page.</div>";
		console.log("ajaxServerInfo is Err");
		ajaxserverinfo_end();
	})
}
ajaxServerInfo();