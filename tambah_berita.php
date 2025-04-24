<?php
include "koneksi.php";

if (isset($_POST['btnsimpan'])) {
    $judul = htmlspecialchars($_POST['judul']);
    $isi = htmlspecialchars($_POST['isi']);
    $tanggal_publikasi = date('Y-m-d');

    // Upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    $folder = "assets/Tampilan/";

    if ($gambar != "") {
        $ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
        $gambar_baru = uniqid() . "." . $ext;
        move_uploaded_file($tmp_name, $folder . $gambar_baru);
    } else {
        $gambar_baru = "";
    }

    // Simpan ke database
    $query = "INSERT INTO data_berita (judul, isi, gambar) 
              VALUES ('$judul', '$isi','$gambar_baru')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Berita berhasil ditambahkan!'); window.location='tambah_berita.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan berita!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Berita</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

<header>
    <?php include "headeradmin.php"; ?>
</header>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <b>Tambah Artikel Terbaru</b>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Judul Berita</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Isi Berita</label>
                    <textarea name="isi" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label>Gambar</label>
                    <input type="file" name="gambar" class="form-control">
                </div>
                <button type="submit" class="btn btn-success" name="btnsimpan">Simpan</button>
                <a class="btn btn-primary" href="data_berita.php">Lihat Berita</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
