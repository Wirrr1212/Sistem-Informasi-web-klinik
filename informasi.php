<?php 
  session_start();
  require 'functions.php'; 

  // Ambil input pencarian dari URL jika ada
  $search = isset($_GET['search']) ? $_GET['search'] : '';
  $jenis_dokter = isset($_GET['jenis_dokter']) ? $_GET['jenis_dokter'] : '';

  // Query untuk mengambil data dokter dengan pencarian nama dan jenis dokter jika ada
  $query = "SELECT * FROM data_dokter WHERE nama_dokter LIKE '%$search%'";

  // Tambahkan filter jenis dokter jika ada
  if ($jenis_dokter) {
    $query .= " AND jenis_dokter = '$jenis_dokter'";
  }

  $query .= " ORDER BY id_dokter ASC";

  $dokter = query($query);

  include "header.php"; 
?>

<div class="album py-5 bg-body-tertiary">
  <div class="container">
    <!-- Keterangan Pencarian -->
    <p class="mb-4">Cari berdasarkan nama atau jenis dokter:</p>

    <!-- Form Pencarian dengan nama dokter dan jenis dokter bersampingan -->
    <form class="d-flex mb-4" method="get">
      <div class="row w-100">
        <!-- Kolom untuk mencari nama dokter -->
        <div class="col-md-6 mb-3">
          <input class="form-control" type="search" name="search" placeholder="Cari nama dokter..." aria-label="Search" value="<?= htmlspecialchars($search) ?>" style="max-width: 100%;">
        </div>

        <!-- Kolom untuk memilih jenis dokter -->
        <div class="col-md-5 mb-3">
          <select class="form-control" name="jenis_dokter">
            <option value="">--Pilih Semua --</option>
            <option value="Dokter Umum" <?= $jenis_dokter == 'Dokter Umum' ? 'selected' : '' ?>>Dokter Umum</option>
            <option value="Dokter Gigi" <?= $jenis_dokter == 'Dokter Gigi' ? 'selected' : '' ?>>Dokter Gigi</option>
            <option value="Bidan" <?= $jenis_dokter == 'Bidan' ? 'selected' : '' ?>>Bidan</option>
          </select>
        </div>

        <!-- Tombol Cari -->
        <div class="col-md-1 mb-3">
          <button class="btn btn-outline-success" type="submit">Cari</button>
        </div>
      </div>
    </form>

    <div class="row">
      <!-- Looping data dokter dari database -->
      <?php if (count($dokter) > 0) : ?>
        <?php foreach($dokter as $row) : ?>
        <div class="col-lg-4 text-center">
          <!-- Gambar dokter, pastikan path gambar sesuai -->
          <img src="assets/Tampilan/<?= htmlspecialchars($row['foto']) ?>" class="bd-placeholder-img rounded-circle" width="140" height="140" alt="Foto <?= htmlspecialchars($row['nama_dokter']) ?>">
          
          <!-- Nama dokter -->
          <h2 class="fw-normal"><?= htmlspecialchars($row['nama_dokter']) ?></h2>
          
          <!-- Deskripsi dokter -->
          <p><?= htmlspecialchars($row['jenis_dokter']) ?></p>
          
          <!-- Tombol View dan Book Appointment -->
          <a href="view_dokter.php?id=<?= urlencode($row['id_dokter']) ?>" class="btn btn-sm btn-outline-secondary">View</a>
          <a href="index.php" class="btn btn-sm btn-outline-secondary">Book Appointment</a>
        </div><!-- /.col-lg-4 -->
        <?php endforeach; ?>
      <?php else : ?>
        <div class="col-12">
          <p>Dokter tidak ditemukan  "<strong><?= htmlspecialchars($search) ?></strong>" dan jenis dokter "<strong><?= htmlspecialchars($jenis_dokter) ?></strong>".</p>
        </div>
      <?php endif; ?>
    </div><!-- /.row -->
  </div><!-- /.container -->
</div><!-- /.album -->

<!-- Footer -->

<?php 
  include "footer.php"; 
?>

<!-- Bootstrap Bundle -->
<script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
