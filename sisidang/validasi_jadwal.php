<?php
$mahasiswa = $_GET["namamahasiswa"];
$tanggal = "";
$jammulai = "";
$jamselesai = "";
$ruangan = $_GET["ruangan"];
$penguji = array();
$hardcopy = false;
$tipeoperasi = $_GET["tipeoperasi"];
$err = 0;

if(isset($_GET["tanggal"])) $tanggal = $_GET["tanggal"];
if(isset($_GET["jammulai"])) $jammulai = $_GET["jammulai"];
if(isset($_GET["jamselesai"])) $jamselesai = $_GET["jamselesai"];

if(isset($_GET["sethardcopy"])) $hardcopy = true;

echo $mahasiswa."<br>";

$countdsn = 0;
while(isset($_GET["penguji".$countdsn])){
	array_push($penguji, $_GET["penguji".$countdsn]);
	$countdsn++;
}

print_r($penguji); echo "<br>";
echo "jumlah dosen = ".$countdsn."<br>";




if($tanggal == "" || $jammulai == "" || $jamselesai == ""){
	
	if($tanggal == "" && $jammulai == "" && $jamselesai == "") $err = 1;
	elseif ($tanggal == "" && $jammulai == "") $err = 2;
	elseif ($tanggal == "" && $jamselesai == "") $err = 3;
	elseif ($jammulai == "" && $jamselesai == "") $err = 4;
	elseif ($tanggal == "") $err = 5;
	elseif ($jammulai == "") $err = 6;
	elseif ($jamselesai == "") $err = 7;
	
	header("location: tambah_jadwal.php?error=".$err);
}else {
	
	$test_date = explode('-', $tanggal);

	if(count($test_date) != 3){
		$err = 10;
		header("location: tambah_jadwal.php?error=".$err);
	}elseif (!preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9])/", $jammulai) || !preg_match("/(2[0-3]|[01][0-9]):([0-5][0-9])/", $jamselesai)) {
		$err = 11;
		header("location: tambah_jadwal.php?error=".$err);
	}elseif (!checkdate($test_date[0], $test_date[0], $test_date[0])) {
		$err = 12;
		header("location: tambah_jadwal.php?error=".$err);
	}


	$idmks = "";
	$idjadwal = 0;
	
	$konek = pg_connect("host=localhost user=postgres password=test123"); //ganti ke database psql nya!
	//$konek = pg_connect("host=db.cs.ui.ac.id user=kevin.kristian password="); //test

	if(!$konek){
		die ("koneksi error nih :(");
	}
	
	$sql = "SELECT idmks FROM tugas_tk.mahasiswa as m JOIN tugas_tk.mata_kuliah_spesial as mk ON m.npm = mk.npm where m.nama= '$mahasiswa' LIMIT 1";
	$result = pg_query($konek,$sql);
	$row = pg_fetch_assoc($result);
	$idmks = $row["idmks"];
	
	echo "idmks ".$idmks."<br>";
	
	$sql = "SELECT idjadwal FROM tugas_tk.jadwal_sidang ORDER BY idjadwal DESC LIMIT 1";
	$result = pg_query($konek,$sql);
	$row = pg_fetch_assoc($result);
	$idjadwal = $row["idjadwal"];
	$idjadwal++;
	
	echo "idjadwal = ".$idjadwal." test ".$row["idjadwal"];	

	$sql = "SELECT idruangan FROM tugas_tk.ruangan where namaruangan = '$ruangan'";
	$result = pg_query($konek,$sql);
	$row = pg_fetch_assoc($result);
	$idruangan = $row["idruangan"];

	echo "<br>id ruangan =".$idruangan;

	$sql = "SELECT * FROM tugas_tk.jadwal_sidang WHERE tanggal = '$tanggal' AND jammulai = '$jammulai' AND jamselesai = '$jamselesai' AND idruangan=$idruangan";
	$result = pg_query($konek,$sql);
	
	if(pg_num_rows($result) > 0){
		$err = 8;
		header("location: tambah_jadwal.php?error=".$err);
	}


	if($err == 0 && $tipeoperasi == "tambah"){

		$sql = "SELECT * FROM tugas_tk.jadwal_sidang WHERE idmks = $idmks";
		$result = pg_query($konek,$sql);

		if(pg_num_rows($result) > 0){
			$err = 9;
			header("location: tambah_jadwal.php?error=".$err);
		}


		$status1 = false;
		$status2 = true;

		$sql = "INSERT INTO tugas_tk.jadwal_sidang VALUES ($idjadwal,$idmks,'$tanggal','$jammulai','$jamselesai',$idruangan)";

		if(pg_query($konek,$sql)){
			echo "<br>berhasil!";
			$status1 = true;
		}else{
			$status1 = false;
		}

		for ($i=0; $i < $countdsn; $i++) { 
			$nip = "";
			$sql = "SELECT nip FROM tugas_tk.dosen WHERE nama = '$penguji[$i]'";
			$result = pg_query($konek,$sql);
			$row = pg_fetch_assoc($result);
			$nip = $row["nip"];

			$sql = "INSERT INTO tugas_tk.dosen_penguji VALUES ($idmks,'$nip')";

			if(pg_query($konek,$sql)){
				$status2 = true&&$status2;
			}else{
				$status2 = false&&$status2;
			}

		}

		if($status1 && $status2){
			echo "kelar sudah";
			header("location: index.php");
		}else{
			$err = 99;
			header("location: tambah_jadwal.php?error=".$err);
		}

	}elseif ($err == 0 && $tipeoperasi == "ubah") {
		$status1 = false;
		$status2 = true;

		$sql = "SELECT * FROM tugas_tk.jadwal_sidang WHERE idmks = $idmks";
		$result = pg_query($konek,$sql);
		$row = pg_fetch_assoc($result);
		$idjadwalupt = $row["idjadwal"];

		$sql = "UPDATE tugas_tk.jadwal_sidang SET tanggal = '$tanggal', jammulai = '$jammulai', jamselesai = '$jamselesai', idruangan = $idruangan WHERE idjadwal = $idjadwalupt";

		if(pg_query($konek,$sql)){
			echo "<br>berhasil!";
			$status1 = true;
		}else{
			$status1 = false;
		}

		$sql = "DELETE FROM tugas_tk.dosen_penguji WHERE idmks = $idmks";
		$result = pg_query($konek,$sql);


		for ($i=0; $i < $countdsn; $i++) { 
			$nip = "";
			$sql = "SELECT nip FROM tugas_tk.dosen WHERE nama = '$penguji[$i]'";
			$result = pg_query($konek,$sql);
			$row = pg_fetch_assoc($result);
			$nip = $row["nip"];

			$sql = "INSERT INTO tugas_tk.dosen_penguji VALUES ($idmks,'$nip')";

			if(pg_query($konek,$sql)){
				$status2 = true&&$status2;
			}else{
				$status2 = false&&$status2;
			}

		}

		if($status1 && $status2){
			echo "kelar sudah";
			header("location: index.php");
		}else{
			$err = 99;
			header("location: tambah_jadwal.php?error=".$err);
		}


	}
	
}



?>
