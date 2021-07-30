<?php 
    session_start();
    $kode_barang = $_GET['kode_barang'];

    if (isset($_SESSION['cart'][$kode_barang])){
        $_SESSION['cart'][$kode_barang]+=1;
    }else{
        $_SESSION['cart'][$kode_barang]=1;
    }

    header('location:template.php?callDisplayCart=true')
?>
