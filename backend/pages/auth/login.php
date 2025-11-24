<?php
session_start();
include '../../app.php';

if (isset($_SESSION['level'])) {
    echo "
        <script>
            alert('Anda harus logout dahulu');
            window.location.href='../dashboard/index.php';
        </script>
    ";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Aplikasi SPP</title>

    <!-- ================= FAVICON ================= -->
    <link rel="icon" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/icon-pembayaran.png" type="image/png" />
    <link rel="apple-touch-icon" sizes="180x180" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/icon-pembayaran.png">
    <link rel="icon" sizes="192x192" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/icon-pembayaran.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* ===== BACKGROUND BIRU TUA ===== */
        body {
            height: 100vh;
            background: linear-gradient(135deg, #0d1b2a, #1b263b);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* ===== ANIMATED CARD LOGIN BIRU MUDA - ABU ===== */
        .card {
            border-radius: 1rem;
            padding: 2rem;
            width: 28rem;
            background: linear-gradient(270deg, #add8e6, #b0b0b0, #add8e6, #b0b0b0);
            background-size: 1000% 1000%;
            color: #333;
            animation: gradientAnim 8s ease infinite;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        @keyframes gradientAnim {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* ===== LOGO ===== */
        .logo {
            display: block;
            margin: 0 auto 20px auto;
            width: 120px;
            height: auto;
        }

        /* ===== PLACEHOLDER ===== */
        input::placeholder {
            color: #666;
            opacity: 1;
        }

        /* ===== INPUT FORM ===== */
        .form-control {
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.2);
            color: #333;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 1);
            color: #333;
        }

        /* ===== TOMBOL ===== */
        .btn-primary {
            background: linear-gradient(90deg, #add8e6, #b0b0b0);
            border: none;
            transition: 0.5s;
            color: #333;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #b0b0b0, #add8e6);
            color: #333;
        }

        /* ===== LINK LOGIN SISWA TANPA GARIS ===== */
        a.text-primary {
            text-decoration: none !important;
            color: #333;
        }

        a.text-primary:hover {
            text-decoration: none !important;
        }

        h3 {
            color: #333;
        }
    </style>
</head>

<body>
    <div class="card shadow-lg">
        <!-- Logo -->
        <img src="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/logo.png"
            alt="Logo SPP" class="logo" style="width: 250px;" height="auto">

        <h3 class="text-center mb-4">Login Admin</h3>
        <form action="../../actions/auth/login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control"
                    placeholder="Masukkan username..." required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password"
                        class="form-control" placeholder="Masukkan password..." required>
                    <button type="button" class="btn btn-outline-secondary"
                        onclick="togglePassword()">👁️</button>
                </div>
            </div>

            <button type="submit" name="tombol" class="btn btn-primary w-100">Login</button>
            <div class="mt-2 text-center">
                <a class="text-primary fw-bold" href="./login2.php">Login sebagai siswa</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passField = document.getElementById("password");
            if (passField.type === "password") {
                passField.type = "text";
            } else {
                passField.type = "password";
            }
        }
    </script>
</body>

</html>