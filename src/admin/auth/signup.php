<?php
// あってる場合は処理を続行させるため{}を閉じない、間違ってる時はすぐ閉じる
if ($_SERVER['REQUEST_METHOD']=== 'POST'){
  // セッションとは、コンピュータのサーバ側に一時的にデータを保存する仕組みのことです。
  session_start();
  $email = $_POST["email"];
  $token = $_POST["token"];
  $name = $_POST["name"];
  $password = $_POST["password"];
  $password_confirm = $_POST["password_confirm"];


if($password !== $password_confirm){
  $message = "パスワードが一致しません";
}else{
  $pdo = new PDO('mysql:host=db;dbname=posse', 'root', 'root');
  $sql = "SELECT * FROM users WHERE email=:email";
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindValue(":email",$email);
  $user = $stmt-> fetch();


  $sql = "SELECT * FROM user_invitations WHERE token = :token AND user_id = :user_id";
  $stmt = $pdo -> prepare($sql);
  $stmt -> bindValue(":token",$token);
  $stmt -> bindValue(":user_id",$user["id"]);
  $stmt -> execute();
  
  $user_invitation = $stmt -> fetch();


// phpmyadminから取ってきている
  $diff = (new DateTime()) -> diff(new DateTime($user_invitation["invited_at"]));
  $is_expired = $diff -> days >= 1;
  if($is_expired){
    $message = "招待期限が切れています。管理者に連絡してください。";
  } else{
    $is_activated = !is_null($user_invitation["activated_at"]);
  if($is_activated){
    $message = "既に認証済みです";
  }else{
    // try 処理 catch 例外処理
    try{
      // beginTransaction()「全て登録できる」か「全て登録できない」かのどちらかでデータを保存
      $pdo -> beginTransaction();
      // UPDATE (表名) SET (カラム名1) = (値1) WHERE (条件);
      $sql = "UPDATE users SET name = :name,password = :password WHERE id = :id";
      $stmt = $pdo -> prepare($sql);
      $stmt -> bindValue(":name",$name);
      $stmt -> bindValue("id",$user["id"]);
      $result = $stmt -> execute();

       // beginTransaction()の正常時のデータを保存
      $pdo -> commit();

      $_SESSION['id'] = $user["id"];
      $_SESSION['message'] = "ユーザー登録に成功しました";
      header('Location: /admin/index.php');
    }catch(PDOException $e){
    // beginTransaction()の正常時のデータを保存  
      $pdo -> rollBack();
      $message = $e -> getMessage();
        }
      }
    }
  }
} else{
  session_start();
  // isset全ての変数に値がセットされている場合のみTRUEを返します。
  $token = isset($_GET['token'] ) ? $_GET['token']:null;
  $email = isset($_GET['email']) ? $_GET['email']:null;

  // if(is_null($token) || is_null($email)){
  //   // errorページに送る
  //   header('Location: /');
  // }

  // if(isset($_SESSION["id"])){
  //   header('Location: /admin/index.php');
  // }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POSSE ユーザー登録</title>
      <!-- スタイルシート読み込み -->
  <link rel="stylesheet" href="./../assets/styles/common.css">
  <link rel="stylesheet" href="./../admin.css">
  <!-- Google Fonts読み込み -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&family=Plus+Jakarta+Sans:wght@400;700&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
  <header>
    <div>posse</div>
  </header>
  <div class="wrapper">
    <main>
      <div class="container">
        <h1 class="mb-4">ユーザー登録</h1>
          <?php if (isset($message)) { ?>
            <p><?= $message ?></p>
          <?php } ?>
          <form method="POST">
            <div class="mb-3">
              <label for="name" class="form-label">名前</label>
              <input type="text" name="name" id="name" class="form-control">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" name="disabled_email" class="email form-control" value="<?= $email ?>" id="email" >
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">パスワード</label>
              <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="mb-3">
              <label for="password_confirm" class="form-label">パスワード(確認)</label>
              <input type="password" name="password_confirm" id="password_confirm" class="form-control">
            </div>
            <input type="hidden" name="token" id="token" value="<?= $token ?>">
            <input type="hidden" name="email" value="<?= $email ?>">
            <button type="submit" class="btn submit">登録</button>
          </form>
      </div>
    </main>
  </div>
  <script>
    const submitButton = document.querySelector('.btn.submit')
    // Array.form 新しい配列を生成、form-controlクラスが入っているものを配列として生成
    const inputDoms = Array.from(document.querySelectorAll('.form-control'))
    const password = document.querySelector('#password')
    const passwordConfirm = document.querySelector('#password_confirm')
    // 対象要素.addEventListener( 種類, 関数, false )
    inputDoms.forEach(inputDom => {
      inputDom.addEventListener('input',event =>{
        // eventの処理を記述
        // dataの略？、dに意味はない、配列の1つ1つのvalueを抽出して配列の長さ
        // (d => d.value)条件
        const isFilled = inputDoms.filter(d => d.value).length === inputDoms.length
        // console.log(inputDoms);
        const isPasswordMatch = password.value === passwordConfirm.value
        submitButton.disabled = !(isFilled && isPasswordMatch)
        console.log(isFilled);
      })
    } )
    // 非同期処理
    const signup = async() => {
      const res =  await fetch(`/services/signup.php`,{
      // リソースを部分更新するメソッドです。
      method:'PATCH',
      // データを別の形式に変換すること
      body :JSON.stringify({
        name : document.querySelector('#name').value,
        email : document.querySelector('#email').value,
        password : document.querySelector('#password').value,
        password_confirm : document.querySelector('#token').value,
        token : document.querySelector('#token').value,
      }),
      headers:{
        'Accept': 'application/json,*/*',
        "Content-Type" : "application/x-www-form-unlencoded"
      },
      });
    const json = await res.json()
    if(res.status === 200){
      alert(json["message"])
      location.href = '/admin/index.php'
    } else{
      alert(json["error"]["message"])
    }
    }
  </script>
</html>
</body>