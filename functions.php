<?php
// Koneksi database
$koneksi = mysqli_connect("127.0.0.1:3307", "root", "", "db_psb");

function query($query){
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function view($id_dokter){
    global $koneksi;
    // Query untuk mengambil data dokter berdasarkan id_dokter
    $query = "SELECT * FROM data_dokter WHERE id_dokter = '$id_dokter'";
    return query($query);
}

function hapus($id_dokter){
    global $koneksi;
    
    // Ambil nama foto yang terkait dengan dokter yang akan dihapus
    $dokter = query("SELECT foto FROM data_dokter WHERE id_dokter = '$id_dokter'")[0];
    $fotoLama = $dokter['foto'];

    // Hapus foto dari folder jika ada
    if ($fotoLama && file_exists("assets/Tampilan/$fotoLama")) {
        unlink("assets/Tampilan/$fotoLama");
    }
    
    // Hapus data dokter dari database
    $query = "DELETE FROM data_dokter WHERE id_dokter = '$id_dokter'";
    mysqli_query($koneksi, $query);
    
    return mysqli_affected_rows($koneksi);
}

function ubah($data, $foto) {
    global $koneksi;

    $id_dokter = htmlspecialchars($data["id_dokter"]);
    $nama_dokter = htmlspecialchars($data["nama_dokter"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]);
    $no_telp = htmlspecialchars($data["no_telp"]);
    $jenis_dokter = htmlspecialchars($data["jenis_dokter"]);
    $hari_praktik = htmlspecialchars($data["hari_praktik"]);
    $jam_praktik = htmlspecialchars($data["jam_praktik"]);
    $kuota = htmlspecialchars($data["kuota"]);

    // Cek apakah foto baru diunggah
    if ($_FILES['foto']['name'] != '') {
        // Jika ada foto baru, maka update dengan foto baru
        $query = "UPDATE data_dokter SET 
                    foto = '$foto',
                    nama_dokter = '$nama_dokter',
                    alamat = '$alamat',
                    jenis_kelamin = '$jenis_kelamin',
                    no_telp = '$no_telp',
                    jenis_dokter = '$jenis_dokter',
                    hari_praktik = '$hari_praktik',
                    jam_praktik = '$jam_praktik',
                    kuota = '$kuota'
                  WHERE id_dokter = '$id_dokter'";
    } else {
        // Jika tidak ada foto baru, gunakan foto lama yang sudah ada di database
        $query = "UPDATE data_dokter SET 
                    nama_dokter = '$nama_dokter',
                    alamat = '$alamat',
                    jenis_kelamin = '$jenis_kelamin',
                    no_telp = '$no_telp',
                    jenis_dokter = '$jenis_dokter',
                    hari_praktik = '$hari_praktik',
                    jam_praktik = '$jam_praktik',
                    kuota = '$kuota'
                  WHERE id_dokter = '$id_dokter'";
    }

    // Eksekusi query
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}


function cari($keyword){
    $query = "SELECT * FROM data_dokter 
                WHERE
                id_dokter LIKE '%$keyword%' OR
                nama_dokter LIKE '%$keyword%' OR
                jenis_kelamin LIKE '%$keyword%' OR
                no_telp LIKE '%$keyword%' OR
                jenis_dokter LIKE '%$keyword%' OR
                hari_praktik LIKE '%$keyword%' OR
                kuota LIKE '%$keyword%'";
    return query($query);
}

function tambah($data){
    global $koneksi;

    $nama_dokter = htmlspecialchars($data["nama_dokter"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $jenis_kelamin = htmlspecialchars($data["jenis_kelamin"]);
    $no_telp = htmlspecialchars($data["no_telp"]);
    $jenis_dokter = htmlspecialchars($data["jenis_dokter"]);
    $hari_praktik = htmlspecialchars($data["hari_praktik"]);
    $jam_praktik = htmlspecialchars($data["jam_praktik"]);
    $kuota = htmlspecialchars($data["kuota"]); // Tambahkan kuota

    // Tangkap data file foto
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // Cek apakah ada file yang diunggah
    if ($error !== 0) {
        echo "<script>alert('Terjadi kesalahan saat mengunggah file!');</script>";
        return false;
    }

    // Cek apakah file yang diunggah adalah gambar (jpg, png, jpeg)
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Yang Anda unggah bukan gambar!');</script>";
        return false;
    }

    // Cek ukuran file (maksimal 2MB)
    if ($ukuranFile > 2000000) {
        echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.');</script>";
        return false;
    }

    // Beri nama baru untuk file gambar agar unik (gunakan uniqid)
    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

    // Tentukan folder tujuan untuk menyimpan file gambar
    $targetDir = 'assets/Tampilan/';

    // Pastikan folder 'assets/Tampilan' ada, jika tidak buat
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Pindahkan file gambar ke folder yang ditentukan
    move_uploaded_file($tmpName, $targetDir . $namaFileBaru);

    // Query untuk menyimpan data ke database, termasuk nama file foto dan kuota
    $query = "INSERT INTO data_dokter (foto, nama_dokter, alamat, jenis_kelamin, no_telp, jenis_dokter, hari_praktik, jam_praktik, kuota) 
                VALUES ('$namaFileBaru', '$nama_dokter', '$alamat', '$jenis_kelamin', '$no_telp', '$jenis_dokter', '$hari_praktik', '$jam_praktik', '$kuota')";

    // Eksekusi query dan periksa apakah berhasil
    if (mysqli_query($koneksi, $query)) {
        return mysqli_affected_rows($koneksi);
    } else {
        echo "<script>alert('Terjadi kesalahan saat menyimpan data!');</script>";
        return false;
    }
}

// Proses saat tombol Simpan ditekan
if (isset($_POST['btnsimpan'])) {
    // Tangkap data dari form
    $data = [
        'id_dokter' => $_POST["id_dokter"],
        'nama_dokter' => $_POST["nama_dokter"],
        'alamat' => $_POST["alamat"],
        'jenis_kelamin' => $_POST["jenis_kelamin"],
        'no_telp' => $_POST["no_telp"],
        'jenis_dokter' => $_POST["jenis_dokter"],
        'hari_praktik' => $_POST["hari_praktik"],
        'jam_praktik' => $_POST["jam_praktik"],
        'kuota' => $_POST["kuota"], // Tambahkan kuota ke array data
    ];

    // Pastikan foto sudah diproses jika ada perubahan
    if ($_FILES['foto']['name'] !== '') {
        $foto = uniqid() . '.' . strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    } else {
        $foto = $_POST["foto_lama"];  // Gunakan foto lama jika tidak ada perubahan foto
    }

    if (tambah($data) > 0) {
        echo "<script>
                alert('Simpan data berhasil');
                document.location='data_dokter.php';
              </script>";
    } else {
        echo "<script>
                alert('Simpan data gagal');
                document.location='data_dokter.php';
              </script>";
    }
}


function getAllDoctors() {
    global $koneksi; // Menggunakan variabel koneksi yang benar
    $query = "SELECT * FROM data_dokter"; // Menggunakan nama tabel yang benar
    $result = mysqli_query($koneksi, $query);
    $doctors = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $doctors[] = $row;
    }
    return $doctors;
}

?>

<?php
require 'koneksi.php';

function tambah_berita($data, $file) {
    global $conn;

    // Tangkap data dari form dengan sanitasi
    $judul = mysqli_real_escape_string($conn, htmlspecialchars($data['judul']));
    $isi = mysqli_real_escape_string($conn, htmlspecialchars($data['isi']));
    $tanggal_publikasi = date('Y-m-d');

    // Cek apakah ada file gambar yang diunggah
    if ($file['error'] === 4) {
        echo "<script>alert('Pilih file gambar terlebih dahulu!');</script>";
        return false;
    }

    // Validasi format gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('File harus berupa gambar JPG, JPEG, atau PNG!');</script>";
        return false;
    }

    // Cek ukuran file (maksimal 2MB)
    if ($file['size'] > 2000000) {
        echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.');</script>";
        return false;
    }

    // Buat nama unik untuk file gambar
    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;
    $targetDir = 'assets/Tampilan/';

    // Pastikan folder tujuan ada
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Pindahkan file ke folder tujuan
    if (!move_uploaded_file($file['tmp_name'], $targetDir . $namaFileBaru)) {
        echo "<script>alert('Gagal mengunggah gambar!');</script>";
        return false;
    }

    // Simpan data ke database
    $query = "INSERT INTO data_berita (gambar, judul, isi, tanggal_publikasi) 
              VALUES ('$namaFileBaru', '$judul', '$isi', '$tanggal_publikasi')";

    return mysqli_query($conn, $query) ? true : false;
}

