<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($conn, $query); 
$row = mysqli_fetch_assoc($result);
$result_songs = mysqli_query($conn, "SELECT * FROM songs");
if (!$result_songs) {
    die("Query gagal: " . mysqli_error($conn));
}

$no = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>naaSound</title>
    <style>
</head>
<body>

 <div class="sidebar">
        <div class="logo">naaSound</div>
        <a href="#" class="nav-link">Home</a>
        <a href="#" class="nav-link">Search</a>
        <a href="#" class="nav-link">Your Library</a>
        <a href="#" class="nav-link">Create Playlist</a>
        <a href="#" class="nav-link">Liked Songs</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
    
    <div class="main-content">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
            <a href="addsong.php" class="btn-add">Add New Song</a>
        </div>
            <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Artist</th>
                    <th>Album</th>
                    <th>Genre</th>
                    <th>Duration</th>
                    <th>Action</th>
                    <th style="text-align: left; width: 150px;"></th>
                    <th style="width: 100px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while ($song = mysqli_fetch_assoc($result_songs)) :
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>
                        <div class="song-title" style="font-weight: bold; color: #4C3D19;">
                            <?= $song['title']; ?> 
                        </div>
                    </td>
                    <td><?= $song['artist']; ?></td>
                    <td><?= $song['album']; ?></td>
                    <td><?= $song['genre']; ?></td>
                    <td>
                        <?= $song['duration']; ?> </td>
                    </td>
                    <td class="action-column">
                        <a href="edit.php?id=<?= $song['id']; ?>" class="no-line-edit">Edit</a>
                        <a href="delete.php?id=<?= $song['id']; ?>" class="no-line-delete" onclick="return confirm('Yakin mau hapus?')">Delete</a>
                    </td>
                    <td class="cell-play">
                        <button class="btn-play" style="border-radius: 50px; background: #4C3D19; color: #E5D7C4; border: none; padding: 5px 15px; cursor: pointer;">
                            Play
                        </button>
                    </td>
                </tr>
                <?php endwhile; 
                ?>
            </tbody>
            </table>
        </div>
    </div>
</body>
</html>
                            

                    