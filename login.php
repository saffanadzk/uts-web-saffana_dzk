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
        echo "Login gagal. Periksa username dan password Anda.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Spotify</title>
    <style>
        body {
            background-color: #1DB954; color: white; font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh;
        }
        .box {
            background-color: #191414; padding: 20px; border-radius: 10px; width: 300px; 
            }
        .logo {
            color: #1DB954; font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 20px;
        }
        input {
            width: 100%; padding: 12px; margin: 10px 0; border: none; border-radius: 5px; background-color: #333; color: white;     
        }       
        button {
            width: 100%; padding: 12px; background-color: #1DB954; border: none; border-radius: 5px; color: white; font-size: 16px; cursor: pointer;
        }
        button:hover {
            background-color: #1ed760;
        }
    </style>
</head>
<body>
    <div class="box">
        <div class="logo">Spotify Login</div>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>


