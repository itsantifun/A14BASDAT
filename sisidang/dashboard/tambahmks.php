<?php
  session_start();
  require_once "../database.php";
  require_once "common_function.php";
  $username = $_SESSION['username'];
  $role = $_SESSION["role"];
  $nama = $_SESSION["nama"];
  
  if($_POST){
    $judulmks = $_POST['judulmks'];
    $term = $_POST['term'];
    $jenismks = $_POST['jenismks'];
    $namamhs = $_POST['namamhs'];
    $id_mks = 1999;
    $npm= (getNPM($username));

    $conn = connectDB();
     $sql = "INSERT INTO mata_kuliah_spesial (IdMKS, NPM, Tahun, Semester, Judul, IsSiapSidang, PengumpulanHardCopy, IjinMajuSidang, IdJenisMKS) VALUES ($id_mks,$npm,$term,false,false,false,$jenismks)";
     $result = pg_query($conn, $sql);
  }
  
  if(!empty($_GET)){
  }else{
    die();
  }

  $id_st_lamaran = 1;//status melamar

?>

<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Tambah Data SKS</title>
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
<h2>Tambah Data Sidang</h2>
<form method="POST" action="tambahmks.php">
<table>
 <tr>
    <td>Term</td>
    <td>
        <select id= "term" name="priority" size="1">
        <option value="Low">Ganjil 2016</option>
        <option value="Normal">Genap 2016</option>
        <option value="High">SP 2016</option>
        </select>
    </td> 
  </tr>
  <tr>
    <td>Jenis MKS</td>
    <td>
      <select id = "jenismks" name="priority" size="1">
        <option value="1">Skripsi</option>
        <option value="2">Karya Akhir</option>
        <option value="3">Proposal Tesis</option>
        <option value="4">Usulan Penelitian</option>
        <option value="5">Seminar Hasil Penelitian S3</option>
        <option value="6">Pra Promosi</option>
        <option value="7">Promosi</option>
        <option value="8">Tesis</option>
        <option value="9">Lain-lain</option>
    </td>
  </tr>
  <tr>
    <td>Mahasiswa</td>
    <td>
      <select id="namamhs" name="priority" size="1">
        <option value="Low">Andi</option>
        <option value="Normal"></option>
        <option value="High"></option>
        </select>
    </td>
  </tr>
  <tr>
    <td>Judul MKS</td>
    <td>
      <input id="judulmks" type="text" name="name">
    </td>
  </tr>
  <tr>
    <td>Pembimbing 1</td>
    <td>
      <select name="priority" size="1">
        <option value="Low">Ani</option>
        <option value="Normal"></option>
        <option value="High"></option>
        </select>
    </td>
  </tr>
  <tr>
    <td>Pembimbing 2</td>
    <td>
      <select name="priority" size="1">
        </select>
    </td>
  </tr>
  <tr>
    <td>Pembimbing 3</td>
    <td>
      <select name="priority" size="1">
        </select>
    </td>
  </tr>
  <tr>
    <td>Penguji 1</td>
    <td>
      <select id="penguji" name="priority" size="1">
        <option value="Low">Alief</option>
        <option value="Normal"></option>
        <option value="High"></option>
        </select>
    </td>
  </tr>
  <tr>
    <td></td>
    <td>
      <button type="submit" value="Send" style="margin-top:15px;">+ Tambah Penguji</button>
    </td>
  </tr>
  <tr>
    <td>
      <button type="submit" value="Simpan" style="margin-top:15px;">Simpan</button>
    </td>
    <td>
      <button type="submit" value="batal" style="margin-top:15px;">Batal</button>
    </td>
  </tr>
  </form>
</table>

</body>
</html>