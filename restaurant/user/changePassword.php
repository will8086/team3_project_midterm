<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/signup.css">
</head>

<body>
    <div class="loginbox border border-dark-subtlerounded bg-light mt-5">
        <form action="./updatePassword.php" method="post">
            <div class="d-flex flex-column">
                <label for="password">Current Password:</label>
                <input class="my-3 rounded" type="password" id="password" name="password">
            </div>
            <div class="d-flex flex-column">
                <label for="newpassword">New Password:</label>
                <input class="my-3 rounded" type="password" id="new_password" name="new_password">
            </div>
            <div class="d-flex flex-column">
                <label for="password">Repeat New Password:</label>
                <input class="my-3 rounded" type="password" id="password_confirmation" name="password_confirmation">
            </div>
            <button type="submit" class="btn btn-info my-3">修改密码</button>
        </form>
    </div>


    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>