<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <title>登入頁面</title>
    <style>
        .block{
                width: 300px;
                height: 250px;
                background-color:#777e5c;
        }
        .bg1{
        background-color:#f1ece2;
        }       
    </style>
</head>

<body class="bg1">
    <div class="block p-3 position-absolute start-0 end-0 m-auto rounded-2 mt-5">
        <h2 class="text-light">食食嗑嗑登入系統</h2>
            <form action="./doLogin.php" method="post">
                <input type="text" name="email" class="form-control mb-2" placeholder="使用者電子郵件">
                <input type="password" name="password1" class="form-control mb-2" placeholder="使用者密碼">
                <input type="password" name="password2" class="form-control mb-2" placeholder="再輸入一次使用者密碼">
                <div class="text-end">
                <button class="btn bg1 btn-send mt-1 fw-bold">送出</button>
                </div>
            </form>
    </div>
    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>