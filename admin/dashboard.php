<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | Manajemen Kos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: url('https://images.unsplash.com/photo-1580584121805-27c3c5d6a6e1?auto=format&fit=crop&w=1470&q=80')
            no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dashboard-card {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.25);
            border-radius: 20px;
            padding: 3rem 2rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .dashboard-card h3 {
            color: #000;
            font-weight: 700;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
            margin-bottom: 2rem;
        }

        .dashboard-card .btn {
            border-radius: 10px;
            font-weight: 600;
            padding: 0.75rem;
            margin: 0.5rem 0;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary {
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            border: none;
        }

        .btn-success {
            background: linear-gradient(90deg, #00b09b, #96c93d);
            border: none;
        }

        .btn-warning {
            background: linear-gradient(90deg, #f7971e, #ffd200);
            border: none;
        }

        .btn-info {
            background: linear-gradient(90deg, #2193b0, #6dd5ed);
            border: none;
        }

        .btn-danger {
            background: linear-gradient(90deg, #ff416c, #ff4b2b);
            border: none;
        }

        .dashboard-card .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        .footer-text {
            color: rgba(0, 0, 0, 0.85);
            text-align: center;
            margin-top: 1.5rem;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="dashboard-card">
        <h3>Dashboard Admin</h3>

        <a href="kos.php" class="btn btn-primary w-100">Data Kos</a>
        <a href="penyewa.php" class="btn btn-success w-100">Data Penyewa</a>
        <a href="pembayaran.php" class="btn btn-warning w-100">Pembayaran</a>
        <a href="laporan_bulanan.php" class="btn btn-info w-100">Laporan Bulanan</a>

        <a href="../auth/logout.php" class="btn btn-danger w-100 mt-3">Logout</a>

        <p class="footer-text">© 2025 Manajemen Kos</p>
    </div>
</div>

</body>

</html>