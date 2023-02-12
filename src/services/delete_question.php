<?php
$dsn = 'mysql:dbname=posse;host=db';
$user = 'root';
$password = 'root';

$dbh = new PDO($dsn, $user, $password);

$questions = $dbh->query("SELECT * FROM questions")->fetchAll(PDO::FETCH_ASSOC);
$choices = $dbh->query("SELECT * FROM choices")->fetchAll(PDO::FETCH_ASSOC);

foreach ($choices as $key => $choice) {
    $index = array_search($choice["question_id"], array_column($questions, 'id'));
    $questions[$index]["choices"][] = $choice;
}

// question_idはidに紐づいているので先に消してはいけません
$sql = "DELETE FROM choices WHERE question_id = :question_id" ;

$stmt = $dbh->prepare($sql);

$stmt->bindValue(':question_id',$_GET["id"], PDO::PARAM_INT);

$stmt->execute();

$sql = "DELETE FROM questions WHERE id = :id" ;

$stmt = $dbh->prepare($sql);

$stmt->bindValue(':id',$_GET["id"], PDO::PARAM_INT);

$stmt->execute();

header("Location:"."/../admin/index.php");
exit();

?>

