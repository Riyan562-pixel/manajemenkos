<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}

include "../config/koneksi.php";

/* TAMBAH PEMBAYARAN */
if (isset($_POST['tambah'])) {
    $penyewa_id = $_POST['penyewa_id'];
    $tanggal = $_POST['tanggal'];
    $jumlah = $_POST['jumlah'];

    mysqli_query($conn, "INSERT INTO pembayarann 
        (penyewa_id, tanggal, jumlah, status) 
        VALUES ('$penyewa_id', '$tanggal', '$jumlah', 'Belum Dibayar')");
}

/* UPDATE STATUS PEMBAYARAN */
if (isset($_GET['lunas'])) {
    $id = $_GET['lunas'];
    mysqli_query($conn, "UPDATE pembayarann SET status='Lunas' WHERE id='$id'");
}

/* HAPUS PEMBAYARAN */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM pembayarann WHERE id='$id'");
}

/* AMBIL DATA */
$data = mysqli_query($conn, "SELECT p.*, s.nama, k.nomor_kamar 
    FROM pembayarann p 
    LEFT JOIN data_penyewa s ON p.penyewa_id=s.id
    LEFT JOIN data_kos k ON s.kamar_id=k.id");

$penyewa = mysqli_query($conn, "SELECT * FROM data_penyewa");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h3 class="fw-bold mb-4">💰 Data Pembayaran</h3>

    <!-- FORM TAMBAH PEMBAYARAN -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="POST" class="row g-2">
                <div class="col-md-4">
                    <select name="penyewa_id" class="form-select" required>
                        <option value="">Pilih Penyewa</option>
                        <?php while($p = mysqli_fetch_assoc($penyewa)): ?>
                            <option value="<?= $p['id'] ?>">
                                <?= $p['nama'] ?> (Kamar <?= $p['kamar_id'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="tanggal" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="jumlah" class="form-control" placeholder="Jumlah Bayar" required>
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- TABEL DATA PEMBAYARAN -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Penyewa</th>
                        <th>Kamar</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                <?php 
                $no = 1;
                $total = 0;
                while($row = mysqli_fetch_assoc($data)): 
                    $total += $row['jumlah'];
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $row['nama'] ?></td>
                    <td class="text-center"><?= $row['nomor_kamar'] ?></td>
                    <td class="text-center"><?= $row['tanggal'] ?></td>
                    <td class="text-end">Rp <?= number_format($row['jumlah']) ?></td>
                    <td class="text-center">
                        <span class="badge <?= $row['status']=='Lunas' ? 'bg-success' : 'bg-warning' ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <?php if($row['status']=='Belum Dibayar'): ?>
                            <a href="?lunas=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Lunas</a>
                        <?php endif; ?>
                        <a href="?hapus=<?= $row['id'] ?>" 
                           onclick="return confirm('Hapus pembayaran?')" 
                           class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>

                <!-- TOTAL PEMBAYARAN -->
                <tr class="fw-bold table-secondary">
                    <td colspan="4" class="text-end">Total Pembayaran</td>
                    <td class="text-end">Rp <?= number_format($total) ?></td>
                    <td colspan="2"></td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>