<?php
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $quantity_sold = $_POST['quantity_sold'];
    $price_per_unit = $_POST['price_per_unit'];
    $discount = $_POST['discount'];
    $description = $_POST['description'];
    $product_date = $_POST['product_date'];

    $conn = connect_db();
    if ($conn) {
        $query = "INSERT INTO product_sales (name, quantity_sold, price_per_unit, discount, description, created_at) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sdddss", $name, $quantity_sold, $price_per_unit, $discount, $description, $product_date);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                mysqli_stmt_close($stmt);
                close_db($conn);
                header("Location: ../foods.php?message=success");
                exit();
            }
        }
        close_db($conn);
        header("Location: ../foods.php?message=error");
        exit();
    } else {
        header("Location:.. /foods.php?message=error");
        exit();
    }
}
?>
