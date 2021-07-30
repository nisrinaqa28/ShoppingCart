<?php include'koneksi.php' ?>

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
    <nav class="navbar navbar-expand-sm bg-info navbar-dark p-3 w-100">
        <a class="navbar-brand" href="?callTabelBarang=true">
            <img src="logo.png" alt="logo" style="width:40px;">
        </a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="?callTabelBarang=true">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?callDisplayCart=true">Cart</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Logout</a>
            </li>
        </ul>
    </nav>

    <section class = "content p-2 w-100">
        <div class="content">
            <?php
                if(isset($_GET["callTabelBarang"])){
                    include 'displayAllData.php';
                }else if(isset($_GET["callCart"])){
                    include 'add_to_shopping_cart.php';
                }else if(isset($_GET["callDisplayCart"])){
                    include 'display_shopping_cart.php';
                }else if(isset($_GET["callDestroy"])){
                    include 'destroy.php';
                }else if(isset($_GET["callDelete"])){
                    include 'delete_cart.php';
                }else if(isset($_GET["callFormCheckout"])){
                    include 'form_checkout.php';
                }else if(isset($_GET["callNota"])){
                    include 'nota.php';
                }
            ?>
        </div>
    </section>
</body>
</html>