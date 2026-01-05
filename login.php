<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email' AND password_pelanggan='$password'");
  $akunyangcocok = $ambil->num_rows;

  if ($akunyangcocok == 1) {
    $akun = $ambil->fetch_assoc();
    $_SESSION["pelanggan"] = $akun;
    echo "<div class='alert alert-success text-center mt-3'>Login berhasil! Selamat datang, " . $akun['nama_pelanggan'] . ".</div>";

    if (isset($_SESSION['keranjang']) || !empty($_SESSION['keranjang'])) {
      echo "<meta http-equiv='refresh' content='1;url=checkout.php'>";
    } else {
      echo "<meta http-equiv='refresh' content='1;url=riwayat.php'>";
    }
  } else {
    echo "<div class='alert alert-danger text-center mt-3'>Email atau password salah!</div>";
    echo "<meta http-equiv='refresh' content='1;url=login.php'>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Pelanggan</title>
  
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <!-- Font & Custom CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/login.css">
</head>
<body>

  <?php include 'templates/navbar.php'; ?>

  <div class="login-container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="max-width: 420px; width: 100%; border-radius: 15px;">
      <div class="card-body">
        <h3 class="text-center mb-4" style="font-family: 'Playfair Display', serif;">Login Pelanggan</h3>

        <form method="post">
          <div class="form-group">
            <label for="email">Email</label>
            <input 
              type="email" 
              name="email" 
              id="email" 
              class="form-control" 
              placeholder="Masukkan email kamu" 
              required>
          </div>

          <div class="form-group mt-3">
            <label for="password">Password</label>
            <input 
              type="password" 
              name="password" 
              id="password" 
              class="form-control" 
              placeholder="Masukkan password" 
              required>
          </div>

          <button type="submit" name="login" class="btn btn-primary btn-block mt-4">
    Login
</button>

        </form>

        <p class="text-center mt-3 mb-0">
          Belum punya akun? 
          <a href="daftar.php" class="text-decoration-none text-pink">Daftar di sini</a>
        </p>
      </div>
    </div>
  </div>

</body>
</html>