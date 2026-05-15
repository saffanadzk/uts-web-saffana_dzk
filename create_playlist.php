<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

if (isset($_POST['create'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $user_id = $_SESSION['user_id']; 
    $query = "INSERT INTO playlists (user_id, name, description) VALUES ('$user_id', '$name', '$desc')";
    $last_id = mysqli_insert_id($conn);
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Playlist - naaSound</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <div class="addsong-card">
        <h2>Create New Playlist</h2>
        <form method="POST">
            <div class="form-group">
                <input type="text" name="name" placeholder="Playlist Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="description" placeholder="Short Description">
            </div>
            <button type="submit" name="create" class="btn-save">Save Playlist</button>
        </form>
    </div>
</body>
</html>