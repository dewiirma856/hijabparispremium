<?php
session_start();
//koneksi ke database
include 'koneksi.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style1.css" media="all">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>

<body style="background-color:rgb(241, 234, 234);">

  <?php include 'templates/navbar.php'; ?>
  <body>
  <div class="banner-produk">
    <img src="foto_produk/paris.jpeg" alt="Product Image">
  </div>
  <!-- konten   -->
  <section class="content">
    <div class="container">
    <h1 class="text-center produk-title">🌷 Warna Produk Terbaru 🌷</h1>
      <div class="row">
        <?php
        $ambil = $koneksi->query("SELECT * FROM produk WHERE id_kategori='1' ORDER BY id_produk DESC");
        while ($perproduk = $ambil->fetch_assoc()):
        ?>
          <div class="col-md-3 produk-card">
          <div class="thumbnail">
            <img src="foto_produk/<?= $perproduk['foto_produk']; ?>" alt="<?= $perproduk['nama_produk']; ?>">
            <div class="caption">
              <h3><?= $perproduk['nama_produk']; ?></h3>
              <h5>Rp. <?= number_format($perproduk['harga_produk']); ?>,-</h5>
              <a href="detail.php?id=<?= $perproduk['id_produk']; ?>" class="btn lihat-detail-btn">Lihat Detail</a>
            </div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </section>

  <br />
  <?php include 'templates/footer.php'; ?>
</body>

</html>