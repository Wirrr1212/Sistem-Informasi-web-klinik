<?php
include "koneksi.php";
$query = "SELECT id_berita, judul,isi, gambar, tanggal FROM data_berita ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Berita Terkini</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
    <header>
        <?php include "header.php"; ?>
    </header>
    <main>
        <div class="album py-5 bg-body-tertiary">
            <div class="container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="col">
                            <div class="card shadow-sm">
                                <img src="assets/Tampilan/<?php echo $row['gambar']; ?>" class="card-img-top" alt="<?php echo $row['judul']; ?>" height="225">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['judul']; ?></h5>
                                    <p class="card-text"><?php echo substr($row['isi'], 0, 100); ?>...</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                        <a href="berita.php?id=<?php echo $row['id_berita']; ?>" class="btn btn-sm btn-outline-secondary">Baca Selengkapnya</a>
                                        </div>
                                        <small class="text-body-secondary"><?php echo date("d M Y", strtotime($row['tanggal'])); ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>
    <?php 
  include "footer.php"; 
?>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>