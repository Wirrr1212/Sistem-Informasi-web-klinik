<?php
  include 'koneksi.php';

  $kode = $_GET['kode'] ?? '';

  $query = mysqli_query($conn, "SELECT p.*, d.nama_dokter 
      FROM tb_pendaftaran1 p 
      LEFT JOIN data_dokter d ON p.id_dokter = d.id_dokter 
      WHERE p.kode_booking = '".mysqli_real_escape_string($conn, $kode)."' 
      LIMIT 1"); // ambil hanya satu data

  $data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bukti Pendaftaran - Klinik Bhakti Asih</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 40px;
      background-color: #fff;
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    td {
      padding: 10px;
      vertical-align: top;
    }
    tr:nth-child(odd) {
      background-color: #f9f9f9;
    }
    .label {
      width: 200px;
      font-weight: bold;
    }
    .center {
      text-align: center;
    }
    @media print {
      .no-print {
        display: none;
      }
    }
  </style>
  <script>
    window.onload = function() {
      window.print();
    }
  </script>
</head>
<body>

  <h2>Bukti Pendaftaran Pasien Rawat Jalan</h2>

  <table>
    <tr>
      <td class="label">Kode Booking</td>
      <td>: <?= htmlspecialchars($data['kode_booking']) ?></td>
    </tr>
    <tr>
      <td class="label">Tanggal Kunjungan</td>
      <td>: <?= htmlspecialchars($data['tgl_kunjungan']) ?></td>
    </tr>
    <tr>
      <td class="label">Nama Pasien</td>
      <td>: <?= htmlspecialchars($data['nm']) ?></td>
    </tr>
    <tr>
      <td class="label">Nama Dokter</td>
      <td>: <?= htmlspecialchars($data['nama_dokter']) ?></td>
    </tr>
    <tr>
      <td class="label">Jenis Penjamin</td>
      <td>: <?= htmlspecialchars($data['jenis_penjamin']) ?></td>
    </tr>
    <tr>
      <td class="label">Nomor BPJS</td>
      <td>: <?= ($data['jenis_penjamin'] == 'BPJS') ? htmlspecialchars($data['no_bpjs']) : '-' ?></td>
    </tr>
    <tr>
      <td class="label">Nomor KTP</td>
      <td>: <?= htmlspecialchars($data['no_ktp']) ?></td>
    </tr>
    <tr>
      <td class="label">Tanggal Lahir</td>
      <td>: <?= htmlspecialchars($data['tgl_lahir']) ?></td>
    </tr>
    <tr>
      <td class="label">Jenis Kelamin</td>
      <td>: <?= htmlspecialchars($data['jk']) ?></td>
    </tr>
    <tr>
      <td class="label">Email</td>
      <td>: <?= htmlspecialchars($data['email']) ?></td>
    </tr>
    <tr>
      <td class="label">Nomor Telepon</td>
      <td>: <?= htmlspecialchars($data['no_telp']) ?></td>
    </tr>
  </table>

  <div class="center no-print" style="margin-top: 40px;">
    <a href="index2.php" style="text-decoration: none; padding: 10px 20px; background: #007BFF; color: white; border-radius: 5px;">Kembali ke Halaman Utama</a>
  </div>

</body>
</html>
