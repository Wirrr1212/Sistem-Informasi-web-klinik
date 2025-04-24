<?php 
	session_start();
	include 'koneksi.php';

	// Cek apakah user sudah login atau belum
	if(!isset($_SESSION['stat_login']) || $_SESSION['stat_login'] != true){
		echo '<script>window.location="login.php"</script>';
		exit; // Menghentikan eksekusi skrip
	}
?>

<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

	<header>
		<?php

		include "headeradmin.php";
		?>
	</header>

	</nav>

	<!-- Konten Utama -->
	<section class="content mt-4">
		<div class="container">
			<h2>Selamat Datang</h2>
			<div class="box p-4 bg-light rounded shadow-sm">
				<h3><?php echo htmlspecialchars($_SESSION['nama']); ?>,di Klinik Pratama Bhakti Asih</h3>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<?php include "footer.php"; ?>

	<!-- Link Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
