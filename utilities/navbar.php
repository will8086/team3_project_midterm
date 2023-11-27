<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("location: ../User/login.php");
}

require("../connect.php");
$webpage = "";
if (isset($_GET["webpage"])) {
    $webpage = $_GET["webpage"];
}


?>
<html lang="zh-TW">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,	initial-scale=1">
    <title>選單</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg1 {
            background-color: #f1ece2;
        }

        .bg2 {
            background-color: #777e5c;
        }

        .text1 {
            color: #777e5c;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg1">
        <div class="container-fluid">
            <a class="navbar-brand ms-3 fw-bold fs-3" href="./navbar.php">
                <img src="../img/logo.png" alt="Logo" width="200" height="150" class="d-inline-block">
            </a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav fw-bold">
                    <span class="text1 d-flex align-items-center fs-4 me-2">
                        <i class="fa-solid fa-hands me-2" style="color: #777e5c;"></i>Hi~歡迎回來，
                        <?= $_SESSION["user"]["name"] ?>
                    </span>
                    <li class="nav-item dropdown pe-1">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <?php if (isset($_SESSION["user"]["img"]) && !empty($_SESSION["user"]["img"])) : ?>
                                <img src="../img/<?= $_SESSION["user"]["img"] ?>" width="80" height="80" class="d-inline-block align-text-bottom rounded-circle img-fluid">
                            <?php else : ?>
                                <img src="../img/noimg.png" width="80" height="80" class="d-inline-block align-text-bottom rounded-circle img-fluid">
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end bg-light">
                            <li><a class="dropdown-item fw-bold" href="../User/logout.php">登出</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
    <div class="side-menu d-flex h-200">
        <nav class="bg1 position-relative pt-3 ps-2" style="width: 14%">
            <div>
                <div class="d-grid gap-2 p-3">
                    <button class="btn bg2 btn-sm fs-4 fw-bold text-white" type="button" data-bs-target="#menu1" data-bs-toggle="collapse">
                        <i class="fa-solid fa-user fa-sm me-2" style="color: #ffffff"></i>使用者</button>
                    <a type="button" class="collapse fs-5 text-decoration-none text-center fw-bold text1
                    <?= ($webpage == "user_list.php") ? "active" : "" ?>" id="menu1" href="?webpage=user_list.php">
                        <i class="fa-solid fa-user-gear fa-sm me-2" style="color: #777e5c;"></i>使用者管理</a>
                    <a type="button" class="collapse fs-5 text-decoration-none text-center fw-bold text1" id="menu1">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #777e5c;"></i>數據統計</a>
                </div>
                <div class="d-grid gap-2 p-3">
                    <button class="btn bg2 fs-4 fw-bold text-white" type="button" data-bs-target="#menu2" data-bs-toggle="collapse">
                        <i class="fa-solid fa-utensils fa-sm me-2" style="color: #ffffff;"></i>餐廳</button>
                    <a type="button" class="collapse fs-5 text-decoration-none text-center fw-bold text1" id="menu2" href="../restaurant/index.php">
                        <i class="fa-solid fa-folder fa-sm me-2" style="color: #777e5c;"></i>餐廳管理</a>
                    <a type="button" class="collapse fs-5 text-decoration-none text-center fw-bold text1" id="menu2">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #777e5c;"></i>數據統計</a>
                </div>
                <div class="d-grid gap-2 p-3">
                    <button class="btn bg2 fs-4 fw-bold text-white" type="button" data-bs-target="#menu3" data-bs-toggle="collapse">
                        <i class="fa-solid fa-bowl-rice fa-sm me-2" style="color: #ffffff;"></i>訂位</button>
                    <a type="button" class="collapse fs-5 text-decoration-none text-center fw-bold text1" id="menu3" <?= ($webpage == "book_list.php") ? "active" : "" ?> id="menu6" href="?webpage=book_list.php">
                        <i class="fa-solid fa-folder fa-sm me-2" style="color: #777e5c;"></i>訂位管理</a>
                    <a type="button" class="collapse fs-5 text-decoration-none text-center fw-bold text1" id="menu3">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #777e5c;"></i>數據統計</a>
                </div>
                <div class="d-grid gap-2 p-3">
                    <button class="btn bg2 fs-4 fw-bold text-white" type="button" data-bs-target="#menu5" data-bs-toggle="collapse">
                        <i class="fa-solid fa-store fa-sm me-2" style="color: #ffffff;"></i>商城</button>
                    <a type="button" class="collapse fs-5 text-decoration-none text-center fw-bold text1" id="menu5" <?= ($webpage == "product_list.php") ? "active" : "" ?> id="menu5" href="?webpage=product_list.php">
                        <i class="fa-solid fa-cash-register fa-sm me-2" style="color: #777e5c;"></i>商品管理</a>
                    <a type="button" class="collapse fs-5 text-decoration-none text-center fw-bold text1" id="menu5" <?= ($webpage == "style-product_list.php") ? "active" : "" ?> id="menu5" href="?webpage=style-product_list.php">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #777e5c;"></i>分類管理</a>
                    <a type="button" class="collapse fs-5 text-decoration-none text-center fw-bold text1" id="menu5" <?= ($webpage == "style-product_list.php") ? "active" : "" ?> id="menu5" href="?webpage=style-product_list.php">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #777e5c;"></i>標籤管理</a>
                </div>
                <div class="d-grid gap-2 p-3">
                    <button class="btn bg2 fs-4 fw-bold text-white" type="button" data-bs-target="#menu4" data-bs-toggle="collapse">
                        <i class="fa-solid fa-cart-shopping fa-sm me-2" style="color: #ffffff;"></i>購物車</button>
                    <a type="button" class="collapse text1 fs-5 text-decoration-none text-center fw-bold" id="menu4" <?= ($webpage == "cartPage02.php") ? "active" : "" ?> id="menu6" href="?webpage=cartPage02.php">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #777e5c;"></i>購物車清單</a>
                    <a type="button" class="collapse text1 fs-5 text-decoration-none text-center fw-bold" id="menu4" <?= ($webpage == "orderPagee.php") ? "active" : "" ?> id="menu6" href="?webpage=orderPagee.php">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #777e5c;"></i>訂單管理</a>
                    <a type="button" class="collapse fs-5 text-decoration-none text-center fw-bold text1" id="menu4" <?= ($webpage == "orderPage.php") ? "active" : "" ?> id="menu6" href="?webpage=orderPage.php">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #777e5c;"></i>訂單明細</a>
                </div>
                <div class="d-grid gap-2 p-3">
                    <button class="btn bg2 fs-4 fw-bold text-white" type="button" data-bs-target="#menu6" data-bs-toggle="collapse">
                        <i class="fa-solid fa-camera-retro fa-sm me-2" style="color: #ffffff;"></i>食記</button>
                    <a type="button" class="collapse fs-5 text-decoration-none text-center fw-bold text1" id="menu6" <?= ($webpage == "post_ArticleList.php") ? "active" : "" ?> id="menu6" href="?webpage=post_ArticleList.php">
                        <i class="fa-solid fa-pen-to-square me-2" style="color: #777e5c;"></i>食記管理</a>
                    <a type="button" class="collapse fs-5 text-decoration-none text-center fw-bold text1" id="menu6">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #777e5c;"></i>統計數據</a>
                    <a type="button" class="collapse fs-5 text-decoration-none text-center fw-bold text1" id="menu6">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #777e5c;"></i>標籤管理</a>
                    <a type="button" class="collapse fs-5 text-decoration-none text-center fw-bold text1" id="menu6">
                        <i class="fa-solid fa-chart-column fa-sm me-2" style="color: #777e5c;"></i>地區管理</a>
                </div>
            </div>
        </nav>
        <main class="w-100 bg1">
            <?php if ($webpage == "") {
                require("../index.php");
            } ?>
            <?php if ($webpage == "user_list.php") {
                require("../User/user_list.php");
            } ?>
            <?php if ($webpage == "user_add.php") {
                require("../User/user_add.php");
            } ?>
            <?php if ($webpage == "user_update.php") {
                require("../User/user_update.php");
            } ?>

            <?php if ($webpage == "post_ArticleList.php") {
                require("../post/post_ArticleList.php");
            } ?>
            <?php if ($webpage == "post_NewArticle.php") {
                require("../post/post_NewArticle.php");
            } ?>
            <?php if ($webpage == "post_ModifyArticle.php") {
                require("../post/post_ModifyArticle.php");
            } ?>

            <?php if ($webpage == "product_list.php") {
                require("../Product/product_list.php");
            } ?>
            <?php if ($webpage == "product_add.php") {
                require("../Product/product_add.php");
            } ?>
            <?php if ($webpage == "product_doAdd.php") {
                require("../Product/product_doAdd.php");
            } ?>
            <?php if ($webpage == "product_doAddImg.php") {
                require("../Product/product_doAddImg.php");
            } ?>
            <?php if ($webpage == "product_doDelete.php") {
                require("../Product/product_doDelete.php");
            } ?>
            <?php if ($webpage == "product_doDelImg.php") {
                require("../Product/product_doDelImg.php");
            } ?>
            <?php if ($webpage == "product_doUpdateOO.php") {
                require("../Product/product_doUpdateOO.php");
            } ?>
            <?php if ($webpage == "product_ImgOO.php") {
                require("../Product/product_ImgOO.php");
            } ?>
            <?php if ($webpage == "product_updateOO.php") {
                require("../Product/product_updateOO.php");
            } ?>

            <?php if ($webpage == "style-product_add.php") {
                require("../Product/Style/product_add.php");
            } ?>
            <?php if ($webpage == "style-product_addL.php") {
                require("../Product/Style/product_addL.php");
            } ?>
            <?php if ($webpage == "style-product_doAdd.php") {
                require("../Product/Style/product_doAdd.php");
            } ?>
            <?php if ($webpage == "style-product_doAddL.php") {
                require("../Product/Style/product_doAddL.php");
            } ?>
            <?php if ($webpage == "style-product_doDelete.php") {
                require("../Product/Style/product_doDelete.php");
            } ?>
            <?php if ($webpage == "style-product_doDeleteL.php") {
                require("../Product/Style/product_doDeleteL.php");
            } ?>
            <?php if ($webpage == "style-product_doUpdate.php") {
                require("../Product/Style/product_doUpdate.php");
            } ?>
            <?php if ($webpage == "style-product_doUpdateL.php") {
                require("../Product/Style/product_doUpdateL.php");
            } ?>
            <?php if ($webpage == "style-product_list.php") {
                require("../Product/Style/product_list.php");
            } ?>
            <?php if ($webpage == "style-product_update.php") {
                require("../Product/Style/product_update.php");
            } ?>
            <?php if ($webpage == "style-product_updateL.php") {
                require("../Product/Style/product_updateL.php");
            } ?>
            <?php if ($webpage == "style-product_updateL.php") {
                require("../Product/utilities/alertFunc.php");
            } ?>


            <?php if ($webpage == "cartPage.php") {
                require("../Cart/cart/cartPage.php");
            } ?>
            <?php if ($webpage == "cartForm04.html") {
                require("../Cart/cart/cartForm04.html");
            } ?>

            <?php if ($webpage == "cartPage1.php") {
                require("../Cart/cart/cartPage1.php");
            } ?>

            <?php if ($webpage == "cartUpdate01.php") {
                require("../Cart/cart/cartUpdate01.php");
            } ?>
            <?php if ($webpage == "cartPage1.php") {
                require("../Cart/cart/cartPage1.php");
            } ?>
            <?php if ($webpage == "cartInsert.php") {
                require("../Cart/cart/cartInsert.php");
            } ?>

            <?php if ($webpage == "cartDelete.php") {
                require("../Cart/cart/cartDelete.php");
            } ?>

            <?php if ($webpage == "orderForm04.html") {
                require("../Cart/orderdetail/orderForm04.html");
            } ?>

            <?php if ($webpage == "orderDelete.php") {
                require("../Cart/orderdetail/orderDelete.php");
            } ?>

            <?php if ($webpage == "orderInsert.php") {
                require("../Cart/orderdetail/orderInsert.php");
            } ?>

            <?php if ($webpage == "orderUpdate.php") {
                require("../Cart/orderdetail/orderUpdate.php");
            } ?>

            <?php if ($webpage == "orderPage.php") {
                require("../Cart/orderdetail/orderPage.php");
            } ?>

            <?php if ($webpage == "orderPage01.php") {
                require("../Cart/orderdetail/orderPage01.php");
            } ?>

            <?php if ($webpage == "orderPagee.php") {
                require("../Cart/ordergeneral/orderPagee.php");
            } ?>

            <?php if ($webpage == "orderDelete2.php") {
                require("../Cart/ordergeneral/orderDelete2.php");
            } ?>

            <?php if ($webpage == "orderForm.html") {
                require("../Cart/ordergeneral/orderForm.html");
            } ?>

            <?php if ($webpage == "orderInsert2.php") {
                require("../Cart/ordergeneral/orderInsert2.php");
            } ?>

            <?php if ($webpage == "orderPage2.php") {
                require("../Cart/ordergeneral/orderPage2.php");
            } ?>

            <?php if ($webpage == "orderUpdate2.php") {
                require("../Cart/ordergeneral/orderUpdate2.php");
            } ?>

            <?php if ($webpage == "cartPage02.php") {
                require("../Cart/cartdetail/cartPage02.php");
            } ?>
            <?php if ($webpage == "cartpage01.php") {
                require("../Cart/cartdetail/cartpage01.php");
            } ?>
            <?php if ($webpage == "cartForm.html") {
                require("../Cart/cartdetail/cartForm.html");
            } ?>
            <?php if ($webpage == "cartInsert02.php") {
                require("../Cart/cartdetail/cartInsert02.php");
            } ?>
            <?php if ($webpage == "cartDelete2.php") {
                require("../Cart/cartdetail/cartDelete2.php");
            } ?>
            <?php if ($webpage == "cartUpdate.php") {
                require("../Cart/cartdetail/cartUpdate.php");
            } ?>








            <?php if ($webpage == "pageBooksList3.php") {
                require("../book/pageBooksList3.php");
            } ?>



            <?php if ($webpage == "book_list.php") {
                require("../book/book_list.php");
            } ?>
            <?php if ($webpage == "book_dashboard.php") {
                require("../book/book_dashboard.php");
            } ?>
            <?php if ($webpage == "book_add.html") {
                require("../book/book_add.html");
            } ?>
            <?php if ($webpage == "book_delete.php") {
                require("../book/book_delete.php");
            } ?>
            <?php if ($webpage == "book_insert.php") {
                require("../book/book_insert.php");
            } ?>
            <?php if ($webpage == "book_pageBook.php") {
                require("../book/book_pageBook.php");
            } ?>
            <?php if ($webpage == "book_update.php") {
                require("../book/book_update.php");
            } ?>

        </main>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>