<?php
	$db = mysqli_connect('localhost', 'root', '', 'seed_sns') or die(mysqli_connect_error());//mysqlの後にiを忘れずに。(iあるなしはphpのver違い)。「or die」はエラーが出たら終了するという意味。()内はどういうエラーかを表示してくれる。
	mysqli_set_charset($db, 'utf8');//接続情報をUTF8で表示させるよ。この関数のデメリットはmysqlオンリーであること。
	//前の時は接続してデータ取ってきて切断するというのを同じページに書いたが、別のファイルで作ることでdb接続する時に毎回書かずにできるようになる。


 ?>