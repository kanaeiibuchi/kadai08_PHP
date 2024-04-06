<?php
//1. POSTデータ取得
//[name,email,age,naiyou]
$name    = $_POST["name"];
$email   = $_POST["email"];
// $place   = $_POST["place"];
$place = isset($_POST["place"]) ? $_POST["place"] : null;
$comment = $_POST["comment"];

//2. DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gu_db;charset=utf8;host=localhost','root','');
  
} catch (PDOException $e) {
  exit('DB_CONECT:'.$e->getMessage());
}


//３．データ登録SQL作成
$sql="INSERT INTO gs_mogu_table(id,name,email,place,comment,indate)VALUES(NULL,:name,:email,:place,:comment,sysdate());";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name' , $name,  PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':email', $email, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':place', $place, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //true or false

//４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("SQL_ERROR:".$error[2]);
}else{
  //５．index.phpへリダイレクト　成功したとき
  header("Location: index.php");
  exit();
}
?>
