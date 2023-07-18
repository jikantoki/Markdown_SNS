// ajax_good処理
if(typeof ajaxgood == 'undefined')var ajaxgood = 0;
function good(content) {
    if(ajaxgood == 0){
    	ajaxgood = 1;
	    $.ajax({
	        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
	        url: "/library/good.php",
	        type: 'POST',
	        datatype: "text",
	        //processData: false,
	        //cache: false,
	        //contentType: false,
	        timeout: 10000,
	        data:{
	        	'id' : [content],
	        	'good_or_bad' : ['good']
	        }
	    }).then(function(data){
			const dt = JSON.parse(data);
			const cn = document.getElementsByClassName('good_' + dt.content);
			const cn_ar = Array.from(cn);
			const gcn = document.getElementsByClassName('good_kazu_' + dt.content);
			const gcn_ar = Array.from(gcn);
			const svg = document.getElementsByClassName('good_svg_' + dt.content);
			const svg_ar = Array.from(svg);
			if(dt.action == 'add'){
				cn_ar.forEach((element, index) => {
					element.classList.add('good_active');
				});
				gcn_ar.forEach((element, index) => {
					let gcni = element.innerHTML;
					element.innerHTML = 1 + parseInt(gcni, 10);
				});
				svg_ar.forEach((element, index) => {
					element.innerHTML="<use xlink:href='/img/gooded.svg#svg'></use>";
				});
			}else if(dt.action == 'remove'){
				cn_ar.forEach((element, index) => {
					element.classList.remove('good_active');
				});
				gcn_ar.forEach((element, index) => {
					let gcni = element.innerHTML;
					element.innerHTML = -1 + parseInt(gcni, 10);
				});
				svg_ar.forEach((element, index) => {
					element.innerHTML="<use xlink:href='/img/good.svg#svg'></use>";
				});
			}
			console.log(data);
			ajaxgood = 0;
	    }).fail(function(e){
	        console.log(e);
	        console.log("ajaxgood_error");
	    	ajaxgood = 0;
	    })
    }else{
    	console.log("ajaxgood is busy!");
    }
}

// ajax_seyana処理
if(typeof ajaxseyana == 'undefined')var ajaxseyana = 0;
function seyana(content) {
    if(ajaxseyana == 0){
    	ajaxseyana = 1;
	    $.ajax({
	        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
	        url: "/library/good.php",
	        type: 'POST',
	        datatype: "text",
	        //processData: false,
	        //cache: false,
	        //contentType: false,
	        timeout: 10000,
	        data:{
	        	'id' : [content],
	        	'good_or_bad' : ['seyana']
	        }
	    }).then(function(data){
			const dt = JSON.parse(data);
			const cn = document.getElementsByClassName('seyana_' + dt.content);
			const cn_ar = Array.from(cn);
			const gcn = document.getElementsByClassName('seyana_kazu_' + dt.content);
			const gcn_ar = Array.from(gcn);
			if(dt.action == 'add'){
				cn_ar.forEach((element, index) => {
					element.classList.add('seyana_active');
				});
				gcn_ar.forEach((element, index) => {
					let gcni = element.innerHTML;
					element.innerHTML = 1 + parseInt(gcni, 10);
				});
			}else if(dt.action == 'remove'){
				cn_ar.forEach((element, index) => {
					element.classList.remove('seyana_active');
				});
				gcn_ar.forEach((element, index) => {
					let gcni = element.innerHTML;
					element.innerHTML = -1 + parseInt(gcni, 10);
				});
			}
			console.log(data);
			ajaxseyana = 0;
	    }).fail(function(e){
	        console.log(e);
	        console.log("ajaxseyana_error");
	    	ajaxseyana = 0;
	    })
    }else{
    	console.log("ajaxseyana is busy!");
    }
}