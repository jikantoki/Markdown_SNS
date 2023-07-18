<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    define("title","ログイン");
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
					<h1 class="index_title">ログイン</h1>
					<form class="table_mother" action="/userinfo.php" method="post" name="login_form">
						<table class="table_center">
							<tr class="">
								<p class="form_caution">全項目が必須入力です。</p>
							</tr>
							<tr class="">
								<th class="border" align="right"><label class="form_label" for="id">ID</label></th>
								<td class="border" align="left"><input class="form_input" type="text" name="id" required></td>
							</tr>
							<tr class="">
								<th class="border" align="right"><label class="form_label" for="mail">メールアドレス</label></th>
								<td class="border" align="left"><input class="form_input" type="email" name="mail" required></td>
							</tr>
							<tr class="">
								<th class="border" align="right"><label class="form_label" for="pass">パスワード</label></th>
								<td class="border" align="left"><input class="form_input" type="password" name="pass" required></td>
							</tr>
						</table>
						<div class="submit_div">
							<?php
								echo "<input style=\"background-color:var(--accent_color1);\" class=\"form_submit\" type=\"submit\" value=\"ログイン\">";
							?>
						</div>
					</form>
				</div>
			</div>
			<hr class="form_after">
			<p class="form_or_p"><a class="form_or" href="/registar">初めての方は、会員登録</a></p>
			<p class="form_or_p"><a class="form_or" href="/pwreset">パスワードを忘れた方はこちら</a></p>
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
