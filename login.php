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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login naaSound</title>
    <link rel="stylesheet" href="style.css?v=1.1"> </head> 
</head>
<body>
    </body>
</html>
<body>
    <body class="auth-page"></body>
    <div class="box">
        <div class="logo">naaSound Login</div>
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


