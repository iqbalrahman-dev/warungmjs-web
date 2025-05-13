<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $conn = connect_db();
    $id = intval($_POST['id']);

    $query = "DELETE FROM product_sales WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    close_db($conn);

    header("Location: ../index.php");
    exit;
}
?>
