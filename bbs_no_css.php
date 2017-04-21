<?php
//テスト後で消す
  if  (!empty($_POST)) {


      $nickname = htmlspecialchars($_POST['nickname']);
      $comment = htmlspecialchars($_POST['comment']);

      //データベースへ接続して、SQLを実行し切断する部分を記述
      // １．データベースに接続する
      $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
      $user = 'root';
      $password='';
      $dbh = new PDO($dsn, $user, $password);
      $dbh->query('SET NAMES utf8');

      // ２．SQL文を実行する
      $sql = 'INSERT INTO `posts`(`nickname`, `comment`, `created`) VALUES("'.$nickname.'","'.$comment.'",now());';

    //INSERT文実行
      $stmt = $dbh->prepare($sql);
      $stmt->execute();

      //SELECT文の実行
      //SQL文作成（SELECT分）
      $sql = 'SELECT * FROM `posts`;';

      //実行
      $stmt = $dbh->prepare($sql);
      $stmt->execute();

      //配列で取得したデータを格納
      //配列を初期化（準備）
      $posts_datas = array();

      //繰り返し文でデータの取得（フェッチ）
      while(1) {
        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rec == false){
          break;
        }
        //echo $rec['nickname'];
        $post_datas[] = $rec;
      }
  }

  // ３．データベースを切断する
  $dbh = null;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>
</head>
<body>
    <form method="post" action="">
      <p><input type="text" name="nickname" placeholder="nickname"></p>
      <p><textarea type="text" name="comment" placeholder="comment"></textarea></p>
      <p><button type="submit" >つぶやく</button></p>
    </form>

    <!-- ここにニックネーム、つぶやいた内容、日付を表示する -->
    <?php
    foreach ($post_datas as $post_each){
      echo $post_each['nickname'].'<br>';
      echo $post_each['comment']'<br>';
      echo $post_each['created'].'<br>';
      echo '<hr>';
    }
    ?>


</body>
</html>
