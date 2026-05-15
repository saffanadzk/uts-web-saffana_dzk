<?php
session_start();
include 'koneksi.php';

$error = ""; 

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password']) || $password === $row['password']) {
            
            $_SESSION['status']   = "login";
            $_SESSION['username'] = $username;
            $_SESSION['user_id']  = $row['id']; 
            header("Location: index.php");
            exit();
        } else {
            $error = "Password failed!";
        }
    } else {
        $error = "Username not found!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login naaSound</title>
    <link rel="stylesheet" href="style.css?v=1.1">
</head>
<body class="auth-page">
    <div class="box">
        <div class="logo">naaSound</div>
        
        <?php if ($error != ""): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Sign In</button> 
        </form>

        <div class="divider">
            <span>OR</span>
        </div>

        <div class="social-login">
            <button type="button" class="btn-social">
                <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" alt="Google">
                Sign in with Google
            </button>
            <button type="button" class="btn-social">
                <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg" alt="Apple">
                Sign in with Apple
            </button>
        </div>
        
        <a href="register.php" class="register-link">Don't have an account? Create An Account</a>
    </div>
</body>
</html>