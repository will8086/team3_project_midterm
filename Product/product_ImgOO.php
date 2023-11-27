<!-- 按修改完跳轉的修改留言頁 -->

<?php
require_once("../connect.php");

if(!isset($_GET["id"])){
 exit;
}else{
    $id= $_GET["id"];
}
$sql="SELECT * FROM `product` WHERE product_id = $id;";
$sql2="SELECT * FROM `product` JOIN `product_img` ON product.product_id = product_img.product_id 
WHERE product_img.product_id = $id ;";


try{
    $result =$conn->query($sql);
    $result2 = $conn->query($sql2);
    
    $row= $result->fetch_assoc();
    $row2s = $result2->fetch_all(MYSQLI_ASSOC);
}catch(mysqli_sql_exception $exc){
    die("讀取失敗" .$exc->getmessage());
}

$conn->close();
?>

<!doctype html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>圖片管理</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <style>
            .img{
                width:200px;
                height:200px;
                object-fit:cover;
            }
            </style>
</head>

<body>
    <div class="container mt-3">
        
        <form action="./product_doUpdate.php" method="post" enctype="multipart/form-data">
            <input type="text" name="product_id" value="<?=$id?>"> 
            <div class="input-group">
                <span class="input-group-text">品名</span>
                <input readonly name="name" type="text" class="form-control" placeholder="商品名稱" 
                value="<?=$row["product_name"]?>">
            </div>
            
        </form>
        
        <form id="form2" class="mt-2 p-2 bg-primary-subtle" method="post" action="./product_doAddImg.php?id=<?=$id?>" enctype="multipart/form-data">
            <div class="myFiles">
                <div class="input-group mt-1">
                    <span class="input-group-text">產品圖</span>
                    <input class="form-control" type="file" name="myFile[]" accept=".png,.jpg,.jpeg">
                    <div class="btn btn-info btn-add-file">+</div>
                </div>
            </div>
            <div class="mt-1 text-end">
                <button type="submit" class="btn btn-primary btn-send">送出</button>
                <a class="btn btn-info" href="./product_list.php">取消</a>
            </div>
        </form>
        <template id="myFile">
            <div class="input-group mt-1 pdUnit">
                <span class="input-group-text">產品圖</span>
                <input class="form-control" type="file" name="myFile[]" accept=".png,.jpg,.jpeg">
                <div class="btn btn-danger btn-del-file">-</div>
            </div>
        </template>
        <div class="d-flex">
            <?php foreach($row2s as $row2): ?>
                <div>
                    <img src="./product_img/<?=$row2["product_img"]?>" alt=""      
                    class="img delImg" pid="<?=$row2["product_img"]?>" idn="<?=$id?>">   
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- 照片按鈕 -->
    <script>
        const btnAddFile = document.querySelector(".btn-add-file");
        const myFiles = document.querySelector(".myFiles");
        btnAddFile.addEventListener("click", function(e){
            e.preventDefault();
            let template = document.querySelector("#myFile");
            let dom = template.content.cloneNode(true);
            removeEvent();
            myFiles.append(dom);
            setDelFileBtn();
        })
        
        function removeEvent(){
            const btnDelFiles = document.querySelectorAll(".btn-del-file");
            [...btnDelFiles].map(function(btn){
                btn.removeEventListener("click", _aa);
            });
        }
        
        function setDelFileBtn(){
            const btnDelFiles = document.querySelectorAll(".btn-del-file");
            [...btnDelFiles].map(function(btn){
                btn.addEventListener("click", _aa);
            });
        }
        function _aa(e){
            let tg = e.currentTarget;
            let dom = tg.closest(".pdUnit");
            dom.remove();
        }
        </script>

    <!-- 刪照片 -->
    <script>
        let delImgs = document.querySelectorAll(".delImg");
        delImgs.forEach(function(img){
            img.addEventListener("click", function(e) {
            let id = this.getAttribute("idn");
            let pid = this.getAttribute("pid");    
            if(confirm("確定要刪除圖片？")){
            window.location.href = `./product_doDelImg.php?id=${id}&img=${pid}`;
            }
            });
        }
        )
    </script>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
crossorigin="anonymous">
</script>
</body>

</html>