<?php
require('../connect.php');

if (!isset($_GET["id"])) {
    exit;
} else {
    $id = $_GET["id"];
}

$sql = "SELECT * FROM `user` WHERE `user_id`=$id;";
$sql2 = "SELECT `user_img` FROM `user` WHERE `user_id`=$id;";
$usertag = "SELECT user.user_id,food_tag.food_tag_id 
            FROM user_tag 
            JOIN food_tag ON food_tag.food_tag_id = user_tag.food_tag_id 
            JOIN user ON user.user_id=user_tag.user_id 
            WHERE user.user_id=$id;";
try {
    $result = $conn->query($sql);
    $result2 = $conn->query($sql2);
    $row = $result->fetch_assoc();
    $row2 = $result2->fetch_assoc();
} catch (mysqli_sql_exception $exc) {
    die("讀取失敗" . $exc->getMessage());
}


try {
    $usertagresult = $conn->query($usertag);
    $usertags = [];
    while ($tagrow = $usertagresult->fetch_assoc()) {
        $usertags[] = $tagrow;
    }
} catch (mysqli_sql_exception $exc) {
    die("讀取失敗" . $exc->getMessage());
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <title>表單</title>
</head>

<body>
    <div class="border container mt-4 rounded bg-white">
        <div class="d-flex my-2">
            <h2 class="fw-bold">修改會員資料</h2>

            <span class="fs-5 ms-auto fw-bold border rounded-4 p-2 bg2 mb-1 text-light">
                最後修改時間:<?= $row["updatetime"]; ?></span>
        </div>
        <form action="../User/doUpdate.php" method="post" enctype="multipart/form-data">
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bg2 fw-bold rounded-start-4" type="button">更改大頭照</span>
                <div class="col-auto ps-5 pt-5 ">
                    <input class="form-control" type="file" name="myfile" accept=".png,.jpg,.jpeg">
                </div>
                <div class="ms-4">
                    <span class="fs-4 fw-bold ms-5">目前的大頭照:</span>
                </div>
                <div class="col-auto ms-5">
                    <?php if (isset($row["user_img"]) && !empty($row["user_img"])) : ?>
                        <img src="<?= "../User/uimg/$row[user_img]" ?>" width="100" height="100" class="d-inline-block align-text-bottom rounded-circle img-fluid">
                    <?php else : ?>
                        <img src="../User/uimg/noimg.png" width="100" height="100" class="d-inline-block align-text-bottom rounded-circle img-fluid">
                    <?php endif; ?>
                </div>
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bg2 fw-bold rounded-start-4">email</span>
                <input name="email" type="text" class="form-control" value="<?= $row["user_email"]; ?>" disabled readonly>
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bg2 fw-bold rounded-start-4">姓名</span>
                <input name="name" type="text" class="form-control" value="<?= $row["user_name"]; ?>">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bg2 fw-bold rounded-start-4">暱稱</span>
                <input name="nickname" type="text" class="form-control" value="<?= $row["nickname"]; ?>">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bg2 fw-bold rounded-start-4">手機</span>
                <input name="phone" type="text" class="form-control" value="<?= $row["user_phone"]; ?>">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bg2 fw-bold rounded-start-4">密碼</span>
                <input name="password" type="password" class="form-control" placeholder="請輸入">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bg2 fw-bold rounded-start-4">再輸入一次密碼</span>
                <input name="password2" type="password" class="form-control" placeholder="請輸入">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <div class="d-flex">
                    <span class="input-group-text text-light bg2 fw-bold rounded-start-4">喜愛的食物種類</span>
                    <input type="checkbox" class="btn-check" id="btn-check-1" name="likefoodtag[]" value="1" <?= in_array(1, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-warning ms-2 rounded rounded-4 fw-bold" for="btn-check-1">
                        台式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-2" name="likefoodtag[]" value="2" <?= in_array(2, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-warning ms-2 rounded rounded-4 fw-bold" for="btn-check-2">中式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-3" name="likefoodtag[]" value="3" <?= in_array(3, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-warning ms-2 rounded rounded-4 fw-bold" for="btn-check-3">日式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-4" name="likefoodtag[]" value="4" <?= in_array(4, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-warning ms-2 rounded rounded-4 fw-bold" for="btn-check-4">韓式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-5" name="likefoodtag[]" value="5" <?= in_array(5, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-warning ms-2 rounded rounded-4 fw-bold" for="btn-check-5">港式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-6" name="likefoodtag[]" value="6" <?= in_array(6, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-warning ms-2 rounded rounded-4 fw-bold" for="btn-check-6">美式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-7" name="likefoodtag[]" value="7" <?= in_array(7, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-warning ms-2 rounded rounded-4 fw-bold" for="btn-check-7">義式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-8" name="likefoodtag[]" value="8" <?= in_array(8, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-warning ms-2 rounded rounded-4 fw-bold" for="btn-check-8">法式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-9" name="likefoodtag[]" value="9" <?= in_array(9, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-warning ms-2 rounded rounded-4 fw-bold" for="btn-check-9">西式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-10" name="likefoodtag[]" value="10" <?= in_array(10, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-warning ms-2 rounded rounded-4 fw-bold" for="btn-check-10">泰式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-11" name="likefoodtag[]" value="11" <?= in_array(11, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-warning ms-2 rounded rounded-4 fw-bold" for="btn-check-11">越式</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-12" name="likefoodtag[]" value="12" <?= in_array(12, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-danger ms-2 rounded rounded-4 fw-bold" for="btn-check-12">火鍋</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-13" name="likefoodtag[]" value="13" <?= in_array(13, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-danger ms-2 rounded rounded-4 fw-bold" for="btn-check-13">燒烤</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-14" name="likefoodtag[]" value="14" <?= in_array(14, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-danger ms-2 rounded rounded-4 fw-bold" for="btn-check-14">牛排</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-15" name="likefoodtag[]" value="15" <?= in_array(15, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-danger ms-2 rounded rounded-4 fw-bold" for="btn-check-15">熱炒</label><br>
                </div>
                <div class="d-flex mt-2" style="margin-left: 136px;">
                    <input type="checkbox" class="btn-check" id="btn-check-16" name="likefoodtag[]" value="16" <?= in_array(16, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-success ms-2 rounded rounded-4 fw-bold" for="btn-check-16">素食</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-17" name="likefoodtag[]" value="17" <?= in_array(17, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-17">飲品</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-18" name="likefoodtag[]" value="18" <?= in_array(18, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-18">酒吧</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-19" name="likefoodtag[]" value="19" <?= in_array(19, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-19">果汁</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-20" name="likefoodtag[]" value="20" <?= in_array(20, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-secondary ms-2 rounded rounded-4 fw-bold" for="btn-check-20">咖啡</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-21" name="likefoodtag[]" value="21" <?= in_array(21, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-21">茶</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-22" name="likefoodtag[]" value="22" <?= in_array(22, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-danger ms-2 rounded rounded-4 fw-bold" for="btn-check-22">炸物</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-23" name="likefoodtag[]" value="23" <?= in_array(23, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-dark ms-2 rounded rounded-4 fw-bold" for="btn-check-23">吃到飽</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-24" name="likefoodtag[]" value="24" <?= in_array(24, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-24">小吃</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-25" name="likefoodtag[]" value="25" <?= in_array(25, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-25">甜點</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-26" name="likefoodtag[]" value="26" <?= in_array(26, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-info ms-2 rounded rounded-4 fw-bold" for="btn-check-26">冰品</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-27" name="likefoodtag[]" value="27" <?= in_array(27, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-secondary ms-2 rounded rounded-4 fw-bold" for="btn-check-27">麵食</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-28" name="likefoodtag[]" value="28" <?= in_array(28, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-success ms-2 rounded rounded-4 fw-bold" for="btn-check-28">壽司</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-29" name="likefoodtag[]" value="29" <?= in_array(29, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-danger ms-2 rounded rounded-4 fw-bold" for="btn-check-29">義大利麵</label><br>
                    <input type="checkbox" class="btn-check" id="btn-check-30" name="likefoodtag[]" value="30" <?= in_array(30, array_column($usertags, 'food_tag_id')) ? 'checked' : ''; ?>>
                    <label class="btn btn-outline-primary ms-2 rounded rounded-4 fw-bold" for="btn-check-30">海鮮</label><br>
                </div>
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bg2 fw-bold rounded-start-4">自我簡介</span>
                <textarea class="form-control" rows="3" name="selfintr"><?= $row["self_intr"]; ?></textarea>
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bg2 fw-bold rounded-start-4">創建帳號時間</span>
                <input name="phone" type="text" class="form-control" value="<?= $row["create_date"]; ?>" disabled readonly>
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bg2 fw-bold rounded-start-4" disabled readonly>最後上線時間</span>
                <input name="phone" type="text" class="form-control" value="<?= $row["last_login_time"]; ?>" disabled readonly>
            </div>
            <div class="mt-3 text-end">
                <button type="submit" class="btn btn-lg bg2 btn-send fw-bold text-white">送出</button>
            </div>
        </form>

        <script src="./js/bootstrap.bundle.min.js"></script>
        <script>
            const form = document.querySelector("form");
            const btnSend = document.querySelector(".btn-send");
            btnSend.addEventListener("click", function(e) {
                e.preventDefault();
                let name = document.querySelector("input[name=name]").value;
                let pwd1 = document.querySelector("input[name=password]").value;
                let pwd2 = document.querySelector("input[name=password2]").value;
                if (name == "") {
                    document.querySelector("input[name=name]").classList.add('is-invalid');
                    return false;
                }
                if (pwd1 == "") {
                    document.querySelector("input[name=password]").classList.add('is-invalid');
                    return false;
                }
                if (pwd2 == "") {
                    document.querySelector("input[name=password2]").classList.add('is-invalid');
                    return false;
                }
                if (pwd2 != pwd1) {
                    document.querySelector("input[name=password]").classList.add('is-invalid');
                    document.querySelector("input[name=password2]").classList.add('is-invalid');
                    return false;
                }
            })
        </script>
</body>

</html>