<?php
session_start();
include 'koneksi.php';

$id=$_GET['id'];
$result=mysqli_query($conn, "SELECT * FROM songs WHERE id='$id'");
$data=mysqli_fetch_array($result);
if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $artist = mysqli_real_escape_string($conn, $_POST['artist']);
    $album = mysqli_real_escape_string($conn, $_POST['album']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);

    $query = "UPDATE songs SET title='$title', artist='$artist', album='$album', genre='$genre', duration='$duration' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
<style>
    body {
        background-color: #2D3E2F; color: #E5D7C4; font-family: 'Segoe UI', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0;
    }
    .card {
        background-color: #CFBB99; padding: 30px; border-radius: 15px; width: 100%; max-width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.3);
    }
    h1 {
        font-size: 24px; color: #4C3D19; text-align: center; margin-bottom: 25px; text-transform: uppercase; letter-spacing: 2px;
    }
    label {
        display: block; margin-bottom: 5px; font-size: 13px; color: #4C3D19; font-weight: bold;
    }
    input[type="text"], input[type="number"] {
        width: 100%; padding: 12px; margin-bottom: 20px; border: 1px solid #bba68c; border-radius: 8px; background-color: #E5D7C4; color: #4C3D19; transition: 0.3s;
    }
    .buttom-group {
        display: flex; gap: 10px; margin-top: 10 px;
    }
    .btn-save {
        flex: 2; background-color: #4C3D19; color: #E5D7C4; border: none; padding: 12px; border-radius: 8px; font-wight: bold; cursor: pointer; transition: 0.3s;
    }
    .btn-save: hover {
        background-color: #352819; transform: translateY(-2px);
    }
    .btn-cancel {
        flex: 1; background-color: #7A1012; color: white; border-radius: 8px; font-weight: bold; text-decoration: none; text-align: center; transition: 0.3s; font-size: 14px; padding: 12px;
    }
</style>
<div class="main-content">
    <div class="card">
    <h1>Edit Lagu</h1>
    <form method="POST" action="">
        <label>Judul Lagu:</label>
            <input type="text" name="title" value="<?php echo $data['title']; ?>" required>
        <label>Artis:</label>
            <input type="text" name="artist" value="<?php echo $data['artist']; ?>" required>
        <label>Album:</label>
            <input type="text" name="album" value="<?php echo $data['album']; ?>" required>
        <label>Genre:</label>
            <input type="text" name="genre" value="<?php echo $data['genre']; ?>" required>
        <label>Duration:</label>
            <input type="text" name="duration" value="<?php echo $data['duration']; ?>" required>
        <button type="submit" name="update" class="btn-save">Simpan Perubahan</button>
        <a href="index.php" class="btn-cancel">Kembali</a>
    </div>
</form>
</div>