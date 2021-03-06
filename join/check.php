<?php
session_start();
//ここの情報はPOST送信されてないからPOSTは使えない。（index.phpで結果をもう一度index.phpを読み込んでから、check.phpに移動するようになっている。。コメントはsession_startより後に書く！！

//dbconnect.phpを読み込む
require('../dbconnect.php');


//セッションにデータがなかったらindex.phpへ遷移するようにする。
if (!isset($_SESSION['join'])) { //joinが存在してなかったら。
  header("Location: index.php"); //遷移先。
  exit(); //下記はやらずここで終了の意味。（index.phpに移動するが処理が続けられるので移動できずにエラーになることがある）
}


    $nick_name = htmlspecialchars($_SESSION['join']['nick_name'], ENT_QUOTES, 'UTF-8');
    //  ←「,ENT_QUOTES, 'UTF-8'」つけといた方が無難。

    //   if ($nick_name == '') {
    //     $nick_name_result = 'ニックネームが入力されていません。';
    //   } else {
    //     $nick_name_result = 'ようこそ' . $nick_name .'様';
    //   }
    // echo '<br>';

    $email=htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES, 'UTF-8');
    //   if ($email == '') {
    //     $email_result = 'メールアドレスが入力されていません。';
    //   } else {
    //     $email_result = 'メールアドレス：' . $email;
    //   }
    // echo '<br>'


    $picture_path = htmlspecialchars($_SESSION['join']['picture_path'], ENT_QUOTES, 'UTF-8');
    //ファイル名にも危ない文字が入ってるかもしれないのでサニタイジングしておく。

    //DB登録処理
    if (!empty($_POST)) {
      $sql = sprintf('INSERT INTO `members` (`nick_name`, `email`, `password`, `picture_path`, `created`, `modified`) VALUES ("%s", "%s", "%s", "%s", now(), now());',
        mysqli_real_escape_string($db,$_SESSION['join']['nick_name']),
        mysqli_real_escape_string($db,$_SESSION['join']['email']),
        mysqli_real_escape_string($db,sha1($_SESSION['join']['password'])),
        mysqli_real_escape_string($db,$_SESSION['join']['picture_path'])
        );
      //insert文の原型をphpMyAdminから持ってくると楽。「`member_id`, 」「NULL,」を消す。「日付」のところと「CURRENT_TIMESTAMP」をnow()に変える。「sprintf()」を頭につける(文の書式を整える)。さらにこうすることで、「,」で区切った前と後ろを同じ順で当て込める。適当に入れた「'aaaaaaaa'」とかを４つとも消して「"%s"」(＝何か入るよ(文字列を代入)。サニタイジングとか色々加えたいので直では書いていない。)に置き換える。
      //$_SESSIONの前に「mysqli_real_escape_string()」をつけてdbををサニタイジングする(MySQLで使用する特殊文字をエスケープ)。サニタイズしたい文字を指定するので、まとめて書けない。
      //$_SESSION['join']['password']を「sha1」(暗号化)で囲む。→phpMyAdminのpasswordにやたら長い文字が表示される。



      //dbを実行する。
      mysqli_query($db, $sql) or die(mysqli_error($db));
      //うまくいったら移動する処理を書く。
      header("Location: thanks.php");
      exit();
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
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="../assets/css/form.css" rel="stylesheet">
    <link href="../assets/css/timeline.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
    <!--
      designフォルダ内では2つパスの位置を戻ってからcssにアクセスしていることに注意！
     -->

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
              <a class="navbar-brand" href="index.html"><span class="strong-title"><i class="fa fa-twitter-square"></i> Seed SNS</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4 content-margin-top">
        <form method="post" action="" class="form-horizontal" role="form">
          <input type="hidden" name="action" value="submit">
          <div class="well">ご登録内容をご確認ください。</div>
            <table class="table table-striped table-condensed">
              <tbody>
                <!-- 登録内容を表示 -->
                <tr>
                  <td><div class="text-center">ニックネーム</div></td>
                  <td><div class="text-center"><?php echo $nick_name; ?></div></td>
                </tr>
                <tr>
                  <td><div class="text-center">メールアドレス</div></td>
                  <td><div class="text-center"><?php echo $email; ?></div></td>
                </tr>
                <tr>
                  <td><div class="text-center">パスワード</div></td>
                  <td><div class="text-center">●●●●●●●●</div></td>
                </tr>
                <tr>
                  <td><div class="text-center">確認用パスワード</div></td>
                  <td><div class="text-center">●●●●●●●●</div></td>
                </tr>
                <tr>
                  <td><div class="text-center">プロフィール画像</div></td>
                  <td><div class="text-center">
                  <!-- 元々のやつ<img src="http://c85c7a.medialib.glogster.com/taniaarca/media/71/71c8671f98761a43f6f50a282e20f0b82bdb1f8c/blog-images-1349202732-fondo-steve-jobs-ipad.jpg" width="100" height="100"> -->

                  <img src="../member_picture/<?php echo $picture_path; ?>"  width="100" height="100">
                  <!-- <img src="../member_picture/<?php echo $_SESSION['join']['picture_path']; ?>"  width="100" height="100"> -->

                  <!-- <?php echo $fileName; ?> -->
                  <!-- <?php echo $picture_path; ?> -->
                  

                  </div></td>
                </tr>
              </tbody>
            </table>
            <!-- ?action=rewriteをつけることで見分けをつくようにしてから戻る（URLが少し変わる）＝GET送信する！これがGET送信であるということは決まりなので覚えとくしかない、、。 -->
            <a href="index.php?action=rewrite">&laquo;&nbsp;書き直す</a>
            <input type="submit" class="btn btn-default" value="会員登録">
            <!-- formタグのmethod="post" action=""で、post送信するようになっていて、同じページに戻る(?)ようになっている。-->
          </div>
        </form>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../assets/js/jquery-3.1.1.js"></script>
    <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="../assets/js/bootstrap.js"></script>
  </body>
</html>
