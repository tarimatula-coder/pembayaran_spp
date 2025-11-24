<?php
session_start();
include '../../app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ===== CEK ADMIN/PETUGAS =====
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = htmlspecialchars($_POST['username']);
        $password = $_POST['password'];

        $qPetugas = "SELECT * FROM petugas WHERE username='$username' LIMIT 1";
        $resultPetugas = mysqli_query($connect, $qPetugas);

        if ($resultPetugas && $resultPetugas->num_rows > 0) {
            $row = $resultPetugas->fetch_object();

            if (password_verify($password, $row->password)) {
                $_SESSION['id_petugas']   = $row->id_petugas;
                $_SESSION['nama_petugas'] = $row->nama_petugas;
                $_SESSION['level']        = $row->level;

                if ($row->level === "admin") {
                    echo "<script>
                        alert('Login berhasil sebagai Admin!');
                        window.location.href='../../pages/dashboard/index.php';
                    </script>";
                    exit;
                } else {
                    echo "<script>
                        alert('Login berhasil sebagai Petugas!');
                        window.location.href='../../pages/pembayaran/index.php';
                    </script>";
                    exit;
                }
            } else {
                echo "<script>alert('Password salah!');window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Username tidak ditemukan!');window.history.back();</script>";
            exit;
        }
    }

    // ===== CEK SISWA =====
    if (!empty($_POST['nisn']) && !empty($_POST['password'])) {
        $nisn = htmlspecialchars($_POST['nisn']);
        $password = htmlspecialchars($_POST['password']);

        $qSiswa = "SELECT * FROM siswa WHERE nisn='$nisn' LIMIT 1";
        $resultSiswa = mysqli_query($connect, $qSiswa);

        if ($resultSiswa && $resultSiswa->num_rows > 0) {
            $row = $resultSiswa->fetch_object();

            if ($nisn === $row->nisn) {
                $_SESSION['id_user'] = $row->nisn;
                $_SESSION['nama']    = $row->nama;
                $_SESSION['level']   = "siswa";

                echo "<script>
                    alert('Login berhasil sebagai Siswa!');
                    window.location.href='../../pages/pembayaran/history2.php?nisn=" . urlencode($row->nisn) . "';
                </script>";
                exit;
            } else {
                echo "<script>alert('Password salah!');window.history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('NISN atau Nama tidak ditemukan!');window.history.back();</script>";
            exit;
        }
    }

    echo "<script>alert('Form tidak lengkap!');window.history.back();</script>";
    exit;
}
