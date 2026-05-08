<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    include 'koneksi.php';
    exit();
}
$songs = mysqli_query($conn, "SELECT * FROM songs");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Spotify</title>
    <style>
        body {
            background-color: #1DB954; color: white; font-family: 'Segoe UI', sans-serif; margin: 0; display: flex; flex-direction: column; min-height: 100vh;
        }
        nav {
            background-color: #000; padding: 15px 50px; display: flex; justify-content: space-between; align-items: center;
        }
        .container {
            padding: 40px; flex: 1;
        }
        table {
            width: 100%; border-collapse: collapse; margin-top: 20px; background-color: #181515; border-radius: 10px; overflow: hidden;
        }
        th {
            text-allign: left; padding: 15px; background-color: #282828; color: #1DB954; text-transform: uppercase;
        }
        td{
            padding: 12px; border-bottom: 1px solid transparent; font-size: 14px;
        }
        tr:hover {
            background-color: #282828; cursor: pointer;
        }
        .song h3 {
            margin: 10px 0 5px 0;
        }