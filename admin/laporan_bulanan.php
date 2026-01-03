<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}
include "../config/koneksi.php";

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

/* DATA STATISTIK */
$qKamar = mysqli_query($conn,"SELECT nomor_kamar FROM data_kos WHERE status='Kosong'");
$kamar_kosong = mysqli_num_rows($qKamar);

$qPenyewa = mysqli_query($conn,"SELECT nama FROM data_penyewa");
$penyewa_aktif = mysqli_num_rows($qPenyewa);

$qBelum = mysqli_query($conn,"
SELECT DISTINCT s.nama
FROM pembayarann p
JOIN data_penyewa s ON p.penyewa_id=s.id
WHERE p.status='Belum Dibayar'
AND MONTH(p.tanggal)='$bulan'
AND YEAR(p.tanggal)='$tahun'
");
$belum_bayar = mysqli_num_rows($qBelum);

$qTotal = mysqli_query($conn,"
SELECT SUM(jumlah) AS total
FROM pembayarann
WHERE status='Lunas'
AND MONTH(tanggal)='$bulan'
AND YEAR(tanggal)='$tahun'
");
$penghasilan = mysqli_fetch_assoc($qTotal)['total'] ?? 0;

/* LIST DATA */
$qListKamar = mysqli_query($conn,"SELECT nomor_kamar FROM data_kos WHERE status='Kosong'");
$qListPenyewa = mysqli_query($conn,"SELECT nama FROM data_penyewa");
$qListBelum = mysqli_query($conn,"
SELECT DISTINCT s.nama
FROM pembayarann p
JOIN data_penyewa s ON p.penyewa_id=s.id
WHERE p.status='Belum Dibayar'
AND MONTH(p.tanggal)='$bulan'
AND YEAR(p.tanggal)='$tahun'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Bulanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    min-height:100vh;
    background: linear-gradient(135deg,#667eea,#764ba2);
    font-family: 'Segoe UI', sans-serif;
}
.stat{
    border-radius:18px;
    padding:20px;
    color:#fff;
}
.s1{background:linear-gradient(135deg,#11998e,#38ef7d)}
.s2{background:linear-gradient(135deg,#396afc,#2948ff)}
.s3{background:linear-gradient(135deg,#ff512f,#dd2476)}
.s4{background:linear-gradient(135deg,#f7971e,#ffd200)}
.glass{
    background:#fff;
    border-radius:18px;
}
</style>
</head>

<body>
<div class="container py-5">

<h3 class="text-white fw-bold mb-4">
📊 Laporan Bulanan <?= date('F Y', mktime(0,0,0,$bulan,1,$tahun)) ?>
</h3>

<!-- FILTER -->
<form method="GET" class="row g-2 mb-4">
<div class="col-md-3">
<select name="bulan" class="form-select">
<?php for($i=1;$i<=12;$i++):
$b=str_pad($i,2,'0',STR_PAD_LEFT); ?>
<option value="<?= $b ?>" <?= $bulan==$b?'selected':'' ?>>
<?= date('F',mktime(0,0,0,$i,1)) ?>
</option>
<?php endfor; ?>
</select>
</div>

<div class="col-md-3">
<select name="tahun" class="form-select">
<?php for($t=date('Y');$t>=2020;$t--): ?>
<option <?= $tahun==$t?'selected':'' ?>><?= $t ?></option>
<?php endfor; ?>
</select>
</div>

<div class="col-md-2 d-grid">
<button class="btn btn-dark">Tampilkan</button>
</div>

<div class="col-md-2 d-grid">
<a href="laporan_excel.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="btn btn-success">
⬇ Export excel
</a>
</div>
</form>

<!-- STAT -->
<div class="row g-4 mb-4">
<div class="col-md-3"><div class="stat s1 text-center shadow"><h6>Kamar Kosong</h6><h2><?= $kamar_kosong ?></h2></div></div>
<div class="col-md-3"><div class="stat s2 text-center shadow"><h6>Penyewa Aktif</h6><h2><?= $penyewa_aktif ?></h2></div></div>
<div class="col-md-3"><div class="stat s3 text-center shadow"><h6>Belum Bayar</h6><h2><?= $belum_bayar ?></h2></div></div>
<div class="col-md-3"><div class="stat s4 text-center shadow"><h6>Penghasilan</h6><h4>Rp <?= number_format($penghasilan) ?></h4></div></div>
</div>

<!-- DETAIL LAPORAN -->
<div class="glass shadow p-4">
<h5 class="fw-bold mb-3">📋 Detail Laporan</h5>

<div class="table-responsive">
<table class="table table-bordered align-middle">
<thead class="table-dark text-center">
<tr>
<th>No</th>
<th>Kamar Kosong</th>
<th>Penyewa Aktif</th>
<th>Belum Bayar</th>
<th>Penghasilan</th>
</tr>
</thead>

<tbody>
<tr>
<td class="text-center">1</td>

<td>
<?php if(mysqli_num_rows($qListKamar)>0): ?>
<ul>
<?php while($k=mysqli_fetch_assoc($qListKamar)): ?>
<li>Kamar <?= $k['nomor_kamar'] ?></li>
<?php endwhile; ?>
</ul>
<?php else: ?>Tidak ada<?php endif; ?>
</td>

<td>
<ul>
<?php while($p=mysqli_fetch_assoc($qListPenyewa)): ?>
<li><?= $p['nama'] ?></li>
<?php endwhile; ?>
</ul>
</td>

<td>
<?php if(mysqli_num_rows($qListBelum)>0): ?>
<ul class="text-danger">
<?php while($b=mysqli_fetch_assoc($qListBelum)): ?>
<li><?= $b['nama'] ?></li>
<?php endwhile; ?>
</ul>
<?php else: ?>Semua Lunas<?php endif; ?>
</td>

<td class="fw-bold text-success text-center">
Rp <?= number_format($penghasilan) ?>
</td>
</tr>
</tbody>
</table>
</div>
</div>

<a href="dashboard.php" class="btn btn-light mt-4">⬅ Kembali</a>

</div>
</body>
</html>