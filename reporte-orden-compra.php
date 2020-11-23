<?php
require_once('Librerias/tcpdf/tcpdf_include_fin.php');
require_once('cado/ClaseReporte.php');
require_once('cado/NumeroLetra.php');

require_once('cado/ClaseLogistica.php');
$olog = new Logistica();
$orden = $olog->ListarOrdenCompraxId($_GET['id_orden'])->fetch();
if (isset($orden['id'])) {
	$detalle_orden = $olog->ListarOrdenComprDetalles($orden['id']);
} else {
	echo "<script type='text/javascript'>";
	echo "window.history.back(-1)";
	echo "</script>";
}




$oreporte = new Reportes();
$oletra = new Numeros();
//$iddoc=7664;//$_GET['id'];
//$cab=$oreporte->CabeceraDoc($iddoc)->fetch();
$tipo_doc = "01";
$nro_doc = $orden['numero'];
$nomcli = "";
$doccli = "";
$tipodoccli = "6";
$serie = "";
$correlativo = "";
$fecha_format = "";
$dircli = "";
$fecha = $orden['fecha'];
$titulo = "";
$op_gravada = "";
$igv = "";
$total = "";
$hash = "";
$tipo_doc_ref = "";
$nro_ref = "";
$motivo_nota = "";
$estado = $orden['estado'];
$referencia = $orden['referencia'];
$sucursal = "Precisa Diagnostica";
$almacen = $olog->ListarAlmacenxid($orden['id_almacen'])->fetch()['nombre'];

$ruc = '20561370096';
//$params = [$ruc,$tipo_doc,$serie,$correlativo,$igv,$total,$fecha_format,$tipodoccli,$doccli];
$qr = ""; //implode('|', $params).'|';

$nom_doc = 'ORDEN';
$nom_completo = 'ORDEN COMPRA';


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$pdf2=new Pdf_Table();

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->setPrintHeader(false);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->SetLeftMargin(20);
$pdf->SetrightMargin(19);

$pdf->AddPage();

// para la cabecera
$pdf->SetFillColor(255);
$style6 = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => '4,3', 'color' => array(0, 0, 0));

$pdf->SetXY(82, 20);
$pdf->Image("imagenes/logo.png", 20, 20,  45, 13, $type = '', $link = '');

$pdf->SetFont('verdana', 'B', 8.5);
$pdf->SetTextColor(200, 0, 0);
$pdf->Text(80, 20, 'PRECISA');
$pdf->SetTextColor(100, 50, 0, 0);
$pdf->Text(96, 20, 'DIAGNOSTICA');
$pdf->SetTextColor(127);
$pdf->Text(121, 20, 'S.A.C');

$pdf->SetXY(82, 24);
$pdf->SetFont('ARIAL', '', 6.5);
$pdf->MultiCell(50, 5, 'CAL. FRANCISCO CABRERA 130            URB. CERCADO DE CHICLAYO            CHICLAYO - CHICLAYO - LAMBAYEQUE', 0, 'C', 1, 1, '', '', true);

$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(127)));
$pdf->RoundedRect(143, 18, 47, 20, 3.5, '1111', 'DF');
$pdf->SetFont('verdana', 'B', 8.5);
$pdf->SetTextColor(100);
//$pdf->Text(147,20,'RUC : 20561370096');
$pdf->SetXY(145, 19.5);
$pdf->Cell(42, 5, 'RUC : 20561370096', 0, 0, 'C');
//$pdf->Text(148,24,'FACTURA DE VENTA');
$pdf->SetXY(145, 23.5);
$pdf->SetTextColor(200, 0, 0);
$pdf->Cell(42, 5, "", 0, 0, 'C');
$pdf->SetXY(145, 27.5);
$pdf->SetTextColor(100, 50, 0, 0);
$pdf->Cell(42, 5, 'ORDEN DE COMPRA', 0, 0, 'C');
$pdf->SetXY(145, 31.5);
$pdf->SetFont('verdana', 'B', 9);
$pdf->SetTextColor(100);
$pdf->Cell(42, 5, $nro_doc, 0, 0, 'C');

$pdf->SetFont('arial', 'B', 7.5);
$pdf->SetTextColor(50);
$pdf->Text(20, 40, "");
$pdf->Text(131, 40, "");
$pdf->Text(20, 45, 'SUCURSAL: ');
$pdf->Text(131, 45, 'ALMACÉN: ');
$pdf->Text(20, 50, 'ESTADO: ');
$pdf->Text(131, 50, 'FECHA DE EMISION :');

if ($tipo_doc == '07') {
	$pdf->Text(20, 55, 'TIPO DOC. REF.  :');
	$pdf->Text(131, 55, 'NRO DOC. REF         :');
}

