<?php
require_once 'database.php';

//ingredients
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price_per_unit = $_POST['price_per_unit'];
    $discount = $_POST['discount'];
    $notes = $_POST['notes'];
    $purchase_date = $_POST['purchase_date'];

    $conn = connect_db(); 
    if ($conn) {
        $query = "INSERT INTO ingredient_purchases (name, quantity, price_per_unit, discount, notes, created_at) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sdddss", $name, $quantity, $price_per_unit, $discount, $notes, $purchase_date);

            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                mysqli_stmt_close($stmt);
                close_db($conn);
                header("Location: ../ingredients.php?message=success");
                exit();
            }
        }
        close_db($conn);
        header("Location: ../gredients.php?message=error");
        exit();
    } else {
        header("Location: ../ingredients.php?message=error");
        exit();
    }
}

function get_ingredients_name() {
    $conn = connect_db();
    if ($conn) {
        $query = "SELECT id, name FROM ingredients";
        $data = fetch_data($conn, $query);
        close_db($conn);
        return $data;
    } else {
        return false;
    }
}
?>