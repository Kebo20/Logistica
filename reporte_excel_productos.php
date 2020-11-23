<?php

require 'excel/Classes/PHPExcel.php';
include 'cado/ClaseLogistica.php';

$fila = 2;

//$objPHPExcel = new PHPExcel();
//$objPHPExcel->getProperties()->setCreator("Kevin Alberca")->setDescription("Reporte de usuarios");
$objPHPExcel = PHPExcel_IOFactory::load("plantilla-productos.xlsx");




$olog = new Logistica();




$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("Productos");

//ANCHO DE COLUMNAS
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(70);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(70);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(50);




//CUERPO

$datos = array();
        
       
  
        $lista = $olog->ListarProductoLog($_GET["q"],$_GET["id_categoria"], 0, 1000000);
       
$i = 0;
$fin=$lista->rowCount()+12;

foreach ($lista as $row) {
    $i++;
    $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $i);

    $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $row["nombre"]);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $row["categoria"]);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $row["codigo_unidad"]." - ".$row["descripcion_unidad"]);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $row["stock_min"]);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $row["stock_max"]);

    if ($row["tipo_producto"] == "0") {
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, "PRODUCTO");
    }
    if ($row["tipo_producto"] == "1") {
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, "SERVICIO");
    }

    if ($row["nombre_producto_fraccion"] != null) {
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H' . $fila,$row["nombre_producto_fraccion"]);

    } else {
        $objPHPExcel->getActiveSheet()->setCellValueExplicit('H' . $fila," ");
    }


    $objPHPExcel->getActiveSheet()->setCellValueExplicit('I' . $fila,$row["cantidad_fraccion"]);



    $fila++;
}

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte-productos.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('php://output');



//header('Content-Type: application/vnd.ms-excel');
//header('Content-Disposition: attachment;filename="Reporte-Kardex.xls"');
//header('Cache-Control: max-age=0');

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//$objWriter->save('php://output');