<?php 
session_start();
include 'koneksi.php';

// Cek apakah user sudah login atau belum
if ($_SESSION['stat_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

// Mengamankan parameter id dari URL
$id = mysqli_real_escape_string($conn, $_GET['id']);

// Mengambil data pasien dan data dokter berdasarkan ID pendaftaran
$query = "SELECT p.*, d.nama_dokter FROM tb_pendaftaran1 p 
          LEFT JOIN data_dokter d ON p.id_dokter = d.id_dokter 
          WHERE p.id_pendaftaran = '$id'";
$pasien = mysqli_query($conn, $query);

if (!$pasien) {
    die('Query gagal: ' . mysqli_error($conn));
}

$p = mysqli_fetch_object($pasien);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pasien | Klinik Pratama Bhakti Asih</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

<header>
    <?php include "headeradmin.php"; ?>
</header>

<div class="container mt-4">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h4 class="m-0">Detail Pendaftaran Pasien</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <td><strong>ID Pendaftaran</strong></td>
                    <td>:</td>
                    <td><?php echo htmlspecialchars($p->id_pendaftaran) ?></td>
                </tr>
                <tr>
                    <td><strong>Tanggal Kunjungan</strong></td>
                    <td>:</td>
                    <td><?php echo htmlspecialchars($p->tgl_kunjungan) ?></td>
                </tr>
                <tr>
                    <td><strong>Nama Pasien</strong></td>
                    <td>:</td>
                    <td><?php echo htmlspecialchars($p->nm) ?></td>
                </tr>
                <tr>
                    <td><strong>Nama Dokter</strong></td>
                    <td>:</td>
                    <td><?php echo !empty($p->nama_dokter) ? htmlspecialchars($p->nama_dokter) : 'Tidak Diketahui'; ?></td>
                </tr>
                <tr>
                    <td><strong>Jenis Penjamin</strong></td>
                    <td>:</td>
                    <td><?php echo htmlspecialchars($p->jenis_penjamin) ?></td>
                </tr>
                <tr>
                    <td><strong>Nomor KTP</strong></td>
                    <td>:</td>
                    <td><?php echo htmlspecialchars($p->no_ktp) ?></td>
                </tr>
                <tr>
                    <td><strong>Jenis Kelamin</strong></td>
                    <td>:</td>
                    <td><?php echo htmlspecialchars($p->jk) ?></td>
                </tr>
                <tr>
                    <td><strong>Tanggal Lahir</strong></td>
                    <td>:</td>
                    <td><?php echo htmlspecialchars($p->tgl_lahir) ?></td>
                </tr>
                <tr>
                    <td><strong>Nomor Telepon</strong></td>
                    <td>:</td>
                    <td><?php echo htmlspecialchars($p->no_telp) ?></td>
                </tr>
            </table>
        </div>

        <div class="card-footer text-center">
            <a href="data-peserta.php" class="btn btn-secondary">Kembali</a>
            <a href="cetak-detail-pasien.php?id=<?php echo urlencode($p->id_pendaftaran); ?>" target="_blank" class="btn btn-primary">Cetak</a>
        </div>
    </div>
</div>

</body>
</html>
