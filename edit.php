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