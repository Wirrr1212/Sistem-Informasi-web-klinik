<?php 
    session_start(); // Pastikan session dimulai di awal file
    include 'koneksi.php';

    // Cek apakah user sudah login atau belum
    if(!isset($_SESSION['stat_login']) || $_SESSION['stat_login'] != true){
        echo '<script>window.location="login.php"</script>';
        exit; // Menghentikan eksekusi skrip
    }

    // Periksa apakah parameter 'id' ada di URL
    if(isset($_GET['id'])){
        $id_pendaftaran = mysqli_real_escape_string($conn, $_GET['id']); // Mengamankan input dari SQL Injection
        
        // Query untuk menghapus data dari database
        $query = "DELETE FROM tb_pendaftaran1 WHERE id_pendaftaran = '$id_pendaftaran'";
        if(mysqli_query($conn, $query)){
            echo '<script>alert("Data berhasil dihapus!");</script>';
        } else {
            echo '<script>alert("Gagal menghapus data!");</script>';
        }

        // Redirect ke halaman data peserta
        echo '<script>window.location="data-peserta.php";</script>';
        exit; // Hentikan eksekusi skrip
    } else {
        echo '<script>alert("ID tidak ditemukan!");</script>';
        echo '<script>window.location="data-peserta.php";</script>';
        exit; // Menghentikan eksekusi skrip
    }
?>
