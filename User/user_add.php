<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <title>新增表單</title>
    <style>
        .bgwhite {
            background-color: #f1ece2;
        }

        .bggreen {
            background-color: #777e5c;
        }
    </style>
</head>

<body>
    <div class="border container mt-5 rounded bgwhite">
        <form action="../User/doadd.php" method="post" enctype="multipart/form-data">
            <!-- 沒有設定 enctype 這個屬性只能上傳文字內容，要加 enctype 的設定才會加上處理檔案 -->
            <h2 class="fw-bold my-3">新增使用者</h2>
            <div class="input-group input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bggreen fw-bold rounded-start-4">email</span>
                <input name="email" type="text" class="form-control" placeholder="請輸入" autocomplete="off">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bggreen fw-bold rounded-start-4">姓名</span>
                <input name="name" type="text" class="form-control" placeholder="請輸入">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bggreen fw-bold rounded-start-4">暱稱</span>
                <input name="nickname" type="text" class="form-control" placeholder="請輸入">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bggreen fw-bold rounded-start-4">手機</span>
                <input name="phone" type="text" class="form-control" placeholder="請輸入">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bggreen fw-bold rounded-start-4">密碼</span>
                <input name="password" type="password" class="form-control" placeholder="請輸入">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <input name="id" type="hidden" value="<?= $id ?>">
                <span class="input-group-text text-light bggreen fw-bold rounded-start-4">再輸入一次密碼</span>
                <input name="password2" type="password" class="form-control" placeholder="請輸入">
            </div>
            <div class="input-group mt-2 input-group-lg">
                <span class="input-group-text text-light bggreen fw-bold rounded-start-4" type="button">上傳照片</span>
                <input class="form-control" type="file" name="myfile" accept=".png,.jpg,.jpeg">
            </div>
            <div class="mt-3 text-end">
                <!-- <button class="btn btn-primary me-auto">
                    <a href="./navbar.php?webpage=list.php" class="fw-bold text-light text-decoration-none"><-回上一頁</a>
                </button> -->
                <button type="reset" class="btn  btn-lg fw-bold me-2 bggreen text-light">清除</button>
                <button type="submit" class="btn btn-lg  btn-send fw-bold bggreen text-light">送出</button>
            </div>
        </form>
    </div>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script>
        const form = document.querySelector("form");
        const btnSend = document.querySelector(".btn-send");
        btnSend.addEventListener("click", function(e) {
            e.preventDefault();
            let email = document.querySelector("input[name=email]").value;
            let name = document.querySelector("input[name=name]").value;
            let pwd1 = document.querySelector("input[name=password]").value;
            let pwd2 = document.querySelector("input[name=password2]").value;
            // let img = document.querySelector("input[name=myFile]").value;
            if (email == "") {
                document.querySelector("input[name=email]").classList.add('is-invalid');
                return false;
            }
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
            // if(img == ""){
            //   alert("請選擇使用者照片");
            //   return false;
            // }
            function validateEmail(email) {
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }
            form.submit();
        })
    </script>
</body>

</html>