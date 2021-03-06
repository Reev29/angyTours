<?php
session_start(); 


$FolioGrupo = $_GET["folio"];
$cantidad = $_SESSION["cant"];
require_once 'Conexion.php';
require_once 'Biblioteca.php';
require('../fpdf/fpdf.php');
$conexion = conectarse();

$clasula = "1.-El PRESENTE COMPROBANTE NO ES UN COMPROBANTE FISCAL.2.-ESTE COMPROBANTE NO ES PRESENTABLE ANTE EL PROVEEDOR DE SERVICIOS YA QUE NO ES UN CUPÓN DE SERVICIOS.
";

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
	// Logo
	// Arial bold 15
	$this->SetFont('Arial','B',8);
	// Movernos a la derecha
	$this->SetY(4);
	$this->Cell(150);

	// Título
	$this->Cell(60,5,'Comprobante de pago',0,2,'C');
	
	// Salto de línea
	$this->Ln(20);
}

// Pie de página
function Footer()
{
	// Posición: a 1,5 cm del final
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Número de página
	$this->Cell(0,10,'Page '.$this->PageNo().'/Comprobante de pago',0,0,'C');
}
	function SetCol($col)
{
    // Establecer la posición de una columna dada
    $this->col = $col;
    $x = 10+$col*65;
    $this->SetLeftMargin($x);
    $this->SetX($x);
}
function ChapterBody($file)
{
    // Abrir fichero de texto
    $txt = file_get_contents($file);
    // Fuente
    $this->SetFont('Times','',12);
    // Imprimir texto en una columna de 6 cm de ancho
    $this->MultiCell(60,5,$txt);
    $this->Ln();
    // Cita en itálica
    $this->SetFont('','I');
    $this->Cell(0,5,'(fin del extracto)');
    // Volver a la primera columna
    $this->SetCol(0);
}

}
$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$sql = "SELECT * FROM ventagrupo WHERE FolioGrupo = '$FolioGrupo'";

