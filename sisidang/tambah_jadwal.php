<?php
$opsimhs = "";
$opsirng="";
$opsidsn="";
$err = "";

if(isset($_GET["error"])){
	
	switch ($_GET["error"]) {
    case 1:
        $err = "require tanggal, jam mulai, & jam selesai";
        break;
    case 2:
        $err = "require tanggal & jam mulai";
        break;
    case 3:
        $err = "require tanggal & jam selesai";
        break;
	case 4:
		$err = "require jam mulai & jam selesai";
		break;
	case 5:
		$err = "require tanggal";
        break;
    case 6:
		$err = "require jam mulai";
        break;
    case 7:
		$err = "require jam selesai";
        break;
    case 8:
		$err = "error insert jadwal, jadwal & tempat bentrok!";
        break;
    case 9:
		$err = "error insert jadwal, jadwal sudah ada silahkan gunakan [<a href='ubah_jadwal.php'>ubah jadwal!</a>]";
        break;
    case 10:
		$err = "format tanggal salah!";
        break;
    case 11:
		$err = "FORMAT JAM SALAH! HH:MM!! 24-HR FORMAT!!!!";
        break;
    case 12:
		$err = "FORMAT TANGGALAN SALAH! MM-DD-YYYY!!!";
        break;
    default:
        $err = "undefined error!";
	}
}

$konek = pg_connect("host=localhost user=postgres password=test123"); //ganti ke alamat database
//$konek = pg_connect("host=db.cs.ui.ac.id user=kevin.kristian password=");

if(!$konek){
	die ("koneksi error nih :(");
}

$sql = "SELECT nama FROM tugas_tk.mahasiswa";
$result = pg_query($konek,$sql);

if(pg_num_rows($result) > 0){
	while($row = pg_fetch_assoc($result)){$opsimhs .= '<option>'.$row["nama"].'</option>';}
}

$sql = "SELECT namaruangan FROM tugas_tk.ruangan";
$result = pg_query($konek,$sql);

if(pg_num_rows($result) > 0){
	while($row = pg_fetch_assoc($result)){$opsirng .= '<option>'.$row["namaruangan"].'</option>';}
}

$sql = "SELECT nama FROM tugas_tk.dosen";
$result = pg_query($konek,$sql);

if(pg_num_rows($result) > 0){
	while($row = pg_fetch_assoc($result)){$opsidsn .= '<option>'.$row["nama"].'</option>';}
}

?>
<!DOCTYPE html>
<html lang="eng">
<head>
	<title>tambah_jadwal</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>
	<h1>Tambah Jadwal</h1>
	<form action="validasi_jadwal.php" method="GET">
		<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"><label>Mahasiswa</label></div>
			<div class="col-md-2"><select name="namamahasiswa" id='namamahasiswa'><?php echo $opsimhs;?></select></div>
		</div>
		<div class="row">
			<div class="col-md-2"><label>Tanggal</label> </div>
			<div class="col-md-2"><input name="tanggal" type="text" id='tanggal' placeholder="mm-dd-yyyy"></div>
		</div>
		<div class="row">
			<div class="col-md-2"><label>Jam Mulai</label></div>
			<div class="col-md-2"><input name="jammulai" type="text" id="jammulai" placeholder="hh:mm 24-hr"></div>
		</div>
		<div class="row">
			<div class="col-md-2"><label>Jam Selesai</label> </div>
			<div class="col-md-2"><input type="text" name="jamselesai" id="jamselesai" placeholder="hh:mm 24-hr"></div>
		</div>
		<div class="row">
			<div class="col-md-2"><label>Ruangan</label></div>
			<div class="col-md-2"><select id="ruangan" name="ruangan"><?php echo $opsirng?></select></div>
		</div>
		<div id="penguji">
		<div class="row">
			<div class="col-md-2"><label>Penguji 1</label></div>
			<div class="col-md-2"><select id="namapenguji0" name="penguji0"><?php echo $opsidsn ?></select></div>
		</div>
		</div>
		<div class="row">
			<div class="col-md-2"><label>Pengumpulan Hardcopy</label></div>
			<div class="col-md-2"><input type="checkbox" id="sethardcopy" name="sethardcopy"></div>
		</div>
		<div class="row">
			<div class="col-md-2"><button type="button" onclick="addpenguji()">Tambah Penguji</button> </div>
			<div class="col-md-2"><button type="button" onclick="resetpenguji()"> reset Penguji</button></div>
		</div>
		<?php if($err != "") echo '<div class="row"><div class="col-md-4"><p class="bg-danger">'.$err.'</p></div></div>'?>
		<div class="row">
			<div class="col-md-2"><button>simpan</button></div>
			<div class="col-md-2"><button type='button'>Batal</button></div>
		</div>
		</div>
		<div class="hidden"><input type="text" name="tipeoperasi" value="tambah"></div>
	</form>
	<script>
		var i = 1;
		
		function addpenguji(){
			document.getElementById("penguji").innerHTML += '<div class="row"><div class="col-md-2"><label>Penguji '+(i+1)+'</label></div><div class="col-md-2"><select id="namapenguji'+i+'" name="penguji'+i+'"><?php echo $opsidsn ?></select></div></div>';
			i++;
		}
		function resetpenguji(){
			i = 0;
			document.getElementById("penguji").innerHTML = '<div class="row"><div class="col-md-2"><label>Penguji '+(i+1)+'</label></div><div class="col-md-2"><select id="namapenguji'+i+'" name="penguji'+i+'"><?php echo $opsidsn ?></select></div></div>';	
			i = 1;
		}
	</script>
</body>

</html>
