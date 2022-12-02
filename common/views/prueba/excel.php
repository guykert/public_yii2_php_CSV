<?php 

use yii\helpers\ArrayHelper;

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */


// Create new PHPExcel object
$objPHPExcel = new \PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Claudio Santibañez")
                             ->setLastModifiedBy("Claudio Santibañez")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Listado Alumnos Jornada.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");

// 


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1')
            ->setCellValue('B2', 'CARGAR PAUTA');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Verdana');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(17);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(55);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('AI1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);


//$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);



$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:A2')
            ->setCellValue('A2', 'N° Pregunta');
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('A2:A2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A2:A2')->getFill()->getStartColor()->setRGB('FFCC00');
$objPHPExcel->getActiveSheet()->getStyle('A2:A2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('A2:A2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                            
 
$objPHPExcel->getActiveSheet()->getStyle('A2:A2')->getBorders()->applyFromArray(
     array(
         'left'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFCC00'
             )
         ),
         'right'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFCC00'
             )
         ),
         'top'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFCC00'
             )
         ),
         'button'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFCC00'
             )
         ),

     )
); 

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:B2')
            ->setCellValue('B2', 'Alternativa');
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('B2:B2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('B2:B2')->getFill()->getStartColor()->setRGB('FFCC00');
$objPHPExcel->getActiveSheet()->getStyle('B2:B2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('B2:B2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                            
 
$objPHPExcel->getActiveSheet()->getStyle('B2:B2')->getBorders()->applyFromArray(
     array(
         'left'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFCC00'
             )
         ),
         'right'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFCC00'
             )
         ),
         'top'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFCC00'
             )
         ),
         'button'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFCC00'
             )
         ),

     )
); 

              


$i_indice = 3;

foreach ($PruebaPauta as $key => $value) {
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $i_indice . ':A' . $i_indice)
    ->setCellValue('A' . $i_indice, $value->numero_pregunta);

    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B' . $i_indice . ':B' . $i_indice)
        ->setCellValue('B' . $i_indice, $value->correcta);

    $i_indice++;
}














// $objPHPExcel->getActiveSheet()->setTitle(Yii::$app->user->identity->sede->nombre);
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Pantilla Carga Pauta.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;