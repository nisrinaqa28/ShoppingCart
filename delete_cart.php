<?php
    session_start();
    $kode_barang=$_GET["kode_barang"];
    unset($_SESSION["cart"][$kode_barang]);

    header("location:template.php?callDisplayCart=true");
?>