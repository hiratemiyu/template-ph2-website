<?php
require_once(dirname(__FILE__) . '/../dbconnect.php');

$params = [
    "content" => $_POST["content"],
    "supplement" => $_POST["supplement"],
    "id" => $_POST["question_id"],
];

// SET単体で使えるの?→下で$set_queryが使われているよ
$set_query = "SET content = :content,supplement = :supplement";


// ～imageだけある場合とない場合があるので処理が別～

//！：等しくない時 ""ではないときの処理→imageがあるときの処理
// .(結合)なので,必要 $set_queryの:supplementの後に,imageがくる
//  $_FILES['inputで指定したname']['tmp_name']：一時保存ファイル名
if($_FILES["image"]["tmp_name"] !== "") {
    $set_query .=",image = :image";
    $params["image"] = "";
}

$sql = "UPDATE questions $set_query WHERE id = :id"; 

// beginTransaction()「全て登録できる」か「全て登録できない」かのどちらかでデータを保存
$dbh -> beginTransaction();
// データ保存などの処理
// 画像の名前を決める、外部のパスはもってこれない
try{
    // isset trueかfalseかを確認
    if(isset($params["image"])){
    // strってついてるやつは文字列の処理、substr（文字列,開始位置,文字数（省略可、省略された場合は末字文字まで生成される））
    // strrchr(文字列,文字) strchrの役割：最後に該当する箇所を取得
        $image_name = uniqid(mt_rand(),true) . '.' . substr(strrchr($_FILES['image']['name'],'.'),1);
        $image_path = dirname(__FILE__) . '/../assets/img/quiz/' . $image_name;
        // move_uploaded_file:出力された値を保存
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $image_path
        );
        $params["image"] = $image_name;
    }



// :contentと:supplement
$stmt = $dbh -> prepare($sql);
$result = $stmt -> execute($params);

// 前のやつ消す
$sql = "DELETE FROM choices WHERE question_id = :question_id";
$stmt = $dbh ->prepare($sql);
$stmt ->bindValue(":question_id" , $_POST["question_id"]);
$stmt -> execute();

// データベース出力された値を挿入
$stmt = $dbh->prepare("INSERT INTO choices(name,valid,question_id) values (:name, :valid, :question_id)");
for($i = 0; $i < count($_POST["choices"]);$i++){
    $stmt -> execute(
        [
            "name" => $_POST["choices"][$i],
            "valid" => (int)$_POST['correctChoice'] === $i + 1 ? 1:0,
            "question_id" => $_POST["question_id"]
        ]);
}

$dbh -> commit();
header("Location: ". "http://localhost:8080/admin/index.php");
}catch(Error $e){
    $dbh -> rollBack();
}
exit();