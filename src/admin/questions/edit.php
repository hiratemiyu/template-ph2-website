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

foreach($questions as $key => $question) {
    $index = array_search($choice["question_id"], array_column($questions, 'id'));
    $questions[$index]["choices"][] = $question;
}

$sql = "SELECT * FROM questions WHERE id = :id";
$stmt = $dbh->prepare($sql);
// print_r($_REQUEST["id"]);

// bindValue (:変数,変数に結びつける値),phpの変数をsqlで使うためのやつ
$sql = "SELECT * FROM choices WHERE question_id = :question_id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(":question_id", $_REQUEST["id"]);
$stmt->execute();
$choices = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_REQUEST["content"] && $_REQUEST["id"])) {

  $sql = "UPDATE questions SET content = :content WHERE id = :id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(':content',$_REQUEST["content"], PDO::PARAM_INT);
  $stmt->bindValue(':id',$_REQUEST["id"], PDO::PARAM_INT);
  $stmt->execute();

  $stmt->bindValue(":id", $_REQUEST["id"]);
  $stmt->execute();
  $question = $stmt->fetch();
}

// print_r($_REQUEST["content"]);

// $stmt->bindValue(':id',$_REQUEST["id"], PDO::PARAM_INT);
// $stmt->execute();

header("Location:../questions/edit.php");
exit();

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
  <link rel="stylesheet" href="../admin.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <div class="wrapper">
    <main>
      <div class="container">
        <h1 class="mb-4">問題編集</h1>
        <form  action="../index.php" class="question-form" method="POST" enctype="multipart/form-data">
          <div class="mb-4">
            <label for="question" class="form-label">問題文:</label>
            <input type="text" name="content" id="question"
            class="form-control required"
            value="<?= $question["content"] ?>"
            placeholder="問題文を入力してください" />
          </div>
          <div class="mb-4">
            <label class="form-label">選択肢:</label>
            <?php foreach($choices as $key => $choice) { ?>
              <input type="text" name="choices[]" class="required form-control mb-2" placeholder="選択肢を入力してください" value=<?= $choice["name"] ?>>
            <?php } ?>
          </div>
          <div class="mb-4">
            <label class="form-label">正解の選択肢</label>
            <?php foreach($choices as $key => $choice) { ?>
              <div class="form-check">
                <input 
                  class="form-check-input" 
                  type="radio" name="correctChoice" id="correctChoice<?= $key ?>" 
                  value="<?= $key + 1 ?>"
                  <?= $choice["valid"] === 1 ? 'checked' : '' ?>
                >
                <label class="form-check-label" for="correctChoice1">
                  選択肢<?= $key + 1 ?>
                </label>
              </div>
            <?php } ?>
          </div>
          <div class="mb-4">
            <label for="question" class="form-label">問題の画像</label>
            <input type="file" name="image" id="image"
              class="form-control"
              placeholder="問題文を入力してください"
            />
          </div>
          <div class="mb-4">
            <label for="question" class="form-label">補足:</label>
            <input type="text" name="supplement" id="supplement"
            class="form-control"
            placeholder="補足を入力してください"
            value="<?= $question["supplement"] ?>"
          />
          </div>
          <input type="hidden" name="question_id" value="<?= $question["id"] ?>">
          <button type="submit" class="btn submit">更新</button>
        </form>
      </div>
    </main>
  </div>
  <script>
    const submitButton = document.querySelector('.btn.submit')
    const inputDoms = Array.from(document.querySelectorAll('.required'))
    inputDoms.forEach(inputDom => {
      inputDom.addEventListener('input', event => {
        const isFilled = inputDoms.filter(d => d.value).length === inputDoms.length
        submitButton.disabled = !isFilled
      })
    })
  </script>
</body>

</html>