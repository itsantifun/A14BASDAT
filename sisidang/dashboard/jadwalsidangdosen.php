<?php
	session_start();
	require "../database.php";
	include 'common_function.php';
	if(!isset($_SESSION['username'])){
			header('Location: ../index.php');
			die();
	}
	$username = $_SESSION['username'];
	$role = $_SESSION["role"];
	$nama = $_SESSION["nama"];
	$conn = connectDB();
	
	
?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>jadwal sidang </title>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="../style.css">
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.js"></script>
  
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/>
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<style>
body {
	background: #f1f4f7;
	padding-top: 50px;
	color: #5f6468;
	font-family: Lato, sans-serif;
	}
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
body img{
      width: 100%; /* Set width to 100% */
      height: 100%;
      margin: auto;
    }
    .row{
        padding-top: 10%; 
        padding-left: 10%;
    }
    .form-top {
        width: 500px;
        overflow: hidden;
        padding: 0 0px 10px 15px;
        background: #fff;
        -moz-border-radius: 4px 4px 0 0; -webkit-border-radius: 4px 4px 0 0; border-radius: 4px 4px 0 0;
        text-align: left;
    }
    .form-bottom {
        width: 400px;
        padding: 2px 2px 3px 2px;
        background: #fff;
        -moz-border-radius: 0 0 4px 4px; -webkit-border-radius: 0 0 4px 4px; border-radius: 0 0 4px 4px;
        text-align: left;
    }
    .form-bottom form button.btn {
        width: 30%;
    }
    .form-bottom form  .input-error {
        border-color: #4aaf51;
    }
</style>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a href="./"><alt="Logo" width="150px" height="50px" class="navbar-brand">home</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li data-toggle="modal" data-target="#myModal"><a href="../logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
  </div>
</nav>

<div class="col-md-10 col-md-offset-1">
<h2>Jadwal Sidang</h2>
<p>Sort By : [Mahasiswa], [Jenis Sidang], [Waktu]</p>
<table data-order[[0,1,3]] id="datamahasiswa" class="display">
  <thead>
  <tr>
    <th>Mahasiswa</th>
    <th>jenis Sidang</th>
    <th>Judul</th>
	<th>Waktu dan Lokasi</th>
	<th>Pembimbing</th>
	<th>status</th>
	
  </tr>
  </thead>
  <tbody>
  <?php
			$namae = "SELECT * FROM DOSEN WHERE username = '$username'";
			$result0 = pg_query($conn, $namae);
			$row0 = pg_fetch_array($result0);
			$namaea = $row0['nama'];
			//echo $namaea;
			$sql = "SELECT * FROM JADWAL_SIDANG";
			$result = pg_query($conn, $sql);
				while($row = pg_fetch_array($result)){
					$mks=getMKS($row['idmks']);
					$jenisMks = getJenisMKS($mks['idjenismks']);
					$mahasiswa = getMahasiswa($mks['npm']);
					$pembimbing = getDosenPembimbing2($mks['idmks'],$namaea);
					$penguji = getDosenPenguji2($mks['idmks'],$namaea);
					$waktu = getWaktu($mks['idmks']);
					$judul = $mks['judul'];
					$status = "";
					if ($mks['pengumpulanhardcopy'] == 't')
					$status = $status."-"."pengumpulanhardcopy"."<br>";
					if ($mks['ijinmajusidang'] == 't')
					$status = $status."-"."ijinmajusidang";
					
					if ($pembimbing == $namaea){
						$penguji = getDosenPenguji($mks['idmks']);
						$pembimbing = getDosenPembimbing($mks['idmks']);
	?>
  <tr>
	<td><?=$mahasiswa?></td>
    <td><?=$jenisMks?></td>
	<td><?=$judul?></td>
	<td><?=$waktu['tanggal']," ",$waktu['jammulai'],"-",$waktu['jamselesai']?></td>
	<td><?=$pembimbing?></td>
	<td><?=$status?></td>
	
  </tr>
					<?php }
	if ($penguji == $namaea){
						$penguji = getDosenPenguji($mks['idmks']);
						$pembimbing = getDosenPembimbing($mks['idmks']);
	?>
	<tr>
	<td><?=$mahasiswa?></td>
    <td><?=$jenisMks?></td>
	<td><?=$judul?></td>
	<td><?=$waktu['tanggal']," ",$waktu['jammulai'],"-",$waktu['jamselesai']?></td>
	<td><?=$pembimbing?></td>
	<td><?=$penguji?></td>
	
  </tr>
				<?php } }
	?>
</tbody>
<script>
$(document).ready( function () {
    $('#datamahasiswa').DataTable();
} );
</script>
</table>

</div>

</body>
</html>
