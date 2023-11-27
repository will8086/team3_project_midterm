<?php
session_start();
// print_r($_SESSION);

if(isset($_SESSION["user_id"])){
    $mysqli = require("../database.php");

    $limit = 5;
    
    $page = isset($_GET['page'])?$_GET['page'] : 1;

    $start = ($page - 1) * $limit; 

    $sql = "SELECT * FROM `restaurant_dishes` WHERE `restaurant_id` = {$_SESSION['user_id']} LIMIT $start, $limit";

    $sql2 = "SELECT count(`dishes_id`) AS `dishes_id` FROM `restaurant_dishes` WHERE `restaurant_id` = {$_SESSION['user_id']}";

    $result = $mysqli -> query($sql);
    $result2 = $mysqli -> query($sql2);

    $dishes = $result -> fetch_assoc();

    $dishesCheck = $result->num_rows;

    $dishesCount = $result2 -> fetch_all(MYSQLI_ASSOC);

    $total = $dishesCount[0]['dishes_id'];

    $pages = ceil( $total / $limit );

    $previous = $page - 1;
    $next = $page + 1;

    $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
    if ($searchKeyword) {
        $searchKeyword = $mysqli->real_escape_string($searchKeyword);
        $sql .= " AND (`dishes_name` LIKE '%{$searchKeyword}%' OR `description` LIKE '%{$searchKeyword}%')";
    }

    

    $i=$start + 1;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/product.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
<?php if (isset($dishes)):?>
            <?php if($result):?>
                <!-- 用户id存在 -->
                <?php if($dishesCheck > 0):
                    $result->data_seek(0);
                    ?>
                    <div class="container">
                        <div class="px-3 py-2 my-3 primary rounded-3 d-flex justify-content-between align-items-center">
                            <h1>菜單管理</h1>
                            <div>
                                <a class="btn btn-sm btn-outline-dark mx-1" href="../index.php">返回主頁</a>
                                <button type="submit" class="btn btn-sm btn-success mx-1" data-bs-toggle="modal" data-bs-target="#add_dishes">
                                <i class="bi bi-plus-lg"></i> 新增菜品
                                </button>
                            </div>
                        </div>
                            <div class="d-flex justify-content-between">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                    <?php if ($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="product.php?page=<?= $previous; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                        <?php for($p = 1; $p <= $pages; $p++):?>
                                            <li class="page-item"><a class="page-link" href="product.php?page=<?=$p;?>"><?=$p;?></a></li>
                                        <?php endfor;?>
                                        <?php if ($page < $pages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="product.php?page=<?= $next; ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                                <div class="w-25">
                                    <form class="form-inline mt-2 d-flex h-50" method="get" action="product.php">
                                        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search" value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                        <button class="btn btn-sm btn-outline-primary mx-3" type="submit">Search</button>
                                    </form>
                                </div>
                            </div>
                    </div>

                    <div class="container">
                        <table class="table table-success table-striped table-hover border text-center align-middle ">
                            <thead>
                                <tr>
                                    <th class="rounded-start-2 w-auto" scope="col">No.</th>
                                    <th class="w-20" scope="col">Image</th>
                                    <th class="w-20"scope="col">Name</th>
                                    <th class="w-10" scope="col">Price</th>
                                    <th class="rounded-end-2 w-35" scope="col">Description</th>
                                    <th class="w-25" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = $result->fetch_assoc()):?>
                                    <?php if ($searchKeyword === '' || stripos($row['dishes_name'], $searchKeyword) !== false || stripos($row['description'], $searchKeyword) !== false): ?>
                                        <tr class="table-light">
                                            <th scope="row"><?=$i?></th>
                                            <td class="d-flex justify-content-center">
                                                <div class="dishesbox mt-3">
                                                    <?= "<img class='imgbox' src='{$row['img_file']}' alt=''>"; ?>
                                                </div>
                                            </td>
                                            <td><?=$row['dishes_name']?></td>
                                            <td><?=$row['price']?>元</td>
                                            <td><?=$row['description']?></td>
                                            <td>
                                            <button type="button" class="btn btn-sm btn-warning mx-2" data-bs-toggle="modal" data-bs-target="#edit_dishes" onclick="fillEditForm(<?=$row['dishes_id']?>, '<?=$row['dishes_name']?>', <?=$row['price']?>, '<?=$row['description']?>', '<?=$row['img_file']?>')">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                                <button onclick="confirmDelete(<?=$row['dishes_id']?>)" class="btn btn-sm btn-danger mx-2"><i class="bi bi-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php endif;?>
                                <?php $i++; ?> <!-- 在这里增加 $i 的值 -->
                            <?php endwhile;?>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal fade" id="add_dishes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="./crudProduct.php" method="post" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">新增菜品</h1>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Name:</span>
                                            <input type="text" class="form-control" name="name" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Price:</span>
                                            <input type="number" min="1" class="form-control" name="price" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Description:</span>
                                            <textarea class="form-control" name="description" required></textarea>
                                        </div>
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="image">Image:</label>
                                            <input type="file" class="form-control" id="image" name="imgfile" accept=".jpg,.jpeg,.png,.webp">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="modal fade" id="edit_dishes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="./crudProduct.php" method="post" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5">修改菜品</h1>
                                    </div>
                                    <div class="modal-body">
                                    <input type="hidden" name="editDishesId" id="editDishesId" value="">

                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Name:</span>
                                            <input type="text" class="form-control" name="editName" id="editName"  required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Price:</span>
                                            <input type="number" min="1" class="form-control" name="editPrice" id="editPrice" required>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Description:</span>
                                            <textarea class="form-control" name="editDescription" id="editDescription" required></textarea>
                                        </div>
                                        <div class="editdishesbox mx-auto my-4">
                                            <img class="imgbox" id="editImage" src="" alt="">
                                        </div>
                                        <div class="input-group mb-3">
                                            <label class="input-group-text" for="image">Image:</label>
                                            <input type="file" class="form-control" id="image" name="imgfile" accept=".jpg,.jpeg,.png,.webp">
                                        </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">Edit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                <?php endif;?>
        
            <?php endif;?>
<?php endif;?>

    <script>
        function confirmDelete(dishesId){
                if (confirm("Are you sure about that?")) {
                window.location.href = "crudProduct.php?del=" + dishesId;
            }
        }


        function fillEditForm(id, name, price, description, imgSrc) {
        const editDishesIdInput = document.getElementById("editDishesId");
        const editNameInput = document.getElementById("editName");
        const editPriceInput = document.getElementById("editPrice");
        const editDescriptionInput = document.getElementById("editDescription");
        const editImage = document.getElementById("editImage");

        editDishesIdInput.value = id;
        editNameInput.value = name;
        editPriceInput.value = price;
        editDescriptionInput.value = description;
        editImage.src = imgSrc;
    }

    </script>
    
    <script src="../js/bootstrap.bundle.min.js"></script>
</body>

</html>