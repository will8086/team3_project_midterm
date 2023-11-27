<?php
// index主页用来表示登入状态
session_start();
// print_r($_SESSION);

if(isset($_SESSION["user_id"])){
    $mysqli = require("./database.php");

    $sql = "SELECT * FROM `restaurant_user` WHERE `restaurant_id` = {$_SESSION["user_id"]}";

    $result = $mysqli -> query($sql);

    $user = $result -> fetch_assoc();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <div class="container">
        <div class="py-4 w-25">
            <a href="./index.php" class="text-decoration-none text-reset"><h1>Home</h1></a>
        </div>
        <?php if (isset($user)):?>
        <div class="container">
            <div class="row">
                <div class="col-12 bg-white border border-dark-subtle rounded-3 d-flex px-4 py-3 mb-5">
                    <?php if (empty($user["img_file"])):?>
                        <div class="avatarbox d-flex">
                            <?= "<img class='rounded-circle imgbox' src='./img/default.jpg' alt=''>"; ?>
                        </div>
                    <?php else: ?>
                        <div class="avatarbox d-flex">
                            <?= "<img class='rounded-circle imgbox' src='./user/{$user['img_file']}' alt=''>"; ?>
                        </div>
                    <?php endif;?>
                        <div class="fs-1 text-primary p-3 d-flex align-items-end">Hi,
                            <?= htmlspecialchars($user["restaurant_name"])?>
                        </div>
                </div>
                    <?php if(empty($user["restaurant_address"])):?>
                            <!-- 隨便一個欄位檢查為null就顯示完善資料提示，一般為初次登入 -->
                            <div>
                                <a class="text-danger mx-2" href="./user/userProfile.php">請繼續完善你的資料！</a>
                            </div>

                    <?php else: ?>
                        <div class="col-4">
                            <div class="card" style="width: 18rem;">
                            <img src="./img/info.png" class="imgbox m-auto my-3 " alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">資料修改</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <a class="btn btn-outline-primary mx-2" href="./user/userProfile.php">資料修改</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="card" style="width: 18rem;">
                            <img src="./img/menu.png" class="imgbox m-auto my-3" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">菜單管理</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <a class="btn btn-outline-primary mx-2" href="./dishes/product.php">菜單管理</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">        
                            <div class="card" style="width: 18rem;" aria-hidden="true">
                            <img src="./img/protection.png" class="imgbox m-auto my-3" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title placeholder-glow">
                                    <span class="placeholder col-6"></span>
                                    </h5>
                                    <p class="card-text placeholder-glow">
                                    <span class="placeholder col-7"></span>
                                    <span class="placeholder col-4"></span>
                                    <span class="placeholder col-4"></span>
                                    <span class="placeholder col-6"></span>
                                    <span class="placeholder col-8"></span>
                                    </p>
                                    <a class="btn btn-primary disabled placeholder col-6" aria-disabled="true"></a>
                                </div>
                            </div>
                        </div>
                        

        </div>

                <?php endif;?>
                <div class="row">
                    <div class="col-12 mt-4">
                        <a class="btn btn-info btn-sm" href="./loginSignup/logout.php">Log out</a>
                    </div>
                </div>
                    
                <?php else: ?>

                    <p><a href="./loginSignup/login.php">Log in</a> or <a href="./loginSignup/signUp.php"> Sign up</a></p>
                    <a href="../utilities/navbar.php">回到管理頁面</a>

                <?php endif;?>
    </div>

    <script src="./js/bootstrap.bundle.min.js"></script>
</body>

</html>