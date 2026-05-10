<?php
include 'koneksi.php';
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Login gagal. Periksa username dan password Anda.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Spotify</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box; font-family: 'Roboto', sans-serif;
        }
        body {
            background: linear-gradient(rgba(166, 216, 29, 0.8), rgba(18, 18, 18, 0.9)), url('https://png.pngtree.com/thumb_back/fw800/background/20250907/pngtree-music-streaming-app-on-phone-with-earbuds-at-night-image_18955606.webp'); background-size: cover; background-position: center; display: flex; justify-content: center; align-items: center; height: 100vh;
        }
        .box {
            background-color: #191414; padding: 40px 30px ; border-radius: 12px; width: 100%; max-width: 400px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4); text-align: center;
            }
        .logo {
            color: #1DB954; font-size: 26px; font-weight: bold; text-align: center; margin-bottom: 30px; letter-spacing: -1px;
        }
        input {
            width: 100%; padding: 14px; margin-bottom: 15px; border: 1px solid transparent; border-radius: 4px; background-color: #333; color: white; transition: all 0.3s ease; font-size: 14px;     
        }
        input:focus {
            border-color: #1DB954; outline: none; background-color: #333;
        }       
        button {
            width: 100%; padding: 14px; background-color: #1DB954; border: none; border-radius: 5px; color: white; font-size: 14px; cursor: pointer; font-weight: 700; text-transform: uppercase; transition: transform 0.2s; letter-spacing: 1px; margin-top: 10px;
        }
        button:hover {
            background-color: #1ed760; transform: translateY(-2px);
        }
        .register-link {
            color: #b3b3b3; display: block; text-align: center; margin-top: 25px; text-decoration: none; font-size: none; font-size: 13px;
        }
        .register-link b {
            color: white;
        }
        .register-link:hover b {
            color: #1DB954; text-decoration: underline;
        }
        .error-message {
            background-color: #ff4d4d; color: white; margin-bottom: 15px; font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="logo">Spotify Login</div>
        <?php if (isset($error)) { echo "<div class='error-message'>$error</div>"; } ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
            <a href="register.php" class="register-link">Belum punya akun? Daftar sekarang</a>
        </form>
    </div>
</body>
</html>


