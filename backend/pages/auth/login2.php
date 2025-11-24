<?php
session_start();
include '../../app.php';

// Jika sudah login sebagai siswa, arahkan ke history
if (isset($_SESSION['level']) && $_SESSION['level'] === 'siswa') {
    header("Location: ../pembayaran/history2.php?nisn=" . urlencode($_SESSION['id_user']));
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa - Aplikasi SPP</title>

    <!-- ================= FAVICON ================= -->
    <link rel="icon" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/icon-pembayaran.png" type="image/png" />
    <link rel="apple-touch-icon" sizes="180x180" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/icon-pembayaran.png">
    <link rel="icon" sizes="192x192" href="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/icon-pembayaran.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            background-color: #a8b2e7;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border-radius: 1rem;
            padding: 2rem;
            width: 28rem;
            background: linear-gradient(270deg, #ecc7c0, #fdae84, #ecc7c0, #fdae84);
            background-size: 800% 800%;
            color: #000;
            animation: gradientAnim 12s ease infinite;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
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

        .logo {
            display: block;
            margin: 0 auto 20px auto;
            width: 100px;
            height: auto;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(0, 0, 0, 0.3);
            color: #000;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.9);
            color: #000;
        }

        .btn-primary {
            background: linear-gradient(90deg, #ecc7c0, #fdae84);
            border: none;
            transition: 0.5s;
            color: #000;
            font-weight: bold;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #fdae84, #ecc7c0);
            color: #000;
        }

        .admin-link {
            text-decoration: none;
            font-weight: bold;
            color: #007bff;
        }

        .admin-link:hover {
            color: #0056b3;
        }

        h3 {
            color: #000;
        }

        .text-start label {
            display: block;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="card shadow-lg">
        <!-- Logo -->
        <img src="../../kaiadmin-lite-1.2.0/kaiadmin-lite-1.2.0/assets/img/kaiadmin/logo3.png" alt="Logo SPP" class="logo">

        <h3 class="mb-4">Login Siswa</h3>
        <form action="../../actions/auth/login.php" method="POST">
            <!-- NISN dengan mata -->
            <div class="mb-3 text-start">
                <label for="nisn" class="form-label">Username (NISN)</label>
                <div class="input-group">
                    <input type="password" name="nisn" id="nisn" class="form-control" placeholder="Masukkan Username..." required>
                    <button type="button" class="btn btn-outline-secondary" onclick="toggleField('nisn')">👁️</button>
                </div>
            </div>

            <!-- Password dengan mata -->
            <div class="mb-3 text-start">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password..." required>
                    <button type="button" class="btn btn-outline-secondary" onclick="toggleField('password')">👁️</button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
            <div class="mt-2">
                <a class="admin-link" href="./login.php">Login sebagai admin</a>
            </div>
        </form>
    </div>

    <script>
        function toggleField(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html>