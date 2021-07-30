<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('logo.png',10,6,20);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'Toko ABC',1,0,'C');
        // Line break
        $this->Ln(20);
        //buat garis horizontal
        $this->Line(10,25,200,25);
    }

    // Page footer
    function Content()
    {
        include_once("koneksi.php");
        $sql = "SELECT kode_barang, nama_barang, harga, stok FROM data_barang";
        $resultset = mysqli_query($conn, $sql) or die ("database error".mysqli_error($conn));
        $this->SetFont('Arial','B',12);

        $this->Cell(47.5,12,"kode_barang",1);
        $this->Cell(47.5,12,"nama_barang",1);
        $this->Cell(47.5,12,"harga",1);
        $this->Cell(47.5,12,"stok",1);

        while ($rows = mysqli_fetch_assoc($resultset)){
            $this->SetFont('Arial','',12);
            $this->Ln();
            foreach($rows as $column){
                $this->Cell(47.5,12,$column,1);
            }
        }
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        //buat garis horizontal 
        $this->Line(10,$this->GetY(),200,$this->GetY());
        // Arial italic 8
        $this->SetFont('Arial','I',9);
        // Page number
        $this->Cell(0,10,'Halaman '.$this->PageNo().'/{nb}',0,0,'R');
    }
}

    // Instanciation of inherited class
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->Content();
    $pdf->Output();
?>