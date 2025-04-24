<?php
include "koneksi.php";

// Hapus berita jika ada permintaan delete
if (isset($_GET['hapus'])) {
    $id_berita = $_GET['hapus'];

    // Ambil nama gambar sebelum dihapus
    $query = "SELECT gambar FROM data_berita WHERE id_berita = '$id_berita'";
    $result = mysqli_query($conn, $query);
    $berita = mysqli_fetch_assoc($result);
    if ($berita['gambar'] != "") {
        unlink("assets/Tampilan/" . $berita['gambar']);
    }

    mysqli_query($conn, "DELETE FROM data_berita WHERE id_berita = '$id_berita'");
    echo "<script>alert('Berita berhasil dihapus!'); window.location='data_berita.php';</script>";
}

// Pencarian berita
if (isset($_POST["cari"])) {
    $keyword = $_POST["keyword"];
    $query = "SELECT * FROM data_berita WHERE judul LIKE '%$keyword%' ORDER BY id_berita DESC";
} else {
    $query = "SELECT * FROM data_berita ORDER BY id_berita DESC";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Berita</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

<header>
    <?php include "headeradmin.php"; ?>
</header>

<div class="container mt-4">
    <a class="btn btn-primary" href="tambah_berita.php"><i class="fas fa-plus"></i> Tambah Artikel Terbaru</a>

    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            <h5>Daftar Artikel</h5>
        </div>

        <!-- Form Pencarian -->
        <form action="" method="POST" class="m-3">
            <div class="input-group">
                <input type="text" class="form-control" name="keyword" placeholder="Cari berita..." autocomplete="off" autofocus>
                <div class="input-group-append">
                    <button class="btn btn-primary" name="cari" type="submit"><i class="fas fa-search"></i> Cari</button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <table class="table table-hover table-sm">
                <thead>
                    <tr class="bg-info text-white">
                        <th>No</th>
                        <th>Judul</th>
                        <th>Isi</th>
                        <th>Gambar</th>
                        <th class="aksi">Aksi</th>
                    </tr>
                </thead>
                <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) :
                ?>
                <tbody>
                    <tr>
                        <td><?= $no; ?></td>
                        <td><?= $row['judul']; ?></td>
                        <td><?= substr($row['isi'], 0, 100); ?>...</td>
                        <td>
                            <?php if ($row['gambar'] != "") : ?>
                                <img src="assets/Tampilan/<?= $row['gambar']; ?>" width="100" height="100" class="rounded-circle">
                            <?php endif; ?>
                        </td>
                        <td>
                            <a style="padding:5px 20px" class="btn btn-primary mb-1" href="edit_berita.php?id=<?= $row['id_berita']; ?>" role="button"><i class="fas fa-edit"></i> Edit</a>
                            <a style="padding:5px 11px" class="btn btn-primary mb-1" href="?hapus=<?= $row['id_berita']; ?>" onclick="return confirm('Hapus berita ini?')" role="button"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                </tbody>
                <?php
                    $no++;
                    endwhile;
                ?>
            </table>
        </div>
    </div>        
</div>

</body>
</html>
