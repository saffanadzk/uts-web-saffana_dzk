<?php
include 'koneksi.php';

$error = '';
$success = '';
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $error = 'Password dan username tidak cocok.';
    } else {
        $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if (mysqli_num_rows($check_email) > 0) {
            $error = 'Email sudah terdaftar.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert = mysqli_query($conn, "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')");
            if ($insert) {
                $success = 'Akun berhasil dibuat! Silakan <a href="login.php">login</a>.';
            } else {
                $error = 'Terjadi kesalahan saat mendaftar.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Spotify</title>
    <style>
        body {
            background-color: #1DB954; color: white; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;
        }
        .register-container {
            background-color: #282828; padding: 40px; border-radius: 10px; width: 100px; max-width: 400px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); text-align: center;
        }
        .logo{
            font-size: 24px; font-weight: bold; color: #1DB954; margin-bottom: 30px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%; padding: 10px; border-radius: 5px; border: none; background-color: #181515; color: white; font-size: 14px;
        }
        input:focus {
            outline: none; border: 2px solid #1DB954;
        }
        .button:hover {
            background-color: #1ed760;  
        }
        .error-message {
            background-color: #ff4d4d; color: white; font-size: 14px; padding: 10px; border-radius: 5px; margin-bottom: 20px;
        }
        .success-message {
            background-color: #4CAF50; color: white; font-size: 14px; padding: 10px; border-radius: 5px; margin-bottom: 20px;
        }
        .footer-text {
            margin-top: 20px; font-size: 14px; color: #b3b3b3;
        }
        a {
            color: white; text-decoration: none; font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">Spotify</div>
        <h3>Daftar Akun Baru untuk Mulai Mendengarkan.</h3>
        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required><br><br>
            <input type="email" name="email" placeholder="Email" required><br><br>
            <input type="password" name="password" placeholder="Password" required><br><br>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required><br><br>
            <button type="submit" name="register" class="button">Daftar</button>
        </form>
        <div class="footer-text">Sudah punya akun? <a href="login.php">Login di sini</a>.</div>
    </div>
</body>
</html>