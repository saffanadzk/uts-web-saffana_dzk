<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$playlist_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

mysqli_query($conn, "DELETE FROM songs WHERE playlist_id = '$playlist_id' AND user_id = '$user_id'");
$delete = mysqli_query($conn, "DELETE FROM playlists WHERE id = '$playlist_id' AND user_id = '$user_id'");

if ($delete) {
    echo "<script>alert('Playlist succesful deleted!'); window.location='index.php';</script>";
} else {
    echo "<script>alert('Failed to delete playlist.'); window.location='index.php';</script>";
}
?>