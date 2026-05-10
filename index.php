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
        .sidebar {
            background-color: #000; width: 250px; padding: 20px; display: flex; flex-direction: column; border-right: 1px solid #282828;
        }
        .logo {
            font-size: 24px; font-weight: bold; color: #1DB954; margin-bottom: 30px;
        }
        .nav-link {
            color: #b3b3b3; text-decoration: none; margin-bottom: 20px; font-size: 14px; font-weight: bold; trasition: color 0.3s;
        }
        .nav-link:hover {
            color: #fff;
        }
        .main-content {
            padding: 40px; flex: 1; background-color: linear-gradient(to bottom, #1e1e1e, #121212); overflow-y: auto;
        }
        header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;
        }
        .user-profile {
            display: flex; align-items: center; background-color: #282828; padding: 5px 15px; border-radius: 20px; font-size: 12px;
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
        .song-title {
            color: #ffffff; font-weight: bold; margin: 10px 0 5px 0;
        }
        .btn-add {
            background-color: #1DB954; color: #000; border: none; padding: 8px 15px; border-radius: 20px; cursor: pointer; text-decoration: none; font-weight: bold; font-size: 12px;
        }
        .logout-btn {
            background-color: transparent; color: #ff4d4d; margin-top: auto; border: 2px solid #ff4d4d; padding: 8px 15px; border-radius: 20px; text-decoration: none; font-size: 12px;
        }
    </style>
</head>
<body>

<!-- sidebar -->
 <div class="sidebar">
        <div class="logo">spotify</div>
        <a href="#" class="nav-link">Home</a>
        <a href="#" class="nav-link">Search</a>
        <a href="#" class="nav-link">Your Library</a>
        <a href="#" class="nav-link">Create Playlist</a>
        <a href="#" class="nav-link">Liked Songs</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
            <a href="Add song.php" class="btn-add">Add New Song</a>
            <header>

            <div class="playlist-section">
                <h3>New Playlist</h3>
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Artist</th>
                        <th>Album</th>
                        <th>Duration</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while ($song = mysqli_fetch_assoc($songs)) :
                    ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td>
                                <div class="song-title"><?= $song['title']; ?></div>
                            </td>
                            <td><?= $song['artist']; ?></td>
                            <td><?= $song['album']; ?></td>
                            <td>
                                <?php
                                $minutes = floor($song['duration'] / 60);
                                $seconds = $song['duration'] % 60;
                                echo sprintf("%d:%02d", $minutes, $seconds);
                                ?>
                            </td>
                            <td>
                                <a href="edit.php?id=<?= $song['id']; ?>" class="btn-edit">Edit</a>
                                <a href="delete.php?id=<?= $song['id']; ?>" class="btn-delete" onclick="return confirm('Apakah kamu yakin akan menghapus ?');">Delete</a>
                            style="color: #ff4d4d; font-weight: bold; text-decoration: none; font-size: 12px;">Delete</a>
                            </td>
                            </tr>
                            <?php endwhile; ?>
                </tbody>
                </table>
            </div>
    </div>
</body>
</html>
                            

                    