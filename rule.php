<!DOCTYPE html>
<html lang="ja">

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
    <?php
    define("title","利用規約");
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
					<h1 class="index_title" style="font-size: 64px;">利用規約</h1>
					<p class="desp1"><?php echo sitename; ?>の利用規約です。当サイトを利用した時点で、次の利用規約に同意したものとみなします。</p>
					<!-- ルートディレクトリの/rule.mdにマークダウン形式で利用規約を書いてね -->
					<div class="main_word">
						<?php
							$rule = file_get_contents($webroot.'/rule.md');
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
