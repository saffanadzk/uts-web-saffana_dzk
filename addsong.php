<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$pesan = '';
if (isset($_POST['simpan lagu'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $artist = mysqli_real_escape_string($conn, $_POST['artist']);
    $album = mysqli_real_escape_string($conn, $_POST['album']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);

    if (empty($title) || empty($artist) || empty($album) || empty($genre) || empty($duration)) {
        $pesan = 'Semua field harus diisi.';
    } else {
        $insert = mysqli_query($conn, "INSERT INTO songs (title, artist, album, genre, duration) VALUES ('$title', '$artist', '$album', '$genre', '$duration')");
        if ($insert) {
            $pesan = 'berhasil menambahkan lagu!';
        } else {
            $pesan = 'Terjadi kesalahan saat menambahkan lagu.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lagu - Spotify</title>
    <style>
        :root {
            --spotify-green: #1DB954;
            --spotify-dark: #282828;
            --spotify-darker: #181515;
        }
        body {
            background-color: var(--spotify-green); color: white; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;
        }
        nav {
            background-color: var(--spotify-dark); padding: 20px; display: flex; flex-direction: column; border-right: 1px solid var(--spotify-dark); position: fixed; left: 0; top: 0; bottom: 0; width: 250px;
        }
        nav a {
            color: #b3b3b3; text-decoration: none; margin-bottom: 20px; font-size: 14px; font-weight: bold; transition: color 0.3s;
        }
        nav a:hover {
            color: #fff;
        }
        .container {
            padding: 20px; flex: 1; display: flex; justify-content: center; allign-items: center;
        }
        .card {
            background-color: var(--spotify-darker); padding: 30px; border-radius: 10px; width: 100%; max-width: 400px; box-shadow: 0 4px 8px rgba(0,0,0,0.5);
        }
        h2 {
            color: var(--spotify-green); text-align: center; margin-top: 0;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block; margin-bottom: 5px; font-size: 14px; color: #b3b3b3;
        }
        input {
            width: 100%; padding: 10px; border-radius: 5px; border: 1px solid transparent; background-color: var(--spotify-darker); color: white; font-size: 14px; border-radius: 4px; box-sizing: border-box;
        }
        input:focus {
            outline: none; border-color: var(--spotify-green);
        }.btn-save {
            background-color: var(--spotify-green); color: #000; border: none; padding: 10px 20px; border-radius: 20px; cursor: pointer; font-weight: bold; font-size: 14px; width: 100%; margin-top: 10px;
        }
        .btn-save:hover {
            transform: scale(1.05); background-color: #1ed760;
        }
        .error-message {
            background-color: #ff4d4d; color: white; font-size: 14px; padding: 10px; border-radius: 5px; margin-bottom: 20px;
        }
        @media (max-width: 600px) {
            nav {
                flex-direction: column; gap: 10px; width: 100%; height: auto; position: relative; border-right: none; border-bottom: 1px solid var(--spotify-dark);
            }
        }
    </style>
</head>
<body>
    <nav>
        <div style="color: var(--spotify-green); font-size: 24px; font-weight: bold; margin-bottom: 30px;">Spotify</div>
        <div>
            <a href="index.php">Home</a>
            <a href="logout.php" style="color: #ff4d4d;">Logout</a>
        </div>
    </nav>
    <div class="container">
        <div class="card">
            <h2>Tambah Lagu Baru</h2>
            <?php if ($pesan): ?>
                <div class="error-message"><?php echo $pesan; ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="Artist">*</label>
                    <input type="text" id="artist" name="artist" placeholder="Masukkan nama artis">
                </div>
                <div class="form-group">
                    <label for="Title">*</label>
                    <input type="text" name="title" placeholder="Masukkan judul lagu">
                </div>
                <div class="form-group">
                    <label for="Album">*</label>
                    <input type="text" name="album" placeholder="Masukkan nama album">
                </div>
                <div class="form-group">
                    <label for ="Genre">*</label>
                    <input type="text" name="genre" placeholder="Masukkan genre lagu">
                </div>
                <div class="form-group">
                    <label for="Duration">*</label>
                    <input type="text" name="duration" placeholder="Masukkan durasi lagu (mm:ss)">
                </div>
                <button type="submit" name="simpan lagu" class="btn-save">Simpan Lagu</button>
            </form>
        </div>
    </div>
</body>
</html>

