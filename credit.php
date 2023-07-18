<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    define("title","クレジット");
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
				<!-- ここに本文を入力 -->
				<div class="top_rule">
					<h1 class="index_title" style="font-size: 64px;">クレジット</h1>
					<p class="desp1"><?php echo sitename; ?>を作るときにお世話になったもの/人のリストです。</p>
					<!-- ルートディレクトリの/credit.mdにマークダウン形式でクレジットを書いてね -->
					<div class="main_word">
						<?php
							$rule = file_get_contents($webroot.'/credit.md');
							$parser = new \cebe\markdown\GithubMarkdown();
							$parser -> html5 = true;
							$parser->enableNewlines = true;
							$creditword = $parser -> parse($rule);
							echo emoji($creditword);
						?>
					</div>
				</div>
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
    include $webroot."/footer.php";
    ?>
    </footer>
</body>

</html>
