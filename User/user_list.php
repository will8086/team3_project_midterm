<?php
if(!isset($_SESSION["user"])){
  header("location:./login.php");
}
require_once("../connect.php");

$where1="";
if(isset($_GET["id"])){
    $id=$_GET["id"];
    $where1="WHERE `user_id`=$id AND";
}

// $cid=(isset($_GET["cid"]))?intval($_GET["cid"]):0;

$search=(isset($_GET["search"]))?($_GET["search"]):"";
$searchType=(isset($_GET["qtype"]))?($_GET["qtype"]):"";
if($search==""){
    $searchSQL = "";
}else{
    $searchSQL = "`$searchType` LIKE '%$search%' AND";
}

// if($cid==0){
//     $catSQL="";
// }else{
//     $catSQL="`nikename` = $cid AND";
// }


//每頁抓取10筆資料
if(!isset($_GET["page"])){
    $page = 1;
}else{
    $page =$_GET["page"];
}
$perPage = 10;
$pageStart = ($page - 1) * $perPage;
$sql = "SELECT * FROM `user` WHERE $searchSQL `isValid` = 1 LIMIT $pageStart, $perPage";
$sqlAll = "SELECT * FROM `user` WHERE  $searchSQL `isValid` = 1";

  try {
    $result=$conn->query($sql);
    $msgnub=$result->num_rows;
    $rows=$result->fetch_all(MYSQLI_ASSOC);
    $resultAll=$conn->query($sqlAll);
    $rowsAll=$resultAll->fetch_all(MYSQLI_ASSOC);
    $totalAll=count($rowsAll);
    $totalPage = ceil($totalAll/$perPage);
  } catch (mysqli_sql_exception $exc) {
    // die ("讀取失敗" .$exc->getMessage());
    $errorMsg = $exc->getMessage();
    // $msgnub = -1;
  }

$webpage="";
if(isset($_GET["webpage"])){
    $webpage=$_GET["webpage"];
}

$conn->close();
  
?>
<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <style>
        .msg {
            display: flex;
        }

        .id {
            width: 30px;
        }

        .name {
            width: 100px;
        }

        .content {
            width: calc(100% - 30px - 100px - 180px)
        }

        .time {
            width: 180px;
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
    <title>使用者列表</title>
</head>

<body>
    <div class="container mt-3 w-100">
        <h1 class="fw-bold">使用者列表</h1>
        <?php if($msgnub>0):?>
            <div class="d-flex">
                <div class="my-2 me-auto">
                    目前共 <?=$totalAll?> 個使用者
                </div>
                <div class="me-1">
                    <div class="input-group input-group-sm">
                        <div class="input-group-text bg1">
                            <input name="searchType" id="searchType1" type="radio" class="form-check-input" value="user_name" checked>
                            <label for="searchType1" class="me-2">名字</label>
                            <input name="searchType" id="searchType2" type="radio" class="form-check-input" value="nickname">
                            <label for="searchType2">暱稱</label>
                        </div>
                        <input name="search" type="text" class="form-control form-control-sm" placeholder="搜尋">
                        <div class="btn bg2 btn-sm btn-search text-light fw-bold">送出搜尋</div>
                    </div>
                </div>
                <div>
                    <a href="?webpage=user_add.php" class="btn bg2 btn-sm text-light fw-bold
                    <?= ($webpage == "user_add.php") ? "active" : "" ?>">新增資料</a>
                </div>
            </div>
        <div class="border p-3 mb-4 rounded bg1">
                <div class="msg bg2 text-light ps-1 fw-bold rounded mb-2">
                    <div class="id">ID</div>
                    <div class="name">Name</div>
                    <div class="nikename ms-3 text-nowrap">暱稱</div>
                    <div class="content ms-5 text-center">E-mail</div>
                    <div class="time">控制</div>
                </div>
            
            <?php foreach($rows as $index => $row):?>
            <div class="msg ps-1 my-2">
                <div class="id"><?=$row["user_id"]?></div>
                <div class="name"><?=$row["user_name"]?></div>
                <div class="name ms-3"><?=$row["nickname"]?></div>
                <div class="content ms-5 text-center"><?=$row["user_email"]?></div>
                <div class="time">
                    <span class="btn btn-sm btn-del" idn="<?=$row["user_id"]?>">
                    <i class="fa-regular fa-trash-can fa-lg" style="color: #777e5c;"></i></span>
                    <a href="?webpage=user_update.php&id=<?=$row["user_id"]?>" class="btn btn-sm ms-1
                    <?= ($webpage == "user_update.php") ? "active" : "" ?>">
                    <i class="fa-regular fa-pen-to-square fa-lg" style="color: #777e5c;"></i></a>
                </div>
            </div>
            <?php endforeach;?>
         <?php elseif($msgnub==0):?>
                目前沒有資料喔!
        <?php else:?>
                錯誤:<?=$msgnub?>
        <?php endif; ?>
        </div>
        <div aria-label="Page navigation example border border-top-0 p-3 rounded rounded-top-0">
                <ul class="pagination justify-content-center">
                    <?php for($n=1;$n<=$totalPage;$n++):?>
                    <li class="page-item">
                        <a 
                        class="page-link
                         <?=($page==$n)?"active":""?>"
                          href="./navbar.php?webpage=user_list.php&page=<?=$n?>">
                          <?=$n?>
                        </a>
                    </li>
                    <?php endfor?>
                </ul>
            </div>
    </div>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script>
        const btnDels=document.querySelectorAll(".btn-del");
        [...btnDels].map(function(btnDel, index){
            btnDel.addEventListener("click",function(){
                let id= parseInt(this.getAttribute("idn"));
                if(window.confirm("真的要刪除嗎??")=== true){
                window.location.href=`../User/doDelete.php?id=${id}`;    
                }
            })
        });
        const btnSearch=document.querySelector(".btn-search");
        btnSearch.addEventListener("click",function(){
            let query=document.querySelector("input[name=search]").value;
            let querytype=document.querySelector("input[name=searchType]:checked").value;
            window.location.href=`../utilities/navbar.php?webpage=user_list.php&search=${query}&qtype=${querytype}`
        }
        );
        
    </script>
</body>

</html>