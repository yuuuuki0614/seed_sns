<?php
    session_start();
    require('dbconnect.php');

    //自動ログイン処理(login成功した後にするのでpasswordは必ず入力されている)
    if (isset($_COOKIE['email']) && !empty($_COOKIE['email'])) {
      //COOKIEに保存されているログイン情報が、入力されてPOST送信されてきたかのように$_POSTに値を代入する
      $_POST['email'] = $_COOKIE['email'];
      $_POST['password'] = $_COOKIE['password'];
      $_POST['save'] = 'on';
    }



    //post送信されていたら、emailとパスワードの入力チェックを行い、どちらかが（あるいは両方とも）未入力の場合、「メールアドレスとパスワードを入力してください」とpassword入力欄の下に表示する。
    //error['login']にblankの文字をセットして判別できるようにする。

    if(!empty($_POST)){//ログインボタンを押した時に初めてpost送信が行われる！
      //email
      // if($_POST['email']==''){  ←←←これよりemptyの方が強度高い(空文字以外にもnullや0も感知してくれる)
      if(empty($_POST['email'])){
        $error['login']='blank';//今初めて$errorも'login'も作り、'blank'を代入した。
      }
      //password(空チェック)
      if(empty($_POST['password'])){
        $error['login']='blank';
      }

      if(empty($error)) {
        //ログイン処理
        //入力されたemail,passwordでDBから会員情報を取得できたら正常ログイン、
        //取得できなかったら$error['login']にfaildを代入して、パスワードの下に「ログインに失敗しました。正しく入力してください」とエラーメッセージを表示する。
        // $sql='';//SELECT文を記述！！(WHERE句を使う)
        $sql = sprintf('SELECT * FROM `members` WHERE `email` = "%s" AND `password` = "%s"',//INSERT INTOとは書き方が少し違うので注意。
        mysqli_real_escape_string($db,$_POST['email']),
        mysqli_real_escape_string($db,sha1($_POST['password'])));



        //SQL実行
        $record = mysqli_query($db, $sql) or die(mysqli_error($db));
        if ($table = mysqli_fetch_assoc($record)) {//「=」は１つ！$recordと&tableは勝手につけた名前。
          //ログイン成功
          //(1)SESSION変数に会員idを保存したい。
          $_SESSION['login_member_id'] = $table['member_id'];//$tableの方はカラム名。

          //(2)SESSION変数にログイン時間を記録。
          $_SESSION['time'] = time();//mysqlはnow()やけどphpはtime()になる。

          //自動ログインonの場合cookieにログイン情報を保存する
          if ($_POST['save'] == 'on') {
            //setcookie(保存するキー,保存する値,保存する期間(秒))
            setcookie('email', $_POST['email'], time() + 60*60*24*14);
            setcookie('password', $_POST['password'], time() + 60*60*24*14);
          }

          //(3)ログイン後のindex.php(トップページ)に遷移。
          header("Location: index.php");
          exit();

        }else{
          //ログイン失敗
          $error['login']='faild';
        }
      }
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
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3 content-margin-top">
        <legend>ログイン</legend>
        <form method="post" action="" class="form-horizontal" role="form">
          <!-- メールアドレス -->
          <div class="form-group">
            <label class="col-sm-4 control-label">メールアドレス</label>
            <div class="col-sm-8">
              <!-- <input type="email" name="email" class="form-control" placeholder="例： seed@nex.com"> -->


              <?php if (isset($_POST['email'])): ?>
                 <input type="email" name="email" class="form-control" placeholder="例： seed@nex.com" value="<?php echo htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'); ?>">
              <?php else: ?>
                       <input type="email" name="email" class="form-control" placeholder="例： seed@nex.com" value="">
              <?php endif; ?>


            </div>
          </div>
          <!-- パスワード -->
          <div class="form-group">
            <label class="col-sm-4 control-label">パスワード</label>
            <div class="col-sm-8">
              <input type="password" name="password" class="form-control" placeholder="">


              <!-- <?php if(isset($error['email']) && $error['email']=='blank'){ ?>
              <p class="error">* emailを入力してください</p>
              <?php } ?>

              <?php if(isset($error['password']) && $error['password']=='blank'){ ?>
              <p class="error">* passwordを入力してください</p>
              <?php } ?> -->


              <?php if(isset($error['login']) && $error['login']=='blank'){ ?>
              <p class="error">* メールアドレスとpasswordを入力してください</p>
              <?php } ?>

              <?php if(isset($error['login']) && $error['login']=='faild'){ ?>
              <p class="error">* ログインに失敗しました。正しく入力してください</p>
              <?php } ?>


            </div>
          </div>
          <!-- 自動ログインのチェックボックス -->
          <div class="form-group">
              <label class="col-sm-4 control-label">自動ログイン</label>
              <div class="col-sm-8">
                 <input type="checkbox" name="save" value="on">
              </div>
          </div>
          <input type="submit" class="btn btn-default" value="ログイン">
        </form>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery-3.1.1.js"></script>
    <script src="assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
