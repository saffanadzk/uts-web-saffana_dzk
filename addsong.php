<?php
session_start();
include 'koneksi.php';

$pesan = '';

if (isset($_POST['simpan_lagu'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $artist = mysqli_real_escape_string($conn, $_POST['artist']);
    $album = mysqli_real_escape_string($conn, $_POST['album']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $duration_raw = $_POST['duration'];

    if (empty($title) || empty($artist) || empty($album) || empty($genre) || empty($duration_raw)) {
        $pesan = 'Semua field harus diisi.';
    } else {
       $parts = explode(':', $duration_raw);
       if (count($parts) == 2) {
           $total_seconds = ($parts[0] * 60) + $parts[1];
        } else {
            $total_seconds = (int)$duration_raw;
        }
        $query = "INSERT INTO songs (title, artist, album, genre, duration) VALUES ('$title', '$artist', '$album', '$genre', '$total_seconds')";
        if (mysqli_query($conn, $query)) {
            header("Location: index.php");
            exit();
        }
        else {
            $pesan = 'Gagal menyimpan lagu: ' . mysqli_error($conn);
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
            --spotify-kombu-green: #354024;
            --spotify-moss-green: #889063;
            --spotify-tan: #CFBB99;
            --spotify-bone: #E5D7C4;
            --spotify-cafe-noir: #4B3621;
        }
        body {
            background-color: #354024; background-color: var(--spotify-kombu-green); color: white; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;
        }
        .card {
            background-color: #FBF9E4; background-color: var(--spotify-pearl); padding: 40px; border-radius: 15px; width: 100%; max-width: 380px; box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        nav {
            background-color: #1a1f11; padding: 20px; display: flex; flex-direction: column; border-right: 1px solid var(--spotify-moss-green); position: fixed; left: 0; top: 0; bottom: 0; width: 250px;
        }
        nav .logo {
            font-size: 24px; font-weight: bold; color: var(--spotify-moss-green); margin-bottom: 40px;
        }
        nav a {
            color: #BAC2C1; text-decoration: none; margin-bottom: 20px; font-size: 14px; font-weight: bold; transition: color 0.3s;
        }
        nav a:hover {
            color: var(--spotify-bone); 
        }
        .container {
            padding: 20px; flex: 1; display: flex; justify-content: center; allign-items: center; background: linear-gradient(180deg, var(--spotify-kombu-green) 0%, #2b331d 100%); margin-left: 250px; 
        }
        .card {
            background-color: var(--spotify-tan); padding: 40px; border-radius: 20px; width: 100%; max-width: 400px; box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        }
        h2 {
            color: var(--spotify-cafe-noir); text-align: center; margin-top: 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block; margin-bottom: 8px; font-size: 13px; color: var(--spotify-cafe-noir);
        }
        input {
            width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #bba686; background-color: var(--spotify-bone); color: var(--spotify-kombu-green); font-size: 14px; box-sizing: border-box; transition: all 0.3s ease;
        }
        input:focus {
            outline: none; border-color: var(--spotify-cafe-noir); box-shadow: 0 0 8px rgba(75, 54, 33, 0.2);
        }.btn-save {
            background-color: var(--spotify-cafe-noir); color: var(--spotify-bone); border: none; padding: 14px; border-radius: 50px; cursor: pointer; font-weight: bold; font-size: 14px; width: 100%; margin-top: 15px; transition: 0.3s ;
        }
        .btn-save:hover {
            transform: scale(1.05); background-color: #352819;
        }
        .btn-cancel {
            background-color: rgba(75, 54, 33, 0.1); color: #7A1012; border-color: #7A1012; 
        }
        .error-message {
            background-color: #7A1012; font-size: 14px; padding: 12px; border-radius: 5px; margin-bottom: 20px;
        }
        .logout-btn {
            margin-top: auto; color: #ff4d4d; text-decoration: none; font-weight: bold; font-size: 14px; transition: 0.3s; padding: 10px 0;
        }
        .logout-btn:hover {
            color: #ff6666; text-decoration: underline;
        }
        @media (max-width: 600px) {
            nav {
                flex-direction: column; gap: 10px; width: 100%; height: auto; position: relative; border-right: none; border-bottom: 1px solid var(--spotify-midnight);
            }
        }
    </style>
</head>
<body>
    <nav>
        <div style="color: var(--spotify-green); font-size: 24px; font-weight: bold; margin-bottom: 30px;">Spotify</div>
        <div>
            <a href="index.php">Home</a>
            <a href="index.php" class="btn-cancel">kembali</a>
        </div>
    </nav>
    <div class="container">
        <div class="card">
            <h2>Tambah Lagu Baru</h2>
            <?php if ($pesan): ?>
                <div class="error-message"><?php echo $pesan; ?></div>
            <?php endif; ?>
            <form action="addsong.php" method="POST">
                <div class="form-group">
                    <label for="Artist"></label>
                    <input type="text" name="artist" placeholder="Masukkan nama artis" required>
                </div>
                <div class="form-group">
                    <label for="Title"></label>
                    <input type="text" name="title" placeholder="Masukkan judul lagu" required>
                </div>
                <div class="form-group">
                    <label for="Album"></label>
                    <input type="text" name="album" placeholder="Masukkan nama album" required>
                </div>
                <div class="form-group">
                    <label for ="Genre"></label>
                    <input type="text" name="genre" placeholder="Masukkan genre lagu" required>
                </div>
                <div class="form-group">
                    <label for="Duration"></label>
                    <input type="text" name="duration" placeholder="Masukkan durasi lagu (mm:ss)" required>
                </div>
                <button type="submit" name="simpan_lagu" class="btn-save">Simpan ke Playlist</button>
            </form>
        </div>
    </div>
</body>
</html>

