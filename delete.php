<?php
  session_start();
  //view.phpとほぼ一緒。

  require('dbconnect.php');



  if (isset($_REQUEST['tweet_id'])) {
    // 返信元のデータ（つぶやきとニックネーム）を取得する
    // $sql = 'SELECT `members`.`nick_name`, `members`.`picture_path`, `tweets`.* FROM `tweets` INNER JOIN `members` on `tweets`.`member_id` = `members`.`member_id` WHERE `tweet_id` = '.$_REQUEST['tweet_id'];

    //delete_flagを1に更新したい
    $sql = 'UPDATE `tweets` SET `delete_flag`=1 WHERE `tweet_id`='.$_REQUEST['tweet_id'];

    mysqli_query($db, $sql) or die(mysqli_error($db));
    header("Location: index.php");
    exit();

    //[@ニックネーム つぶやき]という文字列をセットする
    // $reply_post = '@'.$reply_table['nick_name'].' '.$reply_table['tweet'];
  }





 ?>