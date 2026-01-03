<?php
session_start();
include "../config/koneksi.php";

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = md5($_POST['password']);

$query = mysqli_query($conn, "
    SELECT * FROM admin 
    WHERE username='$username' 
    AND password='$password'
");

if (mysqli_num_rows($query) > 0) {
    $_SESSION['login'] = true;
    header("Location: ../admin/dashboard.php");
    exit;
} else {
    echo "<script>
        alert('Username atau Password salah!');
        window.location='../index.php';
    </script>";
}