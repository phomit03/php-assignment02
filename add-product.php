<!--post dữ liệu lên database-->
<?php
// bật hiển thị lỗi debug
//    error_reporting(E_ALL);
//    ini_set('display_errors', 1);

// Nếu người dùng click vào nút submit
if (!empty($_POST['add_product'])) {
    //validate form phòng trường hợp chưa required thì form thiếu hoặc lỗi sẽ quay lại add luôn
    if (!$_POST["productsName"]) {
        header("Location: add-product.php");
    }
    if (!$_POST["price"]) {
        header("Location: add-product.php");
    }
    if (!$_POST["unit"]) {
        header("Location: add-product.php");
    }
    if (!$_POST["quantity"]) {
        header("Location: add-product.php");
    }
    if (!$_POST["status"]) {
        header("Location: add-product.php");
    }

    //khai báo database
    $severName = "localhost";
    $userName = "root";
    $password = "";
    $dbName = "quanlysanpham";

    //connect db
    $conn = new mysqli($severName, $userName, $password, $dbName);

    //check lỗi thì dừng
    if ($conn->connect_error) {
        die($conn->connect_error);  //die() = break;
    }

    //truy vấn thêm một sv
    $sql_txt = "INSERT INTO crud(productsName, price, unit, quantity, description, status) VALUES (?,?,?,?,?,?)";
    $stt = $conn->prepare($sql_txt);

    //set params and excute
    $pName = $_POST['productsName'];
    $pPrice = (double)$_POST['price'];
    $pUnit = $_POST['unit'];
    $pQuantity = (int)$_POST['quantity'];
    $pDescription = $_POST['description'];
    $pStatus = $_POST['status'];

//    echo $conn->error;
//    var_dump($pName, $pPrice, $pUnit, $pQuantity, $pDescription, $pStatus); die;

    //khai báo 6 biến giả định kiểu string (s), double (d), int (i)
    $stt->bind_param("sdsiss", $pName, $pPrice, $pUnit, $pQuantity, $pDescription, $pStatus);

    $stt->execute();

    header("Location: list-product.php");
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
    <title>Add Students - Database</title>
    <style>
        .btn-primary {
            background-color: #007bff;
        }
    </style>
</head>
<body>
<h1>Add products - Database: </h1>
<form method="post" style="width: 50%; margin:20px auto">
    <div class="form-group" style="text-align: start;">
        <a style="text-decoration: none; color: white" href="list-product.php">
            <button class="btn btn-primary" type="button"><< Back List</button>
        </a>
    </div>
    <div class="form-group">
        <label>ID</label>
        <input class="form-control" type="text" name="ID" placeholder="AUTO_INCREMENT ID" disabled/>
    </div>
    <div class="form-group">
        <label>Products Name *</label>
        <input required class="form-control" type="text" name="productsName"/>
    </div>
    <div class="form-group">
        <label>Price *</label>
        <input required class="form-control" type="text" name="price"/>
    </div>
    <div class="form-group">
        <label>Unit *</label>
        <input required class="form-control" type="text" name="unit"/>
    </div>
    <div class="form-group">
        <label>Quantity *</label>
        <input required class="form-control" type="text" name="quantity"/>
    </div>
    <div class="form-group">
        <label>Description</label>
        <textarea class="form-control" rows="4" cols="50" name="description"></textarea>
    </div>
    <div class="form-group">
        <label>Status *</label>
        <select name="status" class="form-control" required>
            <option value="" selected>choose a status</option>
            <option value="active">active</option>
            <option value="deactive">deactive</option>
        </select>
<!--        <input required class="form-control" type="text" name="status"/>-->
    </div>
    <div class="form-group" style="text-align: center;">
        <input class="btn btn-primary" type="submit" name="add_product" value="Add Product"/>
    </div>
</form>
</body>
</html>
