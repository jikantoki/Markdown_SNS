<? /*
レイヤーで表示されるpost
デフォはdisplay:none;
*/ ?>
<div class="post_left_mother" id="post_left_mother" style="display: none;" onclick="post_left()">
	<div class="post_left_child" id="post_left_child">
		<div class="post_close">
			<div class="post_close_button topbar post_close_flex">
				<a class="post_close_a backbutton" onclick="post_left()">×</a>
				<div class="post_close_title" id="post_close_title"></div>
				<input style="background-color:var(--hover_color2);color:#eeeeee!important;" class="form_submit form_submit_left" id="id_post_submit_left_top" onclick="ajax_sent_post_left();" type="button" value="ポスト" disabled></a>
			</div>
		</div>
		<div class="show_reply_left" id="show_reply_left">
			<?php /* ここにリプなら元ツイとか表示する */ ?>
		</div>
		<div class="top_form_mother top_form_margin top_postor_fix">
			<div class="post_img post_img_margin">
				<a href="u?<?php echo $data_me['id']; ?>">
					<img class="post_img" src="<?php echo $data_me['icon_url']; ?>" width="100px" loading="lazy">
				</a>
			</div>
			<div class="postor">
				<?php
					$small = 1;
					$post_left = 1;
					include $webroot."/postor.php";
					unset($small);
					unset($post_left);
				?>
			</div>
		</div>
	</div>
</div>
<script src="/library/ajaxViewReply.js"></script>