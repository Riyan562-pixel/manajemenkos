<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}

include "../config/koneksi.php";

/* TAMBAH PENYEWA */
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $no_ktp = $_POST['no_ktp'];
    $kamar_id = $_POST['kamar_id'];
    $tgl_masuk = $_POST['tanggal_masuk'];

    mysqli_query($conn, "INSERT INTO data_penyewa (nama,no_hp,no_ktp,kamar_id,tanggal_masuk)
        VALUES ('$nama','$no_hp','$no_ktp','$kamar_id','$tgl_masuk')");

    // Update status kamar menjadi Terisi
    mysqli_query($conn, "UPDATE data_kos SET status='Terisi' WHERE id='$kamar_id'");
}

/* UPDATE PENYEWA */
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $no_ktp = $_POST['no_ktp'];
    $kamar_id = $_POST['kamar_id'];
    $tgl_masuk = $_POST['tanggal_masuk'];

    $old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT kamar_id FROM data_penyewa WHERE id='$id'"));
    $old_kamar = $old['kamar_id'];

    mysqli_query($conn, "UPDATE data_penyewa SET nama='$nama', no_hp='$no_hp', no_ktp='$no_ktp', kamar_id='$kamar_id', tanggal_masuk='$tgl_masuk' WHERE id='$id'");

    // Set kamar lama Kosong
    mysqli_query($conn, "UPDATE data_kos SET status='Kosong' WHERE id='$old_kamar'");
    // Set kamar baru Terisi
    mysqli_query($conn, "UPDATE data_kos SET status='Terisi' WHERE id='$kamar_id'");
}

/* HAPUS PENYEWA */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT kamar_id FROM data_penyewa WHERE id='$id'"));
    $old_kamar = $old['kamar_id'];

    mysqli_query($conn, "DELETE FROM data_penyewa WHERE id='$id'");
    mysqli_query($conn, "UPDATE data_kos SET status='Kosong' WHERE id='$old_kamar'");
}

/* Ambil data penyewa */
$data = mysqli_query($conn, "SELECT p.*, k.nomor_kamar FROM data_penyewa p LEFT JOIN data_kos k ON p.kamar_id=k.id");
$kos = mysqli_query($conn, "SELECT * FROM data_kos WHERE status='Kosong'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Penyewa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h3 class="fw-bold mb-4">📋 Data Penyewa</h3>

    <!-- FORM TAMBAH PENYEWA -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="POST" class="row g-2">
                <div class="col-md-3">
                    <input type="text" name="nama" class="form-control" placeholder="Nama Penyewa" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="no_hp" class="form-control" placeholder="No HP" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="no_ktp" class="form-control" placeholder="No KTP" required>
                </div>
                <div class="col-md-2">
                    <select name="kamar_id" class="form-select" required>
                        <option value="">Pilih Kamar</option>
                        <?php while($k=mysqli_fetch_assoc($kos)): ?>
                            <option value="<?= $k['id'] ?>"><?= $k['nomor_kamar'] ?> (<?= $k['grade'] ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="tanggal_masuk" class="form-control" required>
                </div>
                <div class="col-md-1 d-grid">
                    <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- TABEL DATA PENYEWA -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>No KTP</th>
                        <th>Kamar</th>
                        <th>Tanggal Masuk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1; while($row=mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['no_hp'] ?></td>
                        <td><?= $row['no_ktp'] ?></td>
                        <td class="text-center"><?= $row['nomor_kamar'] ?></td>
                        <td class="text-center"><?= $row['tanggal_masuk'] ?></td>
                        <td class="text-center">
                            <!-- Modal edit bisa ditambahkan sama seperti data kos -->
                            <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus data penyewa?')" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>