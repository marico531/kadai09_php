<?php
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る

//insert.phpより 
///1. POSTデータ取得
$team_name      = $_POST["team_name"];
$team_url       = $_POST["team_url"];
$stadium_name   = $_POST["stadium_name"];
$stadium_url    = $_POST["stadium_url"];
$naiyou         = $_POST["naiyou"];
// 今回はidも必要なため、追加する
$id             = $_POST["id"];

//2. DB接続します
//*** function化する！  *****************
include("funcs.php");// 外部ファイル読み込むためだけのコード。includeは全部の意味
$pdo = db_conn();

//３．データ登録SQL作成
$sql="UPDATE rugby_an_db SET team_name=:team_name,eam_url=:team_url,stadium_name=:stadium_name,stadium_url=:stadium_url,naiyo=:naiyou,WHERE id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':team_name',     $team_name,    PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':team_url',      $team_url,     PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':stadium_name',  $stadium_name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':stadium_url',   $stadium_url,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':naiyou',        $naiyou,       PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); // 実行　true or false

//４．データ登録処理後
if($status==false){
    //*** function化する！*****************
    //エラーを表示させるコード
    sql_error($stmt);

}else{
    //*** function化する！*****************
    //情報をselect.phpに送るコード
redirect("select.php");
}

//insert.phpより 
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

?>