<?php
  session_start();

  require('dbconnect.php');



  if (isset($_REQUEST['tweet_id'])) {
    // 返信元のデータ（つぶやきとニックネーム）を取得する
    // $sql = 'SELECT `tweets`.`tweet_id`,`members`.`nick_name`, `members`.`picture_path`, `tweets`.`tweet`, `tweets`.`created` FROM `tweets` INNER JOIN `members` on `tweets`.`member_id` = `members`.`member_id` WHERE `tweet_id` = '.$_REQUEST['tweet_id'];

    $sql = 'SELECT `members`.`nick_name`, `members`.`picture_path`, `tweets`.* FROM `tweets` INNER JOIN `members` on `tweets`.`member_id` = `members`.`member_id` WHERE `tweet_id` = '.$_REQUEST['tweet_id'];//SELECT

    $tweets = mysqli_query($db, $sql) or die(mysqli_error($db));
    $tweet_each = mysqli_fetch_assoc($tweets);

    //[@ニックネーム つぶやき]という文字列をセットする
    // $reply_post = '@'.$reply_table['nick_name'].' '.$reply_table['tweet'];
  }





 ?>
















<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SeedSNS</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/form.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

  </head>
  <body>
  <?php include('nav.php'); ?>

  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4 content-margin-top">
        <div class="msg">
          <img src="member_picture/<?php echo $tweet_each['picture_path']; ?>" width="100" height="100">
          <p>投稿者 : <span class="name"> <?php echo $tweet_each['nick_name']; ?>さん </span></p>
          <p>
            つぶやき : <br>
            <?php echo $tweet_each['tweet']; ?>
          </p>
          <p class="day">
            <?php echo $tweet_each['created']; ?><!-- 2016-01-28 18:04 -->
            <?php if ($_SESSION['login_member_id'] == $tweet_each['member_id']) { ?>
            [<a href="delete.php?tweet_id=<?php echo $tweet_each['tweet_id']; ?>" style="color: #F33;">削除</a>]
            <?php } ?>
          </p>
        </div>
        <a href="index.php">&laquo;&nbsp;一覧へ戻る</a>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery-3.1.1.js"></script>
    <script src="assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
