<?php

$conn = mysqli_connect("localhost","root","","db_tokobunga");

function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Kesalahan dalam query: " . mysqli_error($conn));
    }

    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

?>