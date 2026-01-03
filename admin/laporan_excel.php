<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}
include "../config/koneksi.php";

// Ambil bulan & tahun
$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

// Statistik
$qKamar = mysqli_query($conn,"SELECT nomor_kamar FROM data_kos WHERE status='Kosong'");
$qPenyewa = mysqli_query($conn,"SELECT nama FROM data_penyewa");
$qBelum = mysqli_query($conn,"
SELECT DISTINCT s.nama
FROM pembayarann p
JOIN data_penyewa s ON p.penyewa_id=s.id
WHERE p.status='Belum Dibayar'
AND MONTH(p.tanggal)='$bulan'
AND YEAR(p.tanggal)='$tahun'
");
$qTotal = mysqli_query($conn,"
SELECT SUM(jumlah) AS total
FROM pembayarann
WHERE status='Lunas'
AND MONTH(tanggal)='$bulan'
AND YEAR(tanggal)='$tahun'
");
$penghasilan = mysqli_fetch_assoc($qTotal)['total'] ?? 0;

// Ambil list data
$listKamar = [];
while($k=mysqli_fetch_assoc($qKamar)) $listKamar[] = $k['nomor_kamar'];

$listPenyewa = [];
while($p=mysqli_fetch_assoc($qPenyewa)) $listPenyewa[] = $p['nama'];

$listBelum = [];
while($b=mysqli_fetch_assoc($qBelum)) $listBelum[] = $b['nama'];

// Hitung max row
$maxRow = max(count($listKamar), count($listPenyewa), count($listBelum), 1);

// Header Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Bulanan_$tahun.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table cellpadding="5" cellspacing="0" style="font-family:Arial, sans-serif;">
    <!-- Judul -->
    <tr>
        <td colspan="5" style="text-align:center; font-size:22pt; font-weight:bold; background-color:#4CAF50; color:white; padding:12px;">
            Laporan Bulanan
        </td>
    </tr>

    <!-- Header Tabel -->
    <tr style="background-color:#1565C0; color:white; font-weight:bold; text-align:center;">
        <th style="width:5%;">No</th>
        <th style="width:20%;">Kamar Kosong</th>
        <th style="width:25%;">Penyewa Aktif</th>
        <th style="width:25%;">Belum Bayar</th>
        <th style="width:25%;">Penghasilan</th>
    </tr>

    <?php
    for($i=0; $i<$maxRow; $i++):
        $no = $i + 1;
        $kamar = $listKamar[$i] ?? '';
        $penyewa = $listPenyewa[$i] ?? '';
        $belum = $listBelum[$i] ?? '';
        $peng = $i===0 ? 'Rp '.number_format($penghasilan) : '';
        // Warna row bergantian optional, tapi tanpa border
        $bgColor = ($i % 2 == 0) ? '#E3F2FD' : '#FFFFFF';
    ?>
    <tr style="background-color:<?= $bgColor ?>;">
        <td style="text-align:center;"><?= $no ?></td>
        <td><?= $kamar ?></td>
        <td><?= $penyewa ?></td>
        <td style="color:red;"><?= $belum ?></td>
        <td style="color:green; font-weight:bold;"><?= $peng ?></td>
    </tr>
    <?php endfor; ?>
</table>
