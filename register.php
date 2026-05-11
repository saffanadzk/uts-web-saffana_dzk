<?php
include 'koneksi.php';

$error = '';
$success = '';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = 'Password dan Konfirmasi Password tidak cocok.';
    } else {
        $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($check_email) > 0) {
            $error = 'Email sudah terdaftar.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert = mysqli_query($conn, "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')");
            if ($insert) {
                header("Location: login.php");
                exit(); 
            } else {
                $error = 'Gagal menyimpan ke database: ' . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Spotify</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; }
        body {
            background-color: #121212; /* Hitam pekat Spotify */
            display: flex; justify-content: center; align-items: center; height: 100vh;
        }
        .box {
            background-color: #191414; padding: 40px; border-radius: 12px; 
            width: 100%; max-width: 400px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .logo { color: #1DB954; font-size: 28px; font-weight: bold; margin-bottom: 20px; }
        h3 { color: white; font-size: 16px; margin-bottom: 25px; }
        input {
            width: 100%; padding: 14px; margin-bottom: 15px; border-radius: 8px; 
            border: 1px solid #333; background-color: #282828; color: white;
        }
        input:focus { border-color: #1DB954; outline: none; }
        button {
            width: 100%; padding: 14px; background-color: #1DB954; border: none; 
            border-radius: 50px; color: white; font-weight: bold;
            text-transform: uppercase; cursor: pointer; transition: 0.3s;
        }
        button:hover { background-color: #1ed760; transform: scale(1.02); }
        .error-message { background-color: #ff4d4d; color: white; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 13px; }
        .login-link { color: #b3b3b3; text-decoration: none; font-size: 13px; display: block; margin-top: 25px; }
    </style>
</head>
<body>
    <div class="box">
        <div class="logo">Spotify</div>
        <h3>Daftar Akun Baru</h3>
        
        <?php if ($error) { echo "<div class='error-message'>$error</div>"; } ?>
        <form method="POST" action="register.php"> <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
            <button type="submit" name="register">Daftar</button>
        </form>
        
        <a href="login.php" class="login-link">Sudah punya akun? <b style="color:white">Login di sini</b></a>
    </div>
</body>
</html>