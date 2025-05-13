<?php
require_once 'database.php';

//ingredients
function add_ingredients_purchase($name, $quantity, $price_per_unit, $discount, $notes) {
    $conn = connect_db(); 

    if ($conn) {
        $query = "INSERT INTO ingredients_purchases (name, quantity, price_per_unit, discount, notes) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sddds", $name, $quantity, $price_per_unit, $discount, $notes);

            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                mysqli_stmt_close($stmt);
                close_db($conn);
                return true;
            } else {
                error_log("Error executing query: " . mysqli_error($conn));
                mysqli_stmt_close($stmt);
                close_db($conn);
                return false;
            }
        } else {
            error_log("Error preparing statement: " . mysqli_error($conn));
            close_db($conn);
            return false;
        }
    } else {
        return false;
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


// function get_foods_data() {
//     $conn = connect_db();
//     if ($conn) {
//         $query = "SELECT id, name, description FROM foods";  // Adjust table and columns as needed
//         $data = fetch_data($conn, $query);
//         close_db($conn);
//         return $data;
//     } else {
//         return false;
//     }
// }

// Handle form submission (assuming this is for the form on index.php)
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $name = $_POST['name'];
//     $email = $_POST['email'];

//     $conn = connect_db();
//     if ($conn) {
//         $query = "INSERT INTO submissions (name, email) VALUES (?, ?)"; //changed table name
//         $stmt = mysqli_prepare($conn, $query);
//         mysqli_stmt_bind_param($stmt, "ss", $name, $email);
//         mysqli_stmt_execute($stmt);
//         mysqli_stmt_close($stmt);
//         close_db($conn);

//         // Redirect to a success page or back to the home page
//         header("Location: index.php?message=success"); //  Change the redirection
//         exit();
//     } else {
//         header("Location: index.php?message=error");
//         exit();
//     }
// }
?>