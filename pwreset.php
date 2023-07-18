<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    define("title","パスワードをリセット");
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/meta.php";
    ?>
</head>

<body>
    <header>
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/header.php";
    ?>
    </header>
	<main>
	<div class="col">
		<div class="left_menu">
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/left.php";
    ?>
    	</div>
		<div class="main_c">
			<div class="top_form_mother">
				<div class="top_form top_form_center">
					<h1 class="index_title">パスワードをリセット</h1>
					<form class="table_mother" action="/reset_request.php" method="post" name="login_form">
						<table class="table_center">
							<tr class="">
								<p class="form_caution">パスワードをリセットします。メールアドレスによる認証が必須です。</p>
							</tr>
							<tr class="">
								<th class="border" align="right"><label class="form_label" for="id">ID</label></th>
								<td class="border" align="left"><input class="form_input" type="text" name="id" required></td>
							</tr>
							<tr class="">
								<th class="border" align="right"><label class="form_label" for="mail">メールアドレス</label></th>
								<td class="border" align="left"><input class="form_input" type="email" name="mail" required></td>
							</tr>
						</table>
						<div class="submit_div">
							<?php
								echo "<input style=\"background-color:var(--accent_color1);\" class=\"form_submit\" type=\"submit\" value=\"リクエストの送信\">";
							?>
						</div>
					</form>
				</div>
			</div>
			<hr class="form_after">
			<!--<p class="form_or_p"><a class="form_or" href="registar">アカウント登録</a></p>-->
		</div>
		<div class="right_menu">
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    include $webroot."/right.php";
    ?>
		</div>
	</div>
	<div class="space"></div>
	</main>
    <footer>
        <?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    $no_post_button = 1;
    include $webroot."/footer.php"
    ?>
    </footer>
</body>

</html>
