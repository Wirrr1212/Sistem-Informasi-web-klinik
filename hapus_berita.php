<?php

require 'functions.php';

// Periksa apakah ID berita tersedia di URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_berita = intval($_GET['id']);
    
    // Ambil data berita sebelum dihapus untuk mendapatkan nama file gambar
    $berita = view($id_berita);
    
    if (!empty($berita)) {
        $gambar = $berita[0]['gambar'];
        
        // Hapus data berita dari database
        if (hapus($id_berita) > 0) {
            // Hapus gambar terkait jika ada
            if (!empty($gambar) && file_exists("assets/Tampilan/" . $gambar)) {
                unlink("assets/Tampilan/" . $gambar);
            }
            echo "<script>
                    alert('Hapus berita berhasil');
                    document.location='data_berita.php';
                </script>";
        } else {
            echo "<script>
                    alert('Hapus berita gagal');
                    document.location='data_berita.php';
                </script>";
        }
    } else {
        echo "<script>
                alert('Data berita tidak ditemukan!');
                document.location='data_berita.php';
            </script>";
    }
} else {
    echo "<script>
            alert('ID tidak valid');
            document.location='data_berita.php';
        </script>";
}
?>
