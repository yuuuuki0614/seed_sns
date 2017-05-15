<?php 
	session_start();

  require('dbconnect.php');



  if (isset($_REQUEST['tweet_id'])) {
    $sql = 'SELECT `members`.`nick_name`, `members`.`picture_path`, `tweets`.* FROM `tweets` INNER JOIN `members` on `tweets`.`member_id` = `members`.`member_id` WHERE `tweet_id` = '.$_REQUEST['tweet_id'];//SELECT

    $reply = mysqli_query($db, $sql) or die(mysqli_error($db));
    $reply_table = mysqli_fetch_assoc($reply);

    //[@ニックネーム つぶやき]という文字列をセットする
    // $reply_post = '@'.$reply_table['nick_name'].' '.$reply_table['tweet'];
  }

 ?>

<!-- view.phpからコピペして編集 -->
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
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><span class="strong-title"><i class="fa fa-twitter-square"></i> Seed SNS</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                <li><a href="logout.php">ログアウト</a></li>
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4 content-margin-top">
        <div class="msg">
          <img src="member_picture/<?php echo $reply_table['picture_path']; ?>" width="100" height="100">
          <p>投稿者 : <span class="name"> <?php echo $reply_table['nick_name']; ?>さん </span></p>
          <p>
            つぶやき : <br>
            <form>
            	<textarea></textarea>
            	<input type="" name="">
            </form>
          </p>
          <p class="day">
            <?php echo $reply_table['created']; ?><!-- 2016-01-28 18:04 -->
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