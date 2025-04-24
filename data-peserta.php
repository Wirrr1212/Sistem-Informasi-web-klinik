<?php
session_start();
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION['stat_login']) || $_SESSION['stat_login'] != true) {
    echo '<script>window.location="login.php"</script>';
    exit;
}

$tgl_awal = $_GET['tgl_awal'] ?? '';
$tgl_akhir = $_GET['tgl_akhir'] ?? '';

if (isset($_GET['wa_id'])) {
    $wa_id = $_GET['wa_id'];
    mysqli_query($conn, "UPDATE tb_pendaftaran1 SET status_wa = 1 WHERE id_pendaftaran = '$wa_id'");
    header("Location: data-peserta.php?tgl_awal=$tgl_awal&tgl_akhir=$tgl_akhir");
    exit;
}

$query = "SELECT p.*, d.nama_dokter, d.jenis_dokter 
          FROM tb_pendaftaran1 p
          LEFT JOIN data_dokter d ON p.id_dokter = d.id_dokter";

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
    <title>Data Peserta</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
</head>
<body>
<header>
    <?php include "headeradmin.php"; ?>
</header>

<div class="container mt-4">
    <a class="btn btn-primary mb-3" href="tambah_peserta.php"><i class="fas fa-plus"></i> Tambah Peserta</a>
    <a href="cetak-pasien.php" target="_blank" class="btn btn-primary mb-3"><i class="fas fa-print"></i> Cetak</a>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Data Peserta Rawat Jalan</h5>
        </div>

        <form method="GET" action="" class="m-3">
            <div class="row d-flex justify-content-center">
                <div class="col-md-4">
                    <label for="tgl_awal">Tanggal Awal:</label>
                    <input type="date" class="form-control text-center" name="tgl_awal" value="<?= $tgl_awal; ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="tgl_akhir">Tanggal Akhir:</label>
                    <input type="date" class="form-control text-center" name="tgl_akhir" value="<?= $tgl_akhir; ?>" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive px-3">
            <table class="table table-hover table-sm">
                <thead>
                    <tr class="bg-info text-white text-center">
                        <th>No</th>
                        <th>ID Pendaftaran</th>
                        <th>Kode Booking</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Nama Pasien</th>
                        <th>Nama Dokter</th>
                        <th>Jenis Penjamin</th>
                        <th>No. KTP / KK</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Nomor Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_array($list_pasien)) {
                    $id = $row['id_pendaftaran'];
                    $nama_pasien = strtoupper($row['nm']);
                    $dokter = $row['nama_dokter'] ?? 'Tidak Diketahui';
                    $jenis_dokter = $row['jenis_dokter'] ?? 'Dokter';
                    $tanggal = $row['tgl_kunjungan'];
                    $jam_kunjungan = date('H:i', strtotime($row['waktu_kunjungan'] ?? '08:00'));
                    $penjamin = $row['jenis_penjamin'];
                    $antrian = $no;

                    // Format nomor WA
                    $telp = preg_replace('/[^0-9]/', '', $row['no_telp']);
                    if (substr($telp, 0, 1) == '0') {
                        $telp = '62' . substr($telp, 1);
                    }

                    // Format pesan WA
                    $pesan = "Yth. Bapak/Ibu $nama_pasien%0A%0A";
                    $pesan .= "Terima kasih telah melakukan pendaftaran online rawat jalan di Klinik Pratama Bhakti Asih. Berikut ini kami informasikan detail perjanjian Bapak/Ibu:%0A%0A";
                    $pesan .= "Tujuan Poliklinik : $jenis_dokter%0A";
                    $pesan .= "Nama Dokter : $dokter%0A";
                    $pesan .= "Tanggal : $tanggal%0A";
                    $pesan .= "Jam : $jam_kunjungan WIB%0A";
                    $pesan .= "Jenis Penjamin : $penjamin%0A";
                    $pesan .= "No. Antrian : $antrian%0A%0A";
                    $pesan .= "- Harap datang 1 jam sebelum jam praktek dokter dan mengambil nomor antrian online pada mesin antrian%0A%0A";
                    $pesan .= "Wajib melakukan konfirmasi kedatangan dengan menjawab *Hadir* atau *Tidak Hadir* dengan batas waktu pukul 17.00.%0A%0A";
                    $pesan .= "Klinik Pratama Bhakti Asih,%0AKepuasan anda adalah Komitmen Kami.";

                    $link_wa = "https://wa.me/$telp?text=$pesan";
                ?>
                    <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['id_pendaftaran']); ?></td>
                        <td><?= htmlspecialchars($row['kode_booking']); ?></td>
                        <td><?= htmlspecialchars($row['tgl_kunjungan']); ?></td>
                        <td><?= htmlspecialchars($row['nm']); ?></td>
                        <td><?= htmlspecialchars($dokter); ?></td>
                        <td><?= htmlspecialchars($penjamin); ?></td>
                        <td><?= htmlspecialchars($row['no_ktp']); ?></td>
                        <td><?= htmlspecialchars($row['jk']); ?></td>
                        <td><?= htmlspecialchars($row['tgl_lahir']); ?></td>
                        <td><?= htmlspecialchars($row['no_telp']); ?></td>
                        <td class="text-center">
                            <a class="btn btn-primary btn-sm mb-1" href="detail-peserta.php?id=<?= urlencode($id); ?>"><i class="fas fa-eye"></i> Detail</a>
                            <a class="btn btn-danger btn-sm mb-1" href="hapus-peserta.php?id=<?= urlencode($id); ?>" onclick="return confirm('Yakin ingin menghapus peserta ini?')"><i class="fas fa-trash"></i> Hapus</a>

                            <?php if ($row['status_wa'] == 0): ?>
                                <a class="btn btn-success btn-sm mb-1" href="<?= $link_wa ?>" target="_blank" onclick="setTimeout(() => { window.location.href='data-peserta.php?wa_id=<?= $id ?>&tgl_awal=<?= $tgl_awal ?>&tgl_akhir=<?= $tgl_akhir ?>'; }, 3000);">
                                    <i class="fab fa-whatsapp"></i> Kirim WA
                                </a>
                            <?php else: ?>
                                <span class="badge bg-success">✅ Sudah WA</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php } ?>
                <?php if (mysqli_num_rows($list_pasien) == 0): ?>
                    <tr>
                        <td colspan="12" class="text-center">Tidak ada data peserta.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
