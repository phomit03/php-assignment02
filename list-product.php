<?php
    //dữ liệu từ database đổ về

    $severName= "localhost";
    $userName = "root";
    $password = "";
    $dbName = "quanlysanpham";

    //connect db
    $conn = new mysqli($severName, $userName, $password, $dbName);

    //nếu có lỗi thì dừng luôn
    if($conn->connect_error){
        die($conn->connect_error);  //die() = break;
    }

    //truy vấn
    $sql_txt = "SELECT * FROM crud";
    $result = $conn->query($sql_txt);
    //var_dump($result);die();

    $list = [];
    if($result->num_rows>0){
        while ($row = $result->fetch_assoc()){
            $list[] = $row;
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Products - Database</title>
</head>

<body>
<h1>List Products - Database: </h1>
<div class="form-group" style="text-align: end; margin-right: 20px;">
    <a style="text-decoration: none; color: white" href="add-product.php">
        <button class="btn btn-primary" type="button">Add Product >></button>
    </a>
</div>

<table class="table table-bordered table-hover" style="width: 95%; margin: 10px auto">
    <thead>
    <tr style="background-color: #ccc">
        <th scope="col">ID</th>
        <th scope="col">Product Name</th>
        <th scope="col">Price</th>
        <th scope="col">Unit</th>
        <th scope="col">Quantity</th>
        <th scope="col">Description</th>
        <th scope="col">Status</th>
        <th scope="col">Action</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($list as $item): ?>
            <tr>
                <td><?php echo $item['ID']; ?></td>
                <td><?php echo $item['productsName']; ?></td>
                <td><?php echo $item['price']; ?></td>
                <td><?php echo $item['unit']; ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo $item['description']; ?></td>
                <td><?php echo $item['status']; ?></td>
                <td>
                    <div class="form-group" >
                        <a style="text-decoration: none; color: white;" href="update-product.php?ID=<?php echo $item['ID']?>">
                            <button class="btn btn-info" type="button">Edit Product</button>
                        </a>
                    </div>
                </td>
                <td>
                    <div class="form-group">
                        <a style="text-decoration: none; color: white;" href="delete-product.php?ID=<?php echo $item['ID']?>"
                           onclick="return confirm('Do you want to remove this product from the list?');">
                            <button class="btn btn-danger" type="button">Delete Product</button>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>

