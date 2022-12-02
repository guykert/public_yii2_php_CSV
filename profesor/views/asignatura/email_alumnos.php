<?php 

use yii\helpers\ArrayHelper;

use common\models\Empresa;

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
$objPHPExcel->getProperties()->setCreator("Desarrollos .csv")
                             ->setLastModifiedBy("Desarrollos .csv")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Listado Alumnos Jornada.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");



$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Verdana');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(17);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('AC1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('A1:C1')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(60);



$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:A1')
            ->setCellValue('A1', 'Listado de alumnos y sus emails  -  Curso : ' . $model['nombre_curso'] . '    Asignatura : ' .  $model['nombre_sub_ramo']);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);

$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('AA1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('A1:A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:A1')->getFill()->getStartColor()->setRGB('0073BE');
// $objPHPExcel->getActiveSheet()->getStyle('A1:A1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
// $objPHPExcel->getActiveSheet()->getStyle('A1:A1')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                            
 
$objPHPExcel->getActiveSheet()->getStyle('A1:A1')->getBorders()->applyFromArray(
     array(
         'left'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),
         'right'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),
         'top'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),
         'button'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),

     )
); 

$objPHPExcel->getActiveSheet()->getStyle('A1:A1')->applyFromArray(
    array(

       'font'  => array(
           'bold'  => true,
           'color' => array('rgb' => 'FFFFFF'),
           'size'  => 16,
           'name'  => 'Calibri'
       )
    )
); 




$arreglo_estilo_letras = array(

    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => 'FFFFFF'),
        'size'  => 12,
        'name'  => 'Calibri'
    )
);

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:A2')
            ->setCellValue('A2', 'RUT ALUMNO');
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(33);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);

$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($arreglo_estilo_letras); 


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B2:B2')
            ->setCellValue('B2', 'NOMBRE');
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);

$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($arreglo_estilo_letras); 


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:C2')
            ->setCellValue('C2', 'Email');
$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);

$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($arreglo_estilo_letras); 


$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getFill()->getStartColor()->setRGB('005085');
$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);



$objPHPExcel->getActiveSheet()->getStyle('A2:C2')->getBorders()->applyFromArray(
     array(
         'left'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),
         'right'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),
         'top'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),
         'button'     => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),

     )
);

$i = 3;

foreach($Alumnos as $Alumno){

	$objPHPExcel->getActiveSheet()->setCellValue('A' . $i,strip_tags(html_entity_decode($Alumno['rut'],ENT_COMPAT,'UTF-8')));
	$objPHPExcel->getActiveSheet()->setCellValue('B' . $i,strip_tags(html_entity_decode($Alumno['nombre'] . "" . $Alumno['apellido_paterno'] . "" . $Alumno['apellido_materno'],ENT_COMPAT,'UTF-8')));
	$objPHPExcel->getActiveSheet()->setCellValue('C' . $i,strip_tags(html_entity_decode($Alumno['email'],ENT_COMPAT,'UTF-8')));

    $i++;

}


header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Emails_' . strtoupper($model['nombre_curso']) . '_'.strtoupper($model['nombre_sub_ramo']).'.xls"');
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