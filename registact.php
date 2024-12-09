<?php
session_start();
error_reporting(0);
include('includes/config.php');

try {
    // Membuat koneksi PDO
    $pdo = new PDO("mysql:host=localhost;dbname=your_db_name", "username", "password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mengambil data dari form
    $fname = $_POST['fullname'];
    $email = $_POST['emailid']; 
    $mobile = $_POST['mobileno'];
    $alamat = $_POST['alamat']; 
    $pass = $_POST['pass'];
    $conf = $_POST['conf'];

    // Mengambil file yang diupload
    $image1 = $_FILES["img1"]["name"];
    $image2 = $_FILES["img2"]["name"];
    $newimg1 = date('dmYHis') . $image1;
    $newimg2 = date('dmYHis') . $image2;

    // Memindahkan file ke folder tujuan
    move_uploaded_file($_FILES["img1"]["tmp_name"], "image/id/" . $newimg1);
    move_uploaded_file($_FILES["img2"]["tmp_name"], "image/id/" . $newimg2);

    // Validasi password
    if ($conf != $pass) {
        echo "<script>alert('Password tidak sama!');</script>";
        echo "<script type='text/javascript'> document.location = 'regist.php'; </script>";
    } else {
        // Periksa apakah email sudah terdaftar
        $sqlCek = "SELECT email FROM users WHERE email = :email";
        $stmtCek = $pdo->prepare($sqlCek);
        $stmtCek->execute([':email' => $email]);

        if ($stmtCek->rowCount() > 0) {
            echo "<script>alert('Email sudah terdaftar, silahkan gunakan email lain!');</script>";
            echo "<script type='text/javascript'> document.location = 'regist.php'; </script>";
        } else {
            // Enkripsi password
            $password = md5($pass);

            // Insert data ke database
            $sqlInsert = "INSERT INTO users (nama_user, email, telp, password, alamat, ktp, kk) 
                          VALUES (:nama_user, :email, :telp, :password, :alamat, :ktp, :kk)";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $isInserted = $stmtInsert->execute([
                ':nama_user' => $fname,
                ':email' => $email,
                ':telp' => $mobile,
                ':password' => $password,
                ':alamat' => $alamat,
                ':ktp' => $newimg1,
                ':kk' => $newimg2
            ]);

            // Periksa apakah data berhasil disimpan
            if ($isInserted) {
                echo "<script>alert('Registrasi berhasil. Sekarang anda bisa login.');</script>";
                echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
            } else {
                echo "<script>alert('Ops, terjadi kesalahan. Silahkan coba lagi.');</script>";
                echo "<script type='text/javascript'> document.location = 'regist.php'; </script>";
            }
        }
    }
} catch (PDOException $e) {
    // Menangani error PDO
    echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    echo "<script type='text/javascript'> document.location = 'regist.php'; </script>";
}
?>
