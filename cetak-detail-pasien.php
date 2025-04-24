<?php 
session_start();
include 'koneksi.php';

// Pastikan user sudah login
if ($_SESSION['stat_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

// Mengamankan parameter ID dari URL
$id = mysqli_real_escape_string($conn, $_GET['id']);

// Mengambil data pasien dan dokter berdasarkan ID pendaftaran
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
    <title>Cetak Detail Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>
<body onload="window.print()">

<div class="container mt-4">
    <div class="text-center">
        <h2 class="fw-bold">Klinik Pratama Bhakti Asih</h2>
        <h4 class="text-secondary">Detail Pendaftaran Pasien</h4>
        <hr class="my-3">
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <table class="table table-bordered">
                <tr>
                    <th class="bg-light">Kode Booking</th>
                    <td><?php echo htmlspecialchars($p->id_pendaftaran) ?></td>
                </tr>
                <tr>
                    <th class="bg-light">Tanggal Kunjungan</th>
                    <td><?php echo htmlspecialchars($p->tgl_kunjungan) ?></td>
                </tr>
                <tr>
                    <th class="bg-light">Nama Pasien</th>
                    <td><?php echo htmlspecialchars($p->nm) ?></td>
                </tr>
                <tr>
                    <th class="bg-light">Nama Dokter</th>
                    <td><?php echo !empty($p->nama_dokter) ? htmlspecialchars($p->nama_dokter) : 'Tidak Diketahui'; ?></td>
                </tr>
                <tr>
                    <th class="bg-light">Jenis Penjamin</th>
                    <td><?php echo htmlspecialchars($p->jenis_penjamin) ?></td>
                </tr>
                <tr>
                    <th class="bg-light">No. KTP/KK</th>
                    <td><?php echo htmlspecialchars($p->no_ktp) ?></td>
                </tr>
                <tr>
                    <th class="bg-light">Jenis Kelamin</th>
                    <td><?php echo htmlspecialchars($p->jk) ?></td>
                </tr>
                <tr>
                    <th class="bg-light">Tanggal Lahir</th>
                    <td><?php echo htmlspecialchars($p->tgl_lahir) ?></td>
                </tr>
                <tr>
                    <th class="bg-light">Nomor Telepon</th>
                    <td><?php echo htmlspecialchars($p->no_telp) ?></td>
                </tr>
            </table>

            <div class="text-center mt-4">
                <button class="btn btn-primary print-btn" onclick="window.print()">
                    <i class="bi bi-printer"></i> Cetak
                </button>
                <button class="btn btn-secondary print-btn" onclick="window.close()">
                    <i class="bi bi-x-circle"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
