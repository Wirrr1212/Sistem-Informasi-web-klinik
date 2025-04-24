<?php
include "koneksi.php";

$id_berita = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM data_berita WHERE id_berita = '$id_berita'");
$row = mysqli_fetch_assoc($result);

if (isset($_POST['btnupdate'])) {
    $judul = htmlspecialchars($_POST['judul']);
    $isi = htmlspecialchars($_POST['isi']);
    $gambar_lama = $_POST['gambar_lama'];

    // Cek apakah ada gambar baru yang diunggah
    if ($_FILES['gambar']['name'] != "") {
        $gambar_baru = $_FILES['gambar']['name'];
        $tmp_gambar = $_FILES['gambar']['tmp_name'];
        $folder = "assets/Tampilan/" . $gambar_baru;

        // Hapus gambar lama jika ada
        if ($gambar_lama != "" && file_exists("assets/Tampilan/" . $gambar_lama)) {
            unlink("assets/Tampilan/" . $gambar_lama);
        }

        move_uploaded_file($tmp_gambar, $folder);
    } else {
        $gambar_baru = $gambar_lama;
    }

    mysqli_query($conn, "UPDATE data_berita SET judul='$judul', isi='$isi', gambar='$gambar_baru' WHERE id_berita='$id_berita'");
    echo "<script>alert('Berita berhasil diperbarui!'); window.location='data_berita.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Berita</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

<header>
    <?php include "headeradmin.php"; ?>
</header>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Edit Berita</h5>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Judul Berita</label>
                    <input type="text" name="judul" class="form-control" value="<?= $row['judul']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Isi Berita</label>
                    <textarea name="isi" class="form-control" rows="5" required><?= $row['isi']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Gambar Berita</label><br>
                    <?php if ($row['gambar'] != "") : ?>
                        <img src="assets/Tampilan/<?= $row['gambar']; ?>" width="100" class="mb-2">
                    <?php endif; ?>
                    <input type="file" name="gambar" class="form-control">
                    <input type="hidden" name="gambar_lama" value="<?= $row['gambar']; ?>">
                </div>
                <button type="submit" name="btnupdate" class="btn btn-success"><i class="fas fa-save"></i> Update</button>
                <a href="data_berita.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
