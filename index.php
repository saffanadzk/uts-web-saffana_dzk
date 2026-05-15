<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: auth.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$cek_playlist = mysqli_query($conn, "SELECT * FROM playlists WHERE user_id = '$user_id'");
$jumlah_playlist = mysqli_num_rows($cek_playlist);

if (isset($_GET['playlist_id'])) {
    $playlist_id = intval($_GET['playlist_id']);
    $q_p = mysqli_query($conn, "SELECT id, name FROM playlists WHERE id = '$playlist_id' AND user_id = '$user_id'");
} else {
    $q_p = mysqli_query($conn, "SELECT id, name FROM playlists WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1");
}

$p_data = mysqli_fetch_assoc($q_p);
$playlist_name = $p_data['name'] ?? null;
$playlist_id = $p_data['id'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>naaSound - Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="dashboard-body">
    <div class="sidebar">
        <div class="logo">naaSound</div>
        <nav class="nav-menu">
            <a href="index.php" class="nav-link active"><i class="fas fa-home"></i> Home</a>
            <a href="#" class="nav-link"><i class="fas fa-search"></i> Search</a>
            <a href="#" class="nav-link"><i class="fas fa-book"></i> Your Library</a>
            <div class="nav-divider"></div>
            <a href="create_playlist.php" class="nav-link"><i class="fas fa-plus-square"></i> Create Playlist</a>
            <a href="addsong.php" class="nav-link"><i class="fas fa-music"></i> Add Song</a>
        </nav>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
    
    <div class="main-content">
        <div class="content-header">
            <div class="header-text">
                <h1 class="welcome-text">Welcome, <?= htmlspecialchars($username); ?></h1>
                <?php if ($jumlah_playlist > 0): ?>
                    <h2 class="playlist-subtitle"><?= htmlspecialchars($playlist_name); ?></h2>
                <?php else: ?>
                    <h2 class="playlist-subtitle" style="color: #8A7A63;">You haven't created a playlist yet</h2>
                <?php endif; ?>
            </div>

            <div class="action-header-buttons">
                <?php if ($jumlah_playlist > 0): ?>
                    <a href="delete_playlist.php?id=<?= $playlist_id; ?>" 
                       class="btn-delete-playlist" 
                       onclick="return confirm('Hapus playlist \'<?= htmlspecialchars($playlist_name); ?>\' beserta seluruh isinya?')">
                       <i class="fas fa-trash"></i> Delete This Playlist
                    </a>
                <?php endif; ?>

                <a href="create_playlist.php" class="btn-add">+ New Playlist</a>
            </div>
        </div>

        <div class="card-container">
            
            <?php if ($jumlah_playlist == 0): ?>
                <div style="text-align: center; padding: 50px 20px;">
                    <i class="fas fa-music" style="font-size: 50px; color: #889063; margin-bottom: 15px;"></i>
                    <p style="color: #4C3D19; font-weight: bold; font-size: 18px; margin-bottom: 8px;">No Playlist Created</p>
                    <p style="color: #8A7A63; font-size: 14px; margin-bottom: 25px;">Please create your first playlist to start adding songs.</p>
                    <a href="create_playlist.php" class="btn-add" style="box-shadow: none; display: inline-block;">Create Playlist</a>
                </div>

            <?php else: ?>
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Genre</th>
                            <th>Duration</th>
                            <th>Action</th>
                            <th>Play</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query_s = mysqli_query($conn, "SELECT * FROM songs WHERE user_id = '$user_id' AND playlist_id = '$playlist_id'");
                        $no = 1;
                        
                        if (mysqli_num_rows($query_s) == 0): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted" style="padding: 30px;">
                                    This playlist is empty. Please click <a href="addsong.php" style="color: #356024; font-weight: bold; text-decoration: none;">Add Song</a> to add a song.
                                </td>
                            </tr>
                        <?php else: 
                            while($s = mysqli_fetch_assoc($query_s)): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="song-title"><?= htmlspecialchars($s['title']); ?></td>
                                <td><?= htmlspecialchars($s['artist']); ?></td>
                                <td><?= htmlspecialchars($s['genre']); ?></td>
                                <td>
                                    <?php 
                                    $durasi_raw = $s['duration'];
                                    if (strpos($durasi_raw, ':') !== false) {
                                        echo htmlspecialchars($durasi_raw);
                                    } else {
                                        $detik = (int)$durasi_raw;
                                        echo ($detik > 0) ? floor($detik / 60) . ":" . sprintf('%02d', ($detik % 60)) : "0:00";
                                    }
                                    ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="edit_song.php?id=<?= $s['id']; ?>" class="link-edit">Edit</a>
                                        <a href="delete_song.php?id=<?= $s['id']; ?>" class="link-delete" onclick="return confirm('Delete this song?')">Delete</a>
                                    </div>
                                </td>
                                <td>
                                    <button class="play-btn">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; 
                        endif; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        </div>
    </div>
</body>
</html>