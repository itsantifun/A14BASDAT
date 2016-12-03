<?php
	session_start();
	if (isset($_SESSION["role"])) {
		
		$roleList = array("admin.php", "mahasiswa.php","dosen.php");
		$role = $_SESSION["role"];
		$activities = array();
		if ($role == "MHS") {
			$activities[0] = $roleList[1];
		} 
		elseif ($role == "DOSEN") {
			$activities[0] = $roleList[2];
		}
		elseif ($role == "ADMIN") {
			$activities[0] = $roleList[0];
		}
		$activities[0] = "dashboard/".$activities[0];
		header("Location: ".$activities[0]);
	} else {
		header("Location: index.php");
	}
	
?>