//RESULTADOS CABECERA
$pdf->SetFont('arial', '', 7.5);
$pdf->Text(40, 45, $sucursal);
$pdf->Text(162, 45, $almacen);
$pdf->Text(40, 50, $estado);
$pdf->Text(162, 50, $fecha);
$y_ini = $pdf->GetY() + 5;
$pdf->SetFillColor(100, 20, 0, 0);
$pdf->SetLineStyle(array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(100, 20, 0, 0)));
$pdf->RoundedRect(20, $y_ini, 171, 7, 2, '1001', 'DF');
$pdf->SetFont('verdana', 'B', 8.5);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetXY(20, $y_ini);
$pdf->Cell(200, 5, 'DETALLES', 0, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('arial', 'B', 6.5);
$pdf->SetTextColor(0);
$pdf->SetLineStyle(array('width' => 0.01, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(100, 20, 0, 0)));
$pdf->SetFillColor(10, 0, 0, 0);
$pdf->Cell(10, 5, 'N°', 1, 0, 'C', 1, 0);
$pdf->Cell(95, 5, 'Producto', 1, 0, 'C', 1, 0);
$pdf->Cell(10, 5, 'Cant.', 1, 0, 'C', 1, 0);
$pdf->Cell(24, 5, 'Unidad', 1, 0, 'C', 1, 0);
$pdf->Cell(16, 5, 'Despachado', 1, 0, 'C', 1, 0);
$pdf->Cell(16, 5, 'Pendiente', 1, 0, 'C', 1, 0);
$pdf->Ln(5);
$pdf->SetFont('arial', '', 6.5);
$pdf->SetFillColor(255);

$detalle = '<table style="padding:4px 5px; "  width="100%" >';
$i = 0;
while ($fila = $detalle_orden->fetch()) {
	$i++;
	if ($i % 2 == 0) {
		$color = 'style="background-color:#e6f7ff"';
	} else {
		$color = '';
	}
	$detalle .= '<tr ' . $color . '>
			   <td  align="center" width="5.8%" style="border-right: 0.1px solid #666; border-left: 0.1px solid #666; " >' . ($i) . '</td>
			   <td  align="left" width="55.6%" style="border-right: 0.1px solid #666; " >' . $fila['nombre'] . '</td>
			   <td align="center" width="5.9%" style="border-right: 0.1px solid #666; " >' . $fila['cantidad'] . '</td>
			   <td width="14%" style="border-right: 0.1px solid #666; ">' . $fila['nombre_unidad'] . '</td>
			   <td width="9.3%" style="border-right: 0.1px solid #666;" align="right">' . $fila['despachado'] . '</td>
			   <td width="9.3%" style="border-right: 0.1px solid #666;" align="right">' . $fila['pendiente'] . '</td>
			</tr>';
}
$detalle .= '<tr >
			   <td align="right" colspan="6" bgcolor="#EAEAEA" style="border: 0.1px solid #666; " >
			   <b>TOTAL DE ITEMS : ' . $i . '</b></td>
			</tr></table>';

$pdf->writeHTML($detalle, true, false, false, false, '');


$nom_monto = $oletra->numtoletras($total);
$nom_titulo = '';


$pdf->Ln(-2);
$pdf->SetFillColor(234, 234, 234);
$pdf->SetLineStyle(array('width' => 0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 1, 'color' => array(0, 0, 0, 60)));
$pdf->SetFont('arial', 'B', 6.5);
//$pdf->Cell(122,5,$nom_monto,0,0,'L');$pdf->Cell(24,5,'OP. GRAVADAS : ',0,0,'R');$pdf->Cell(25,5,'S/ '.$op_gravada.'   ',1,1,'R');
//$pdf->Cell(122,5,'Información Adicional',0,0,'L');$pdf->Cell(24,5,'IGV (18%) : ',0,0,'R');$pdf->Cell(25,5,'S/ '.$igv.'   ',1,1,'R');
//$pdf->Cell(122,5,'REFERENCIA : '.$referencia,0,0,'L');$pdf->Cell(24,5,'PRECIO VENTA : ',0,0,'R');$pdf->Cell(25,5,'S/ '.$total.'   ',1,1,'R');

$pdf->Ln(3);
$pdf->SetLineStyle(array('width' => 0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 1, 'color' => array(0, 0, 0, 60)));
$hr = '<hr width="100%"/>';
$pdf->writeHTML($hr, true, false, false, false, '');
$pdf->Ln(2);
$pdf->SetFont('arial', '', 6);
$pdf->Cell(122, 3, $hash, 0, 1, 'L');
$pdf->Cell(122, 3, 'Referencia: ' . $referencia, 0, 1, 'L');
$pdf->Cell(122, 3, '', 0, 1, 'L');

$pdf->Cell(122, 3, 'REPRESENTACION IMPRESA DE ' . $nom_completo, 0, 1, 'L');




if ($estado == 'anulada') {
	$pdf->StartTransform();
	$pdf->SetAlpha(0.4);
	$pdf->SetTextColor(150);
	$pdf->SetFont('verdana', 'B', 45);
	$pdf->Rotate(20, 15, 150);
	$pdf->Text(85, 80, 'ANULADO');
	$pdf->StopTransform();
}




/*$style = array(
    'border' => false,
	'padding'=>0,
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);*/

//$y=$pdf->GetY()-10;
//$pdf->write2DBarcode($qr, 'QRCODE,H', 170, $y, 50, 50, $style, 'N');

$pdf->Output('Documento.pdf', 'I');
