<?php
include "koneksi.php";

// Fungsi untuk mendapatkan kode booking terbaru
function generateKodeBooking($conn) {
    $query = "SELECT kode_booking FROM data_dokter ORDER BY kode_booking DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $lastKode = mysqli_fetch_assoc($result)['kode_booking'];

    if ($lastKode) {
        $nomor = intval(substr($lastKode, 1)) + 1; // Ambil angka terakhir dan tambah 1
    } else {
        $nomor = 10; // Jika belum ada data, mulai dari A10
    }

    return 'A' . $nomor;
}

// Cek apakah ada id yang dikirimkan via URL
if (isset($_GET['id'])) {
    $id_dokter = $_GET['id'];
    $query = "SELECT * FROM data_dokter WHERE id_dokter = '$id_dokter'";
    $result = mysqli_query($conn, $query);
    $dokter = mysqli_fetch_assoc($result);
    
    if (!$dokter) {
        echo "<script>alert('Dokter tidak ditemukan!'); window.location = 'data_dokter.php';</script>";
        exit;
    }

    // Jika kode_booking kosong, buat yang baru
    if (empty($dokter['kode_booking'])) {
        $dokter['kode_booking'] = generateKodeBooking($conn);
    }
} else {
    echo "<script>alert('ID dokter tidak ada!'); window.location = 'data_dokter.php';</script>";
    exit;
}

// Proses jika tombol Simpan ditekan
if (isset($_POST['btnsimpan'])) {
    $id_dokter = $_POST['id_dokter'];
    $nama_dokter = $_POST['nama_dokter'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp = $_POST['no_telp'];
    $jenis_dokter = $_POST['jenis_dokter'];
    $hari_praktik = $_POST['hari_praktik'];
    $jam_praktik = $_POST['jam_praktik'];
    $kuota = $_POST['kuota'];
    $kode_booking = $_POST['kode_booking']; // Tambahkan kode booking
    $foto_lama = $_POST['foto_lama'];

    if ($_FILES['foto']['name'] !== '') {
        $foto = uniqid() . '.' . strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        move_uploaded_file($_FILES['foto']['tmp_name'], 'assets/Tampilan/' . $foto);
        if ($foto_lama != "") {
            unlink("assets/Tampilan/" . $foto_lama);
        }
    } else {
        $foto = $foto_lama;
    }

    $query = "UPDATE data_dokter SET 
                nama_dokter='$nama_dokter', 
                alamat='$alamat', 
                jenis_kelamin='$jenis_kelamin', 
                no_telp='$no_telp', 
                jenis_dokter='$jenis_dokter', 
                hari_praktik='$hari_praktik', 
                jam_praktik='$jam_praktik', 
                kuota='$kuota', 
                kode_booking='$kode_booking', 
                foto='$foto' 
              WHERE id_dokter='$id_dokter'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data dokter berhasil diubah!'); window.location = 'data_dokter.php';</script>";
    } else {
        echo "<script>alert('Data dokter gagal diubah!'); window.location = 'data_dokter.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Data Dokter</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

<header>
    <?php include "headeradmin.php"; ?>
</header>

<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3>Edit Data Dokter</h3>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_dokter" value="<?= $dokter['id_dokter']; ?>">
                <input type="hidden" name="foto_lama" value="<?= $dokter['foto']; ?>">

                <div class="mb-3">
                    <label class="form-label">Nama Dokter</label>
                    <input type="text" class="form-control" name="nama_dokter" value="<?= $dokter['nama_dokter']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" required><?= $dokter['alamat']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select class="form-control" name="jenis_kelamin">
                        <option value="Laki-laki" <?= $dokter['jenis_kelamin'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $dokter['jenis_kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">No Telp</label>
                    <input type="text" class="form-control" name="no_telp" value="<?= $dokter['no_telp']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Dokter</label>
                    <input type="text" class="form-control" name="jenis_dokter" value="<?= $dokter['jenis_dokter']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Hari Praktik</label>
                    <input type="text" class="form-control" name="hari_praktik" value="<?= $dokter['hari_praktik']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jam Praktik</label>
                    <input type="text" class="form-control" name="jam_praktik" value="<?= $dokter['jam_praktik']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kuota</label>
                    <input type="number" class="form-control" name="kuota" value="<?= $dokter['kuota']; ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kode Booking</label>
                    <input type="text" class="form-control" name="kode_booking" value="<?= $dokter['kode_booking']; ?>" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Dokter</label><br>
                    <img src="assets/Tampilan/<?= $dokter['foto']; ?>" width="100"><br>
                    <input type="file" class="form-control" name="foto">
                </div>

                <button type="submit" class="btn btn-success" name="btnsimpan">Simpan</button>
                <a href="data_dokter.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
