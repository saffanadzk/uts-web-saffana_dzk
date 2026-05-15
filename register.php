<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if(mysqli_num_rows($cek) > 0) {
            $error = "Username already taken!";
        } else {
            $query = mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password')");
        if ($query) {
            header("Location: auth.php");
            exit();
        } else {
            $error = "Failed to register!";
        }
    }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - naaSound</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body class="auth-page"> <div class="box"> 
        <p style="color: #4C3D19; font-weight: bold; margin-bottom: 25px; font-size: 20px;">Create New Account</p>
        <?php if(isset($error)) : ?>
            <div class="error-message"><?= $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required> <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
    
            <button type="submit" name="register">Sign Up</button>
        </form>
        <div class="divider">
            <span>Have an account?</span>
        </div>
        <a href="auth.php" class="register-link">Login Now</a>
    </div>
</body>
</html>