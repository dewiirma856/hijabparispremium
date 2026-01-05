<?php
session_start();

// Koneksi ke database
include 'koneksi.php';

// Mendapatkan id_produk dari url
$id_produk = $_GET['id'];

// Query ambil data
$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
$detail = $ambil->fetch_assoc();

// Jika tombol beli di klik
if(isset($_POST['beli'])){
  // Mendapatkan jumlah yang diinputkan
  $jumlah = $_POST['jumlah'];

  // Validasi jumlah
  if ($jumlah > $detail['stok_produk']) {
    echo "<div class='alert alert-danger'>Maaf, stok tidak cukup.</div>";
  } else {
    // Masukkan ke keranjang belanja
    $_SESSION['keranjang'][$id_produk] = $jumlah;
    echo "<div class='alert alert-success'>Produk telah masuk ke keranjang</div>";
    echo "<meta http-equiv='refresh' content='1;url=keranjang.php'>";
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" type="text/css" href="css/style1.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Produk</title>
  <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
  <script>
    function validateForm() {
      var jumlah = document.forms["beliForm"]["jumlah"].value;
      if (jumlah == "") {
        alert("Silakan masukkan jumlah produk yang ingin dibeli.");
        return false;
      }
      return true;
    }
  </script>
</head>
<body>

<!-- navbar -->
<?php include 'templates/navbar.php'; ?>

<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <img src="foto_produk/<?= $detail['foto_produk']; ?>" class="img-responsive" alt="<?= $detail['nama_produk']; ?>">
      </div>
      <div class="col-md-6">
        <h2><?= $detail['nama_produk']; ?></h2>
        <h4>Rp. <?= number_format($detail['harga_produk']); ?>,-</h4>
        <h5>Stok : <?= $detail['stok_produk']; ?></h5>

        <?php if ($detail['stok_produk'] > 0): ?>
          <form action="" method="post" name="beliForm" onsubmit="return validateForm()">
            <div class="form-group">
              <div class="input-group">
                <input type="number" min="1" max="<?= $detail['stok_produk']; ?>" class="form-control" name="jumlah" placeholder="Jumlah" required>
                <div class="input-group-btn">
                  <button class="btn btn-primary" name="beli" type="submit">Beli</button>
                </div>
              </div>
            </div>
          </form>
        <?php else: ?>
          <div class="alert alert-danger">Maaf, stok kami sedang habis.</div>
        <?php endif; ?>

        <p><?= $detail['deskripsi_produk']; ?></p>
      </div>
    </div>
  </div>
</section>

<br />
<?php include 'templates/footer.php'; ?>
</body>
</html>