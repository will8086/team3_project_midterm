<?php

require_once("../connect.php");
// $sql = "SELECT * FROM `CartProduct_detail` ORDER BY `quantity` ASC;";
//下面是, 只取出cart_id為3的資料
// $sql = "SELECT * FROM `CartProduct_detail` WHERE cart_id = 3 ORDER BY `quantity` ASC;";
// $sql = "SELECT * FROM `CartProduct_detail` WHERE product_id = 34 ORDER BY `quantity` ASC;";
// $sql = "SELECT * FROM `CartProduct_detail` WHERE product_id LiKE '%3%' ORDER BY `quantity` ASC;";

//判斷是否有網址變數
$where1 = "";
if(isset($_GET["product_id"])){
    $product_id = $_GET["product_id"];
    //可將$where1變數, 插入sql語法中
    $where1 = "WHERE `product_id` = $product_id";
}


//搜尋
$search = (isset($_GET["search"]))?$_GET["search"]:"";
$searchType = (isset($_GET["type"]))?$_GET["type"]:"";

if($search == ""){
    $searchSQL = "";
}else{
    //搜索匡有東西，才用WHERE ～～
    $searchSQL = "WHERE `$searchType` LIKE '%$search%'";
}


if(!isset($_GET["page"])){
    $page = 1;
}else{
    $page = $_GET["page"];
}


$perPage = 10;
$pageStart = ($page - 1) * $perPage;

//取得資料的總筆數
$totalSql = "SELECT COUNT(*) as total FROM `Oder_detail` $where1";
//$conn --> 連線物件
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalRows = $totalRow['total'];

//算出總頁數
$totalPages = ceil($totalRows / $perPage);

$sql = "SELECT * FROM `Oder_detail` JOIN product ON oder_detail.product_id = product.product_id
JOIN order_general ON order_general.order_id = oder_detail.order_id 
ORDER BY `Oder_detail`.`product_id` ASC" ;

// var_dump($sql);
// exit;
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
    <title>Order Detail 留言列表</title>
    <style>
    .msg{
        display: flex;
    }
    .ordernum{
        width: 200px;
    }
    .id{
        width: 150px;
    }
    .pn{
        width: 110px;
    }
    .qt{
        width: 110px;
    }
    .name{
        width: 110px;
    }
    .edit{
        width: 110px;
    }
    .content{
        width: calc(100% - 200px - 110px - 110px - 110px - 110px - 150px)
    }
    .time{
        width: 230px;
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
  <h1 class="pt-4 fw-bold">訂單明細</h1>
        <?php if($msgNum > 0): ?>
            <div class="d-flex">
                <div class="my-2 me-auto ">
                    目前共 <?=$msgNum?> 筆資料
                </div>

                    <!-- 增加的部份 start -->
                    <div class="me-1">
                        <div class="input-group input-group-sm">
                            <div class="input-group-text">
                                <input name="searchType" id="searchType1" type="radio" class="form-check-input" value="order_id" checked>
                                <label for="searchType1" class="me-2">訂單編號</label>
                                <input name="searchType" id="searchType2" type="radio" class="form-check-input" value="product_id">
                                <label for="searchType2">商品編號</label>
                            </div>
                            <input name="search" type="text" class="form-control form-control-sm" placeholder="搜尋">
                            <div class="btn titlecgr btn-sm btn-search">送出搜尋</div>
                        </div>
                    </div>
                    <!-- 增加的部份 end -->


                <div>
                <a href="../utilities/navbar.php?webpage=orderForm04.html" class="btn titlecgr btn-sm">增加資料</a>
                </div>
            </div>
            <div class="msg titlecgr">
                <div class="ordernum">訂單編號</div>
                <div class="id">商品編號</div>
                <div class="content">商品名稱</div>
                <div class="pn">單價</div>
                <div class="qt">數量</div>
                <div class="name">小計</div>
                <div class="edit">編輯</div>  
            </div>

            <!-- 因已經用fetch_all()來取資料, 就無需用while跑迴圈 -->
            <!--  while($row = $result->fetch_assoc()):  有加php-->
        <?php foreach($rows as $row):?>
            <div class="msg my-1">
            <div class="ordernum"><?=$row["order_id"]?></div>
                <div class="id"><?=$row["product_id"]?></div>
                <div class="content"><?=$row["product_name"]?></div>
                <div class="pn"><?=$row["price"]?></div>
                <div class="qt"><?=$row["num"]?></div>
                <?php $subtotal = $row["price"] * $row["num"];?>
                <div class="name"><?=$subtotal?></div>
                <div class="edit">  
                    <span class="btn btn-sm btn-del" idn="<?=$row["order_id"]?>"><i class="fa-regular fa-trash-can"></i></span>
                    <a href="../utilities/navbar.php?webpage=orderPage01.php&order_id=<?=$row["order_id"]?>" class="btn btn-sm"><i class="fa-regular fa-pen-to-square"></i></a>
                </div> 
            </div>
        <?php endforeach; ?>
            <?php elseif($msgNum == 0): ?>
                目前沒有資料
            <?php else: ?>
                發生錯誤：<?= $errorMsg ?>
        <?php endif;  ?>

        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                 
                    <?php for ($i=1;$i<=$totalPages; $i++):?>
                        <li class="page-item">
                            <a class="page-link <?=($page==$i)?"active":""?>" href="../utilities/navbar.php?webpage=orderPage.php?page=<?=$i?>"><?=$i?></a>
                        </li>
                    <?php endfor; ?>

                       
                </ul>
            </nav>
        </div>



</div>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script>
        const btnDels = document.querySelectorAll(".btn-del");
        [...btnDels].map(function(btnDel, index){
            btnDel.addEventListener("click", function(){
                let order_id = parseInt(this.getAttribute("idn"));
                let product_id = parseInt(this.getAttribute("product_id"));
                if(window.confirm("是否確認刪除？") === true){
                    window.location.href = `../utilities/navbar.php?webpage=orderDelete.php&order_id=${order_id}&product_id=${product_id}`;
                }
            })
        });

        const btnSearch = document.querySelector(".btn-search");
        btnSearch.addEventListener("click", function(){
            let query = document.querySelector("input[name=search]").value;
            let queryType = document.querySelector("input[name=searchType]:checked").value;
           window.location.href = `./utilities/navbar.php?webpage=orderPage.php&search=${query}&type=${queryType}`;

        });

    </script>
</body>

</html>