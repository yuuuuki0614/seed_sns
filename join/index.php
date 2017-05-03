<?php
session_start();

//フォームからデータがPOST送信された時。（$_POST=スーパーグローバル変数。）
if(!empty($_POST)){
  //エラー項目の確認
  //ニックネームのチェック
  if($_POST['nick_name']==''){
    $error['nick_name']='blank'; //定義（代入）だから「=」は１つ
  }
  //email
  if($_POST['email']==''){
    $error['email']='blank';
  }
  //password(空チェック,文字長チェック：４文字以上)
  if($_POST['password']==''){
    $error['password']='blank';
  }elseif (strlen($_POST['password'])<4) {
    $error['password']='length';
  }

  //確認用password(同じかチェック)
  if($_POST['password']==''){
    $error['password']='notsame';
  }
  // elseif (strlen($_POST['password'])<4) {
  //   $error['password']='length';
  // }




  //画像ファイルの拡張子チェック（$_FILES）
  $fileName = $_FILES['picture_path']['name'];
  //’picture_path’は下記のnameと同じ。
  //'name'は他にsizeなどがある。
  //picture_pathの中のnameを呼び出している。
  if (!empty($fileName)){

      //拡張子を取得
      $ext = substr($fileName, -3);
      $ext = strtolower($ext);
      //変数の中身を全部小文字に変換しますよ。(lower=小文字、upper=大文字)

      if ($ext!='jpg' && $ext!='gif' && $ext!='png'){
        $error['picture_path']='type';
      }
  }



  //エラーがない場合
  if(empty($error)){
      //画像をアップロード
      $picture_path = date('YmdHis') . $_FILES['picture_path']['name'];move_uploaded_file($_FILES['picture_path']['tmp_name'], '../member_picture/' . $picture_path);
          //ファイル名の頭に日時を入れて被らないようにする。
          //一時的な場所に一時的な名前で保存されるのでtmp_name.
          //その後ろは保存していきたい場所を指定。（ファイルを作成し、権限をつける必要がある→everyoneも読み書き）
      //セッションに値を保存
      $_SESSION['join'] = $_POST;
      $_SESSION['join']['picture_path'] = $picture_path;
          //保存するよ。
      header('Location: check.php');
  }


}


//$_FILES＝$_POSTに似ているが、POST送信した時にユーザーの情報が入る専用？













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
        <legend>会員登録</legend>
        <form method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data">
        <!-- actionが空ぽ＝自分のところに送信 -->
        <!-- enctype=“”を入れることで画像を送信できる準備をする。 -->



          <!-- ニックネーム -->
          <div class="form-group">
            <label class="col-sm-4 control-label">ニックネーム</label>
            <div class="col-sm-8">
              
              <!-- <input type="text" name="nick_name" class="form-control" placeholder="例： Seed kun"> -->
              <?php if (isset($_POST['nick_name'])): ?>
                    <input type="text" name="nick_name" class="form-control" placeholder="例： Seed kun" value="<?php echo htmlspecialchars($_POST['nick_name'], ENT_QUOTES, 'UTF-8'); ?>">
                    <!-- 「ENT_QUOTES」はsingke''もdouble""も認識？。文字指定はDBに送信の途中で文字化けしたら嫌なので念のため指定。 -->
              <?php else: ?>
                    <input type="text" name="nick_name" class="form-control" placeholder="例： Seed kun" value="">
              <?php endif; ?>



              <?php if(isset($error['nick_name']) && $error['nick_name']=='blank'){ ?>
              <p class="error">* ニックネームを入力してください</p>
              <?php } ?>

            </div>
          </div>


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



              <?php if(isset($error['email']) && $error['email']=='blank'){ ?>
              <p class="error">* emailを入力してください</p>
              <?php } ?>
            </div>
          </div>


          <!-- パスワード -->
          <div class="form-group">
            <label class="col-sm-4 control-label">パスワード</label>
            <div class="col-sm-8">
              <input type="password" name="password" class="form-control" placeholder="">
              <?php if(isset($error['password']) && $error['password']=='blank'){ ?>
              <p class="error">* passwordを入力してください</p>
              <?php } ?>

              <?php if(isset($error['password']) && $error['password']=='length'){ ?>
              <p class="error">* passwordは4文字以上で入力してください</p>
              <?php } ?>
            </div>
          </div>

          <!-- 確認用パスワード -->
          <div class="form-group">
            <label class="col-sm-4 control-label">確認用パスワード</label>
            <div class="col-sm-8">
              <input type="password" name="password" class="form-control" placeholder="">
              <?php if(isset($error['password']) && $error['password']=='notsame'){ ?>
              <p class="error">* passwordが違います</p>
              <?php } ?>

              <!-- <?php if(isset($error['password']) && $error['password']=='length'){ ?> -->
              <!-- <p class="error">* passwordは4文字以上で入力してください</p> -->
              <?php } ?>
            </div>
          </div>

          <!-- プロフィール写真 -->
          <div class="form-group">
            <label class="col-sm-4 control-label">プロフィール写真</label>
            <div class="col-sm-8">
              <input type="file" name="picture_path" class="form-control">
              <!-- type="file"が指定されている。 -->
              <?php if(isset($error['picture_path']) && $error['picture_path']=='type'){ ?>
              <p class="error">*写真は「.gif」「.jpg」「.png」の画像を指定してください。</p>
              <?php } ?>
              <!-- nicknameやemailのように戻っても表示させるのは結構大変なので、もう一度指定してもらうように誘導する -->
              <?php if (!empty($error)): ?>
                <p class="error">* 恐れ入りますが、画像を改めて指定してください。</p>
              <?php endif; ?>
            </div>
          </div>

          <input type="submit" class="btn btn-default" value="確認画面へ">
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
