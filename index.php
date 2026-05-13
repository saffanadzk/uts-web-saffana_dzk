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
    <title>Spotify</title>
    <style>
        body {
            background-color: #354024; color: #E5D7C4; font-family: 'Segoe UI', sans-serif; margin: 0; display: flex; flex-direction: column; min-height: 100vh;
        }
        .sidebar {
            background-color: #1a1f11; width: 230px; padding: 24px; display: flex; flex-direction: column; border-right: 1px solid #4b5a34;
        }
        .sidebar h1 {
            font-size: 24px; font-weight: bold; color: #E5D7C4 ; margin-bottom: 20px;
        }
        .sidebar a {
            color: #E5D7C4; text-decoration: none; margin-bottom: 20px; font-size: 14px; font-weight: bold; transition: color 0.3s;
        }
        .logo {
            font-size: 24px; font-weight: bold; color: #889063 ; margin-bottom: 30px;
        }
        .nav-link {
            color: #889063; text-decoration: none; margin-bottom: 20px; font-size: 14px; font-weight: bold; trasition: color 0.3s;
        }
        .nav-link:hover {
            color: #E5D7C4 ;
        }
        .main-content {
            padding: 40px; flex: 1; background-color: linear-gradient(to bottom, #889063, #354024); overflow-y: auto;
        }
        header h1 {
            font-size: 28px; color: #E5D7C4; margin: 0; 
        }
        header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;
        }
        .user-profile {
            display: flex; align-items: center; background-color: #4C3D19; padding: 5px 15px; border-radius: 20px; font-size: 12px;
        }
        table {
            width: 100%; border-collapse: collapse; margin-top: 30px; background-color: #CFBB99; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        th {
            text-align: left; padding: 15px; background-color: #4C3D19; color: #E5D7C4 ; text-transform: uppercase; font-size: 13px;
        }
        td{
            background-color: transparent !important; padding: 12px 15px; border-bottom: 1px solid #bba686; font-size: 14px; color: #4C3D19;
        }
        tr:hover {
            background-color: #dbc9ad; cursor: pointer;
        }
        .song-title {
            color: #4C3D19; font-weight: bold; margin: 10px 0 5px 0;
        }
        .btn-play {
            background-color: #4C3D19; color: #E5D7C4; border: none; padding: 6px 18px; border-radius: 50px; cursor: pointer; font-weight: bold; font-size: 12px;
        }
        .btn-play:hover {
            background-color: #4C3D19;
        }
        .btn-add {
            background-color: #4C3D19; color: #E5D7C4 ; border: none; padding: 8px 20px; border-radius: 50px; cursor: pointer; text-decoration: none; font-weight: bold; font-size: 12px;
        }
        .btn-add:hover {
            opacity: 0.9; background-color: #2e2114; transform: translateY(-2px);
        }
        .btn-edit {
            color: #4C3D19; text-decoration: none; transition: 0.3s; cursor: pointer; font-weight: bold; font-size: 13px; margin-right: 10px;
        }
        .no-line-edit {
            color: #4C3D19; text-decoration: none !important; cursor: pointer; font-weight: bold; font-size: 13px; border-bottom: 2px solid #889063; margin-right: 15px; transition: 0.3s; display: inline-block;
        }
        .btn-delete {
            color: #7A1012; text-decoration: none; transition: 0.3s; cursor: pointer; font-weight: bold; font-size: 13px;
        }
        .no-line-delete {
            color: #7A1012; text-decoration: none !important; transition: 0.3s; cursor: pointer; font-weight: bold; font-size: 13px; border-bottom: 2px solid #7A1012; display: inline-block;
        }
        .logout-btn {
            background-color: transparent; color: #E5D7C4; margin-top: auto; border: 2px solid #4C3D19; padding: 8px 15px; border-radius: 20px; text-decoration: none; font-size: 12px;
        }
        .logout-btn:hover {
            background-color: #4C3D19; color: #E5D7C4; border-color: transparent;
        }
        .action-column {
            white-space: nowrap; text-align: left !important; padding-left: 0px !important; background-color: transparent !important; border-bottom: 1px solid #bba686;
        }
        .action-column a {
            text-decoration: none !important; text-decoration-line: none !important; border-bottom: none !important; outline: none !important
        }
        .action-column a:hover {
            text-decoration: underline !important; border-bottom: none !important; outline: none !important;
        }
        .cell-play {
            text-align: center; background-color: transparent !important;
        }
    </style>
</head>
<body>

 <div class="sidebar">
        <div class="logo">spotify</div>
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
                            

                    