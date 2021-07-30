<?php 
    session_start();
    include 'koneksi.php';
?>

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
        .table-center th, td{
            text-align: center;
        }
    </style>
</head>

<body>
    <h2 class ="row justify-content-center">Shopping Cart</h2>
    <table class="table table-striped table-bordered border-dark table-color w-auto" border ="1" align="center">
        <tr style="text-align: center;">
            <th>Nama Barang</th>
			<th>Foto</th>    
            <th>Kuantitas</th>
            <th>Harga Satuan</th>
            <th>Sub Total Harga</th>
            <th>Sub Total Berat</th>
            <th>Aksi</th>
        </tr>
        
        <?php 
            $total = 0;
            $total_berat = 0;
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
                    <td><a href="template.php?callDelete=true&kode_barang=<?php echo $kode_barang ?>" class="btn btn-danger">Hapus</a></td>
                </tr>
            <?php endforeach?>
            <tr style="text-align: center;">
                <th colspan="4">TOTAL</th>
                <th><?php echo $total?></th>
                <th><?php echo $total_berat." kg (".$beratTotal." kg)"?></th>
                <th><a href="template.php?callFormCheckout=true" class="btn btn-success">Checkout</a></th>
            </tr>
	</table>
    <div class="text-center">
        <a href="template.php?callTabelBarang=true" class="btn btn-primary">Lanjutkan Belanja</a>
        <a href="template.php?callDestroy=true" class="btn btn-danger">Kosongkan Keranjang</a>
    </div>
</body>
</html>