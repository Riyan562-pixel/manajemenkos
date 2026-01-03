<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin | Manajemen Kos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .bg-slideshow {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-size: cover;
            background-position: center;
            animation: slideBg 20s infinite;
        }

        @keyframes slideBg {
            0% { background-image: url('https://images.unsplash.com/photo-1580584121805-27c3c5d6a6e1?auto=format&fit=crop&w=1470&q=80'); }
            33% { background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=1470&q=80'); }
            66% { background-image: url('https://images.unsplash.com/photo-1572120360610-d971b9b639a8?auto=format&fit=crop&w=1470&q=80'); }
            100% { background-image: url('https://images.unsplash.com/photo-1580584121805-27c3c5d6a6e1?auto=format&fit=crop&w=1470&q=80'); }
        }

        .login-card {
            backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 3rem 2rem;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.4);
        }

        h3 {
            color: #030303ff;
            text-align: center;
            font-weight: 700;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
            margin-bottom: 0.5rem;
        }

        .welcome-text {
            text-align: center;
            color: #030303ff;
            font-weight: 500;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 6px rgba(0,0,0,0.5);
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            border: none;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }

        .footer-text {
            color: rgba(5, 5, 5, 0.8);
            text-align: center;
            margin-top: 1rem;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.3);
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
    </style>
</head>
<body>

<div class="bg-slideshow"></div>

<div class="container">
    <div class="col-md-4">
        <div class="login-card">
            <h3>Login Admin</h3>
            <p class="welcome-text">Selamat Datang di Aplikasi Manajemen Kos</p>
            <form action="auth/proses_login.php" method="POST">
                <div class="mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                </div>
                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </div>
            </form>
        </div>
        <p class="footer-text">© 2025 Manajemen Kos</p>
    </div>
</div>

</body>
</html>
