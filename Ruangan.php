<?php
include 'koneksi.php';

// Ambil data ruangan untuk dropdown
$query = "SELECT * FROM ruangan";
$result = $conn->query($query);

// Jika ada pilihan yang dipilih
$selected_room = isset($_GET['ruangan']) ? $_GET['ruangan'] : 'Pilih';

// Ambil data ruangan berdasarkan pilihan
$query_selected = "SELECT * FROM ruangan WHERE nama_ruangan = ?";
$stmt = $conn->prepare($query_selected);
$stmt->bind_param("s", $selected_room);
$stmt->execute();
$result_selected = $stmt->get_result();
$data = $result_selected->fetch_assoc();

// Cegah error jika data tidak ditemukan
$nama_ruangan = $data['nama_ruangan'] ?? 'Data tidak ditemukan';
$jumlah = $data['jumlah'] ?? 0;

include "header.php";
?>

<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center p-3 bg-dark text-white rounded mb-4">
        <span class="fs-5 fw-bold">Ruangan</span>

        <!-- Dropdown Bootstrap -->
        <div class="dropdown ms-3">
            <button class="btn btn-primary dropdown-toggle px-4" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown">
                <?= $selected_room ?: 'Pilih Ruangan'; ?>
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="?ruangan=">Pilih Ruangan</a></li>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <li>
                        <a class="dropdown-item" href="?ruangan=<?= urlencode($row['nama_ruangan']); ?>">
                            <?= htmlspecialchars($row['nama_ruangan']); ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 text-center">
            <div class="card text-white bg-dark">
                <div class="card-header">Ruangan</div>
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($nama_ruangan) ?></h5>
                    <p class="fs-1 fw-bold">
                        <?= htmlspecialchars($jumlah) ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Detail Ruangan</div>
                <div class="card-body">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Kamar</th>
                                <th scope="col">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= htmlspecialchars($nama_ruangan) ?></td>
                                <td><?= htmlspecialchars($jumlah) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!-- /.row -->
</div><!-- /.container -->

<!-- Footer -->
<?php include "footer.php"; ?>

</body>
</html>
