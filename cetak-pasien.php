<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login
if ($_SESSION['stat_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}

// Ambil filter tanggal jika ada
$tgl_awal = isset($_GET['tgl_awal']) ? $_GET['tgl_awal'] : '';
$tgl_akhir = isset($_GET['tgl_akhir']) ? $_GET['tgl_akhir'] : '';

// Query utama
$query = "SELECT p.*, d.nama_dokter FROM tb_pendaftaran1 p 
          LEFT JOIN data_dokter d ON p.id_dokter = d.id_dokter";

// Jika filter tanggal diisi, tambahkan kondisi WHERE
if (!empty($tgl_awal) && !empty($tgl_akhir)) {
    $query .= " WHERE p.tgl_kunjungan BETWEEN '$tgl_awal' AND '$tgl_akhir'";
}

$list_pasien = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Data Pasien</title>
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
        <h4 class="text-secondary">Data Pendaftaran Pasien</h4>
        <hr class="my-3">
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr class="bg-info text-white">
                <th>No</th>
                <th>ID Pendaftaran</th>
                <th>Tanggal Kunjungan</th>
                <th>Nama Pasien</th>
                <th>Nama Dokter</th>
                <th>Jenis Penjamin</th>
                <th>Nomor KTP</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Nomor Telepon</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_array($list_pasien)) {
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['id_pendaftaran']); ?></td>
                    <td><?= htmlspecialchars($row['tgl_kunjungan']); ?></td>
                    <td><?= htmlspecialchars($row['nm']); ?></td>
                    <td><?= !empty($row['nama_dokter']) ? htmlspecialchars($row['nama_dokter']) : 'Tidak Diketahui'; ?></td>
                    <td><?= htmlspecialchars($row['jenis_penjamin']); ?></td>
                    <td><?= htmlspecialchars($row['no_ktp']); ?></td>
                    <td><?= htmlspecialchars($row['jk']); ?></td>
                    <td><?= htmlspecialchars($row['tgl_lahir']); ?></td>
                    <td><?= htmlspecialchars($row['no_telp']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
