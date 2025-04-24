<?php 
  session_start();

	include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laporan Pendaftaran Pasien</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script>
		window.print();
	</script>
</head>
<body>

	<h2>Laporan Pendaftaran Pasien</h2>
	<table class="table" border="1" cellspacing="0" cellpadding="10">
		<thead>
			<tr>
				<th>No</th>
				<th>ID Pendaftaran</th>
				<th>Tanggal Kunjungan</th>
				<th>Nama Pasien</th>
				<th>Nama Dokter</th>
				<th>Jenis Penjamin</th>
				<th>Nomor BPJS</th>
				<th>Nomor KTP</th>
				<th>Tanggal Lahir</th>
				<th>Email</th>
				<th>Jenis Kelamin</th>
				<th>Nomor Telepon</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$no = 1;
				$list_peserta = mysqli_query($conn, "SELECT p.*, d.nama_dokter FROM tb_pendaftaran1 p LEFT JOIN data_dokter d ON p.id_dokter = d.id_dokter");
				while($row = mysqli_fetch_array($list_peserta)) { 
			?>
			<tr>
				<td><?php echo $no++ ?></td>
				<td><?php echo htmlspecialchars($row['id_pendaftaran']) ?></td>
				<td><?php echo htmlspecialchars($row['tgl_kunjungan']) ?></td>
				<td><?php echo htmlspecialchars($row['nm']) ?></td>
				<td><?php echo htmlspecialchars($row['nama_dokter']) ?></td>
				<td><?php echo htmlspecialchars($row['jenis_penjamin']) ?></td>
				<td>
					<?php 
						// Tampilkan Nomor BPJS hanya jika jenis penjamin adalah BPJS
						echo ($row['jenis_penjamin'] == 'BPJS') ? htmlspecialchars($row['no_bpjs']) : '-'; 
					?>
				</td>
				<td><?php echo htmlspecialchars($row['no_ktp']) ?></td>
				<td><?php echo htmlspecialchars($row['tgl_lahir']) ?></td>
				<td><?php echo htmlspecialchars($row['email']) ?></td>
				<td><?php echo htmlspecialchars($row['jk']) ?></td>
				<td><?php echo htmlspecialchars($row['no_telp']) ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>

</body>
</html>
