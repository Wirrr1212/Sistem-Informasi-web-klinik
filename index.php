<?php
session_start();
include 'koneksi.php';

$dokterList = mysqli_query($conn, "SELECT * FROM data_dokter");
$selectedDoctorId = $_GET['id'] ?? null;

$errorMessage = '';
if (isset($_POST['submit'])) {
    $idDokter = $_POST['id_dokter'];
    $dokterQuery = mysqli_query($conn, "SELECT * FROM data_dokter WHERE id_dokter = '$idDokter'");
    $dokterData = mysqli_fetch_assoc($dokterQuery);

    if (!$dokterData) {
        $errorMessage = "Data dokter tidak ditemukan.";
        echo "<div class='alert alert-danger'>$errorMessage</div>";
        return;
    }

    $jenis = strtolower(trim($dokterData['jenis_dokter']));
    $kuotaMaksimal = (int)$dokterData['kuota'];

    // Menentukan kode awal berdasarkan jenis dokter
    if ($jenis == 'dokter umum') {
        $kodeAwal = 'A';
    } elseif ($jenis == 'dokter gigi') {
        $kodeAwal = 'B';
    } elseif ($jenis == 'bidan') {
        $kodeAwal = 'C';
    } else {
        $errorMessage = "Jenis dokter tidak dikenali.";
        echo "<div class='alert alert-danger'>$errorMessage</div>";
        return;
    }

    $tanggal = date('Y-m-d', strtotime($_POST['tgl_kunjungan']));

    // Cek kuota
    $cekKuota = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM tb_pendaftaran1 WHERE id_dokter = '$idDokter' AND tgl_kunjungan = '$tanggal'");
    $dataKuota = mysqli_fetch_assoc($cekKuota);

    if ($dataKuota['jumlah'] >= $kuotaMaksimal) {
        $errorMessage = "Maaf, kuota penuh pada tanggal tersebut.";
    } else {
        // Ambil ID terakhir dari tabel
        $getMaxId = mysqli_query($conn, "SELECT MAX(id_pendaftaran) AS max_id FROM tb_pendaftaran1");
        $d = mysqli_fetch_object($getMaxId);
        $idPendaftaran = ($d && isset($d->max_id)) ? intval($d->max_id) + 1 : 1;

        // Hitung nomor antrian untuk dokter & tanggal yang sama
        $getAntrian = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tb_pendaftaran1 WHERE id_dokter = '$idDokter' AND tgl_kunjungan = '$tanggal'");
        $rowAntrian = mysqli_fetch_assoc($getAntrian);
        $nomorAntrian = $rowAntrian ? $rowAntrian['total'] + 1 : 1;

        // Kode dokter khusus, contoh: C001
        $kodeJenis = $kodeAwal . str_pad($idDokter, 3, "0", STR_PAD_LEFT);

        // Format tanggal
        $tanggalFormat = date('Ymd', strtotime($tanggal));

        // Kode booking final
        $kodeBooking = $kodeJenis . "-" . $tanggalFormat . "-" . $nomorAntrian;

        // Simpan ke database
        $insert = mysqli_query($conn, "INSERT INTO tb_pendaftaran1 (
            id_pendaftaran, kode_booking, tgl_kunjungan, nm, jenis_penjamin, no_bpjs, no_ktp,
            tgl_lahir, email, jk, no_telp, id_dokter, nama_dokter
        ) VALUES (
            '$idPendaftaran',
            '$kodeBooking',
            '$tanggal',
            '".htmlspecialchars($_POST['nm'])."',
            '".htmlspecialchars($_POST['jenis_penjamin'])."',
            '".htmlspecialchars($_POST['no_bpjs'])."',
            '".htmlspecialchars($_POST['no_ktp'])."',
            '".htmlspecialchars($_POST['tgl_lahir'])."',
            '".htmlspecialchars($_POST['email'])."',
            '".htmlspecialchars($_POST['jk'])."',
            '".htmlspecialchars($_POST['no_telp'])."',
            '$idDokter',
            '".htmlspecialchars($dokterData['nama_dokter'])."'
        )");

        if ($insert) {
            echo "<script>
                alert('Booking berhasil! Kode Anda: $kodeBooking');
                window.location='berhasil.php?kode=$kodeBooking';
            </script>";
        } else {
            $errorMessage = "Terjadi kesalahan saat menyimpan data: " . mysqli_error($conn);
        }
    }
}
?>

?>

<!DOCTYPE html>
<html>
<head>
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<section class="box-formulir">
    <h2>Booking Appointment</h2>
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger"><?= $errorMessage ?></div>
    <?php endif; ?>
    <form action="" method="post">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Kunjungan</label>
                    <input type="date" name="tgl_kunjungan" class="form-control" min="<?= date('Y-m-d', strtotime('+1 day')); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nm" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Penjamin</label>
                    <select class="form-control" name="jenis_penjamin" id="jenis_penjamin" required>
                        <option value="">--Pilih Jenis Penjamin--</option>
                        <option value="Pribadi">Pribadi</option>
                        <option value="Asuransi">Asuransi</option>
                        <option value="BPJS">BPJS</option>
                    </select>
                </div>
                <div id="no_bpjs_field" class="col-md-6 mb-3" style="display: none;">
                    <label class="form-label">No. BPJS</label>
                    <input type="text" name="no_bpjs" id="no_bpjs" class="form-control" pattern="[0-9]{13}" placeholder="Masukkan 13 digit Nomor BPJS">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. KTP/KK</label>
                    <input type="text" name="no_ktp" class="form-control" pattern="[0-9]{16}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tgl_lahir" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kelamin</label><br>
                    <input type="radio" name="jk" value="Laki-laki" required> Laki-laki
                    <input type="radio" name="jk" value="Perempuan" required> Perempuan
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="no_telp" class="form-control" pattern="[0-9]{10,13}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pilih Dokter</label>
                    <select name="id_dokter" class="form-control" required>
                        <option value="">--Pilih Dokter--</option>
                        <?php while ($dokter = mysqli_fetch_assoc($dokterList)): ?>
                            <option value="<?= $dokter['id_dokter'] ?>" <?= ($selectedDoctorId == $dokter['id_dokter']) ? 'selected' : '' ?> >
                                <?= $dokter['nama_dokter'] ?> - <?= $dokter['jenis_dokter'] ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <button type="submit" name="submit" class="btn btn-primary">Daftar</button>
                    <a href="informasi.php" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </form>
</section>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const jenisPenjamin = document.getElementById("jenis_penjamin");
    const noBpjsField = document.getElementById("no_bpjs_field");

    jenisPenjamin.addEventListener("change", function () {
        noBpjsField.style.display = (this.value === "BPJS") ? "block" : "none";
    });
});
</script>
</body>
</html>
