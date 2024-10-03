<?php
//１．PHP
//select.phpのidを受け取る
$id = $_GET["id"];
//select.phpのPHPコードをマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。

//【重要】
//insert.phpを修正（関数化）してからselect.phpを開く！！
//funcs.phpを読み込み、dbにも接続している状態
include("funcs.php");
$pdo = db_conn();

//２．データ登録SQL作成
//sqlをセットして、selectを実行している
// $sql = "SELECT * FROM gs_an_table WHERE id=:id";
$sql = "SELECT * FROM rugby_an_db WHERE id=:id";
$stmt = $pdo->prepare($sql);  // ここでprepareを先に実行
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  // bindValueはその後に実行
$status = $stmt->execute();


//３．データ表示
//状況がfalseだったらエラーを表示する
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データを取得する
$v = $stmt->fetch();

?>

<!--
２．HTML
以下にindex.phpのHTMLをまるっと貼り付ける！
理由：入力項目は「登録/更新」はほぼ同じになるからです。
※form要素 input type="hidden" name="id" を１項目追加（非表示項目）
※form要素 action="update.php"に変更
※input要素 value="ここに変数埋め込み"
-->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>チーム一覧更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">チーム一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="POST" action="update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>チーム情報更新</legend>
     <label>チーム名：<input type="text"   name="team_name" value="<?=$v["team_name"] ?>"></label><br>
     <label>チームサイトURL：<input type="text"   name="team_url" value="<?=$v["team_url"] ?>"></label><br>
     <label>メインスタジアム名：<input type="text"   name="stadium_name" value="<?=$v["stadium_name"] ?>"></label><br>
     <label>スタジアムサイトURL：<input type="text"   name="stadium_url" value="<?=$v["stadium_url"] ?>"></label><br>
     <!-- textAreasではvalueは使えない。なので表示部分に入れる -->
     <label><textArea name="naiyou" rows="4" cols="40"><?=$v["naiyou"] ?></textArea></label><br>
     <!-- idがkeyなので追加する。 -->
     <input type="hidden" name="id" value="<?=$v["id"] ?>">
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->
<br>
<a href="select.php">チーム一覧を見る</a>

</body>
</html>

