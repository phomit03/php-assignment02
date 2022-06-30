<?php
    //set value khi nhấn edit

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
    $sql_txt = "SELECT * FROM crud WHERE ID = " . $_GET['ID'];
    $result = $conn->query($sql_txt);

    $products = null;
    if($result && $result->num_rows > 0){
        while ($row = $result->fetch_assoc()){
            $products = $row;
        }
    }

    //nếu không có dữ liệu được get thì die, error
    if ($products == null){
        die("Products Not Found !");
    }

    //nếu người dùng click nút submit(update products) thì dữ liệu sẽ được update trên database
    if (!empty($_POST['update-products'])) {
        //GET ID để update
        header("Location: update-product.php?ID=" . $products['ID']);

        //validate form phòng trường hợp input rỗng, chưa required thì vẫn tiếp tục ở form update
        if (!$_POST["productsName"]) {
            header("Location: update-product.php");
        }
        if (!$_POST["price"]) {
            header("Location: update-product.php");
        }
        if (!$_POST["unit"]) {
            header("Location: update-product.php");
        }
        if (!$_POST["quantity"]) {
            header("Location: update-product.php");
        }
        if (!$_POST["status"]) {
            header("Location: update-product.php");
        }

        //truy vấn sql
        $sql_txt = "UPDATE crud 
                SET productsName = ?, price = ?, unit = ?, quantity = ?, description = ?, status = ? 
                WHERE ID = ?";
        $stt = $conn->prepare($sql_txt);

        //ID sẽ gán bằng ID được GET
        $ID = (int)$_GET['ID'];

        //set params and excute
        $pName = $_POST['productsName'];
        $pPrice = (double)$_POST['price'];
        $pUnit = $_POST['unit'];
        $pQuantity = (int)$_POST['quantity'];
        $pDescription = $_POST['description'];
        $pStatus = $_POST['status'];
        $pID = $ID;

        //khai báo 7 biến giả định kiểu string (s), double (d), int (i)
        $stt->bind_param("sdsissi", $pName, $pPrice, $pUnit, $pQuantity, $pDescription, $pStatus, $pID);
        $stt->execute();

        //điều hướng về list
        header("Location: list-product.php");
    }

    //get value options
    $statusOptions = [
        '' => 'choose a status',
        'active' => 'active',
        'deactive' => 'deactive',
    ];
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Products - Database</title>
    <style>
        .btn-primary {
            background-color: #007bff;
        }
    </style>
</head>
<body>
    <h1>Edit Products - Database: </h1>
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
            <label>Product Name *</label>
            <input required class="form-control" type="text" name="productsName" value="<?php echo $products['productsName']?>" />
        </div>
        <div class="form-group">
            <label>Price *</label>
            <input required class="form-control" type="text" name="price" value="<?php echo $products['price']?>" />
        </div>
        <div class="form-group">
            <label>Unit *</label>
            <input required class="form-control" type="text" name="unit" value="<?php echo $products['unit']?>"/>
        </div>
        <div class="form-group">
            <label>Quantity *</label>
            <input required class="form-control" type="text" name="quantity" value="<?php echo $products['quantity']?>"/>
        </div>
        <div class="form-group">
            <label>Description</label>
            <input class="form-control" rows="4" cols="50" name="description" value="<?php echo $products['description']?>">
        </div>
        <div class="form-group">
            <label>Status *</label>
            <select name="status" class="form-control" name="status" required>
                <?php foreach ($statusOptions as $value => $items): ?>
                    <!--nếu $products['status'] == $value thì selected $value đó lên và in ra $items của th đó-->
                    <option value="<?= $value ?>" <?php echo $products['status'] == $value ? 'selected' : ''?>>
                        <?= $items ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group" style="text-align: center;">
            <input class="btn btn-primary" type="submit" name="update-products" value="Update Product"/>
        </div>
    </form>
</body>
</html>
