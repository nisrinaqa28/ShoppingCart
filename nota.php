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
        <div class="container">
        <?php
            include "koneksi.php";
            $ambil = $conn->query("SELECT * FROM transaksi WHERE no_transaksi='$_GET{no_transaksi}'");
            $nota = $ambil->fetch_assoc()?>

            <pre><?php print_r($nota)?></pre>
            <p>
                Tanggal: <?php echo $nota['tanggal'];?> <br>
                Nama: <?php echo $nota['nama_pembeli'];?> <br>
                Nomor Handphone: <?php echo $nota['no_telepon'];?> <br>
                Alamat: <?php echo $nota['alamat'];?> <br>
                Kecamatan: <?php echo $nota['kecamatan'];?> <br>
                Kota: <?php echo $nota['kota'];?> <br>
                Kode Pos: <?php echo $nota['kode_pos'];?> <br>
                Tarif Ongkos Kirim: <?php echo $nota['tarif_ongkir'];?> <br>
                Total Penjualan: <?php echo $nota['total_penjualan'];?>
            </p>
        </div>
    </body>
</html>