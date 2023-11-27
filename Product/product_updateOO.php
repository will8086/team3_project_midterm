<!-- 按修改完跳轉的修改留言頁 -->

<?php
require_once("../connect.php");

if(!isset($_GET["id"])){
 exit;
}else{
    $id= $_GET["id"];
}

$sql="SELECT * FROM `product` WHERE product_id = $id;";
$sql2="SELECT * FROM `product_type`;";
$sql3="SELECT * FROM `product_type_list`;";
$sql4="SELECT * FROM `product` JOIN `product_img` ON product.product_id = product_img.product_id 
WHERE product_img.product_id = $id ;";
$sql5="SELECT * FROM `discount_rate`;";


try{
    $result =$conn->query($sql);
    $result2 = $conn->query($sql2);
    $result3 = $conn->query($sql3);
    $result4 = $conn->query($sql4);
    $result5 = $conn->query($sql5);

    // $result3 = $conn->query($sql3);
    $row= $result->fetch_assoc();
    $row2s = $result2->fetch_all(MYSQLI_ASSOC);
    $row3s = $result3->fetch_all(MYSQLI_ASSOC);
    $row4s = $result4->fetch_all(MYSQLI_ASSOC);
    $row5s = $result5->fetch_all(MYSQLI_ASSOC);

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
    <title>修改商品</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->
    <style>
        .img{
            width:200px;
            height:200px;
            object-fit:cover;
        }
        .height{
            height: 110px;
        }
        .isValid{
            width: 110px!important; 
        }
        #preview_progressbarTW_img{
            width: 200px;
            object-fit:cover;
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

    </style>
</head>

<body>
    <div class="container mt-3">

        <form action="../utilities/navbar.php?webpage=product_doUpdateOO.php" method="post" enctype="multipart/form-data" class="px-2">
            <!-- 讓doUpdate的$_POST["id"]抓得到東西 -->
            <input type="hidden" name="id" value="<?=$id?>"> 

            <div class="input-group">
                <span class="input-group-text">品名</span>
                <input name="name" type="text" class="form-control" placeholder="發文者名稱" value="<?=$row["product_name"]?>">
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">價錢</span>
                <input name="price" type="text" class="form-control" placeholder="發文者名稱" value="<?=$row["price"]?>">
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text height">介紹</span>
                <textarea name="description" class="form-control"><?=$row["product_description"]?></textarea>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text height">規格</span>
                <textarea name="specification" class="form-control"><?=$row["specification"]?></textarea>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">分類</span>
                <select name="type" id="type1" class=" form-select">
                    <option value disabled <?=($row["product_type_id"]===NULL)?"selected":""?>>請選擇</option>
                
                    <?php foreach($row2s as $row2): ?>
                        <option value="<?=$row2["product_type_id"]?>" <?=($row["product_type_id"] == $row2["product_type_id"])?"selected":""?> ><?=$row2["product_type_name"]?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">次分類</span>
                <select name="typeList" id="typeList1" class=" form-select">
                    <!-- product裡的product_type_list_id沒有值的話顯示請選擇 -->
                    <option value disabled <?=($row["product_type_list_id"]===NULL)?"selected":""?>>請選擇</option>

                    <?php foreach($row3s as $row3): ?>
                        <option value="<?=$row3["product_type_list_id"]?>" <?=($row["product_type_list_id"] == $row3["product_type_list_id"])?"selected":""?> ><?=$row3["product_type_list_name"]?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">折扣</span>
                <select name="discount" id="" class=" form-select">

                    <option value disabled <?=($row["discount_rate_id"]===NULL)?"selected":""?>>請選擇</option>

                    <?php foreach($row5s as $row5): ?>
                        <option value="<?=$row5["discount_rate_id"]?>" <?=($row["discount_rate_id"] == $row5["discount_rate_id"])?"selected":""?> ><?=$row5["discount_rate"]?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="input-group mt-1 justify-content-between">
                <div class="d-flex ">
                    <span class="input-group-text">商品狀態</span>
                    <input type="text" name="isValid" value="<?=$row["isValid"]?>" class=" form-control">
                </div>
                    <p class="text-secondary text-end">"欲下架商品請填0"</p>
            </div>
            <div class="mt-1 text-end">
                <button type="submit" class="btn wtF gr">送出</button>
                <a class="btn gr wtF" href="../utilities/navbar.php?webpage=product_list.php">回上一頁</a>
            </div>
        </form>
    </div>
    <div class="container wt rounded my-2">
        <div class="d-flex flex-wrap">
            <?php foreach($row4s as $row4): ?>
                <div class="border border-secondary rounded p-1 m-2">
                    <img src="../Product/product_img/<?=$row4["product_img"]?>" alt=""      
                    class="img delImg" pid="<?=$row4["product_img"]?>" idn="<?=$id?>">
                    <div class="input-group ">
                        <!-- <span class="input-group-text text-secondary">首圖顯示</span> -->
                        <input readonly name="isValid" type="hidden" class="form-control isValid" value="<?=$row4["showed_1st"]?>">
                    </div> 
                </div>
            <?php endforeach; ?>
        </div>
        
        <form id="form2" class="mt-2 mb-5 p-2 " method="post" action="../utilities/navbar.php?webpage=product_doAddImg.php&id=<?=$id?>" enctype="multipart/form-data">
            <div class="myFiles">
                <div class="input-group mt-1">
                    <span class="input-group-text">產品圖</span>
                    <input class="form-control" id="imgInp" type="file" name="myFile[]" accept=".png,.jpg,.jpeg" data-target="preview_progressbarTW_img">

                    <div class="btn gr wtF btn-add-file">+</div>
                </div>
            </div>
            <div class="mt-1 text-end">
                <button type="submit" class="btn gr wtF btn-send">新增圖片</button>
                <!-- <a class="btn btn-info" href="./product_doUpdateImg.php?id=<?=$id?>">修改</a> -->
                <a class="btn gr wtF" href="">取消</a>
                <!-- ./product_list.php -->
            </div>
        </form>


    <!-- 預覽圖片 -->
        <div>
            <img id="preview_progressbarTW_img" src="../Product/product_img/default.jpg" class="border border-secondary rounded p-1 m-2" />
        </div>
        <template id="myFile">
            <div class="input-group mt-1 pdUnit">
                <span class="input-group-text">產品圖</span>
                <input class="form-control" type="file" name="myFile[]" accept=".png,.jpg,.jpeg">
                <div class="btn btn-danger btn-del-file">-</div>
            </div>
        </template>
    </div>

<!-- 
        <template id="inputs">
        <div class="input-group mt-1 ">
            <input class="form-control" type="file" name="imgFile[]" accept=".png,.jpg,.jpeg">
        </div>
        </template>
         -->
   <script>
    // 新增圖片預覽

    // 取得input元素
    const inputElement = document.getElementById('imgInp');
    // 取得用於預覽所選圖片的圖片元素
    const previewImgElement = document.getElementById('preview_progressbarTW_img');
    // 為input元素添加事件監聽器
    inputElement.addEventListener('change', function() {
        //當檔案改變後，做一些事 
        readURL(this);
        // this代表<input id="imgInp">
    });

    // var input = document.querySelector("input[name=myFile]");
    // input.addEventListener("change",(e)=>{
    //     readURL(e.target)
    //     //動作的目標=input
 
    // })

    function readURL(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function (e) {
                // 使用querySelector按ID選取圖片元素
                previewImgElement.src = e.target.result;
            }
            //使用 reader 將選取的檔案讀取為 Data URL
            reader.readAsDataURL(input.files[0]);
        }
    }
   </script>
    <script>
        
    //動態下拉選單
        let typeSelect=document.querySelector("#type1");
        let typeListSelect=document.querySelector("#typeList1");
        
        typeSelect.addEventListener("change",(e)=>{
            // console.log(e.target.value); 抓到大分類被選的值 1.2.3.4...
            
            // 清空次分類的select元素
            typeListSelect.innerHTML='<option value selected disabled>請選擇</option>';
            
            // 大分類被選的值塞進變數
            let selectedTypeID =e.target.value;
            // 次分類的每一筆值拿起來看，如果裡面的大分類ID跟選到的數字一樣， 就新增<option>把次分類ID跟名稱設進<option>，再把<option>放進次分類的<select>
            <?php foreach($row3s as $row3): ?>
                if (selectedTypeID === '<?=$row3["product_type_id"]?>'){
                    let option = document.createElement("option");
                    option.value ='<?=$row3["product_type_list_id"]?>';
                    option.text = '<?=$row3["product_type_list_name"]?>';
                    typeListSelect.appendChild(option);                
                }
            <?php endforeach; ?>
        })
      
    </script>

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
            window.location.href = `../utilities/navbar.php?webpage=product_doDelImg.php&id=${id}&img=${pid}`;
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