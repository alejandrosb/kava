<?php
//Example FPDF script with PostgreSQL
//Ribamar FS - ribafs@dnocs.gov.br
error_reporting(E_ALL);
ini_set('display_errors', '1');

require('fpdf.php');
include ("../conexion/conectar.php");
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetTitle('Reporte');   

//Set font and colors
$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0,0,0);
//Connection and query
$consulta = mysqli_query($con,"SELECT descripcion FROM tienda LIMIT 1");
$nom = mysqli_fetch_array($consulta);
$ntenda="Reporte de Clientes";
//pg_result($rtienda,0,'nombretienda');
//$ndire="Nombre de la tienda";
/*pg_result($rtienda,0,'direccion');*/

/*$verfecha="SELECT LOCALTIMESTAMP(1) AS FECHA";
$rf=pg_query($verfecha) or die (pg_last_error());*/
$ffecha=date("Y-m-d");
//pg_result($rf,0,'FECHA');

$pdf->Cell(135,5,$nom['descripcion'],0,0,'L',0);
$pdf->Cell(30,5,$ffecha,0,1,'R',1);
$pdf->Cell(135,5,$ntenda,0,0,'L',0);
$pdf->Cell(30,5,'',0,1,'R',1);
// Line break
$pdf->Ln(5);
$pdf->Cell(135,5,'LISTADO DE CLIENTES',0,0,'L',0);
// Line break
$pdf->Ln(5);

//Table header
$pdf->Cell(50,10,'Codigo',0,0,'L',1);
$pdf->Cell(50,10,'Nombre',0,0,'L',1);
$pdf->Cell(25,10,'Fecha',0,0,'L',1);
$pdf->Cell(25,10,'Total',0,1,'L',1);

//Restore font and colors
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(225,255,255);
$pdf->SetTextColor(0);

$result = mysqli_query($con,"SELECT venta.cliente,cliente.nombre ,venta.fecha, sum(venta.total) as total FROM `venta` inner join cliente on venta.cliente=cliente.codcli group by fecha,cliente.codcli DESC");

while($row = mysqli_fetch_array($result)) {
	$siape=$row['cliente'];
	$nome=$row['nombre'];
	$telef=$row['fecha'];
	$usu=$row['total'];
	$pdf->Cell(50,5,$siape,0,0,'L');
	$pdf->Cell(50,5,$nome,0,0,'L');
	$pdf->Cell(25,5,$telef,0,0,'L');
	$pdf->Cell(25,5,$usu,0,1,'L');
}
mysqli_close($con);
$pdf->Output('Listado_usuarios.pdf','I');
?>
