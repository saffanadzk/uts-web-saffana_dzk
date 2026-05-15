<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

if (isset($_POST['simpan_lagu'])) {
    $user_id = $_SESSION['user_id'];
    $artist = mysqli_real_escape_string($conn, $_POST['artist']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $album = mysqli_real_escape_string($conn, $_POST['album']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $dur = $_POST['duration'];

    $q_p = mysqli_query($conn, "SELECT id FROM playlists WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1");
    $p_data = mysqli_fetch_assoc($q_p);
    $playlist_id = $p_data['id'] ?? 0;

    $parts = explode(':', $dur);
    $total_seconds = (count($parts) == 2) ? ($parts[0] * 60) + $parts[1] : (int)$dur;

    $query = "INSERT INTO songs (user_id, playlist_id, title, artist, album, genre, duration) 
              VALUES ('$user_id', '$playlist_id', '$title', '$artist', '$album', '$genre', '$total_seconds')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Song - naaSound</title>
    <link rel="stylesheet" href="style.css?v=<?= time(); ?>">
</head>

<body class="addsong-body">
    <div class="addsong-wrapper">
        <div class="addsong-card">
            <h2>Add New Song</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <input type="text" name="artist" placeholder="Enter artist name" required>
                </div>
                <div class="form-group">
                    <input type="text" name="title" placeholder="Enter song title" required>
                </div>
                <div class="form-group">
                    <input type="text" name="album" placeholder="Enter album name" required>
                </div>
                <div class="form-group">
                    <div class="input-row">
                        <input type="text" name="genre" placeholder="Enter song genre" required>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" name="duration" placeholder="Enter song duration" required>
                </div>
                <button type="submit" name="simpan_lagu" class="btn-save">Save to Playlist</button>
                <a href="index.php" class="back-to-dashboard">← Back to Dashboard</a>
            </form>
        </div>
    </div>
</body>
</html>