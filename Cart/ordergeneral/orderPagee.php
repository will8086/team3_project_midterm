<?php

require_once("../connect.php");


//判斷是否有網址變數
$where1 = "";
if(isset($_GET["order_id"])){
    $order_id = $_GET["order_id"];
    //可將$where1變數, 插入sql語法中
    // $where1 = "WHERE `order_id` = $order_id";
}

if(!isset($_GET["page"])){
    $page = 1;
}else{
    $page = $_GET["page"];
}

$perPage = 10;
$pageStart = ($page - 1 ) * $perPage;
//取得資料的總筆數
$totalSql = "SELECT COUNT(*) as total FROM `Order_general` $where1";
//$conn --> 連線物件
$totalResult = $conn->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$totalRows = $totalRow['total'];

// 計算總頁數
$totalPages = ceil($totalRows / $perPage);





$sql = "SELECT * FROM `Order_general` JOIN user ON order_general.user_id = user.user_id ORDER BY `order_id` ASC LIMIT $pageStart, $perPage";
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
    <title>Order General 留言列表</title>
    <style>
    .msg{
        display: flex;
    }
    .id{
        width: 200px;
    }
    .name{
        width: 250px;
    }
    .edit{
        width: 150px;
    }
    .content{
        width: calc(100% - 200px - 250px - 300px - 150px)
    }
    .time{
        width: 300px;
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
  <h1 class="pt-4 fw-bold">訂單管理系統</h1>
        <?php if($msgNum > 0): ?>
            <div class="d-flex">
                <div class="my-2 me-auto totalinfo">
                    目前共 <?=$msgNum?> 筆資料
                </div>
                <div>
                <a href="../utilities/navbar.php?webpage=orderForm.html" class="btn btn-sm titlecgr">增加資料</a>
                </div>
            </div>
            <div class="msg titlecgr">
                <div class="id">訂單號碼</div>
                <div class="name">訂單狀態</div>
                <div class="name">會員號碼</div>
                <div class="name">付款方式</div>
                <div class="name">運送方式</div>
                <div class="name">運送狀態</div>
                <div class="content">地址</div>
                <div class="time">訂單成立時間</div>
                <div class="edit">編輯</div>
                
            </div>
        
            <!-- 因已經用fetch_all()來取資料, 就無需用while跑迴圈 -->
            <!--  while($row = $result->fetch_assoc()):  有加php-->
        <?php foreach($rows as $row):?>
            <div class="msg my-1">


                <div class="id"><?=$row["order_id"]?></div>
                <div class="name"><?=$row["payment_status"]?></div>
                <div class="name"><?=$row["user_id"]?></div>
                <div class="name"><?=$row["payment_method"]?></div>
                <div class="name"><?=$row["delivery_method"]?></div>
                <div class="name"><?=$row["delivery_status"]?></div>
                <div class="content"><?=$row["delivery_address"]?></div>
                <div class="time"><?=$row["order_date"]?></div>
                <div class="edit">  
                    <span class="btn btn-sm btn-del" idn="<?=$row["order_id"]?>"><i class="fa-regular fa-trash-can"></i></span>
                    <a href="../utilities/navbar.php?webpage=orderPage2.php&order_id=<?=$row["order_id"]?>" class="btn btn-sm"><i class="fa-regular fa-pen-to-square"></i></a>  
                </div> 
            </div>
        <?php endforeach; ?>
            <?php elseif($msgNum == 0): ?>
                目前沒有資料
            <?php else: ?>
                發生錯誤：<?= $errorMsg ?>
        <?php endif;  ?>

        <div class="d-flex justify-content-center mt-3">
            <nav aria-label="Page navigation example ">
                <ul class="pagination">
                 
                    <?php for ($i=1;$i<=$totalPages; $i++): ?>
                        <li class="page-item">
                            <a class="page-link <?= ($page==$i)?"active":""?>" href="./navbar.php?webpage=orderPagee.php&page=<?=$i?>"><?=$i?></a>
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
            if(window.confirm("是否刪除資料？") === true){
                window.location.href = `../utilities/navbar.php?webpage=orderDelete2.php&order_id=${order_id}`;
            }
        });
    })
</script>
</body>

</html>