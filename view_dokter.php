<?php 
  session_start();

  require 'functions.php'; 

  // Ambil ID dokter dari URL
  $id = $_GET["id"];

  // Query data dokter berdasarkan ID
  $dokter = view($id)[0];  // Mengambil data dokter pertama (karena id_dokter unik)

  include "header.php"; 
?>
<div class="container mt-5">
  <div class="row">
    <div class="col-md-6 text-center">
      <!-- Gambar dokter -->
      <img src="assets/Tampilan/<?= htmlspecialchars($dokter['foto']) ?>" class="img-fluid rounded-circle" alt="Foto <?= htmlspecialchars($dokter['nama_dokter']) ?>" width="200">
      <h2 class="fw-normal mt-3"><?= htmlspecialchars($dokter['nama_dokter']) ?></h2>
      <p class="text-muted"><?= htmlspecialchars($dokter['jenis_dokter']) ?></p>
    </div>

    <div class="col-md-6">
      <h3>Profil Dokter</h3>
      <p><strong>Jenis Dokter: </strong><?= htmlspecialchars($dokter['jenis_dokter']) ?></p>
      
      <h3>Jadwal Praktik</h3>
      <table class="table">
        <tbody>
          <tr>
            <td>Hari Praktik</td>
            <td><?= htmlspecialchars($dokter['hari_praktik']) ?></td>
          </tr>
          <tr>
            <td>Jam Praktik</td>
            <td><?= htmlspecialchars($dokter['jam_praktik']) ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="text-center mt-4">
    <a href="informasi.php" class="btn btn-primary">Kembali</a>
    <a href="index.php?id=<?= htmlspecialchars($dokter['id_dokter']) ?>" class="btn btn-primary">Booking Appointment</a>
  </div>
</div>

<?php 
  include "footer.php"; 
?>
