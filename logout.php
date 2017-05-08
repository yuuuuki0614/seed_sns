<?php
	//セッション変数の中身を上書きして空にする。(箱はそのまま中身を消す)
	$_SESSION = array();//これで中身空っぽになる。
	if (ini_get("session.use_cookies")) {//呼び出す情報も削除。
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 420000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
	}
	session_destroy();//箱自体を削除。

	//Cookie情報も削除。
	setcookie('email', '', time() - 3600);
	setcookie('password', '', time() - 3600);

	header("Location: index.php");
	exit();


 ?>