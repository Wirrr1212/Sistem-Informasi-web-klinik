<?php
session_start();
include 'koneksi.php';

$kode_booking = '';

// Fungsi ambil nilai enum dari kolom di tabel
function getEnumValues($conn, $table, $column) {
    $query = mysqli_query($conn, "SHOW COLUMNS FROM $table LIKE '$column'");
    $row = mysqli_fetch_assoc($query);
    preg_match("/^enum\(\'(.*)\'\)$/", $row['Type'], $matches);
    $enum = explode("','", $matches[1]);
    return $enum;
}

$jenisDokterEnum = getEnumValues($conn, 'data_dokter', 'jenis_dokter');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['jenis_dokter'])) {
    // Penentuan kode awal berdasarkan jenis dokter
    $jenis = strtolower(trim($_POST['jenis_dokter']));
    $kodeAwal = 'X';

    if ($jenis == 'dokter umum') {
        $kodeAwal = 'A';
    } elseif ($jenis == 'dokter gigi') {
        $kodeAwal = 'B';
    } elseif ($jenis == 'kebidanan') {
        $kodeAwal = 'C';
    }

    // Ambil ID terakhir dan buat kode booking
    $query = mysqli_query($conn, "SELECT MAX(RIGHT(id_dokter, 3)) AS max_id FROM data_dokter");
    $row = mysqli_fetch_assoc($query);
    $next_id = $row ? sprintf("%03d", ((int)$row['max_id']) + 1) : '001';
    $kode_booking = $kodeAwal . $next_id;
}

if (isset($_POST['btnsimpan'])) {
    $nama = $_POST['nama_dokter'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jenis_kelamin'];
    $telp = $_POST['no_telp'];
    $jenis = $_POST['jenis_dokter'];
    $hari = $_POST['hari_praktik'];
    $jam = $_POST['jam_praktik'];
    $kuota = $_POST['kuota'];
    $kode = $_POST['kode_booking'];

    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];
    $upload_dir = "uploads/";
    move_uploaded_file($tmp, $upload_dir . $foto);

    $simpan = mysqli_query($conn, "INSERT INTO data_dokter 
        (nama_dokter, alamat, jenis_kelamin, no_telp, jenis_dokter, hari_praktik, jam_praktik, kuota, kode_booking, foto) 
        VALUES (
        '$nama', '$alamat', '$jk', '$telp', '$jenis', '$hari', '$jam', '$kuota', '$kode', '$foto')");

    if ($simpan) {
        echo "<script>alert('Data berhasil disimpan!'); window.location='data_dokter.php';</script>";
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Tambah Data Dokter</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

<header>
    <?php include "headeradmin.php"; ?>
</header>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <b>Tambah Data Dokter</b>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Nama Dokter</label>
                    <input type="text" name="nama_dokter" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>No Telp</label>
                    <input type="text" name="no_telp" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Jenis Dokter</label>
                    <select name="jenis_dokter" class="form-control" required onchange="this.form.submit()">
                        <option value="">-- Pilih Jenis Dokter --</option>
                        <?php foreach ($jenisDokterEnum as $jenis): ?>
                            <option value="<?= $jenis ?>" <?= (isset($_POST['jenis_dokter']) && $_POST['jenis_dokter'] == $jenis) ? 'selected' : '' ?>>
                                <?= $jenis ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Hari Praktik</label>
                    <select name="hari_praktik" class="form-control" required>
                        <option value="">-- Pilih Hari Praktik --</option>
                        <?php
                        $hari = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
                        foreach ($hari as $h) {
                            echo "<option value='$h'>$h</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Jam Praktik</label>
                    <select name="jam_praktik" class="form-control" required>
                        <option value="">-- Pilih Jam Praktik --</option>
                        <option value="Pagi (08:00 - 14:00)">Pagi (08:00 - 14:00)</option>
                        <option value="Sore (16:00 - 22:00)">Sore (16:00 - 22:00)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kuota Pasien</label>
                    <input type="number" name="kuota" class="form-control" min="1" required>
                </div>
                <div class="form-group">
                    <label>Kode Booking</label>
                    <input type="text" class="form-control" name="kode_booking" value="<?= $kode_booking ?>" readonly>
                </div>
                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="foto" class="form-control">
                </div>
                <button type="submit" class="btn btn-success" name="btnsimpan">Simpan</button>
                <a class="btn btn-primary" href="data_dokter.php">Lihat Data Dokter</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
