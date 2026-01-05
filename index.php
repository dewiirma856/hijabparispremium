<?php
session_start();
// Koneksi ke database
include 'koneksi.php';

?>

<!DOCTYPE html>
<html lang="id">

<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/style1.css">
  <link rel="stylesheet" type="text/css" href="css/login.css">
  <link rel="stylesheet" type="text/css" href="css/komentar.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hijab Paris Premium</title>
  <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>

<body style="background-color: rgb(241, 234, 234);">

  <?php include 'templates/navbar.php'; ?>

  <!-- Foto Atas -->
  <div class="top-photo">
    <img src="foto_produk/hijab2.jpeg" alt="Foto Atas" class="img-fluid">
    <a href="product.php" class="btn btn-transparent">Lihat Produk</a>
  </div>

  <!-- Toko -->
  
  <!-- Konten HTML di sini -->
  <!-- Section Hijab Paris Premium -->
<div class="container-hijab">
  <div class="row align-items-center">
  <div class="container my-5">
  <div class="row text-center">

    <!-- Foto 1 -->
    <div class="col-md-4 mb-4">
      <img src="foto_produk/1.jpeg" alt="Hijab Paris Premium" class="img-fluid rounded-circle shadow" style="max-width: 200px;">
    </div>

    <!-- Foto 2 -->
    <div class="col-md-4 mb-4">
      <img src="foto_produk/paris3.jpeg" alt="Hijab Paris Elegan" class="img-fluid rounded-circle shadow" style="max-width: 200px;">
    </div>

    <!-- Foto 3 -->
    <div class="col-md-4 mb-4">
      <img src="foto_produk/paris4.jpeg" alt="Hijab Paris Cantik" class="img-fluid rounded-circle shadow" style="max-width: 200px;">
    </div>
    
  </div>

  <!-- Video -->
  <div class="row justify-content-center mt-4">
    <div class="col-md-8 text-center">
      <div class="embed-responsive embed-responsive-16by9 shadow rounded">
        <video controls class="embed-responsive-item">
          <source src="foto_produk/vidio.mp4" type="video/mp4">
          Browser Anda tidak mendukung video tag.
        </video>
      </div>
    </div>
  </div>
</div>


    <!-- Deskripsi Kanan -->
    <div class="col-md-8">
      <h2 class="judul-produk">Hijab Paris Premium</h2>
      <p class="deskripsi-produk">
        Hijab Paris Premium merupakan hijab yang terbuat dari bahan berkualitas tinggi.
        Memiliki tekstur halus, tidak mudah kusut, mudah dibentuk, nyaman, dan tidak membuat gerah.
        Cocok untuk acara formal maupun nonformal dengan harga yang tetap terjangkau.
      </p>

      <div class="spesifikasi">
        <h4>Spesifikasi</h4>
        <ul>
          <li>Bahan: Perpaduan Cotton Paris & Voal</li>
          <li>Ukuran: 110cm x 110cm</li>
          <li>Hijab Trendy dan Kekinian</li>
        </ul>
      </div>

      <div class="order-btn text-center mt-3">
        <a href="product.php" class="btn-order">ORDER SEKARANG!!</a>
      </div>
    </div>
  </div>
</div>


  <!-- Kode JavaScript di sini -->
  <script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;

    function showSlide(index) {
      // Sembunyikan semua slide
      slides.forEach((slide) => {
        slide.classList.remove('active');
      });

      // Tampilkan slide yang aktif
      slides[index].classList.add('active');
    }

    function nextSlide() {
      currentSlide = (currentSlide + 1) % totalSlides; // Pindah ke slide berikutnya
      showSlide(currentSlide);
    }

    // Atur interval untuk mengganti slide setiap 3 detik
    setInterval(nextSlide, 3000);

    // Tampilkan slide pertama saat halaman dimuat
    showSlide(currentSlide);
  </script>

 <!-- Konten Produk -->
<section class="content" id="konten">
  <div class="container">
    <h1 class="text-center produk-title">🌷 Warna Produk Terbaru 🌷</h1>
    <div class="horizontal-scroll">
      <?php
      $ambil = $koneksi->query("SELECT * FROM produk");
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


  
 <!-- Tampilkan komentar -->
<section class="komentar" style="background-color: #fff5f7; padding: 60px 0;">
  <div class="container">
    <h2 class="text-center mb-4" style="font-family: 'Playfair Display', serif; color: #b6466c; font-weight: 700;">
      Komentar Pelanggan
    </h2>

    <?php
    $query = $koneksi->query("SELECT tanggal, nama, rating, komentar FROM komentar ORDER BY id_komentar DESC");

    if ($query->num_rows > 0) {
      echo "<div class='table-responsive'>";
      echo "<table class='table table-bordered komentar-table'>";
      echo "<thead>
              <tr>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Rating</th>
                <th>Komentar</th>
              </tr>
            </thead>";
      echo "<tbody>";

      while ($row = $query->fetch_assoc()) {
        echo "<tr>";
        echo "<td class='tanggal'>" . date('d F Y H:i', strtotime($row['tanggal'])) . "</td>";
        echo "<td>" . htmlspecialchars($row['nama']) . "</td>";

        echo "<td class='rating'>";
        for ($i = 1; $i <= $row['rating']; $i++) {
            echo '<span class=\"bintang\">&#9733;</span>';
        }
        for ($i = $row['rating'] + 1; $i <= 5; $i++) {
            echo '<span class=\"bintang-kosong\">&#9734;</span>';
        }
        echo "</td>";

        echo "<td class='komentar'>" . htmlspecialchars($row['komentar']) . "</td>";
        echo "</tr>";
      }

      echo "</tbody>";
      echo "</table>";
      echo "</div>";
    } else {
      echo "<p class='text-center' style='color:#b6466c;'>Belum ada komentar.</p>";
    }
    ?>

    <!-- Pesan bawah tabel -->
    <div class="text-center mt-5" style="color: #6b3f55; font-family: 'Lora', serif;">
      <h5 style="font-weight: 700;">💬 Terima kasih atas dukungan Anda!</h5>
      <p style="font-size: 15px;">
        Setiap komentar membantu kami untuk terus menghadirkan <strong>Hijab Paris Premium</strong> yang anggun dan nyaman dipakai.
      </p>
      
    </div>
  </div>
</section>
  <?php include 'templates/footer.php'; ?>

  <script type="text/javascript">
    window.$crisp = [];
    window.CRISP_WEBSITE_ID = "8368d913-c072-48a4-ae8a-be3961b1ced1";
    (function() {
      d = document;
      s = d.createElement("script");
      s.src = "https://client.crisp.chat/l.js";
      s.async = 1;
      d.getElementsByTagName("head")[0].appendChild(s);
    })();
  </script>

</body>

</html>