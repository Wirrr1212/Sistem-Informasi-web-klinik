<?php 
session_start();
include "koneksi.php"; // Pastikan koneksi database ada

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Cek apakah ID valid
if ($id <= 0) {
    echo "Berita tidak ditemukan!";
    exit;
}

// Ambil data berita dari database
$query = "SELECT * FROM data_berita WHERE id_berita = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Berita tidak ditemukan!";
    exit;
}

$row = mysqli_fetch_assoc($result);

// Ambil 3 berita terbaru untuk Recent Posts
$query_recent = "SELECT id_berita, judul, gambar, tanggal FROM data_berita ORDER BY tanggal DESC LIMIT 3";
$result_recent = mysqli_query($conn, $query_recent);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $row['judul']; ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>

<?php include "header.php"; ?>

<main class="container">
    <div class="row g-5">
        <!-- Bagian Konten Berita -->
        <div class="col-md-8">
            <img src="assets/Tampilan/<?php echo $row['gambar']; ?>" class="img-fluid w-100 rounded mt-5 mb-4" alt="<?php echo $row['judul']; ?>">
            <article class="blog-post">
                <h2 class="blog-post-title"><?php echo $row['judul']; ?></h2>
                <p class="blog-post-meta"><?php echo date("d M, Y", strtotime($row['tanggal'])); ?></p>
                <p><?php echo nl2br($row['isi']); ?></p>
            </article>
            <a href="Artikel.php" class="btn btn-primary">Kembali</a>
        </div>

        <!-- Bagian Sidebar -->
        <div class="col-md-4">
            <br>
            <div class="position-sticky" style="top: 2rem;">
                <!-- Kotak Background -->
                <div class="p-4 mb-3 bg-body-tertiary rounded">
                    <h4 class="fst-italic">Tentang Berita</h4>
                    <p class="mb-0">Temukan berita terbaru dan informasi menarik di sini!</p>
                </div>

                <!-- Recent Posts -->
                <div>
                    <h4 class="fst-italic">Recent Posts</h4>
                    <ul class="list-unstyled">
                        <?php while ($recent = mysqli_fetch_assoc($result_recent)) { ?>
                        <li>
                            <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="berita.php?id=<?php echo $recent['id_berita']; ?>">
                                <img src="assets/Tampilan/<?php echo $recent['gambar']; ?>" width="50%" height="96" class="rounded">
                                <div class="col-lg-8">
                                    <h6 class="mb-0"><?php echo $recent['judul']; ?></h6>
                                    <small class="text-body-secondary"><?php echo date("d M, Y", strtotime($recent['tanggal'])); ?></small>
                                </div>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>

                <!-- Archives -->
                <div class="p-4">
                    <h4 class="fst-italic">Archives</h4>
                    <ol class="list-unstyled mb-0">
                        <li><a href="#">March 2024</a></li>
                        <li><a href="#">February 2024</a></li>
                        <li><a href="#">January 2024</a></li>
                    </ol>
                </div>

                <!-- Elsewhere -->
                <div class="p-4">
                    <h4 class="fst-italic">Elsewhere</h4>
                    <ol class="list-unstyled">
                        <li><a href="#">GitHub</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Facebook</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "footer.php"; ?>

<script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
