<?php

include "koneksi.php";
session_start();
	$nama_pembeli = $_POST['nama_pembeli'];
	$nomor_hp = $_POST['nomor_hp'];
	$alamat = $_POST['alamat'];
	$kecamatan = $_POST['kecamatan'];
	$kota = $_POST['kota'];
	$total_transaksi = $_SESSION['total'];
	
	if($nama_pembeli != '' || $nomor_hp != '' || $alamat != '' || $kecamatan != '' || $kota != '')
	{
		$queryInsert = "INSERT INTO tabel_transaksi_penjualan SET nama_pembeli='$nama_pembeli', nomor_hp='$nomor_hp', alamat='$alamat', kota ='$kota', total_transaksi = '$total_transaksi', kecamatan = '$kecamatan'";
		$resultInsert = mysqli_query($conn, $queryInsert);
		$i = 0;
		
		$queryCari ="SELECT id_transaksi_penjualan FROM tabel_transaksi_penjualan 
		WHERE nama_pembeli='$nama_pembeli' ORDER BY id_transaksi_penjualan DESC Limit 1";
		$resultCari = $conn->query($queryCari);
		$cari = $resultCari->fetch_assoc();
		$_SESSION['id_transaksi'] = $cari['id_transaksi_penjualan'];
		
		while($i<count($_SESSION['nama_barang'])):
			$kode_barang = $_SESSION['kode_barang'][$i];
			$jumlah_jual = $_SESSION['quantity'][$i];
			$harga_jual = $_SESSION['harga'][$i];
			$queryInsert2 = "INSERT INTO tabel_jual SET id_transaksi_penjualan = ".$cari['id_transaksi_penjualan'].", kode_barang = $kode_barang, jumlah_jual = $jumlah_jual, harga_jual = $harga_jual";
			$queryUpdate = "UPDATE tabel_barang SET stok = stok - $jumlah_jual WHERE kode_barang='$kode_barang'";
			$resultInsert2 = mysqli_query($conn, $queryInsert2);
			$resultUpdate = mysqli_query($conn, $queryUpdate);
			$i = $i + 1;
		endwhile;		
		if($resultInsert){
			if($resultInsert2){
				if($resultUpdate){
					unset($_SESSION['kode_barang']);
					unset($_SESSION['nama_barang']);
					unset($_SESSION['harga']);
					unset($_SESSION['quantity']);
					unset($_SESSION['total']);
					header('Location:template.php?callInvoice=true');	
				}else{ echo "update error"; }
			}else{ echo "insert error"; }
		}else{ echo "Input Gagal"; 	}
	}
	mysqli_close($conn);

?>