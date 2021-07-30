<?php
	session_start();
	include "koneksi.php";
?>	


<html>
<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">       
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

    <style>
        .table-striped>tbody>tr:nth-child(odd)>td, 
        .table-striped>tbody>tr:nth-child(odd)>th {
            background-color: lightblue;
        }
        .table-striped>tbody>tr:nth-child(even)>td, 
        .table-striped>tbody>tr:nth-child(even)>th {
           background-color: white; 
        }
    </style>
</head>
<body>
	<h3> Ringkasan Belanja </h3>
	<table class="table table-striped table-bordered border-dark table-color" >
		<tr style="text-align: center;">
			<th>Nama Barang</th>
			<th>Foto</th>    
			<th>Kuantitas</th>
			<th>Harga Satuan</th>
			<th>Sub Total Harga</th>
			<th>Sub Total Berat</th>
		</tr>
		
		<?php 
			$total = 0;
			$total_berat=0;
			foreach ($_SESSION['cart'] as $kode_barang => $jumlah):
		?>
			<?php 
				$sql = $conn->query("SELECT * FROM data_barang WHERE kode_barang='$kode_barang'");
				$row = $sql->fetch_assoc()?>
				<tr>
					<td><?php echo $row["nama_barang"] ?></td>
					<td><?php echo "<img src='foto/$row[foto]' width='90' height='120' />";?></td>
					<td><?php echo $jumlah ?></td>
					<td><?php echo $row["harga"] ?></td>
					<td><?php echo $row["harga"]*$jumlah ?></td>
					<?php $total = $total + ($row["harga"]*$jumlah);?>
					<td><?php echo $row["berat_barang"]*$jumlah." kg"?></td>
                    <?php 
                        $total_berat = $total_berat + ($row["berat_barang"]*$jumlah);
                        if ($total_berat < 1){
                            $beratTotal = 1;
                        }else{
                            $split = explode(".",$total_berat);
                            //echo strlen($split[1]);
                            if($split[1] > (3 * pow(10, strlen($split[1])-1))){
                                $beratTotal = $split[0] + 1;
                            }else{
                                $beratTotal = $split[0];
                            }
                        }
                    ?>
				</tr>
			<?php endforeach?>
			<tr style="text-align: center;">
				<th colspan="4">TOTAL</th>
				<th><?php echo $total?></th>
				<th><?php echo $total_berat." kg (".$beratTotal." kg)"?></th>
			</tr>
	</table>
	<br></br>
	<title> Checkout </title>
	<h3> Checkout </h3>
	<p> Silahkan isi data berikut. </p>
	<table style = "width:50%" class="table table-striped table-color table-borderless">
		<form action = "" method="post" enctype = "multipart/form-data">
			<tr>
				<td>Nama Pembeli</td>
				<td><input class = "rounded-3" type = "text" name = "nama_pembeli"></td>
			</tr>
			<tr>
				<td>Nomor Handphone</td>
				<td><input class = "rounded-3" type = "text" name = "no_telepon"></td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td><input class = "rounded-3" type = "text" name = "alamat"></td>
			</tr>
			<tr>
				<td>Kecamatan</td>
				<td><input class = "rounded-3" type = "text" name = "kecamatan"></td>
			</tr>
			<tr>
				<td>Kota</td>
				<td><input class = "rounded-3" type = "text" name = "kota"></td>
			</tr>
			<tr>
				<td>Kode Pos</td>
				<td><input class = "rounded-3" type = "text" name = "kode_pos"></td>
			</tr>
			<tr> 
				<td><button class = "btn btn-danger" type = "submit" value = "submit" name = "submit">Submit</button></td>
				<td></td>
			</tr>
		</form>
	</table>

</body>
</html>

<?php
	if(isset($_POST['submit'])){
		$tanggal = date("Y-m-d");
		$nama_pembeli = $_POST['nama_pembeli'];
		$no_telepon = $_POST['no_telepon'];
		$alamat = $_POST['alamat'];
		$kecamatan = $_POST['kecamatan'];
		$kota = $_POST['kota'];
		$kode_pos = $_POST['kode_pos'];
		
		if($nama_pembeli != '' || $no_telepon != '' || $alamat != '' || $kecamatan != '' || $kota != '' || $kode_pos != ''){
			
			$ambil = $conn->query("SELECT * FROM ongkos_kirim WHERE kecamatan_tujuan = '$kecamatan'");
			$ongkir = $ambil->fetch_assoc();
			$tarif = $ongkir['ongkir_perkg'] * $beratTotal;

			$total_pembelian = $total+$tarif;
			
			$conn->query("INSERT INTO transaksi (tanggal, nama_pembeli, no_telepon, alamat, kecamatan, kota, kode_pos, tarif_ongkir, total_penjualan) VALUES ('$tanggal','$nama_pembeli','$no_telepon','$alamat','$kecamatan','$kota','$kode_pos', '$tarif','$total_pembelian')");
					
			$no_transaksi_jual= $conn->insert_id;
			foreach ($_SESSION['cart'] as $kode_barang => $jumlah):
				$sql = $conn->query("SELECT * FROM data_barang WHERE kode_barang='$kode_barang'");
                $row = $sql->fetch_assoc();
				$harga_jual = $row['harga']*$jumlah;
				$conn->query("INSERT INTO jual (no_transaksi, kode_barang, jumlah_jual, harga_jual) VALUES ('$no_transaksi_jual', '$kode_barang', '$jumlah', '$harga_jual')");
				$conn->query("UPDATE data_barang SET stok = stok - $jumlah WHERE kode_barang='$kode_barang'");
			endforeach;
		}

		unset($_SESSION['cart']);
		echo"<script>alert('Pembelian Sukses');</script>";
		echo"<script>location='nota.php?no_transaksi=$no_transaksi_jual';</script>";
	}
?>