$resultado= @mysql_query($sql) or die(mysql_error());

						while ($datos = @mysql_fetch_assoc($resultado) ){

								$FolioVta = $datos['FolioGrupo'];
								$idViajero = $datos['idViajero'];
								$IdUsuario = $datos['IdUsuario'];
								$Descripcion = $datos['Descripcion'];
								$CantidadTotal = $datos['CostoTotal'];
								$CantLetras = $datos['CantLetras'];
								$Saldo = $datos['Saldo'];
								$FechaViaje = $datos['FechaIn'];
								$FechaCompra = $datos['FechaCompra'];
								$estatus = $datos['Estatus'];
							}


							$sql = "SELECT * FROM cliente WHERE idViajero = '$idViajero'";

						$resultado= @mysql_query($sql) or die(mysql_error());

						while ($datos = @mysql_fetch_assoc($resultado) ){

								$nombre = $datos["Nombre"];
								
							}
							$sql = "SELECT * FROM usuarios WHERE IdUsuario = '$IdUsuario'";

						$resultado= @mysql_query($sql) or die(mysql_error());

						while ($datos = @mysql_fetch_assoc($resultado) ){

								$nombreU = $datos["Nombre"];
								
							}


					$pdf = new PDF();
					$pdf->AddPage();

					$pdf->Image('../imagenes/logo.jpg',40,15,33);
					// Arial bold 15
					$pdf->SetFont('Arial','B',8);
					// Movernos a la derecha
					$pdf->SetY(12);
					$pdf->Cell(80);

					// Título
					$pdf->Cell(60,5,'Angytours',0,2,'C');
					$pdf->Cell(60,5,'Calle 59J # 565 X 110 y 112 Col Bojorquez',0,2,'C');
					$pdf->Cell(60,5,'Tel: (999)9-12-28-95 | Cel: (044)99-92-44-54-14',0,2,'C');
					$pdf->Cell(60,5,'Correo: angeviajes@hotmail.com',0,2,'C');
					$pdf->Cell(60,5,'RFC: PELA620129L36',0,2,'C');
					$pdf->SetFont('Arial','',10);
					$pdf->SetY(35);
					$pdf->SetX(140);
					$pdf->Cell(40,8,utf8_decode("Fecha: ").utf8_decode($dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ),0,1);					
					$pdf->SetY(45);
					$pdf->SetX(20);					
					$pdf->Cell(130,8,utf8_decode("Cliente : ").utf8_decode($nombre),1,0);
					$pdf->Cell(30,8,utf8_decode("Folio : ").$FolioVta,1,1);
					$pdf->SetX(20);				
					$pdf->Cell(60,8,utf8_decode("Cantidad : ").$CantidadTotal,1,0,'L');
					$pdf->Cell(50,8,utf8_decode("Abono : ").$cantidad,1,0,'L');
					$pdf->Cell(50,8,utf8_decode("Saldo : ").$Saldo,1,1,'L');
					$pdf->SetX(20);
					
					$pdf->MultiCell(160,6,utf8_decode("Descripción : ").utf8_decode($Descripcion),1,'J');					
					$pdf->SetX(20);
					$pdf->Cell(100,14,utf8_decode("Le atendio : ").utf8_decode($nombreU),1,0);
					$pdf->Cell(60,14,utf8_decode("Firma : "),1,2);

					$pdf->SetY(100);

					$pdf->SetX(20);
					 $pdf->SetFont('Arial','B',4);


					 $pdf->MultiCell(160,3,utf8_decode($clasula),0,'J');


					///Segundo Cupon
					 $pdf->SetY(50);

					 // codigo de una sola página******************************************************************
					$pdf->SetY(204);
					$pdf->Image('../imagenes/logo.jpg',40,140,32,24);
					// Arial bold 15
					$pdf->SetFont('Arial','B',8);
					// Movernos a la derecha
					 $pdf->SetY(140);
					 $pdf->Cell(80);

					// Título
					$pdf->Cell(60,5,'Angytours',0,2,'C');
					$pdf->Cell(60,5,'Calle 59J # 565 X 110 y 112 Col Bojorquez',0,2,'C');
					$pdf->Cell(60,5,'Tel: (999)9-12-28-95 | Cel: (044)99-92-44-54-14',0,2,'C');
					$pdf->Cell(60,5,'Correo: angeviajes@hotmail.com',0,2,'C');
					$pdf->Cell(60,5,'RFC: PELA620129L36',0,2,'C');
					$pdf->SetFont('Arial','',10);
					$pdf->SetY(165);
					$pdf->SetX(140);
					$pdf->Cell(40,8,utf8_decode("Fecha: ").utf8_decode($dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y') ),0,1);					
					$pdf->SetY(175);
					$pdf->SetX(20);
					$pdf->Cell(130,8,utf8_decode("Cliente : ").utf8_decode($nombre),1,0);
					$pdf->Cell(30,8,utf8_decode("Folio : ").$FolioVta,1,1);
					$pdf->SetX(20);
					$pdf->Cell(60,8,utf8_decode("Cantidad : ").$CantidadTotal,1,0,'L');
					$pdf->Cell(50,8,utf8_decode("Abono : ").$cantidad,1,0,'L');
					$pdf->Cell(50,8,utf8_decode("Saldo : ").$Saldo,1,1,'L');
					$pdf->SetX(20);
					$pdf->MultiCell(160,5,utf8_decode("Descripción : ").utf8_decode($Descripcion),1,'L');
					$pdf->SetX(20);
					$pdf->Cell(100,14,utf8_decode("Le atendio : ").utf8_decode($nombreU),1,0);
					$pdf->Cell(60,14,utf8_decode("Firma : "),1,1);
					

					$pdf->SetY(225);
					$pdf->SetX(20);

					$pdf->SetFont('Arial','B',4);
					$pdf->MultiCell(160,3,utf8_decode($clasula),0,'J');
					// para descargar la página quitar los comentarios
					$pdf->Output('abono '.$FolioVta.' cli '.$nombre.'.pdf','D'); 

cerrar($conexion);
?>


