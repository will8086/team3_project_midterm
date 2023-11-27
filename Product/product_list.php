<!-- 訊息列表 -->

<?php
require_once("../connect.php");

// $where1="";
// if(isset($_GET["product_id"])){
//     $id= $_GET["product_id"];
//     $where1="where `product_id` =$id";
// }

$dir="";
if(isset($_GET["dir"])){
    $dir= $_GET["dir"];
}

// $sort="id";
// if(isset($_GET["sort"])){
//     $sort= $_GET["sort"];
// }
// usort($rows, function($a, $b){
//   global $sort;
//   if($GLOBALS["dir"] == "DESC"){
//       return $b[$sort] <=> $a[$sort];
//   }else{
//       return $a[$sort] <=> $b[$sort];
//   }
// });


//V
$tid=(isset($_GET["tid"]))?intval($_GET["tid"]):0;
if($tid == 0){
  $typeSQL = "";
}else{
  $typeSQL = "`product`.`product_type_id` = $tid AND";
}

//將從送出搜尋btn得到的網址變數設定至變數中
$search = (isset($_GET["search"]))?$_GET["search"]:"";
$searchType = (isset($_GET["qtype"]))?$_GET["qtype"]:"";


if($search == ""){
  $searchSQL = "";
}else{
  $searchSQL = "`$searchType` LIKE '%$search%' AND ";
}

if(!isset($_GET["page"])){
  $page=1;
}else{
  $page =$_GET["page"];
}

$perPage = 10;
$pageStart = ($page - 1) * $perPage;
//索引>>從0開始取10筆/從10開始取10.....


$sql = "SELECT * FROM `product` JOIN `product_type_list` ON product.product_type_list_id = product_type_list.product_type_list_id JOIN product_type
ON product_type.product_type_id = product_type_list.product_type_id JOIN discount_rate ON discount_rate.discount_rate_id = product.discount_rate_id WHERE $typeSQL $searchSQL product.isValid = 1 ORDER BY product_id DESC LIMIT $pageStart, $perPage ; ";
// limit0,5五個一頁  
$sqlAll = "SELECT * FROM `product` WHERE $typeSQL $searchSQL product.isValid = 1";
$sqlType="SELECT * FROM `product_type` WHERE isValid = 1";
// $sqlImg="SELECT * FROM `product` JOIN `product_img` ON product.product_id = product_img.product_id 
// WHERE product_img.product_id = $id;";

try{
  //連線從資料庫抓sql語法的東西
  $result =$conn->query($sql);
  $resultAll =$conn->query($sqlAll);
  $resultType =$conn->query($sqlType);
  // $resultImg =$conn->query($sqlImg);
  //數幾個
  $msgNum=$result ->num_rows;
    //用fetch_all()方法取出全部
    //MYSQLI_ASSOC將內容轉成關聯式陣列
  $rows=$result->fetch_all(MYSQLI_ASSOC);
  $rowsAll=$resultAll->fetch_all(MYSQLI_ASSOC);
  $totalAll = count($rowsAll);  
  $totalPage = ceil($totalAll/$perPage);

  $rowsType = $resultType->fetch_all(MYSQLI_ASSOC);
  // $rowsImg = $resultImg->fetch_all(MYSQLI_ASSOC);
  
}catch(mysqli_sql_exception $exc){
  //die("讀取失敗" .$exc->getmessage());
  $errorMsg=$exc->getmessage();
  $msgNum=-1;
  //數字設-1下面可以顯示發生錯誤
}

