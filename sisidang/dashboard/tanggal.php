<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <!-- Trigger the modal with a button -->
  

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">informasi sidang</h4>
        </div>
        <div class="modal-body">
         <table class="table">
			<h3>
			PENGUJIAN
			<h3>
			<tr>
				<th>Jenis Sidang</th>
				<th>Mahasiswa</th>	
				<th>Waktu dan Lokasi</th>
				<th>Penguji</th>
			</tr>
			<?php
			//require 'calendar.php';
			$sql = "SELECT IDMKS FROM DOSEN_PEMBIMBING,
				DOSEN WHERE username='$username' AND nip=nipdosenpembimbing";
			$result = pg_query($conn, $sql);
				while($row = pg_fetch_array($result)){
					$mks=getMKS($row['idmks']);
					$jenisMks = getJenisMKS($mks['idjenismks']);
					$mahasiswa = getMahasiswa($mks['npm']);
					$penguji = getDosenPenguji($mks['idmks']);
					$waktu = getWaktu($mks['idmks']);
					if(date("m",strtotime($waktu['tanggal'])) == date("m")){
			?>
			<tr>
			
				<td><?=$jenisMks?></td>
				<td><?=$mahasiswa?></td>
				<td><?=$waktu['tanggal']," ",$waktu['jammulai'],"-",$waktu['jamselesai']?></td>
				<td><?=$penguji?></td>
			</tr>
			
					<?php }  }
				?>
			</table>
			<table class="table">
			<h3>
			BIMBINGAN
			<h3>
			<tr>
				<th>Jenis Sidang</th>
				<th>Mahasiswa</th>	
				<th>Waktu dan Lokasi</th>
				<th>pembimbing</th>
			</tr>
			<?php
			$sql = "SELECT IDMKS FROM DOSEN_PENGUJI,
				DOSEN WHERE username='$username' AND nip=nipdosenpenguji";
			$result = pg_query($conn, $sql);
				while($row = pg_fetch_array($result)){
					$mks=getMKS($row['idmks']);
					$jenisMks = getJenisMKS($mks['idjenismks']);
					$mahasiswa = getMahasiswa($mks['npm']);
					$pembimbing = getDosenPembimbing($mks['idmks']);
					$waktu = getWaktu($mks['idmks']);
					if(date("m",strtotime($waktu['tanggal'])) == date("m")){
			?>
			<tr>
			
				<td><?=$jenisMks?></td>
				<td><?=$mahasiswa?></td>
				<td><?=$waktu['tanggal']," ",$waktu['jammulai'],"-",$waktu['jamselesai']?></td>
				<td><?=$pembimbing?></td>
			</tr>
			
					<?php }}
				?>
			</table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

</body>
</html>