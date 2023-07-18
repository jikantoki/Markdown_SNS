<div class="ff_kazu">
	<div class="ff_a_div">
		<a href="/follow&#063;<?php echo $data['id']; ?>" class="ff_a ff_follow">フォロー: <b><?php
			$sql = "select count(*) from follow_list where rand_id_me=:rand_id_me";
			$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
			$params = array(':rand_id_me' => $data['rand_id']); // 挿入する値を配列に格納する
			$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
			if($res){
				$data_follow_kazu = $stmt->fetch();
//					var_dump($data_follow_kazu);			//ユーザー情報丸見えデバッグ
			}
			echo $data_follow_kazu[0];
		?></b>人</a>
	</div>
	<div class="ff_a_div">
		<a href="/follower&#063;<?php echo $data['id']; ?>" class="ff_a ff_follower">フォロワー: <b><?php
			$sql = "select count(*) from follow_list where rand_id_aite=:rand_id_aite";
			$stmt = $pdo->prepare($sql); //挿入する値は空のまま、SQL実行の準備をする
			$params = array(':rand_id_aite' => $data['rand_id']); // 挿入する値を配列に格納する
			$res=$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行
			if($res){
				$data_follower_kazu = $stmt->fetch();
//					var_dump($data);			//ユーザー情報丸見えデバッグ
			}
			echo $data_follower_kazu[0];
		?></b>人</a>
	</div>
</div>