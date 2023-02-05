<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POSSE管理画面ダッシュボード</title>
</head>

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


?>

<body>
    <main>
        <div class="container">
            <h1 class="mb-4" >問題作成</h1>
            <form class="question-form" action="../../services/create_question.php" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="question" class="form-label">問題文:</label>
                    <input type="text" name="content" id="question"
                    class="form-control required" placeholder="問題文を入力してください">
                </div>
                <div class="mb-4">
                    <label for="question">選択肢:</label>
                    <!-- choicesっているname属性が []でchoicesが配列があることを宣言 -->
                    <input type="text" name="choices[]" class="required form-control mb-2" placeholder="選択肢1を入力">
                    <input type="text" name="choices[]" class="required form-control mb-2" placeholder="選択肢2を入力">
                    <input type="text" name="choices[]" class="required form-control mb-2" placeholder="選択肢3を入力">
                </div>
                <div class="mb-4">
                    <label class="form-label">正解の選択肢</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correctChoice1" id="correctChoice1" checked value="1">
                        <label class="form-check-label" for="correctChoice1">
                            選択肢1
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correctChoice1" id="correctChoice1" checked value="1">
                        <label class="form-check-label" for="correctChoice1">
                            選択肢2
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="correctChoice1" id="correctChoice1" checked value="1">
                        <label class="form-check-label" for="correctChoice1">
                            選択肢3
                        </label>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="question" class="form-label">問題の画像</label>
                    <input type="file" name="image" id="image"
                    class="form-control required" placeholder="問題文を入力してください">
                </div>
                <div class="mb-4">
                    <label for="question" class="form-label">補足：</label>
                    <input type="text" name="supplement" id="supplement"
                    class="form-control required" placeholder="補足を入力してください">
                </div>
                <button type="submit" disabled class="btn submit">作成</button>
            </form>
        </div>
    </main>
    
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