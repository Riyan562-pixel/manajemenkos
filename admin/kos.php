<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}

include "../config/koneksi.php"; // pastikan koneksi ke db_kos

/* TAMBAH DATA KOS */
if (isset($_POST['tambah'])) {
    mysqli_query($conn, "INSERT INTO data_kos
        (grade, nomor_kamar, harga, fasilitas, status)
        VALUES (
            '$_POST[grade]',
            '$_POST[nomor]',
            '$_POST[harga]',
            '$_POST[fasilitas]',
            'Kosong'
        )");
}

/* UPDATE DATA KOS */
if (isset($_POST['update'])) {
    mysqli_query($conn, "UPDATE data_kos SET
        grade='$_POST[grade]',
        nomor_kamar='$_POST[nomor]',
        harga='$_POST[harga]',
        fasilitas='$_POST[fasilitas]',
        status='$_POST[status]'
        WHERE id='$_POST[id]'");
}

/* HAPUS DATA KOS */
if (isset($_GET['hapus'])) {
    mysqli_query($conn, "DELETE FROM data_kos WHERE id='$_GET[hapus]'");
}

$data = mysqli_query($conn, "SELECT * FROM data_kos");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Kos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">

    <h3 class="fw-bold mb-4">📋 Data Kos</h3>

    <!-- FORM TAMBAH -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="POST" class="row g-2">
                <div class="col-md-2">
                    <select name="grade" class="form-select" required>
                        <option value="">Grade</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="text" name="nomor" class="form-control" placeholder="No Kamar" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="harga" class="form-control" placeholder="Harga" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="fasilitas" class="form-control" placeholder="Fasilitas">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- TABEL DATA KOS -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Grade</th>
                        <th>Nomor Kamar</th>
                        <th>Harga</th>
                        <th>Fasilitas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no=1; while($row=mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><?= $row['grade'] ?></td>
                        <td class="text-center"><?= $row['nomor_kamar'] ?></td>
                        <td class="text-end">Rp <?= number_format($row['harga']) ?></td>
                        <td><?= $row['fasilitas'] ?></td>
                        <td class="text-center">
                            <span class="badge <?= $row['status']=='Kosong'?'bg-success':'bg-danger' ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $row['id'] ?>">Edit</button>
                            <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Hapus data kos?')" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>

                    <!-- MODAL EDIT -->
                    <div class="modal fade" id="edit<?= $row['id'] ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST">
                                    <div class="modal-header">
                                        <h5>Edit Data Kos</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                        <select name="grade" class="form-select mb-2">
                                            <option value="A" <?= $row['grade']=='A'?'selected':'' ?>>A</option>
                                            <option value="B" <?= $row['grade']=='B'?'selected':'' ?>>B</option>
                                        </select>
                                        <input type="text" name="nomor" value="<?= $row['nomor_kamar'] ?>" class="form-control mb-2">
                                        <input type="number" name="harga" value="<?= $row['harga'] ?>" class="form-control mb-2">
                                        <input type="text" name="fasilitas" value="<?= $row['fasilitas'] ?>" class="form-control mb-2">
                                        <select name="status" class="form-select">
                                            <option value="Kosong" <?= $row['status']=='Kosong'?'selected':'' ?>>Kosong</option>
                                            <option value="Terisi" <?= $row['status']=='Terisi'?'selected':'' ?>>Terisi</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>