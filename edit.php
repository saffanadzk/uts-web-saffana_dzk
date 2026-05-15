<?php
session_start();
include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM songs WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $album = $_POST['album'];
    $genre = $_POST['genre'];
    $duration = $_POST['duration']; 
    $update = mysqli_query($conn, "UPDATE songs SET 
        title='$title', 
        artist='$artist', 
        album='$album', 
        genre='$genre', 
        duration='$duration' 
        WHERE id='$id'");
    if ($update) {
        echo "<script>alert('Song updated successfully!'); window.location='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Song - naaSound</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-body">
    <div class="addsong-wrapper">
        <div class="addsong-card">
            <h2>Edit Song</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <input type="text" name="artist" value="<?= $data['artist']; ?>" placeholder="Enter artist name" required>
                </div>
                <div class="form-group">
                    <input type="text" name="title" value="<?= $data['title']; ?>" placeholder="Enter song title" required>
                </div>
                <div class="form-group">
                    <input type="text" name="album" value="<?= $data['album']; ?>" placeholder="Enter album name">
                </div>
                <div class="form-group">
                    <input type="text" name="genre" value="<?= $data['genre']; ?>" placeholder="Enter song genre">
                </div>
                <div class="form-group">
                    <input type="text" name="duration" value="<?= $data['duration']; ?>" placeholder="Enter song duration (mm:ss)">
                </div>
                
                <button type="submit" name="update" class="btn-save">Save Changes</button>
                <div style="margin-top: 20px; text-align: center;">
                    <a href="index.php" style="color: #4C3D19; text-decoration: none; font-weight: bold; font-size: 14px;">
                        ← Back to Dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>