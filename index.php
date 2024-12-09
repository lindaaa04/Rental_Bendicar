<?php 
// Memulai sesi untuk menyimpan data pengguna
session_start(); 

// Menyertakan file konfigurasi database dan format rupiah
include('includes/config.php');
include('includes/format_rupiah.php');

// Menonaktifkan laporan error
error_reporting(0); 
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
<!-- Meta Tag -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>RENTAL MOBIL BENDI CAR</title>

<!-- Menyertakan file CSS untuk Bootstrap dan gaya lainnya -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="assets/css/style3.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<link href="assets/css/slick.css" rel="stylesheet">
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<link href="assets/css/font-awesome.min.css" rel="stylesheet">

<!-- Switcher untuk warna tema -->
<link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
<link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />

<!-- Favicon -->
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet"> 
</head>
<body>

<!-- Switcher untuk mengubah tema warna -->
<?php include('includes/colorswitcher.php');?>

<!-- Header -->
<?php include('includes/header.php');?>

<!-- Bagian Mobil Terkini -->
<section class="section-padding gray-bg">
  <div class="container">
    <div class="row"> 
      
      <!-- Tab Navigasi -->
      <div class="recent-tab">
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#resentnewcar" role="tab" data-toggle="tab">Mobil Untuk Anda</a></li>
        </ul>
      </div>

      <!-- Daftar Mobil Terkini -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="resentnewcar">

<?php 
// Query untuk mengambil data mobil dan merek dari database
$sql = "SELECT mobil.*, merek.* FROM mobil, merek WHERE merek.id_merek = mobil.id_merek";
$query = mysqli_query($koneksidb, $sql);
// Mengecek apakah ada data yang ditemukan
if(mysqli_num_rows($query) > 0) {
    while($results = mysqli_fetch_array($query)) {
?>  

<!-- Menampilkan informasi mobil -->
<div class="col-list-3">
<div class="recent-car-list">
<div class="car-info-box"> 
  <a href="vehical-details.php?vhid=<?php echo htmlentities($results['id_mobil']);?>">
    <img src="admin/img/vehicleimages/<?php echo htmlentities($results['image1']);?>" class="img-responsive" alt="image">
  </a>
<ul>
<li><i class="fa fa-car" aria-hidden="true"></i><?php echo htmlentities($results['bb']);?></li>
<li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($results['tahun']);?> Model</li>
<li><i class="fa fa-user" aria-hidden="true"></i><?php echo htmlentities($results['seating']);?> Seats</li>
</ul>
</div>
<div class="car-title-m">
<h6><a href="vehical-details.php?vhid=<?php echo htmlentities($results['id_mobil']);?>"><?php echo htmlentities($results['nama_merek']);?> , <?php echo htmlentities($results['nama_mobil']);?></a></h6>
<span class="price"><?php echo htmlentities(format_rupiah($results['harga']));?> /Hari</span> 
</div>
<div class="inventory_info_m">
<p><?php echo substr($results['deskripsi'],0,70);?></p>
</div>
</div>
</div>
<?php }}?>
       
      </div>
    </div>
  </div>
</section>
<!-- /Bagian Mobil Terkini -->

<!-- Footer -->
<?php include('includes/footer.php');?>

<!-- Back to Top -->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>

<!-- Form Login -->
<?php include('includes/login.php');?>

<!-- Form Registrasi -->
<?php include('includes/registration.php');?>

<!-- Form Lupa Password -->
<?php include('includes/forgotpassword.php');?>

<!-- Script -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<script src="assets/switcher/js/switcher.js"></script>
<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>

</body>
</html>
