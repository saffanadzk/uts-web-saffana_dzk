<?php
session_start();
include 'koneksi.php';

if (!isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM songs WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php? status=success");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    } else {
    header("Location: index.php?status=error");
}
?>