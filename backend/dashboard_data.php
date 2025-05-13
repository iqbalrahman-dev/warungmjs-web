<?php
require_once 'database.php';

function get_monthly_totals() {
    $conn = connect_db();
    $current_month = date('Y-m');
    $monthly_ingredient_total = 0;
    $monthly_sales_total = 0;

    if ($conn) {
        $query1 = "SELECT SUM(total_cost) AS total_monthly_ingredient
                   FROM ingredient_purchases
                   WHERE DATE_FORMAT(created_at, '%Y-%m') = ?";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1, "s", $current_month);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        $row1 = mysqli_fetch_assoc($result1);
        $monthly_ingredient_total = $row1['total_monthly_ingredient'] ?? 0;
        mysqli_stmt_close($stmt1);

        $query2 = "SELECT SUM(total_price) AS total_monthly_sales
                   FROM product_sales
                   WHERE DATE_FORMAT(created_at, '%Y-%m') = ?";
        $stmt2 = mysqli_prepare($conn, $query2);
        mysqli_stmt_bind_param($stmt2, "s", $current_month);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $row2 = mysqli_fetch_assoc($result2);
        $monthly_sales_total = $row2['total_monthly_sales'] ?? 0;
        mysqli_stmt_close($stmt2);

        close_db($conn);
    }

    return [
        'month' => $current_month,
        'monthly_ingredient_total' => $monthly_ingredient_total,
        'monthly_sales_total' => $monthly_sales_total
    ];
}


function get_today_dashboard_data($selectedDate = null) {
    $conn = connect_db();
    $today = $selectedDate ?? date('Y-m-d');

    $ingredient_purchases = [];
    $product_sales = [];
    $total_ingredient_cost = 0;
    $total_product_sale = 0;

    if ($conn) {
        // Ingredient Purchases
        $query1 = "SELECT *
                   FROM ingredient_purchases 
                   WHERE DATE(created_at) = ?";
        $stmt1 = mysqli_prepare($conn, $query1);
        mysqli_stmt_bind_param($stmt1, "s", $today);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        $ingredient_purchases = mysqli_fetch_all($result1, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt1);

        $query2 = "SELECT SUM(total_cost) AS total_ingredient_cost 
                   FROM ingredient_purchases
                   WHERE DATE(created_at) = ?";
        $stmt2 = mysqli_prepare($conn, $query2);
        mysqli_stmt_bind_param($stmt2, "s", $today);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $row2 = mysqli_fetch_assoc($result2);
        $total_ingredient_cost = $row2['total_ingredient_cost'] ?? 0;
        mysqli_stmt_close($stmt2);

        // Product Sales
        $query3 = "SELECT *
                   FROM product_sales
                   WHERE DATE(created_at) = ?";
        $stmt3 = mysqli_prepare($conn, $query3);
        mysqli_stmt_bind_param($stmt3, "s", $today);
        mysqli_stmt_execute($stmt3);
        $result3 = mysqli_stmt_get_result($stmt3);
        $product_sales = mysqli_fetch_all($result3, MYSQLI_ASSOC);
        mysqli_stmt_close($stmt3);

        $query4 = "SELECT SUM(total_price) AS total_product_sale
                   FROM product_sales
                   WHERE DATE(created_at) = ?";
        $stmt4 = mysqli_prepare($conn, $query4);
        mysqli_stmt_bind_param($stmt4, "s", $today);
        mysqli_stmt_execute($stmt4);
        $result4 = mysqli_stmt_get_result($stmt4);
        $row4 = mysqli_fetch_assoc($result4);
        $total_product_sale = $row4['total_product_sale'] ?? 0;
        mysqli_stmt_close($stmt4);

        close_db($conn);
    }

    return [
        'today' => $today,
        'ingredient_purchases' => $ingredient_purchases,
        'total_ingredient_cost' => $total_ingredient_cost,
        'product_sales' => $product_sales,
        'total_product_sale' => $total_product_sale
    ];
}
