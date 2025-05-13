<?php

require_once 'config.php';

function connect_db() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }
    echo "berhasil connect";
    return $conn;
}

function close_db($conn) {
    mysqli_close($conn);
}

function fetch_data($conn, $query) {
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $data;
    } else {
        mysqli_error($conn);
        return false;
    }
}
?>