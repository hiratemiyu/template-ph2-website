<?
// 中に書いたファイルを持ってくる
// dirname(FILE)の中に現在のファイルのパスが含まれる
// . 文字列の結合
require_once(dirname(__FILE__) . '/../dbconnect.php');

// 画像をユニーク化する、画像の名前をランダムに生成（imgのquiz、全部数字のやつ）
// strってついてるやつは文字列の処理、substr（文字列,開始位置,文字数（省略可、省略された場合は末字文
// 生成される））
// $_FILEに限って$_POST[]の使い方をしない 
// strrchr(文字列,文字) strchrの役割：最後に現れる場所以降の文字列を取得
// '.'、拡張子を最後に現れる場所以降から取る index.phpなら.phpを取得→'.'を0番目としたときに1番目から取ってくる、文字数省力（全部取ってくる）なのでphpがもってこられる
$image_name = uniqid(mt_rand(),true) . '.' .substr(strrchr($_FILES['image']['name'],'.'),1);
// uniqidでrand関数使ってランダムな数字の羅列になる
// $image_name：mt_randで生成された文字列+.substrで生成された拡張子(.imgとか.pngとか)
// path ファイルから画像を取ってきてどこに画像を保存させるか指定
$image_path = dirname(__FILE__) . '/../assets/img/quiz/' . $image_name;

// tmp,temporary nameの略
move_uploaded_file(
    $_FILES['image']['tmp_name'],
    $image_path
);

// : バインド変数 変数には何も入っていない,bindValueで変数（入力されたもの）を直接入れる方法と、executeで配列で入れる方法がある
// 変数が入らない場合はqueryでいける
// image青くなるのは頻繁に使われるやつ
$stmt = $dbh -> prepare("INSERT INTO questions(content,image,supplement) VALUES(:content,:image,:supplement) ");
$stmt -> execute([
    "content" => $_POST["content"],
    "image" =>  $image_name,
    "supplement" => $_POST["supplement"]
]);

// 最後に挿入された行のidを返す
// AUTO_INCREMENT：1ずつ増える、をデータベースを作るとき、主キーに設定の時に指定
$lastInsertId = $dbh -> lastInsertId();

$stmt = $dbh -> prepare("INSERT INTO choices(name,valid,question_id) VALUES (:name,:valid,:question_id)");

// create.phpでname属性でchoicesと付けた分が入る
for($i=0 ; $i<count($_POST["choices"]); $i++){
    $stmt -> execute([
        "name" => $_POST["choices"][$i],
        // $iの中に変数が入ってそれがCorrectchoiceと正しいなら1が入る
        "valid" => (int)$_POST['correctChoice1'] === $i + 1 ? 1 : 0,
        "question_id" => $lastInsertId
    ]);
}
// 指定されたサイトにリダイレクト（直接）飛ぶ
header("Location: ". "http://localhost:8080/admin/index.php");
?>