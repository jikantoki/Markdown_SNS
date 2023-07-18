// pjaxで読み込むもの、phpファイルだけどjsのみ記述可能
console.log("reset now");
ajax_add_content();
twemoji.parse(document.body);
document.getElementById("count").value = '0';
if(document.getElementById("post_textarea") != null){
	document.getElementById("post_option").style.display = "none";
	document.getElementById("post_preview").style.display = "none";	//デフォルトでプレビューを非表示
	//サジェスト設定
	function startSuggest() {
	  new Suggest.LocalMulti(
	        "post_textarea",    // 入力のエレメントID
	        "suggest", // 補完候補を表示するエリアのID
	        emoji_list,      // 補完候補の検索対象となる配列
	        {dispMax: 10, interval: 300, prefix: false, highlight: true, dispAllLey: true, classMouseOver: 'select'}); // オプション
	}
	//jQuery('#post_textarea<?php if($post_left != 0){echo '_left';} ?>').twemojiPicker();
}
//辞書をスタート
window.addEventListener ?
  window.addEventListener('DOMContentLoaded', startSuggest, false) :
  window.attachEvent('onload', startSuggest);
$(document).ready( function () {
   $("a[href^='http']:not([href*='" + location.hostname + "'])").attr('target', '_blank');
})

if(typeof left_menu_activate == 'function'){
	left_menu_activate();
}
(function(){
  // テキストボックスのDOMを取得
  if(document.getElementById("post_textarea") != null){
	  const username = document.getElementById("post_textarea");
	  // 活性/非活性を切り替えるボタンのDOMを取得
	  const button = document.getElementById("id_post_submit");
	  // 入力テキストのキーアップイベント
	  console.log("button disable is active");
	  username.addEventListener('keyup', function() {
	    // テキストボックスに入力された値を取得
	    const text = username.value;
	    //console.log(text);
	    // テキストが入力されている場合
	    if(text) {
	      // ボタンのdisabled属性を取り除く
	      button.disabled = null;
	    } else {
	      // ボタンにdisabledを設定する
	      button.disabled = "disabled";
	    }
	  })
  }
}());
(function(){
  // テキストボックスのDOMを取得
  if(document.getElementById("post_textarea_left") != null){
	  const username = document.getElementById("post_textarea_left");
	  // 活性/非活性を切り替えるボタンのDOMを取得
	  const button = document.getElementById("id_post_submit_left");
	  const button2 = document.getElementById("id_post_submit_left_top");
	  // 入力テキストのキーアップイベント
	  console.log("button disable is active_left");
	  username.addEventListener('keyup', function() {
	    // テキストボックスに入力された値を取得
	    const text = username.value;
	    //console.log(text);
	    // テキストが入力されている場合
	    if(text) {
	      // ボタンのdisabled属性を取り除く
	      button.disabled = null;
	      button2.disabled = null;
	    } else {
	      // ボタンにdisabledを設定する
	      button.disabled = "disabled";
	      button2.disabled = "disabled";
	    }
	  })
  }
}());
	jQuery( function($) {
	    $('tbody tr[data-href]').addClass('clickable').click( function() {
	        window.location = $(this).attr('data-href');
	    }).find('a').hover( function() {
	        $(this).parents('tr').unbind('click');
	    }, function() {
	        $(this).parents('tr').click( function() {
	            window.location = $(this).attr('data-href');
	        });
	    });
	});
$(document).ready( function () {
   $("a[href^='http']:not([href*='" + location.hostname + "'])").attr('target', '_blank');
})