<?php
    $webroot = $_SERVER['DOCUMENT_ROOT'];
    $no_title = 1;
    $js_load = 1;
    include $webroot."/meta.php";
    include $webroot."/header.php";
?>
<div class="server_info_mother">
	<h2 class="side_title">サーバー情報</h2>
	<?php
		$time2 = time() - ( 60 * 60 * 24 );//一日前のunixtime
		$time3 = time() - ( 60 * 60 * 24 * 30 );//一ヶ月前のunixtime
		$sql = "select count(*) from users_list";
		$q = $pdo -> query($sql);
		$human_kazu = $q -> fetchAll(PDO::FETCH_BOTH);
		$sql = "select count(*) from sent_list where sent_time>".$time2;
		$q = $pdo -> query($sql);
		$oneday_post = $q -> fetchAll(PDO::FETCH_BOTH);
		$sql = "select count(*) from sent_list where sent_time>".$time3;
		$q = $pdo -> query($sql);
		$onemonth_post = $q -> fetchAll(PDO::FETCH_BOTH);
		$sql = "select count(*) from sent_list;";
		$q = $pdo -> query($sql);
		$all_post = $q -> fetchAll(PDO::FETCH_BOTH);
		$sql = "select access_cnt from server_info limit 1;";
		$q = $pdo -> query($sql);
		$acnt = $q -> fetchAll(PDO::FETCH_BOTH);
	?>
	<div class="server_info">
		<table class="jinkou">
			<tbody>
				<tr>
					<td class="j_one">サーバー人口</td>
					<td class="j_two"><?php echo $human_kazu[0][0]; ?>人</td>
				</tr>
				<tr>
					<td class="j_one">過去24時間の投稿数</td>
					<td class="j_two"><?php echo $oneday_post[0][0]; ?>件</td>
				</tr>
				<tr>
					<td class="j_one">過去30日間の投稿数</td>
					<td class="j_two"><?php echo $onemonth_post[0][0]; ?>件</td>
				</tr>
				<tr>
					<td class="j_one">過去全ての投稿数</td>
					<td class="j_two"><?php echo $all_post[0][0]; ?>件</td>
				</tr>
				<tr>
					<td class="j_one">アクセスカウンター</td>
					<td class="j_two"><?php echo $acnt[0][0]; ?>アクセス</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>