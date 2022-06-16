<?php
//共通に使う関数を記述
//XSS対応（ echoする場所で使用！それ以外はNG ）


function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}


//DB接続
function db_conn()
{
    try {
        $db_name = 'gs_db';    //データベース名
        $db_id   = 'root';      //アカウント名
        $db_pw   = 'root';      //パスワード：XAMPPはパスワード無しに修正してください。
        $db_host = 'localhost'; //DBホスト
        $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
        return $pdo;
    } catch (PDOException $e) {
        exit('DB Connection Error:' . $e->getMessage());
    }
}


// ログインチェク処理 loginCheck()

function loginCheck(){

    if( $_SESSION['chk_ssid'] != session_id()){
        //loginがちゃんとできない場合
        exit('# Login Error #');
        
        } else{
        
            //LOGINGAできている場合、鍵を交換する
            session_regenerate_id(true);
            $_SESSION['chk_ssid'] = session_id();
        
        };

};
