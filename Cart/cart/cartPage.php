<?php

require_once("../connect.php");
// $sql = "SELECT * FROM `CartProduct_detail` ORDER BY `quantity` ASC;";
//下面是, 只取出cart_id為3的資料
// $sql = "SELECT * FROM `CartProduct_detail` WHERE cart_id = 3 ORDER BY `quantity` ASC;";
// $sql = "SELECT * FROM `CartProduct_detail` WHERE product_id = 34 ORDER BY `quantity` ASC;";
// $sql = "SELECT * FROM `CartProduct_detail` WHERE product_id LiKE '%3%' ORDER BY `quantity` ASC;";

//判斷是否有網址變數
$where1 = "";
if(isset($_GET["cart_id"])){
    $cart_id = $_GET["cart_id"];
    //可將$where1變數, 插入sql語法中
    $where1 = "WHERE `cart_id` = $cart_id";
}

if(!isset($_GET["page"])){
    $page = 1;
}else{
    $page = $_GET["page"];
}

$perPage = 10;
$pageStart = ($page - 1) * $perPage;
//取得資料總筆數
$totalSql = "SELECT COUNT(*) as total FROM `cart` $where1";
//從資料庫抓取資料
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult -> fetch_assoc();
$totalRows = $totalRow['total'];

// 計算總頁數
$totalPages = ceil($totalRows / $perPage);

$sql = "SELECT * FROM `cart` ORDER BY `cart`.`cart_id` ASC;";
try{
    //使用result來承接內容
     $result = $conn->query($sql);
     $msgNum = $result -> num_rows;
     //把所有資料一次取出, 便關聯式陣列, 並且最後一筆停在第0筆
     $rows = $result -> fetch_all(MYSQLI_ASSOC);
    }catch(mysqli_sql_exception $exc){
    //  die("讀取失敗:" .$exc->getMessage());
     //將錯誤訊息存到$errorMsg變數
     $errorMsg = $exc->getMessage();
     $msgNum = -1;
    }
    $conn->close();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../../css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>留言列表</title>
    <style>
    .msg{
        display: flex;
    }
    .id{
        width: 600px;
    }
    .name{
        width: 520px;
    }
    .edit{
        width: calc(100% - 600px - 520px);
    }
    h1, .totalinfo {
        color: #777e5c;
    }
   .bgcwhite{
    background-color: #F1Ece2;
   }
   .titlecgr{
    background-color: #777e5c;
    color: white;
   }
   .pagination{
        --bs-pagination-color: #777e5c;
        --bs-pagination-hover-color: #777e5c;
        --bs-pagination-focus-color: #777e5c;
        }

        .active>.page-link, .page-link.active {
        background-color: #777e5c;
        border-color: #777e5c;
        }

        .form-check-input:checked {
        background-color: #777e5c;
        border-color: #777e5c;
        }
    </style>
</head>

<body> 
<div class="container p-4 bgcwhite">
  <h1 class="pt-4">購物車系統</h1>
        <?php if($msgNum > 0): ?>
            <div class="d-flex">
                <div class="my-2 me-auto totalinfo">
                    目前共 <?=$msgNum?> 筆資料
                </div>
                <div>
                <a href="navbar.php?webpage=cartForm04.html" class="btn titlecgr btn-sm">增加資料</a>
                </div>
            </div>
            <div class="msg titlecgr ps-1">
                <div class="id">購物車編號</div>
                <div class="name">會員編號</div>
                <div class="edit">編輯</div>
                
            </div>
            <!-- 因已經用fetch_all()來取資料, 就無需用while跑迴圈 -->
            <!--  while($row = $result->fetch_assoc()):  有加php-->
        <?php foreach($rows as $row):?>
            <div class="msg my-1">
                <div class="id"><?=$row["cart_id"]?></div>
                <div class="name"><?=$row["user_id"]?></div>
                <div class="edit">
                    <span class="btn btn-sm btn-del" idn="<?=$row["cart_id"]?>"><i class="fa-regular fa-trash-can"></i></span>
                    <a href="./navbar.php?webpage=cartPage1.php&cart_id=<?=$row["cart_id"]?>" class="btn btn-sm"><i class="fa-regular fa-pen-to-square"></i></a>
                </div>
            </div>
        <?php endforeach; ?>
            <?php elseif($msgNum == 0): ?>
                目前沒有資料
            <?php else: ?>
                發生錯誤：<?php $errorMsg ?>
        <?php endif;  ?>

        <div class="d-flex justify-content-center mt-3">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php for ($i=1;$i<=$totalPages; $i++): ?>
                        <li class="page-item">
                            <a class="page-link <?= ($page==$i)?"active":""?>" href="./navbar.php?webpage=cartPage.php?page=<?=$i?>"><?=$i?></a>
                        </li>
                    <?php endfor; ?>

                        <!-- 下一頁 -->
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                </ul>
            </nav>
        </div>


</div>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script>
        const btnDels = document.querySelectorAll(".btn-del");
        //抓取的會是類陣列, 因此要轉為陣列
        [...btnDels].map(function(btnDel, index){
            btnDel.addEventListener("click", function(){
                let cart_id = parseInt(this.getAttribute("idn"));
                if(window.confirm("是否確認刪除？") === true ){
                    window.location.href =`../utilities/navbar.php?webpage=cartDelete.php&cart_id=${cart_id}`;
                }
            });
        });

    </script>
</body>

</html>