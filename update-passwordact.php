<?php
session_start();
error_reporting(0);
include('includes/config.php');

try {
    // Membuat koneksi PDO
    $pdo = new PDO("mysql:host=localhost;dbname=your_db_name", "username", "password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mengambil data dari form
    $passw = $_POST['pass'];
    $pass = md5($passw);
    $new = $_POST['new'];
    $confirm = $_POST['confirm'];
    $mail = $_POST['mail'];

    // Query untuk memeriksa email dan password
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
    $stmt->execute([
        ':email' => $mail,
        ':password' => $pass
    ]);

    // Cek apakah ada user yang cocok
    if ($stmt->rowCount() == 1) {
        if ($confirm == $new) {
            $newpass = md5($new);

            // Query untuk update password
            $stmtUpdate = $pdo->prepare("UPDATE users SET password = :newpass WHERE email = :email");
            if ($stmtUpdate->execute([
                ':newpass' => $newpass,
                ':email' => $mail
            ])) {
                echo "<script type='text/javascript'>
                    alert('Berhasil update password.'); 
                    document.location = 'update-password.php'; 
                </script>";
            } else {
                echo "<script type='text/javascript'>
                    alert('Gagal update password!'); 
                    document.location = 'update-password.php'; 
                </script>";
            }
        } else {
            echo "<script type='text/javascript'>
                alert('Password baru dan konfirmasi password tidak sama!'); 
                document.location = 'update-password.php'; 
            </script>";
        }
    } else {
        echo "<script type='text/javascript'>
            alert('Password salah!'); 
            document.location = 'update-password.php'; 
        </script>";
    }
} catch (PDOException $e) {
    // Menangani error koneksi atau query
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    echo "<script type='text/javascript'> document.location = 'update-password.php'; </script>";
}
?>
