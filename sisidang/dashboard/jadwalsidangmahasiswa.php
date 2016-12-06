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
	if($role <> "MHS"){
			header('Location: ../index.php');
			die();
	}
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
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"/>
  <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js"></script>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td{
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

th{
	border: 1px solid #eeeeee;
    text-align: left;
    padding: 8px;
    background-color: #dddddd;
	width: 220px;
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
        <li data-toggle="modal" data-target="#myModal"><a href="../logout.php">logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="col-md-10 col-md-offset-1" style="margin-top:5%">
<table>
	<?php
			$status = true;
			$namae = "SELECT * FROM MAHASISWA WHERE username = '$username'";
			$result0 = pg_query($conn, $namae);
			$row0 = pg_fetch_array($result0);
			$namaea = $row0['npm'];
			//echo $namaea;
			$sql = "SELECT * FROM JADWAL_SIDANG";
			$result = pg_query($conn, $sql);
				while($row = pg_fetch_array($result)){
					$mks=getMKS($row['idmks']);	
					$mahasiswa = getMahasiswa($mks['npm']);
					$jenisMks = getJenisMKS($mks['idjenismks']);
					$pembimbing = getDosenPembimbing($mks['idmks']);
					$penguji = getDosenPenguji($mks['idmks']);
					$waktu = getWaktu($mks['idmks']);
					$judul = $mks['judul'];
				if($namaea == $mks['npm'] && $mks['issiapsidang'] == "t"){
					$status = false;
	?>
	<h2>Jadwal Sidang Mahasiswa</h2>
  <tr>
    <th>Judul Tugas Akhir</th>
    <td><?=$judul?></td>
  </tr>
  <tr>
    <th>Jadwal Sidang</th>
    <td>19 Nov 2016</td>
  </tr>
  <tr>
    <th>Waktu Sidang</th>
    <td>09:00-10:30 WIB @ 2.2301</td>
  </tr>
  <tr>
    <th>Dosen Pembimbing</th>
    <td>ani, Status : izin maju sidang, Kumpul Hard Copy</td>
  </tr>
  <tr>
    <th>Dosen Penguji</th>
    <td>anto</td>
  </tr>
				<?php } }
	if($status)	echo "belum ada jadwal";				
  ?>
  
</table>
</div>
</body>
</html>
