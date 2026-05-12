<?php
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Spotify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box; font-family: 'Roboto', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #889063 0%, #354024 100%), url('https://png.pngtree.com/thumb_back/fw800/background/20250907/pngtree-music-streaming-app-on-phone-with-earbuds-at-night-image_18955606.webp'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; font-family: 'Segoe UI', sans-serif;
        }
        .box {
            background-color: #CFBB99; padding: 40px 30px ; border-radius: 12px; width: 100%; max-width: 400px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4); text-align: center;
            }
        .logo {
            color: #4C3D19; font-size: 26px; font-weight: bold; text-align: center; margin-bottom: 30px; letter-spacing: -1px;
        }
        h2 {
            color: #4C3D19; margin-bottom: 20px;
        }
        input {
            width: 100%; padding: 14px; margin-bottom: 15px; border: 1px solid #889063; border-radius: 4px; background-color: #E5D7C4; color: #354024; transition: all 0.3s ease; font-size: 14px;     
        }
        input:focus {
            border-color: #4B3621; outline: none; background-color: #F0E6D6;
        }    
        button {
            width: 100%; padding: 14px; background-color: #4C3D19; border: none; border-radius: 5px; color: #E5D7C4; background-color: 0.3s; font-size: 14px; cursor: pointer; font-weight: 700; text-transform: uppercase; transition: transform 0.2s; letter-spacing: 1px; margin-top: 10px;
        }
        button:hover {
            background-color: #352819; transform: translateY(-2px);
        }
        .register-link {
            color: #4C3D19; display: block; text-align: center; margin-top: 25px; text-decoration: none; font-size: none; font-size: 13px;
        }
        .register-link b {
            color: #354024; font-weight: bold;
        }
        .register-link:hover b {
            text-decoration: underline;
        }
        .error-message {
            background-color: #7A1012; color: #E5D7C4; margin-bottom: 15px; font-size: 12px;
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


