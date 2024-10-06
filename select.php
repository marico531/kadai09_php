<?php
//【重要】
//insert.phpを修正（関数化）してからselect.phpを開く！！
//funcs.phpを読み込み、dbにも接続している状態
include("funcs.php");
$pdo = db_conn();

//2．データ登録SQL作成
$sql = "SELECT * FROM rugby_an_db";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//３．データ表示
//状況がfalseだったらエラーを表示する
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
//状況がtrueだったらデータを全て$valuesに取り込む
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
//状況が$valuesのデータをjsonに取り込む場合は以下コードを利用する
$json = json_encode($values,JSON_UNESCAPED_UNICODE);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>チーム一覧表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>
  div { padding: 10px; font-size: 16px; }
  table { width: 100%; } /* テーブル全体の幅を100%に */
  th, td { padding: 8px; text-align: left; }
  th { background-color: #f2f2f2; }

  /* 列の幅を設定 */
  td:nth-child(2), td:nth-child(4), td:nth-child(6) {
    white-space: nowrap;  /* 改行を防ぐ */
    width: 250px;         /* 固定の幅を指定 */
    overflow: hidden;
    text-overflow: ellipsis; /* 溢れた場合は省略記号（…）を表示 */
  }

</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="index.php">チーム登録</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
  <div class="container jumbotron">
    <table border='1' style='border-collapse: collapse;'>
      <thead>
        <tr>
          <th>ID</th>
          <th>チーム名</th>
          <th>チームサイト</th>
          <th>メインスタジアム名</th>
          <th>スタジアムサイト</th>
          <th>備考</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($values as $v){ ?>
          <tr>
            <td><?= h($v["id"])?></td>
            <td><?= h($v["team_name"])?></td>
            <td><a href="<?= h($v["team_url"]) ?>" target="_blank"><?= h($v["team_name"]) ?> 公式サイト</a></td>
            <td><?= h($v["stadium_name"]) ?></td>
            <td><a href="<?= h($v["stadium_url"]) ?>" target="_blank"><?= h($v["stadium_name"]) ?> 公式サイト</a></td>
            <td><?= h($v["naiyou"] )?></td>
            <!-- detail.phpに飛ばすコード -->
            <td><a href="detail.php?id=<?=h($v["id"])?>">更新</a></td>
            <td><a href="delete.php?id=<?=h($v["id"])?>">削除</a></td>

          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<!-- Main[End] -->

<script>
  const jsonData = '<?php echo $json; ?>';
  console.log(JSON.parse(jsonData));
</script>
</body>
</html>
