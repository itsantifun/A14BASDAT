<?php
  session_start();
  include "../navbar.php";
  require_once "../database.php";
  require_once "common_function.php";

  $username = $_SESSION['username'];
  $role = $_SESSION["role"];
  $nama = $_SESSION["nama"];

  if(!empty($_GET)) {
    $conn = connectDB();
    $sql = $query = "SELECT * FROM mata_kuliah_spesial"; 
    $result = pg_query($conn, $sql);

  } else {
    die();
  }


?>

<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Daftar MK Spesial </title>
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
<p>
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
        <li data-toggle="modal" data-target="#myModal"><a href="#">Selamat datang</a></li>
      </ul>
    </div>
  </div>
</nav>
</p>
<p>a</p>
<p>-</p>
<p></p>
<h2>Daftar MK Spesial <?echo $role . ': ' .$nama; ?> </h2>
<p><input class="btn btn-danger" type="submit" name="commit" value="tambah"></p>
<p>Sort By : [Mahasiswa], [Jenis Sidang], [Waktu]</p>
<table>
  <tr>
    <td>ID</td>
    <td>Judul</td>
    <td>Mahasiswa</td>
    <td>term</td>
    <td>Jenis MKS</td>
    <td>Status</td>
  </tr>
  <tr>
    <?php
      while($result) {
        $field = pg_fetch_array($result);
        $IdMKS = $field[0];
        $NPM = $field[1];
        $Tahun = $field[2];
        $Semester = $field[3];
        $Judul = $field[4];
        $IsSiapSidang = $field[5];
        $PengumpulanHardCopy = $field[6];
        $IjinMajuSidang = $field[7];
        $IdJenisMKS = $field[8];
      }?>
      <td><?echo  $IdMKS; ?></td>
        <td><?echo $Judul; ?></td>
        <td><?echo $NPM; ?></td>
        <td><?echo $Tahun . ' ' . $Semester; ?></td>
        <td><?echo $IdJenisMKS ?></td>
        <td><?echo $IsSiapSidang ?><?echo $PengumpulanHardCopy ?><?echo $IjinMajuSidang ?></td>
  </tr>
</table>

</body>
</html>