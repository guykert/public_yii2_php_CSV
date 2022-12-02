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


$objPHPExcel->removeSheetByIndex(0);

$nueva_hoja = $objPHPExcel->createSheet();

$objPHPExcel->setActiveSheetIndex(0); // marcar como activa la nueva hoja
$nueva_hoja->setTitle(substr(preg_replace('([^A-Za-z0-9])', ' ', $titulo_excel), 0, 30)); // definimos el titulo


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:L1')
            ->setCellValue('A1', $titulo_excel);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(55);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->getStartColor()->setRGB('c0c0c0');
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(19);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);








$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getBorders()->applyFromArray(
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



$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:A2')
            ->setCellValue('A2', 'N° de Pregunta');
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
            ->setCellValue('B2', 'Alternativa Correcta');
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

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:C2')
            ->setCellValue('C2', '% ALT-A');
$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('C2:C2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('C2:C2')->getFill()->getStartColor()->setRGB('FFCC00');
$objPHPExcel->getActiveSheet()->getStyle('C2:C2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('C2:C2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                            
 
$objPHPExcel->getActiveSheet()->getStyle('C2:C2')->getBorders()->applyFromArray(
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


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D2:D2')
            ->setCellValue('D2', '% ALT-B');
$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('D2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('D2:D2')->getFill()->getStartColor()->setRGB('FFCC00');
$objPHPExcel->getActiveSheet()->getStyle('D2:D2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('D2:D2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                            
 
$objPHPExcel->getActiveSheet()->getStyle('D2:D2')->getBorders()->applyFromArray(
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


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E2:E2')
            ->setCellValue('E2', '% ALT-C');
$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('E2:E2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('E2:E2')->getFill()->getStartColor()->setRGB('FFCC00');
$objPHPExcel->getActiveSheet()->getStyle('E2:E2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('E2:E2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                            
 
$objPHPExcel->getActiveSheet()->getStyle('E2:E2')->getBorders()->applyFromArray(
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


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F2:F2')
            ->setCellValue('F2', '% ALT-D');
$objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('F2:F2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('F2:F2')->getFill()->getStartColor()->setRGB('FFCC00');
$objPHPExcel->getActiveSheet()->getStyle('F2:F2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('F2:F2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                            
 
$objPHPExcel->getActiveSheet()->getStyle('F2:F2')->getBorders()->applyFromArray(
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

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G2:G2')
            ->setCellValue('G2', '% ALT-E');
$objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('G2:G2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('G2:G2')->getFill()->getStartColor()->setRGB('FFCC00');
$objPHPExcel->getActiveSheet()->getStyle('G2:G2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('G2:G2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                            
 
$objPHPExcel->getActiveSheet()->getStyle('G2:G2')->getBorders()->applyFromArray(
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


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H2:H2')
            ->setCellValue('H2', '% Buenas');
$objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('H2:H2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('H2:H2')->getFill()->getStartColor()->setRGB('FFCC00');
$objPHPExcel->getActiveSheet()->getStyle('H2:H2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('H2:H2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                            
 
$objPHPExcel->getActiveSheet()->getStyle('H2:H2')->getBorders()->applyFromArray(
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


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('I2:I2')
            ->setCellValue('I2', '% Malas');
$objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('I2:I2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('I2:I2')->getFill()->getStartColor()->setRGB('FFCC00');
$objPHPExcel->getActiveSheet()->getStyle('I2:I2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('I2:I2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                            
 
$objPHPExcel->getActiveSheet()->getStyle('I2:I2')->getBorders()->applyFromArray(
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

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J2:J2')
            ->setCellValue('J2', '% Omitidas');
$objPHPExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('J2:J2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('J2:J2')->getFill()->getStartColor()->setRGB('FFCC00');
$objPHPExcel->getActiveSheet()->getStyle('J2:J2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('J2:J2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                            
 
$objPHPExcel->getActiveSheet()->getStyle('J2:J2')->getBorders()->applyFromArray(
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

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('K2:K2')
            ->setCellValue('K2', '% Nivel Discrim.');
$objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('K2:K2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('K2:K2')->getFill()->getStartColor()->setRGB('FFCC00');
$objPHPExcel->getActiveSheet()->getStyle('K2:K2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('K2:K2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                            
 
$objPHPExcel->getActiveSheet()->getStyle('K2:K2')->getBorders()->applyFromArray(
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


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('L2:L2')
            ->setCellValue('L2', '% Nivel Dificultad.');
$objPHPExcel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
$objPHPExcel->getActiveSheet()->getStyle('L2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('L2:L2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('L2:L2')->getFill()->getStartColor()->setRGB('FFCC00');
$objPHPExcel->getActiveSheet()->getStyle('L2:L2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('L2:L2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                            
 
$objPHPExcel->getActiveSheet()->getStyle('L2:L2')->getBorders()->applyFromArray(
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

    // echo "numero_pregunta : " . $value['numero_pregunta'];
    // echo "alternativa_a : " . $value['alternativa_a'];
    // echo "<br>";

    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $i_indice . ':A' . $i_indice)
    ->setCellValue('A' . $i_indice, $value['numero_pregunta']);
    
    $objPHPExcel->getActiveSheet()->getStyle('A' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B' . $i_indice . ':B' . $i_indice)
        ->setCellValue('B' . $i_indice, $value['correcta']);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('B' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C' . $i_indice . ':C' . $i_indice)
        ->setCellValue('C' . $i_indice, $value['alternativa_a']);
    $objPHPExcel->getActiveSheet()->getStyle('C' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('C' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D' . $i_indice . ':D' . $i_indice)
        ->setCellValue('D' . $i_indice, $value['alternativa_b']);
    $objPHPExcel->getActiveSheet()->getStyle('D' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('D' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('E' . $i_indice . ':E' . $i_indice)
            ->setCellValue('E' . $i_indice, $value['alternativa_c']);
    $objPHPExcel->getActiveSheet()->getStyle('E' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('E' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F' . $i_indice . ':F' . $i_indice)
            ->setCellValue('F' . $i_indice, $value['alternativa_d']);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('F' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G' . $i_indice . ':G' . $i_indice)
            ->setCellValue('G' . $i_indice, $value['alternativa_e']);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('G' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H' . $i_indice . ':H' . $i_indice)
                ->setCellValue('H' . $i_indice, $value['alternativa_buenas']);
    $objPHPExcel->getActiveSheet()->getStyle('H' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('H' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('I' . $i_indice . ':I' . $i_indice)
                ->setCellValue('I' . $i_indice, $value['alternativa_malas']);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('I' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('J' . $i_indice . ':J' . $i_indice)
                ->setCellValue('J' . $i_indice, $value['alternativa_omitidas']);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('J' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('K' . $i_indice . ':K' . $i_indice)
                    ->setCellValue('K' . $i_indice, $value['alternativa_nivel_disc']);
    $objPHPExcel->getActiveSheet()->getStyle('K' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('K' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('L' . $i_indice . ':L' . $i_indice)
                    ->setCellValue('L' . $i_indice, $value['alternativa_nivel_dific']);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('L' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $i_indice++;
}

// exit;

$objPHPExcel->getActiveSheet()->setTitle($titulo_excel);




foreach ($arrayCursos as $key => $value) {

    $nombre_curso = substr(preg_replace('([^A-Za-z0-9])', ' ', $value['nombre_curso']), 0, 30);

    $indice_pestania = $key + 1;

    $nueva_hoja = $objPHPExcel->createSheet();

    $objPHPExcel->setActiveSheetIndex($indice_pestania); // marcar como activa la nueva hoja
    $nueva_hoja->setTitle($nombre_curso); // definimos el titulo

    $objPHPExcel->getActiveSheet()->mergeCells('A1:L1')
    ->setCellValue('A1', $titulo_excel . ' - ' . $nombre_curso);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
    $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(55);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->getStartColor()->setRGB('c0c0c0');
    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(19);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(12);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);








    $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getBorders()->applyFromArray(
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



    $objPHPExcel->getActiveSheet()->mergeCells('A2:A2')
        ->setCellValue('A2', 'N° de Pregunta');
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

    $objPHPExcel->getActiveSheet()->mergeCells('B2:B2')
        ->setCellValue('B2', 'Alternativa Correcta');
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

    $objPHPExcel->getActiveSheet()->mergeCells('C2:C2')
        ->setCellValue('C2', '% ALT-A');
    $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setSize(12);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
    $objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
    $objPHPExcel->getActiveSheet()->getStyle('C2:C2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('C2:C2')->getFill()->getStartColor()->setRGB('FFCC00');
    $objPHPExcel->getActiveSheet()->getStyle('C2:C2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
    $objPHPExcel->getActiveSheet()->getStyle('C2:C2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        

    $objPHPExcel->getActiveSheet()->getStyle('C2:C2')->getBorders()->applyFromArray(
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


    $objPHPExcel->getActiveSheet()->mergeCells('D2:D2')
        ->setCellValue('D2', '% ALT-B');
    $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setSize(12);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
    $objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
    $objPHPExcel->getActiveSheet()->getStyle('D2:D2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('D2:D2')->getFill()->getStartColor()->setRGB('FFCC00');
    $objPHPExcel->getActiveSheet()->getStyle('D2:D2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
    $objPHPExcel->getActiveSheet()->getStyle('D2:D2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        

    $objPHPExcel->getActiveSheet()->getStyle('D2:D2')->getBorders()->applyFromArray(
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


    $objPHPExcel->getActiveSheet()->mergeCells('E2:E2')
        ->setCellValue('E2', '% ALT-C');
    $objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->setSize(12);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
    $objPHPExcel->getActiveSheet()->getStyle('E2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
    $objPHPExcel->getActiveSheet()->getStyle('E2:E2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('E2:E2')->getFill()->getStartColor()->setRGB('FFCC00');
    $objPHPExcel->getActiveSheet()->getStyle('E2:E2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
    $objPHPExcel->getActiveSheet()->getStyle('E2:E2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        

    $objPHPExcel->getActiveSheet()->getStyle('E2:E2')->getBorders()->applyFromArray(
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


    $objPHPExcel->getActiveSheet()->mergeCells('F2:F2')
        ->setCellValue('F2', '% ALT-D');
    $objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('F2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->setSize(12);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
    $objPHPExcel->getActiveSheet()->getStyle('F2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
    $objPHPExcel->getActiveSheet()->getStyle('F2:F2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('F2:F2')->getFill()->getStartColor()->setRGB('FFCC00');
    $objPHPExcel->getActiveSheet()->getStyle('F2:F2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
    $objPHPExcel->getActiveSheet()->getStyle('F2:F2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        

    $objPHPExcel->getActiveSheet()->getStyle('F2:F2')->getBorders()->applyFromArray(
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

    $objPHPExcel->getActiveSheet()->mergeCells('G2:G2')
        ->setCellValue('G2', '% ALT-E');
    $objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->setSize(12);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
    $objPHPExcel->getActiveSheet()->getStyle('G2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
    $objPHPExcel->getActiveSheet()->getStyle('G2:G2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('G2:G2')->getFill()->getStartColor()->setRGB('FFCC00');
    $objPHPExcel->getActiveSheet()->getStyle('G2:G2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
    $objPHPExcel->getActiveSheet()->getStyle('G2:G2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        

    $objPHPExcel->getActiveSheet()->getStyle('G2:G2')->getBorders()->applyFromArray(
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


    $objPHPExcel->getActiveSheet()->mergeCells('H2:H2')
        ->setCellValue('H2', '% Buenas');
    $objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('H')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('H2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setSize(12);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
    $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
    $objPHPExcel->getActiveSheet()->getStyle('H2:H2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('H2:H2')->getFill()->getStartColor()->setRGB('FFCC00');
    $objPHPExcel->getActiveSheet()->getStyle('H2:H2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
    $objPHPExcel->getActiveSheet()->getStyle('H2:H2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        

    $objPHPExcel->getActiveSheet()->getStyle('H2:H2')->getBorders()->applyFromArray(
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


    $objPHPExcel->getActiveSheet()->mergeCells('I2:I2')
        ->setCellValue('I2', '% Malas');
    $objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('I')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('I2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setSize(12);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
    $objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
    $objPHPExcel->getActiveSheet()->getStyle('I2:I2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('I2:I2')->getFill()->getStartColor()->setRGB('FFCC00');
    $objPHPExcel->getActiveSheet()->getStyle('I2:I2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
    $objPHPExcel->getActiveSheet()->getStyle('I2:I2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        

    $objPHPExcel->getActiveSheet()->getStyle('I2:I2')->getBorders()->applyFromArray(
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

    $objPHPExcel->getActiveSheet()->mergeCells('J2:J2')
        ->setCellValue('J2', '% Omitidas');
    $objPHPExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('J')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('J2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setSize(12);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
    $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
    $objPHPExcel->getActiveSheet()->getStyle('J2:J2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('J2:J2')->getFill()->getStartColor()->setRGB('FFCC00');
    $objPHPExcel->getActiveSheet()->getStyle('J2:J2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
    $objPHPExcel->getActiveSheet()->getStyle('J2:J2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        

    $objPHPExcel->getActiveSheet()->getStyle('J2:J2')->getBorders()->applyFromArray(
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

    $objPHPExcel->getActiveSheet()->mergeCells('K2:K2')
        ->setCellValue('K2', '% Nivel Discrim.');
    $objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('K')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('K2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->setSize(12);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
    $objPHPExcel->getActiveSheet()->getStyle('K2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
    $objPHPExcel->getActiveSheet()->getStyle('K2:K2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('K2:K2')->getFill()->getStartColor()->setRGB('FFCC00');
    $objPHPExcel->getActiveSheet()->getStyle('K2:K2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
    $objPHPExcel->getActiveSheet()->getStyle('K2:K2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        

    $objPHPExcel->getActiveSheet()->getStyle('K2:K2')->getBorders()->applyFromArray(
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


    $objPHPExcel->getActiveSheet()->mergeCells('L2:L2')
        ->setCellValue('L2', '% Nivel Dificultad.');
    $objPHPExcel->getActiveSheet()->getStyle('L2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    $objPHPExcel->getActiveSheet()->getStyle('L2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setBold(true);
    $objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setName('Calibri');
    $objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->setSize(12);
    $objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(18);
    $objPHPExcel->getActiveSheet()->getStyle('L2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
    $objPHPExcel->getActiveSheet()->getStyle('L2:L2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('L2:L2')->getFill()->getStartColor()->setRGB('FFCC00');
    $objPHPExcel->getActiveSheet()->getStyle('L2:L2')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
    $objPHPExcel->getActiveSheet()->getStyle('L2:L2')->getBorders()->getBottom()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
                        

    $objPHPExcel->getActiveSheet()->getStyle('L2:L2')->getBorders()->applyFromArray(
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

    foreach ($value['PruebaPauta'] as $key => $value) {
        $objPHPExcel->getActiveSheet()->mergeCells('A' . $i_indice . ':A' . $i_indice)
        ->setCellValue('A' . $i_indice, $value['numero_pregunta']);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('B' . $i_indice . ':B' . $i_indice)
        ->setCellValue('B' . $i_indice, $value['correcta']);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('B' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('C' . $i_indice . ':C' . $i_indice)
        ->setCellValue('C' . $i_indice, $value['alternativa_a']);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('C' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('D' . $i_indice . ':D' . $i_indice)
        ->setCellValue('D' . $i_indice, $value['alternativa_b']);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('D' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('E' . $i_indice . ':E' . $i_indice)
            ->setCellValue('E' . $i_indice, $value['alternativa_c']);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('F' . $i_indice . ':F' . $i_indice)
            ->setCellValue('F' . $i_indice, $value['alternativa_d']);
        $objPHPExcel->getActiveSheet()->getStyle('F' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('F' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('G' . $i_indice . ':G' . $i_indice)
            ->setCellValue('G' . $i_indice, $value['alternativa_e']);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('H' . $i_indice . ':H' . $i_indice)
                ->setCellValue('H' . $i_indice, $value['alternativa_buenas']);
        $objPHPExcel->getActiveSheet()->getStyle('H' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('H' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('I' . $i_indice . ':I' . $i_indice)
                ->setCellValue('I' . $i_indice, $value['alternativa_malas']);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('J' . $i_indice . ':J' . $i_indice)
                ->setCellValue('J' . $i_indice, $value['alternativa_omitidas']);
        $objPHPExcel->getActiveSheet()->getStyle('J' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('K' . $i_indice . ':K' . $i_indice)
                    ->setCellValue('K' . $i_indice, $value['alternativa_nivel_disc']);
        $objPHPExcel->getActiveSheet()->getStyle('K' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('K' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()->mergeCells('L' . $i_indice . ':L' . $i_indice)
                    ->setCellValue('L' . $i_indice, $value['alternativa_nivel_dific']);
        $objPHPExcel->getActiveSheet()->getStyle('L' . $i_indice)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('L' . $i_indice)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $i_indice++;
    }

}


$objPHPExcel->setActiveSheetIndex(0);








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