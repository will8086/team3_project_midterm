<?php
// index主页用来表示登入状态
session_start();
// print_r($_SESSION);

if(isset($_SESSION["user_id"])){
    $mysqli = require("../database.php");

    $sql = "SELECT * FROM `restaurant_user` WHERE `restaurant_id` = {$_SESSION["user_id"]}";

    $result = $mysqli -> query($sql);
    // 這裡是mysqli_result 对象


    $user = $result -> fetch_assoc();
    // 這裡是陣列

    $userCheck = $result->num_rows;
    // 确认确实有笔数存在为1


}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/profile.css">
</head>

<body>
    <?php if (isset($user)):?>
            <?php if($result):?>

                <?php if($userCheck > 0):
                    $result->data_seek(0);
                    ?>

                    <?php while ($row = $result->fetch_assoc()):
                        // print_r($row['restaurant_phonenumber']);?>
                            <form action="./updateprofile.php" method="post" enctype="multipart/form-data">
                                <div class="container">
                                    <div class="py-4 w-25">
                                        <a href="../index.php" class="text-decoration-none text-reset"><h1>Home</h1></a>
                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class=" border bg-white rounded-3 col-7 p-4">
                                                <div class="d-flex flex-column">
                                                    <label class="fs-3" for="name">使用者名稱:</label>
                                                    <input class="my-3 rounded" type="text" id="name" name="name" value="<?=$row['restaurant_name']?>">
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <label class="fs-3" for="email">信箱:</label>
                                                    <input class="my-3 rounded" type="text" id="email" name="email" value="<?=$row['restaurant_email']?>">
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <label class="fs-3" for="phone">電話:</label>
                                                    <input class="my-3 rounded" type="text" id="phone" name="phone" value="<?=($row['restaurant_phonenumber'])?$row['restaurant_phonenumber'] : ''?>" required>
                                                    <!-- 三元運算子是空值直接是空字串，不是就是電話 -->
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <label class="fs-3" for="address">地址:</label>
                                                    <input class="my-3 rounded" type="text" id="address" name="address" value="<?=$row['restaurant_address']?>" required>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <label class="fs-3" for="intro">簡介:</label>
                                                    <textarea class="my-3 rounded" type="text" id="intro" name="intro" cols="30" rows="10"><?=$row['introduction']?></textarea>

                                                </div>       
                                            </div>
                                            <div class="col-1"></div>
                                            <div class="border bg-white rounded-3 col-4 p-4">
                                                <div class="d-flex flex-column">
                                                    <label class="fs-3" for="imgfile">上傳頭像:</label>
                                                            <?php if (!empty($user["img_file"])):?>
                                                                <div class="avatarbox d-flex justify-content-center mx-auto">
                                                                    <?= "<img class='rounded-circle imgbox' src='{$user['img_file']}' alt=''>"; ?>
                                                                </div>
                                                            <?php endif;?>
                                                        <input type="file" class="form-control my-5" id="imgfile" name="imgfile" aria-describedby="inputGroupFileAddon03" aria-label="Upload">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="my-3">
                                            <button type="submit" class="btn btn-outline-primary btn-sm me-2">修改資料</button>
                                            <a class="btn btn-outline-danger btn-sm ms-2" href="./changePassword.php">修改密码</a>
                                        </div>
                                    </div>    
                                </div>
                            </form>
                        <?php endwhile;?>
                    
                <?php endif;?>
            
            <?php endif;?>
    <?php endif;?>

    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>