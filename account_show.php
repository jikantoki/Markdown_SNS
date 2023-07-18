<?php
	if(isset($_SESSION['id'])){
		echo "<div>";
			echo "<a href=\"/u?".$data_me['id']."\"><img class=\"top_profile_img\" src=\"".$data_me['icon_url']."\"></a>";
		echo "</div>";
		echo "<div class=\"ul_profile_text\">";
			echo "<a class=\"ul_profile\" href=\"/u?".$data_me['id']."\">".$displayname_me."</a>";
			echo "<a class=\"ul_profile_id\" href=\"/u?".$data_me['id']."\">ID:".$data_me['id']."</a>";
		echo "</div>";
		echo "<div class=\"logout_button\">";
			echo "<a style=\"--color:".$caution_color1.";\" class=\"logout_a\" href=\"/logout\">ログアウト</a>";
		echo "</div>";
	}else{
		echo "<div>";
			echo "<a href=\"/login\"><img class=\"top_profile_img\" src=\"/img/account_default.png\"></a>";
		echo "</div>";
		echo "<div class=\"ul_profile_text\">";
			echo "<a class=\"ul_profile\" href=\"/login\">ログイン</a>";
			echo "<a class=\"ul_profile_id\" href=\"/registar\">初めての方は登録</a>";
		echo "</div>";
		echo "<div class=\"logout_button\">";
	//		echo "<a style=\"--color:".$caution_color1.";\" class=\"logout_a\" href=\"/logout\">ログアウト</a>";
		echo "</div>";
	}
?>