$conn->close();

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>商品列表</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .df{
          display: flex;
        }
        .id{
          width: 50px;
        
        }
        .name{
          width: 120px;
        }
        .price{
          width: 60px;
        }
        .description{
          width: calc((100% - 40px - 120px - 40px - 100px - 100px - 40px - 100px));
        }
        .product_type_id{
          width: 130px;
        }
        .product_type_list_id{
          width: 130px;
        }

        .discount_rate_id{
          width: 50px;
        }
        .control{
          /* width: 100px; */
          display:flex;
           justify-content:center; 
          align-items:center;
        } 
        .id,.name,.price,.description,.product_type_id,.product_type_list_id,.discount_rate_id,.control{
          /* display:inline;  */
          display:flex;
          /* flex-wrap; */
          /* flex-direction: row; */
          justify-content:center; 
          align-items:center;
          /* height: 80px; */
          /* overflow:auto; */
        }

        .gr{
          background-color: #777e5c;
        }
        .grF{
          color: #777e5c;
        }
        .wt{
          background-color: #f1ece2; 
        }
        .wtF{
          color: #f1ece2;
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
        .But:hover,.nav-tabs .nav-link.active{
          background-color: #777e5c;
          color:#f1ece2;
          
        }
        
        .nav-tabs .nav-link:hover{
          background-color: #777e5c;
          color:#f1ece2;
        }
     
        .nav-tabs{
          border-color: #777e5c ;
        }
    </style>
  </head>
  <body>


  <div class="wt container border-0">
  <h1 class="fw-bold">商品列表</h1>

  <?php if($msgNum>0): ?>
    <div class=" d-flex">
        <div class="my-2 me-auto "> 
          目前共<?=$totalAll?>項商品

        </div>

        <div class="me-1">
          <div class="input-group input-group-sm">
            <div class="input-group-text">
              <input name="searchType" id="searchType1" type="radio" class="form-check-input" value="product_name" checked>
              <label for="searchType1" class="me-2">品名</label>

              <input name="searchType" id="searchType2" type="radio" class="form-check-input" value="product_description">
              <label for="searchType2">商品內文</label>


            </div>
              <input name="search" type="text" class="form-control form-control-sm" placeholder="搜尋">
              <div class="btn gr btn-sm btn-search wtF">送出搜尋</div>
          </div>
        </div>


        <div>
          <a href="../utilities/navbar.php?webpage=product_add.php" <?= ($webpage == "product_add.php") ? "active" : "" ?> class="btn btn-sm gr wtF">新增商品</a>
        </div>
    </div>

    <div class="nav nav-tabs">
        <a class="nav-link <?=($tid==0)?"active":""?> grF" href="../utilities/navbar.php?webpage=product_list.php">全部</a>


        
        <!-- 逐筆將大分類ID放進tabs，點擊時將其設至網址變數，網址變數和tabs所屬ID一致時active -->
        <?php foreach($rowsType as $row): ?>
        <a class="nav-link <?=($tid==$row["product_type_id"])?"active":""?> grF" href="../utilities/navbar.php?webpage=product_list.php&tid=<?=$row["product_type_id"]?>"><?=$row["product_type_name"]?></a>
        <?php endforeach; ?>
    </div>



<!-- 重複一輪從這 -->

  <div class="border-0 p-3">
    
    <?php foreach($rows as $index => $row): ?>
      <div class="df justify-content-between">
        <button class="btn wh m-2 setID But" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?=$row["product_id"]?>" aria-expanded="false" aria-controls="collapseExample" idn="<?=$row["product_id"]?>">
          <?=$row["product_name"]?>
        </button>

        <div class="control ps-2 ">
          <a href="../utilities/navbar.php?webpage=product_updateOO.php&id=<?=$row["product_id"]?>" <?= ($webpage == "product_updeatOO.php") ? "active" : "" ?> class="btn  btn-sm" ><i class="fa-regular fa-pen-to-square grF"></i></a>
          
          <span class="btn btn-sm btn-del " idn="<?=$row["product_id"]?>"><i class="fa-regular fa-trash-can grF" idn="<?=$row["product_id"]?>"></i></span>
          
      </div>
      
        </div>
        <div class="collapse" id="collapseExample<?=$row["product_id"]?>">
          <div class=" my-3 card card-body d-flex">
            <div class="df text-bg-secondary rounded">
                <div class="id px-2 gr">商品編號</div>
                <div class="name px-2 gr">品名</div>
                <div class="price px-2 gr">價錢</div>
                <div class="description px-2 gr">介紹</div>
                <!-- <div class="specification">規格</div> -->
                <div class="product_type_id px-2 gr">分類</div>
                <div class="product_type_list_id px-2 gr">次分類</div>
                <div class="discount_rate_id px-2 gr">折扣</div>
                <!-- <div class="control ps-2">控制</div> -->
            </div>
            <div class="df">
              <div class="id px-2"><?=$row["product_id"]?></div>
              <div class="name px-2"><?=$row["product_name"]?></div>
              <div class="price px-2"><?=$row["price"]?></div>
              <div class="description px-2"><?=$row["product_description"]?></div>
              <div class="product_type_id px-2"><?=$row["product_type_id"].$row["product_type_name"]?></div>
              <div class="product_type_list_id px-2"><?=$row["product_type_list_id"].$row["product_type_list_name"]?></div>
              <div class="discount_rate_id px-2"><?=$row["discount_rate"]?></div>
            </div>
          </div>
          <!-- <div class=" my-3 card card-body d-flex">
            <div class="d-flex flex-wrap">
              <?php foreach($rowImg as $rowImg): ?>
                  <div class="border border-secondary rounded p-1 m-2">
                      <img src="./img/<?=$rowImg["product_img"]?>" alt=""      
                      class="img delImg" pid="<?=$rowImg["product_img"]?>" idn="<?=$id?>">   
                  </div>
              <?php endforeach; ?>
            </div>
          </div> -->
        </div>


    <?php endforeach; ?>

    <div aria-label="Page navigation example" class=" mt-5 d-flex justify-content-center">
      <ul class="pagination">
      <?php for($i=1;$i<=$totalPage;$i++): ?>

        <li class="page-item">
          <a class="page-link <?=($page==$i)?"active":""?>" 
              href="../utilities/navbar.php?webpage=product_list.php&page=<?=$i?><?=($tid>0)?"&tid=$tid":""?><?=($search=="")?"":"&search=$search&qtype=$searchType"?>"><?=$i?></a>
        </li>
      <?php endfor; ?>

      </ul>
    </div>
  </div>
<!-- 到這 -->
    

    <?php elseif($msgNum==0): ?>
       目前沒有商品
    <?php else: ?>
        發生錯誤:<?=$errorMsg?>
    <?php endif; ?>
</div>  


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Z5a0jRDgcWshsMIf2x5JgbR/Jm1fIHlLO1kymLdQkI7IPDh2voqo8QsfvAJSjma" crossorigin="anonymous"></script>

    <script>
        const btnDels= document.querySelectorAll(".btn-del");
          // foreach=[...btnDels].map
        btnDels.forEach(function(btnDel,index){  
          btnDel.addEventListener("click", function(){
          let id = parseInt(this.getAttribute("idn"));
          if(window.confirm("確認要刪除嗎?") === true){
          window.location.href=`../utilities/navbar.php?webpage=product_doDelete.php&id=${id}`;
          }
        })
        });
            //抓取搜尋radio及搜尋input的值並加入網址變數
        const btnSearch = document.querySelector(".btn-search");
        btnSearch.addEventListener("click", function(){
          let query = document.querySelector("input[name=search]").value;
          let queryType = document.querySelector("input[name=searchType]:checked").value;

          window.location.href = `../utilities/navbar.php?webpage=product_list.php&search=${query}&qtype=${queryType}`;
        })
    </script>
      <script>
        let setID = document.querySelectorAll(".setID");
        setID.forEach(function(ID){
            ID.addEventListener("click", function(e) {
            let id = this.getAttribute("idn");
            // alert(id);
            });
        }
        )
    </script>

  </body>
</html>