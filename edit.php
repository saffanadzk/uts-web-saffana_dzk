<?php
session_start();
include 'koneksi.php';

$id=$_GET['id'];
$result=mysqli_query($conn, "SELECT * FROM songs WHERE id='$id'");
$data=mysqli_fetch_array($result);
if (!isset($_POST['update'])) {
    $title = $_POST($conn, $_POST['title']);
    $artist = $_POST($conn, $_POST['artist']);
    $album = $_POST($conn, $_POST['album']);
    $genre = $_POST($conn, $_POST['genre']);
    $duration = $_POST($conn, $_POST['duration']);

    $query = "UPDATE songs SET title='$title', artist='$artist', album='$album', genre='$genre', duration='$duration' WHERE id='$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>
<form method="POST" action="">
    <input type="text" name="title" value="<?php echo $data['title']; ?>" required>
    <input type="text" name="artist" value="<?php echo $data['artist']; ?>" required>
    <input type="text" name="album" value="<?php echo $data['album']; ?>" required>
    <input type="text" name="genre" value="<?php echo $data['genre']; ?>" required>
    <input type="number" name="duration" value="<?php echo $data['duration']; ?>" required>
    <button type="submit" name="update">Simpan Perubahan</button>
</form>