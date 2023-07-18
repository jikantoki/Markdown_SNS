<div class="profile_button">
	<?php
		if(isset($_SESSION['id'])){
			//IDとセッションが同じ場合にプロフィール編集を表示
			if(strcmp($_SESSION['id'],$data["session_id"]) == 0){
				echo "<a href=\"/edit\"><img class=\"profile_setting\" src=\"/img/setting_colored.png\"></a>";
			}
		}else{
			//IDが未定義（ログインしてない場合）の時の処理
		}
		//echo $_SESSION['id'];
		//echo $data["id"];
	?>
</div>