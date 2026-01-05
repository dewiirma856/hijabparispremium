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
  <link rel="stylesheet"  href="css/style1.css" media="all">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bunut Shoes Family</title>
  <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body style="background-color:rgb(241, 234, 234);">

<?php include 'templates/navbar.php'; ?>

<div class="banner-produk">
    <img src="foto_produk/1.jpg" alt="Product Image">
  </div>

<script>
    // Fungsi untuk mengatur gambar latar belakang berdasarkan halaman
    function setBackground() {
        const nav1 = document.querySelector('.nav1');
        const page = window.location.pathname; // Mendapatkan path halaman saat ini

        // Mengatur gambar latar belakang berdasarkan halaman
        if (page.includes('product.php')) {
            nav1.style.backgroundImage = "url('foto_produk/men.jpg')"; // Ganti dengan jalur gambar produk
        } else if (page.includes('perempuan.php')) {
            nav1.style.backgroundImage = "url('foto_produk/women.jpg')"; // Ganti dengan jalur gambar perempuan
        } else if (page.includes('lainnya.php')) {
            nav1.style.backgroundImage = "url('foto_produk/lainnya.webp')"; // Ganti dengan jalur gambar lainnya
        } else {
            nav1.style.backgroundImage = "url('foto_produk/default-background.jpg')"; // Gambar default jika tidak ada yang cocok
        }
    }

    // Panggil fungsi saat halaman dimuat
    window.onload = setBackground;
</script>

<!-- konten   -->
<section class="content">
  <div class="container">
    <div class="row">
      <?php
      $ambil = $koneksi->query("SELECT * FROM produk WHERE id_kategori='2' ORDER BY id_produk DESC");
      while($perproduk = $ambil->fetch_assoc()):
      ?>
      <div class="col-md-3">
        <div class="thumbnail">
          <img src="foto_produk/<?= $perproduk['foto_produk']; ?>">
          <div class="caption">
            <h3><?= $perproduk['nama_produk']; ?></h3>
            <h5>Rp. <?= number_format($perproduk['harga_produk']); ?>,-</h5>
            <a href="detail.php?id=<?= $perproduk['id_produk']; ?>" class="btn btn-primary">Lihat Detail</a>
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