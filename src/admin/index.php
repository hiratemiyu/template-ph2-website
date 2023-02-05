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
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POSSE 管理画面ダッシュボード</title>
  <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="./assets/styles/common.css">
  <link rel="stylesheet" href="./admin.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="../assets/scripts/common.js" defer></script>
</head>

<body>
  <div class="container">
    <h1 class="mv-4">問題一覧</h1>


        <table class="table" >
          <thead>
              <tr>
                <th>ID</th>
                <th>問題</th>
                <th></th>
              </tr>
          </thead>
          <tbody>
            <?php foreach ($questions as $question) { ?>
              <form action="../admin/questions/edit.php" method="POST">
                  <tr id=question-<?=$question["id"]?>>
                    <td name="question_id"><?= $question["id"]; ?></td>
                    <td>
                      <a href="./questions/edit.php?id=<?= $question["id"]?>">
                        <?= $question["content"]; ?>
                      </a>
                    </td>
                    <td>
                      <a href="../services/delete_question.php?id=<?= $question["id"]?>">削除</a>
                    </td>
                  </tr>
              </form>
            <?php } ?>
          </tbody>
        </table>
  </div>
    <script>
      const deleteQuestion = async (questionId) => {
        if (!confirm('削除してもよろしいでしょうか？')) return
        const res = await fetch (`http://localhost:8080/services/delete_question.php?id=${questionId}`, 
        { method: 'DELETE' });
        if(res.status === 204){
          alert('削除に成功しました'){
            document.getElementByID(`question-${questionId}`).remove()
          }else{
            alert('削除に失敗しました')
          }
        }
      }
    </script>
</body>

</html>