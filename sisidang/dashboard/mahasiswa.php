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
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login sisidang</title>
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="../style.css">
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
        padding-top: 8%; 

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
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
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
      <a href="./"><alt="Logo" width="150px" height="50px" class="navbar-brand">tambah perserta MKS</a>
    </div>
	<div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a href="jadwalsidangmahasiswa.php"><alt="Logo" width="150px" height="50px" class="navbar-brand">Lihat Jadwal Sidang</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li data-toggle="modal" data-target="#myModal"><a href="../logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="row">

	<div class="col-md-10 col-md-offset-1">
		<table class="table">
			<tr>
				<th>NPM</th>
				<th>Nama</th>
				<th>email</th>
				<th>email alternatif</th>	
				<th>telepon</th>
				<th>notelp</th>
			</tr>
			<?php
			$sql = "SELECT * FROM MAHASISWA WHERE username='$username'";
			$result = pg_query($conn, $sql);
			$mahasiswa= pg_fetch_array($result);
			$npm = $mahasiswa['npm'];
			$email = $mahasiswa['email'];
			$email_alternatif = $mahasiswa['email_alternatif'];
			$telepon = $mahasiswa['telepon'];
			$notelp = $mahasiswa['notelp'];
			?>
			<tr>
			
				<td><?=$npm?></td>
				<td><?=$nama?></td>
				<td><?=$email?></td>
				<td><?=$email_alternatif?></td>
				<td><?=$telepon?></td>
				<td><?=$notelp?></td>
			</tr>
			
			</table>
	</div>
	
</div>


</script>
</body>
</html>