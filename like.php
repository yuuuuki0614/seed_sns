<?php
	session_start();//loginしてる人のmemberIDを知りたい

	//delete.phpを参考にいいね機能を作ってみよう！

	require('dbconnect.php');

	if (isset($_REQUEST['tweet_id'])) {
		//GET送信されたtweet_idを取得
		$tweet_id = $_REQUEST['tweet_id'];

		//SQL文作成（likesテーブルのINSERT文）
		$sql = sprintf('INSERT INTO `likes` (`member_id`, `tweet_id`) VALUES (%d,%d);',$_SESSION['login_member_id'],$tweet_id);


		//SQL実行
		mysqli_query($db, $sql) or die(mysqli_error($db));

		//一覧のページに戻る（index.php）
		header("Location: index.php");
	    exit();

    }




 ?>