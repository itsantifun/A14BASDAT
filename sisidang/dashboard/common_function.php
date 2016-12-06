<?php
	function getJenisMKS($id){
		$conn = connectDB();
		$sql = "SELECT * FROM JENISMKS WHERE id=$id" ;
		$result = pg_query($conn, $sql);
		$mks= pg_fetch_array($result);
		return $mks['namamks'];
	}
	
	function getMahasiswa($npm){
		$conn = connectDB();
		$sql = "SELECT * FROM Mahasiswa WHERE npm='$npm'" ;
		$result = pg_query($conn, $sql);
		$mahasiswa= pg_fetch_array($result);
		return $mahasiswa['nama'];
	}
	
	function getMKS($idmks){
		$conn = connectDB();
		$sql = "SELECT * FROM MATA_KULIAH_SPESIAL WHERE idmks='$idmks'" ;
		$result = pg_query($conn, $sql);
		$arr= pg_fetch_array($result);
		return $arr;
	}
	
	function getDosenPenguji($idmks){
		$conn = connectDB();
		$sql = "SELECT * FROM DOSEN_PENGUJI
			WHERE idmks='$idmks'";
		$result = pg_query($conn, $sql);
		$dosen = "";
		while($dosenidmks = pg_fetch_array($result)){
			$nip = $dosenidmks['nipdosenpenguji'];
			$sql = "SELECT * FROM DOSEN
				WHERE nip='$nip'" ;
			$result2 = pg_query($conn, $sql);
			$row = pg_fetch_array($result2);
			$dosen = $dosen."-".$row['nama']."<br>";
		}
		return $dosen;
	}

	function getDosenPembimbing($idmks){
		$conn = connectDB();
		$sql = "SELECT * FROM DOSEN_PEMBIMBING
			WHERE idmks='$idmks'" ;
		$result = pg_query($conn, $sql);
		$dosenidmks= pg_fetch_array($result);
		$nip = $dosenidmks['nipdosenpembimbing'];
		$sql = "SELECT * FROM DOSEN
			WHERE nip='$nip'" ;
		$result = pg_query($conn, $sql);
		$dosen = pg_fetch_array($result);
		return $dosen['nama'];
	}
	
	function getWaktu($idmks){
		$conn = connectDB();
		$sql = "SELECT * FROM JADWAL_SIDANG
			WHERE idmks='$idmks'";
		$result = pg_query($conn, $sql);
		$waktu= pg_fetch_array($result);
		return $waktu;
	}
	function getDosenPenguji2($idmks,$namaea){
		$conn = connectDB();
		$sql = "SELECT * FROM DOSEN_PENGUJI
			WHERE idmks='$idmks'";
		$result = pg_query($conn, $sql);
		while($dosenidmks = pg_fetch_array($result)){
			$nip = $dosenidmks['nipdosenpenguji'];
			$sql = "SELECT * FROM DOSEN
				WHERE nip='$nip'" ;
			$result2 = pg_query($conn, $sql);
			$row = pg_fetch_array($result2);
			$dosen =$row['nama'];
			if ($dosen == $namaea)
				return $dosen;
		}
		return "salah";
		
	}
	
	function getDosenPembimbing2($idmks,$namaea){
		$conn = connectDB();
		$sql = "SELECT * FROM DOSEN_PEMBIMBING
			WHERE idmks='$idmks'";
		$result = pg_query($conn, $sql);
		while($dosenidmks = pg_fetch_array($result)){
			$nip = $dosenidmks['nipdosenpembimbing'];
			$sql = "SELECT * FROM DOSEN
				WHERE nip='$nip'" ;
			$result2 = pg_query($conn, $sql);
			$row = pg_fetch_array($result2);
			$dosen =$row['nama'];
			if ($dosen == $namaea)
				return $dosen;
		}
		return "salah";
	}
?>