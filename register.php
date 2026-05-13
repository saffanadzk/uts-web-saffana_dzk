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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="box">
        <div class="logo">Daftar Akun naaSound</div>
        
        <?php if (isset($error)) { echo "<div class='error-message'>$error</div>"; } ?>

        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
            
            <button type="submit" name="register">Daftar</button>
            
            <a href="login.php" class="register-link">Sudah punya akun? <b>Login sekarang</b></a>
        </form>
    </div>
</body>
</body>
</html>