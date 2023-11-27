<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>餐廳帳號註冊</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/signup.css">
    <style>
        .bgg{
            background-color: #777e5c;
        }
    </style>
</head>

<body>
    <h1 class="text-center my-3">Sign Up</h1>

    <div class="loginbox border border-dark-subtle rounded bg-light">
        <form action="./processSignup.php" method="post">
            <div class="d-flex flex-column">
                <label for="name">Name:</label>
                <input class="my-3 rounded" type="text" id="name" name="name">
            </div>
            <div class="d-flex flex-column">
                <label for="email">Email:</label>
                <input class="my-3 rounded" type="email" id="email" name="email">
            </div>
            <div class="d-flex flex-column">
                <label for="password">Password:</label>
                <input class="my-3 rounded" type="password" id="password" name="password">
            </div>
            <div class="d-flex flex-column">
                <label for="password_confirmation">Repeat password:</label>
                <input class="my-3 rounded" type="password" id="password_confirmation" name="password_confirmation">
            </div>
            <button type="submit" class="btn bgg btn-sm">Sign Up</button>
        </form>
    </div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>