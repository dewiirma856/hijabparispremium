<?php
//koneksi ke database
include 'koneksi.php';

// Jika tombol daftar ditekan
if(isset($_POST['daftar'])){
  // Mengambil isian nama, email, password, alamat, telepon
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $alamat = $_POST['alamat'];
  $telepon = $_POST['telepon'];

  // Cek apakah email sudah digunakan atau belum
  $ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email'");
  $yangcocok = $ambil->num_rows;
  if($yangcocok == 1){
    echo "<div class='alert alert-danger'>Pendaftaran gagal, email sudah digunakan!</div>";
		echo "<meta http-equiv='refresh' content='1;url=daftar.php'>";
  }
  else{
    // Insert ke tabel pelanggan
    $koneksi->query("INSERT INTO pelanggan(email_pelanggan, password_pelanggan, nama_pelanggan, telepon_pelanggan, alamat_pelanggan) VALUES('$email', '$password', '$nama', '$telepon', '$alamat')");
    echo "<div class='alert alert-success'>Pendaftaran sukses, Silahkan login</div>";
		echo "<meta http-equiv='refresh' content='1;url=login.php'>";
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Pelanggan</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <style>
    body {
      font-family: 'Lora', serif;
      background-color: #ffe6f0; /* pink pastel */
    }
    .panel {
      background-color: #ffffff;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      margin-top: 50px;
    }
    .panel-heading {
      margin-bottom: 25px;
      text-align: center;
    }
    .panel-title {
      font-family: 'Playfair Display', serif;
      font-size: 28px;
      font-weight: 700;
      color: #d63384; /* pink shade */
    }
    .form-control {
      border-radius: 10px;
      border: 1px solid #d63384;
      padding: 12px;
    }
    .btn-primary {
      background-color: #ff99cc;
      border: none;
      border-radius: 10px;
      padding: 10px 20px;
      font-weight: 600;
      transition: 0.3s;
    }
    .btn-primary:hover {
      background-color: #ff66b3;
    }
    label {
      font-weight: 600;
      color: #d63384;
    }
    textarea.form-control {
      resize: none;
    }
    .col-md-offset-2 {
      margin-left: 16.666667%;
    }
    @media (max-width: 767px) {
      .panel {
        margin-top: 20px;
        padding: 20px;
      }
    }
  </style>
</head>
<body>

<!-- navbar -->
<?php include 'templates/navbar.php'; ?>

<section class="content">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="panel">
          <div class="panel-heading">
            <h3 class="panel-title">Daftar Pelanggan</h3>
          </div>
          <div class="panel-body">
            <form action="" method="post">
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control" name="nama" required>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" required>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" cols="30" rows="4" class="form-control" required></textarea>
              </div>
              <div class="form-group">
                <label for="telepon">Telepon / HP</label>
                <input type="text" class="form-control" name="telepon" required>
              </div>
              <div class="form-group text-center">
                <button class="btn btn-primary" name="daftar">Daftar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
