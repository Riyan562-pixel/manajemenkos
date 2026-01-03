<?php
$conn = mysqli_connect("localhost", "root", "", "db_kos", 3307);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
