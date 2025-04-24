<?php 
	include 'koneksi.php';
	$kode = $_GET['kode'] ?? ''; // Ambil kode booking dari URL
?>

<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pendaftaran Berhasil - Klinik Pratama Bhakti Asih</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f0f0f0;
			margin: 0;
			padding: 0;
		}
		.box-formulir {
			width: 90%;
			max-width: 600px;
			margin: 60px auto;
			background: white;
			padding: 30px 40px;
			border-radius: 12px;
			box-shadow: 0 0 15px rgba(0,0,0,0.1);
			text-align: center;
		}
		h2 {
			color: #2c3e50;
			margin-bottom: 10px;
		}
		.notice {
			color: #555;
			margin-bottom: 30px;
			font-size: 16px;
		}
		.kode-booking {
			font-size: 22px;
			color: #d35400;
			font-weight: bold;
			margin: 10px 0;
		}
		.btn-cetak, .btn-kembali {
			display: inline-block;
			padding: 12px 25px;
			color: white;
			text-decoration: none;
			font-weight: bold;
			border-radius: 6px;
			margin-top: 15px;
			margin-right: 10px;
			transition: background 0.3s ease;
		}
		.btn-cetak {
			background: #28a745;
		}
		.btn-cetak:hover {
			background: #218838;
		}
		.btn-kembali {
			background: #007bff;
		}
		.btn-kembali:hover {
			background: #0069d9;
		}
	</style>
</head>
<body>

	<section class="box-formulir">
		<h2>Pendaftaran Berhasil!</h2>
		<p class="notice">Simpan kode booking Anda dan tunjukkan saat datang ke klinik.</p>
		
		<div>
			<p>Kode Booking Anda:</p>
			<div class="kode-booking"><?= htmlspecialchars($kode) ?></div>
			
			<a href="cetak.php?kode=<?= urlencode($kode) ?>" class="btn-cetak" target="_blank">Cetak Bukti Pendaftaran</a>
			<a href="index2.php" class="btn-kembali">Kembali ke Halaman Utama</a>
		</div>
	</section>

</body>
</html>
