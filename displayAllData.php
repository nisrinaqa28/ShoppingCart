<?php include'koneksi.php' ?>

<html> 
    <head>
        

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
        <h2 class ="row justify-content-center">Data Barang</h2>
        <table class="table table-striped table-bordered border-dark table-color w-auto" align="center">
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Foto</th>  
                <th>Harga</th>
                <th>Stok</th>
                <th>Berat Barang (Kg)</th>
                <th>Aksi</th>
            </tr>
        <?php
            $sql = 'SELECT * FROM data_barang';
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td> <?php echo $row['kode_barang']; ?> </td>
                        <td> <?php echo $row['nama_barang']; ?> </td>
                        <td> <?php echo "<img src='foto/$row[foto]' width='200' height='70' />";?></td>
                        <td> <?php echo $row['harga']; ?> </td>
                        <td> <?php echo $row['stok']; ?> </td>
                        <td> <?php echo $row['berat_barang']; ?> </td>
                        <td><a href="add_to_shopping_cart.php?kode_barang=<?php echo $row['kode_barang']?>">Pilih</a></td>
                    </tr>
                <?php
                }
            }
            else {
                echo "0 results";
            }
        ?>       
        </table>
        <div class="text-center">
        <a href="export_pdf.php" class="btn btn-primary">Export PDF</a>
        </div>
    </body>
</html>