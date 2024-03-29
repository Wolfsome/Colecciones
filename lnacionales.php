<?php

require('common/libs/fpdf/fpdf.php');


  //Mostramos los errores
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

//Llamamos al archivo para conectarnos a la base de datos y obtener los datos de la inscripción
require_once('includes/conexion.php');

//Consultas para obtener los datos de las monedas nacionales
$sql = "SELECT monedas.*, paises.nombre AS nombrepais, paises.bandera, paises.divisa, e.descripcion AS estado_moneda, f.foto 
    FROM monedas 
    JOIN paises ON monedas.pais = paises.id 
    JOIN estado e ON monedas.estado = e.id
    LEFT JOIN fotos f ON monedas.id= f.id_moneda
    WHERE monedas.pais LIKE 'es%';";
$consulta = mysqli_query($con,$sql) or die(mysqli_errno($con));
$total = mysqli_num_rows($consulta);

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('common/public/images/monedas.png',5,5,50);
        // Salto de Línea
        $this->Ln(20);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        $this->Cell(0,10,iconv('utf-8','cp1252','Colección de Monedas - España'),0,0,'C');
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,iconv('utf-8','cp1252','Página '.$this->PageNo()),0,0,'C');
    }

    // Tabla coloreada
    function FancyTable($header, $data, $titulo)
    {

        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Salto de línea
        $this->Ln(10);
        $this->Cell(0,10,iconv('utf-8','cp1252','MONEDAS ESPAÑOLAS'),0,0,'C');
        $this->Ln(10);

        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255,165,0);
        $this->SetTextColor(255);
        $this->SetDrawColor(255,165,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B',9);

        // Cabecera
        $w = array(15,75, 40, 20, 20,20);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('','',8);
        // Datos
        $fill = false;
        $pos=1;
        while ($row = mysqli_fetch_assoc($data))
        {

            // Mostramos listado de monedas
            $this->Cell($w[0],6,$pos,'LR',0,'R',$fill);
            $this->Cell($w[1],6,iconv('utf-8','cp1252',$row['nombre']),'LR',0,'L',$fill);
            $this->Cell($w[2],6,iconv('utf-8','cp1252',$row['valor'].' '.$row['divisa']),'LR',0,'L',$fill);
            $this->Cell($w[3],6,$row['anno'],'LR',0,'R',$fill);
            $this->Cell($w[4],6,$row['estado'],'LR',0,'R',$fill);
            $this->Cell($w[5],6,$row['cantidad'],'LR',0,'R',$fill);
            $this->Ln();
            $fill = !$fill;
            $pos=$pos+1;
        }
        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
    }
}

$header = array("Orden","Moneda","Valor",iconv('utf-8','cp1252',"Año"),"Estado","Cantidad");

$pdf = new PDF();
$pdf->AddPage('P');
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(255,165,0);
$pdf->FancyTable($header,$consulta,'Monedas - España');

$pdf->AddPage('P');
$contador = 1;


$consulta_detalle = mysqli_query($con,$sql) or die(mysqli_errno($con));
while ($detalle = mysqli_fetch_array($consulta_detalle)){
    if($contador == 1){
        $pdf->SetXY(10,60);
    }
    $pdf->Line(10,56,200,56);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20,0,'Nombre:',0,0,'J');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(50,0,$detalle['nombre'],0,0,'J');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(15,0,'Valor:',0,0,'J');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(30,0,$detalle['valor'].' '.$detalle['divisa'],0,0,'J');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20,0,iconv('utf-8','cp1252','Año:'),0,0,'J');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(30,0,$detalle['anno'],0,0,'J');
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20,0,'Cantidad:',0,0,'J');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(30,0,$detalle['cantidad'],0,0,'J');
    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(55,0,iconv('utf-8','cp1252','Estado de Conservación:'),0,0,'J');
    $pdf->SetFont('Arial','',12);
    $pdf->Cell(10,0,iconv('utf-8','cp1252',$detalle['estado_moneda']),0,0,'J');
    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20,10,'Motivo:',0,0,'J');
    $pdf->SetFont('Arial','',12);
    $pdf->MultiCell(170,20,iconv('utf-8','cp1252',$detalle['motivo']),1,'J');
    $pdf->Ln(5);
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(20,0,'Fotos:',0,0,'J');
    $pdf->Cell(170,60,'',1);

    if($contador==1){
        $x=35;
        $y=96;
    }else{
        $x=35;
        $y=212;
    }

    if(isset($detalle['foto']))
        $pdf->Image('common/public/images/monedas/'.$detalle['foto'],$x,$y,80);
    else
        $pdf->Image('common/public/images/monedas/moneda.png',$x,$y,55);


    $pdf->Ln(80);
    $pdf->Line(10,170,200,170);
    
    if($contador==2){
        $pdf->AddPage('P');
        $contador = 1;
    }else{
        $contador++;
    }
}
$pdf->Output('I','Listado de Monedas Nacionales');
