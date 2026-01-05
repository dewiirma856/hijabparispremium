<?php
session_start();
// Koneksi ke database
include 'koneksi.php';

error_reporting(E_ALL); // Menampilkan semua jenis error (E_ALL)
ini_set('display_errors', 1); // Menampilkan error di layar
ini_set('log_errors', 1); // Menyimpan error ke log file
ini_set('error_log', __DIR__ . '/php-error.log'); // Lokasi file log error

// Jika tidak ada session pelanggan (belum login)
if (!isset($_SESSION['pelanggan']) || empty($_SESSION['pelanggan'])) {
    echo "<script>alert('Silahkan login');</script>";
    echo "<script>location='login.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Tangkap data dari form
  $nama = $_POST['nama'];
  $email = $_POST['email'];
  $komentar = $_POST['komentar'];
  $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0; // Tangkap nilai rating, default 0 jika tidak ada

  // Validasi input
  if (empty($nama) || empty($email) || empty($komentar) || $rating < 1 || $rating > 5) {
      echo "<script>alert('Semua field harus diisi dan rating harus antara 1-5!'); window.history.back();</script>";
      exit();
  }

  // Simpan komentar dan rating ke database
  $query = $koneksi->prepare("INSERT INTO komentar (nama, email, komentar, rating) VALUES (?, ?, ?, ?)");
  if ($query === false) {
      die('Prepare failed: ' . htmlspecialchars($koneksi->error));
  }

  $query->bind_param("sssi", $nama, $email, $komentar, $rating);

  if ($query->execute()) {
      echo "<script>alert('Komentar dan rating berhasil dikirim!'); window.location.href = 'index.php';</script>";
  } else {
      echo "<script>alert('Terjadi kesalahan. Silakan coba lagi.');</script>";
      echo "Error: " . $query->error; // Tampilkan pesan error
  }

  $query->close();
  $koneksi->close();
}



// if(!isset($_SESSION["keranjang"])){
//   // Diarahkan ke ke index.php
//   echo "<script>alert('Belum ada riwayat pembayaran!')</script>";
//   echo "<script>location='index.php';</script>";
// }

// echo "<pre>";
// print_r($_SESSION['pelanggan']);
// echo "</pre>";

?>





<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet"  href="css/login.css" media="all">
  <link rel="stylesheet" type="text/css" href="css/riwayat.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Belanja</title>
  <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<?php include 'templates/navbar.php'; ?>

<section class="content">
  <div class="container">
    <h2>Riwayat Belanja <?= $_SESSION['pelanggan']['nama_pelanggan']; ?></h2>

    <table>
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Status</th>
					<th>Total</th>
					<th>Opsi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				// Mendapatkan id_pelanggan yang login dari session
				$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];
				$ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pelanggan='$id_pelanggan'");
				if($ambil->num_rows == 0):
				?>
				<tr>
					<td colspan="5">Tidak ada data riwayat... </td>
				</tr>
				<?php endif; ?>
				<?php
				while($pecah = $ambil->fetch_assoc()):
				?>
				<tr>
					<th><?= $no++; ?></th>
					<td><?= date("d F Y", strtotime($pecah['tanggal_pembelian'])); ?></td>
					<td>
						<?= $pecah['status_pembelian']; ?><br>
						<?php if(!empty($pecah['resi_pengiriman'])): ?>
							Resi : <?= $pecah['resi_pengiriman']; ?>
						<?php endif; ?>
					</td>
					<td>Rp. <?= number_format($pecah['total_pembelian']); ?>,-</td>
					<td>
						<a href="nota.php?id=<?= $pecah['id_pembelian']; ?>" class="btn btn-info">Nota</a>
						
						<?php if($pecah['status_pembelian'] == 'pending'): ?>
							<a href="pembayaran.php?id=<?= $pecah['id_pembelian']; ?>" class="btn btn-success">Input Pembayaran</a>
							<?php else: ?>
								<a href="lihat-pembayaran.php?id=<?= $pecah['id_pembelian']; ?>" class="btn btn-warning">Lihat Pembayaran</a>
						<?php endif; ?>
						
					</td>
				</tr>
				<?php endwhile; ?>
			</tbody>
    </table>

  </div>
</section>
<!-- Form Komentar -->
 
<section class="komentar">
  <div class="container">
    <h2 class="text-center">Komentar Pelanggan</h2>
    <form action="" method="post">
      <div class="form-group">
        <label for="nama">Nama:</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= $_SESSION['pelanggan']['nama_pelanggan']; ?>" readonly>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $_SESSION['pelanggan']['email_pelanggan']; ?>" readonly>
      </div>
      <div class="form-group">
  <label for="rating">Rating:</label>
  <div class="rating">
    <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 stars">&#9733;</label>
    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 stars">&#9733;</label>
    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars">&#9733;</label>
    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 stars">&#9733;</label>
    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star">&#9733;</label>
  </div>
</div>
      <div class="form-group">
        <label for="komentar">Komentar:</label>
        <textarea class="form-control" id="komentar" name="komentar" rows="5" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Kirim Komentar</button>
    </form>
  </div>
</section>
<br />
<?php include 'templates/footer.php'; ?>
</body>
</html>