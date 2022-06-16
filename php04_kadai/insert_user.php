<?php

/**
 * 1. index.phpのフォームの部分がおかしいので、ここを書き換えて、
 * insert.phpにPOSTでデータが飛ぶようにしてください。
 * 2. insert.phpで値を受け取ってください。
 * 3. 受け取ったデータをバインド変数に与えてください。
 * 4. index.phpフォームに書き込み、送信を行ってみて、実際にPhpMyAdminを確認してみてください！
 */


//1. POSTデータ取得
//直接sql文に突っ込むと悪さする文字列が入る可能性があるが、まずは、ポストでデータを受け取る
$name = $_POST['name'];
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];
$kanri_flg = $_POST['kanri_flg'];
$life_flg = $_POST['life_flg'];


var_dump($name);


//2. DB接続します
// 接続できない場合、トライキャッチでエラーが受け取ったらと言う構文
// エグジットしてエラー文書を表示する
// スモールeはエラー文字列
// new PDO関数がコマンド（データベースを使えるようにするコマンド）
// sqlソフトを定める
// データベース名を決める
//アドレスのサーバー名とサーバーidとパスワード入れる（ローカルの場合も外部サーバーの場合もある）

try {
  //ID:'root', Password: 'root'
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//３．データ登録SQL作成

// 1. SQL文を用意

// insert into コマンドで””に挟まれた文字列をデータをsql文にする
// データベースのフィールドのカラム項目に、バリューズの後に代する。ただし、渡されるデータは、後で、セキュリティ工夫する）
// db テーブル名をINSERT INToの後に置く

$sql = "INSERT INTO gs_login_table (
                          id, 
                          name,
                          lid,
                          lpw, 
                          kanri_flg,
                          life_flg
                      ) VALUES (
                            NULL, 
                            :name, 
                            :lid, 
                            :lpw, 
                            :kanri_flg,
                            :life_flg
                      ) " ;



// pdoの中のprepare関数に渡す、stmt関数にさらに渡すことで、セキュリティ処理をする

$stmt = $pdo->prepare($sql);

//  2. バインド変数を用意　関連づけて、ハッキングの無効化
// Integer 数値の場合 PDO::PARAM_INT
// String文字列の場合 PDO::PARAM_STR

$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);
$stmt->bindValue(':kanri_flg', $kanri_flg, PDO::PARAM_INT);
$stmt->bindValue(':life_flg', $life_flg, PDO::PARAM_INT);

//  3. 実行

// //statusはエグゼキュートで最後に実行する全てを代入し切った変数

$status = $stmt->execute();

//４．データ登録処理後

if($status === false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  //エラーインフォ関数でエラーの値をstmtから取り出して、$error変数（配列）の２番目の読む
  //エグジットで処理を止めて、クエリエラーが表示し、配列の中身が表示される
  $error = $stmt->errorInfo();
  exit('ErrorMessage:'.$error[2]);
}else{
  //５．index.phpへリダイレクト処理
  //フォールスでなければエルス以下を実行即ち、ヘッダー関数（phpの場合はリダイレクト）処理する
// Location ころん で場所を指定するとそこに自動で飛ぶ・ロケートする
//半角スペースに注意！
 header('Location: user.php');
 exit;

}
?>
