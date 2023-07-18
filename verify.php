<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    define("title","本人確認");
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
				<div class="top_form">
					<h1 class="index_title">本人確認をする</h1>
					<form class="table_mother" action="/verified.php" method="post" name="login_form">
						<table class="table_center">
							<tr class="">
								<p class="form_caution">全項目が必須入力です。<br>このWebサイトの利用に本人確認は必須ではありませんが、本人確認をする事で信頼性を向上させる事が出来ます。</p>
							</tr>
							<tr class="">
								<th class="border" align="right"><label class="form_label" for="verify_url">身分証の画像のURL（表）</label></th>
								<td class="border" align="left"><input class="form_input" type="url" name="verify_url" required></td>
							</tr>
							<tr class="">
								<th class="border" align="right"><label class="form_label" for="verify_url2">身分証の画像のURL（裏）</label></th>
								<td class="border" align="left"><input class="form_input" type="url" name="verify_url2" required></td>
							</tr>
						</table>
						<div class="submit_div">
							<?php
								echo "<input style=\"background-color:var(--accent_color1);\" class=\"form_submit\" type=\"submit\" value=\"本人確認をする\">";
							?>
						</div>
					</form>
				</div>
			</div>
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
