<?php
  session_start();//使うところに書くが、慣れない間は全部に書くと良い。

  //ログイン状態のチェックーdbではないのでconnectの上で可。
  //ログインしていると判断できる条件
  //1.SESSIONにidが入っていること
  //2.最後の行動から1時間以内であること
  if (isset($_SESSION['login_member_id']) && ($_SESSION['time'] + 3600 > time()) ) {//2時にloginして今2時半なら、2時+1時間(=3時)が今より大きい。
    
    //ログインしている
    //SESSIONの時間を更新
    $_SESSION['time'] = time();

  }else{
    //ログインしていない
    header('Location: login.php');
    exit();
  }


  require('dbconnect.php');//dbに接続する
  //どこが間違っているのか、var_dump()を使ってデバックチェックできるようになろう！

  //ログインしている人の情報を取得（名前を表示）ーdb使用するためconnectの下に書く。
  //SQLを実行し、ユーザーのデータを取得
  $sql = sprintf('SELECT * FROM `members` WHERE `member_id` = %d',
   mysqli_real_escape_string($db, $_SESSION['login_member_id']));

  $record = mysqli_query($db, $sql) or die(mysqli_error($db));
  $member = mysqli_fetch_assoc($record);


  //DB登録処理
  if (!empty($_POST)) {
    //補足：つぶやきが空っぽじゃない時だけ、INSERTする
    if (!empty($_POST['tweet'])) {//ここもしかして要らない？

        // $tweet = htmlspecialchars($_POST['tweet'], ENT_QUOTES, 'UTF-8');この長いのを簡潔にかくとこうなる↓↓
        $tweet = h($_POST['tweet']);
        $login_member_id = $_SESSION['login_member_id'];

        if (isset($_POST['reply_tweet_id'])) {
          $reply_tweet_id = $_POST['reply_tweet_id'];
        }else{
          $reply_tweet_id = 0;
        }

        $sql = sprintf('INSERT INTO `tweets` (`tweet`, `member_id`, `reply_tweet_id`, `created`, `modified`) VALUES ("%s", "%s", "%s", now(), now());',
          mysqli_real_escape_string($db,$tweet),
          mysqli_real_escape_string($db,$login_member_id),
          mysqli_real_escape_string($db,$reply_tweet_id)
        );

        //dbを実行する。
        mysqli_query($db, $sql) or die(mysqli_error($db));
        header("Location: index.php");//書かなくてもいいのに、自分のページにリダイレクトする理由。＝再読み込み時にPOST送信が発生しなくなる！
        exit();

    }

  }

  //ページング処理（投稿を取得するの上に）

  //0.ページ番号を取得する（ある場合はGET送信で送られる、ない場合は常に1ページ目と認識する）
  $page = '';
  //GET送信されてきたページ番号を取得
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  }
  //ないときは1ページ目
  if ($page == '') {
    $page = 1;
  }

  //1.表示する正しいページの数値を設定する（Min）//悪い人が「-10」頁とかを防ぐ。
  $page = max($page,1);

  //2.必要なページ数を計算する
  //１ページに表示する行数
  $row = 5;
  //（キーワードで検索された場合）を追加。//「delete_flag`=0」は0だけ表示したい。
  if (isset($_GET['search_word']) && !empty($_GET['search_word'])) {
    $sql = sprintf('SELECT COUNT(*) as cnt FROM `tweets` INNER JOIN `members` on `tweets`.`member_id` = `members`.`member_id` WHERE `delete_flag`=0 AND `tweet` LIKE "%%%s%%" ORDER BY `tweets`.`created` DESC', mysqli_real_escape_string($db,$_GET['search_word']));//結合した上で取ってくるのが正確。
  }else{
    $sql = 'SELECT COUNT(*) as cnt FROM `tweets` INNER JOIN `members` on `tweets`.`member_id` = `members`.`member_id` WHERE `delete_flag`=0 ORDER BY `tweets`.`created` DESC';
  }

  $record_cnt = mysqli_query($db, $sql) or die(mysqli_error($db));

  $table_cnt = mysqli_fetch_assoc($record_cnt);
  //ceil()：小数点切り上げする関数
  $maxPage = ceil($table_cnt['cnt'] / $row);

  //3.表示する正しいページ数の数値を設定する（Max）
  $page = min($page,$maxPage);

  //4.ページに表示する件数だけ取得する
  $start = ($page -1) * $row;







  //投稿を取得する
  //（キーワードで検索された場合）
  //「WHERE `delete_flag`=0」の後ろに「AND `tweet` LIKE "%%%s%%"」追加。
  //お尻の「$start, $row);」の前に「$_GET['search_word']」追加、サニタイズ。
  if (isset($_GET['search_word']) && !empty($_GET['search_word'])) {
    $sql = sprintf('SELECT `members`.`nick_name`,`members`.`picture_path`,`tweets`.* FROM `tweets` INNER JOIN `members` on `tweets`.`member_id` = `members`.`member_id` WHERE `delete_flag`=0 AND `tweet` LIKE "%%%s%%" ORDER BY `created` DESC LIMIT %d, %d',mysqli_real_escape_string($db,$_GET['search_word']),$start, $row);
  }else{//（検索されてない場合）
  // $sql = 'SELECT * FROM `tweets`'; ←←データを一覧で取り出すシンプルな文。
  //削除機能「WHERE `delete_flag`=0」を加える。
  $sql = sprintf('SELECT `members`.`nick_name`,`members`.`picture_path`,`tweets`.* FROM `tweets` INNER JOIN `members` on `tweets`.`member_id` = `members`.`member_id` WHERE `delete_flag`=0 ORDER BY `created` DESC LIMIT %d, %d', $start, $row);
  }

  // $stmt = $dbh->prepare($sql);これは使わないのかな？
  // $stmt->execute();これなんだっけ？
  $tweets = mysqli_query($db, $sql) or die(mysqli_error($db));

  $tweets_array = array();
  while ($tweet = mysqli_fetch_assoc($tweets)) {
    //$tweetには$tweet['tweet_id']が含まれている
    //：0か1のフラグのSELECT文を書く。$tweets_array[]に入れたい（カラムを増やす）
    //いいね機能の実装のための処理
    $sql = 'SELECT COUNT(*) as `like_flag` FROM `likes` WHERE `tweet_id` = '.$tweet['tweet_id'].' AND `member_id` ='.$_SESSION['login_member_id'];

    $likes = mysqli_query($db, $sql) or die(mysqli_error($db));
    $like = mysqli_fetch_assoc($likes);


    //いいね数の取得
    // $sql = 'SELECT COUNT(*)as `like_count` FROM `likes` WHERE `tweet_id` =50';
    $sql = 'SELECT COUNT(*)as `like_count` FROM `likes` WHERE `tweet_id` ='.$tweet['tweet_id'];
    $likes_cnt = mysqli_query($db, $sql) or die(mysqli_error($db));
    $like_cnt = mysqli_fetch_assoc($likes_cnt);//どうしたらいいかよくわからないデータで来るから、それをphpで扱いやすい配列の形にして代入



    // echo '<pre>';//pre＝このままの行で表示。本当は<br>した方がいい。
    // var_dump('記事のID');
    // var_dump($tweet['tweet_id']);
    // var_dump('ログインした人がlikeしているかどうが');
    // var_dump($like);
    // echo '</pre>';


    $tweet['like_flag'] = $like['like_flag'];//SELECT COUNT(*) as `like_flag`で別名をつけている。
    $tweet['like_count'] = $like_cnt['like_count'];//SELECT COUNT(*) as `like_count`で別名をつけている。

    $tweets_array[] = $tweet;
  }

  // echo '<pre>';//「}」の後に書く！
  // var_dump($tweets_array);
  // echo '</pre>';



  //返信の場合（GET送信されてるresから値を取ってくる）
  if (isset($_REQUEST['res'])) {
    //返信元のデータ（つぶやきとニックネーム）を取得する   ここっここここここここここここここ
    $sql = 'SELECT `tweets`.`tweet`,`members`.`nick_name` FROM `tweets` INNER JOIN `members` on `tweets`.`member_id` = `members`.`member_id` WHERE `tweet_id` = '.$_REQUEST['res'];
    $reply = mysqli_query($db, $sql) or die(mysqli_error($db));
    $reply_table = mysqli_fetch_assoc($reply);

    //[@ニックネーム つぶやき]という文字列をセットする
    $reply_post = '@'.$reply_table['nick_name'].' '.$reply_table['tweet'];
  }

  function h($input_value){//「h」:自分で作った関数、「($input_value)」:引数。
    return htmlspecialchars($input_value, ENT_QUOTES, 'UTF-8');
  }//return ○○ :戻り値
  //上か下にまとめて書き、実行したい箇所で呼び出す感じ。
  //他のページで使いたければ、「require('dbconnect.php');」みたいな感じで読み込めば可能？


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
      <div class="col-md-4 content-margin-top">
        <legend>ようこそ<?php echo $member['nick_name']; ?>さん！</legend>
        <form method="post" action="" class="form-horizontal" role="form">
            <!-- つぶやき -->
            <div class="form-group">
              <label class="col-sm-4 control-label">つぶやき</label>
              <div class="col-sm-8">
                <!-- ここにresがある時の表示をする -->
                <?php if (isset($reply_post)){ ?>
                    <textarea name="tweet" cols="50" rows="5" class="form-control" placeholder="例：Hello World!"><?php echo $reply_post; ?></textarea>
                    <input type="hidden" name="reply_tweet_id" value="<?php echo $_REQUEST['res']; ?>">
                <?php }else{ ?>
                    <textarea name="tweet" cols="50" rows="5" class="form-control" placeholder="例：Hello World!"></textarea>
                <?php } ?>

              </div>
            </div>
          <ul class="paging">
            <input type="submit" class="btn btn-info" value="つぶやく">
                &nbsp;&nbsp;&nbsp;&nbsp;

                <?php
                  $word = '';
                  if (isset($_GET['search_word']) && !empty($_GET['search_word'])) {
                    $word = '&search_word='.$_GET['search_word'];
                  }
                ?>

                <li>
                  <?php if ($page > 1) { ?>
                  <a href="index.php?page=<?php echo $page-1; ?><?php echo $word; ?>" class="btn btn-default">前</a>
                  <?php }else{ ?>
                    前
                  <?php } ?>
                </li>
                &nbsp;&nbsp;|&nbsp;&nbsp;
                <li>
                  <?php if ($page < $maxPage) { ?>
                  <a href="index.php?page=<?php echo $page+1; ?><?php echo $word; ?>" class="btn btn-default">次</a>
                  <?php }else{ ?>
                    次
                  <?php } ?>
                </li>
          </ul>
        </form>
      </div>

      <div class="col-md-8 content-margin-top">

        <!-- 検索ボックス -->
        <!-- どちらもPOST送信可能だが、わかりやすいよう今回はget送信で。 -->
        <form action="" method="get" class="form-horizontal">
          <input type="text" name="search_word">
          <input type="submit" class="btn btn-success btn-xs" value="検索">
        </form>




        <!-- ここでつぶやいた内容を繰り返し表示する -->
        <?php foreach ($tweets_array as $tweet_each) { ?>

        <div class="msg">
          <!-- <img src="http://c85c7a.medialib.glogster.com/taniaarca/media/71/71c8671f98761a43f6f50a282e20f0b82bdb1f8c/blog-images-1349202732-fondo-steve-jobs-ipad.jpg" width="48" height="48"> -->
          <img src="member_picture/<?php echo $tweet_each['picture_path']; ?>" width="48" height="48">
          <p>
            <?php echo $tweet_each['tweet']; ?><!-- つぶやき４(1〜3は要らないので消す) -->
            <span class="name">
            (<?php echo $tweet_each['nick_name']; ?>)<!-- (Seed kun) -->
            </span>
            [<a href="index.php?res=<?php echo $tweet_each['tweet_id']; ?>">Re</a>]



            <?php if ($tweet_each['like_count'] == !0){; ?>
              <!-- <small>いいね数:1</small> -->
              <small><i class="fa fa-thumbs-up"></i>:<?php echo $tweet_each['like_count']; ?></small>
            <?php } ?>



            <?php if ($tweet_each['like_flag'] == 1){
                //すでにいいねされているので、「いいねを取り消す」を表示。（phpの中にコメントを書くとhtmlのソースの表示では見えない！）
              ; ?>
                <a href="unlike.php?tweet_id=<?php echo $tweet_each['tweet_id']; ?>"><small>いいねを取り消す</small></a>
            <?php }else{
                //まだいいねされていないので、「いいね」 を表示。（いいね＆取り消すは逆でも可。）
            ?>
                <a href="like.php?tweet_id=<?php echo $tweet_each['tweet_id']; ?>"><small>いいね！</small></a>
            <?php } ?>
          </p>




          <p class="day">
            <a href="view.php?tweet_id=<?php echo $tweet_each['tweet_id']; ?>">
              <?php echo $tweet_each['created']; ?><!-- 2016-01-28 18:04 -->
            </a>
            <?php if ($tweet_each['reply_tweet_id'] > 0) { ?>
            | <a href="view.php?tweet_id=<?php echo $tweet_each['reply_tweet_id']; ?>">返信元のつぶやき</a>
            <?php } ?>

            <?php if ($_SESSION['login_member_id'] == $tweet_each['member_id']) { ?>
            [<a href="edit.php?tweet_id=<?php echo $tweet_each['tweet_id']; ?>" style="color: #00994C;">編集</a>]
            [<a href="delete.php?tweet_id=<?php echo $tweet_each['tweet_id']; ?>" style="color: #F33;">削除</a>]
            <?php } ?>

          </p>
        </div>
        <?php } ?>

      </div>

    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery-3.1.1.js"></script>
    <script src="assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
