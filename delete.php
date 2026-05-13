<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM songs WHERE id='$id'");
    if ($query) {
        header("Location: index.php? status=success");
        exit();
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
}
?>