function edit_berita($data, $file) {
    global $conn;

    // Tangkap data dari form dengan sanitasi
    $id_berita = intval($data['id_berita']);
    $judul = mysqli_real_escape_string($conn, htmlspecialchars($data['judul']));
    $isi = mysqli_real_escape_string($conn, htmlspecialchars($data['isi']));
    $tanggal_publikasi = mysqli_real_escape_string($conn, $data['tanggal']);
    $gambar_lama = mysqli_real_escape_string($conn, $data['gambar_lama']);

    $namaFileBaru = $gambar_lama; // Default gunakan gambar lama

    // Cek apakah ada file gambar baru yang diunggah
    if (isset($file['name']) && !empty($file['name'])) {
        $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ekstensiGambar = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
            echo "<script>alert('File harus berupa gambar JPG, JPEG, atau PNG!');</script>";
            return false;
        }

        if ($file['size'] > 2000000) {
            echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.');</script>";
            return false;
        }

        // Hapus gambar lama jika ada
        if (!empty($gambar_lama) && file_exists('assets/Tampilan/' . $gambar_lama)) {
            unlink('assets/Tampilan/' . $gambar_lama);
        }

        // Upload gambar baru
        $namaFileBaru = uniqid() . '.' . $ekstensiGambar;
        move_uploaded_file($file['tmp_name'], 'assets/Tampilan/' . $namaFileBaru);
    }

    // Update data di database
    $query = "UPDATE data_berita SET 
                judul = '$judul', 
                isi = '$isi', 
                tanggal_publikasi = '$tanggal_publikasi', 
                gambar = '$namaFileBaru'
              WHERE id_berita = $id_berita";

    return mysqli_query($conn, $query) ? true : false;
}

function hapus_berita($id_berita) {
    global $conn;

    $id_berita = intval($id_berita);

    // Ambil data berita berdasarkan ID
    $query = "SELECT gambar FROM data_berita WHERE id_berita = $id_berita";
    $result = mysqli_query($conn, $query);
    $berita = mysqli_fetch_assoc($result);

    // Hapus gambar dari folder jika ada
    if ($berita && !empty($berita['gambar']) && file_exists('assets/Tampilan/' . $berita['gambar'])) {
        unlink('assets/Tampilan/' . $berita['gambar']);
    }

    // Hapus data berita dari database
    $query = "DELETE FROM data_berita WHERE id_berita = $id_berita";
    return mysqli_query($conn, $query) ? true : false;
}
?>
