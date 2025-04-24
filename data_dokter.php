<?php
include "koneksi.php";

// Hapus dokter jika ada permintaan delete
if (isset($_GET['hapus'])) {
    $id_dokter = $_GET['hapus'];

    // Ambil nama gambar sebelum dihapus
    $query = "SELECT foto FROM data_dokter WHERE id_dokter = '$id_dokter'";
    $result = mysqli_query($conn, $query);
    $dokter = mysqli_fetch_assoc($result);
    if ($dokter['foto'] != "") {
        unlink("assets/Tampilan/" . $dokter['foto']);
    }

    mysqli_query($conn, "DELETE FROM data_dokter WHERE id_dokter = '$id_dokter'");
    echo "<script>alert('Data dokter berhasil dihapus!'); window.location='data_dokter.php';</script>";
}

// Pencarian dokter
if (isset($_POST["cari"])) {
    $keyword = $_POST["keyword"];
    $query = "SELECT * FROM data_dokter WHERE nama_dokter LIKE '%$keyword%' ORDER BY id_dokter ASC";
} else {
    $query = "SELECT * FROM data_dokter ORDER BY id_dokter ASC";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Dokter</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

<header>
    <?php include "headeradmin.php"; ?>
</header>

<div class="container mt-4">
    <a class="btn btn-primary" href="tambahdata.php"><i class="fas fa-user-plus"></i> Tambah Data Dokter</a>

    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            <h5>Daftar Dokter</h5>
        </div>

        <!-- Form Pencarian -->
        <form action="" method="POST" class="m-3">
            <div class="input-group">
                <input type="text" class="form-control" name="keyword" placeholder="Cari dokter..." autocomplete="off" autofocus>
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
                        <th>ID Dokter</th>
                        <th>Nama Dokter</th>
                        <th>Foto</th>
                        <th>Jenis Dokter</th>
                        <th>Hari & Jam Praktik</th>
                        <th>Kuota</th>
                        <th>Kode Booking</th>
                        <th class="aksi">Aksi</th>
                    </tr>
                </thead>
                <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) :
                ?>
                <tbody>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['id_dokter']; ?></td>
                        <td><?= $row['nama_dokter']; ?></td>
                        <td>
                            <?php if ($row['foto'] != "") : ?>
                                <img src="assets/Tampilan/<?= $row['foto']; ?>" width="70" height="70" class="rounded-circle">
                            <?php endif; ?>
                        </td>
                        <td><?= $row['jenis_dokter']; ?></td>
                        <td><?= $row['hari_praktik'] . " | " . $row['jam_praktik']; ?></td>
                        <td><?= $row['kuota']; ?></td>
                        <td><?= $row['kode_booking']; ?></td>
                        <td>
                            <a style="padding:5px 20px" class="btn btn-primary mb-1" href="editdata.php?id=<?= $row['id_dokter']; ?>"><i class="fas fa-edit"></i> Edit</a>
                            <a style="padding:5px 11px" class="btn btn-primary mb-1" href="?hapus=<?= $row['id_dokter']; ?>" onclick="return confirm('Hapus data dokter ini?')"><i class="fas fa-trash"></i> Hapus</a>
                        </td>
                    </tr>
                </tbody>
                <?php endwhile; ?>
            </table>
        </div>
    </div>        
</div>

</body>
</html>
