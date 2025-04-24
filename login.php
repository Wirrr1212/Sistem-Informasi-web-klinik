<?php 
	session_start();

	include 'koneksi.php';

	if(isset($_POST['login'])){
		// Menggunakan mysqli_real_escape_string untuk mencegah SQL Injection
		$user = mysqli_real_escape_string($conn, $_POST['user']);
		$pass = mysqli_real_escape_string($conn, $_POST['pass']);
	
		$cek = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username = '$user' AND password = '".MD5($pass)."'");
	
		if(mysqli_num_rows($cek) > 0){
			$a = mysqli_fetch_object($cek);
	
			$_SESSION['stat_login'] = true;
			$_SESSION['id_admin'] = $a->id_admin;
			$_SESSION['nama'] = $a->nm_admin;
			echo '<script>window.location="beranda.php"</script>';
		} else {
			echo '<script>alert("Gagal Login")</script>';
		}
	}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Klinik Pratama Bhakti Asih - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            height: 100vh;
        }
        .login-form {
            max-width: 400px;
            padding: 2rem;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .login-image {
            background: url('gambar.jpg') no-repeat center center;
            background-size: cover;
        }
        .custom-image {
            width: 100%;
            height: auto;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container-fluid login-container d-flex align-items-center justify-content-center">
        <div class="row w-75 shadow-lg">
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center">
                <img src="assets/Tampilan/ay.png" alt="Gambar Klinik" class="custom-image">
            </div>
            <div class="col-md-6 d-flex flex-column align-items-center justify-content-center p-4">
                <img src="assets/Tampilan/log.png" alt="Logo Klinik" class="mb-3" width="100">
                <h2 class="text-center mb-4">Klinik Pratama Bhakti Asih</h2>
                <div class="login-form w-100">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="user" class="form-label">Username</label>
                            <input type="text" name="user" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="pass" class="form-label">Password</label>
                            <input type="password" name="pass" class="form-control" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>