<div class="profile_button">
	<?php
		if(isset($_SESSION['id'])){
			//ID�ƃZ�b�V�����������ꍇ�Ƀv���t�B�[���ҏW��\��
			if(strcmp($_SESSION['id'],$data["session_id"]) == 0){
				echo "<a href=\"/edit\"><img class=\"profile_setting\" src=\"/img/setting_colored.png\"></a>";
			}
		}else{
			//ID������`�i���O�C�����ĂȂ��ꍇ�j�̎��̏���
		}
		//echo $_SESSION['id'];
		//echo $data["id"];
	?>
</div>