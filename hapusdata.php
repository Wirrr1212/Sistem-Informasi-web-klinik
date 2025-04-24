<?php

require 'functions.php';

// Ambil ID dari URL dan pastikan itu angka
$hapus = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($hapus > 0) {
    if (hapus($hapus) > 0) {
        echo "<script>
                alert('Hapus data berhasil');
                document.location='data_dokter.php';
            </script>";
    } else {
        echo "<script>
                alert('Hapus data gagal');
                document.location='data_dokter.php';
            </script>";
    }
} else {
    echo "<script>
            alert('ID tidak valid');
            document.location='data_dokter.php';
        </script>";
}
?>
