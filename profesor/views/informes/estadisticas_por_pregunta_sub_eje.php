<?php



/**
 * Bootstrap for PhpSpreadsheet classes.
 */

// This sucks, but we have to try to find the composer autoloader

$vendorDirPath = realpath($_SERVER["DOCUMENT_ROOT"] . '/vendor');

// var_dump($vendorDirPath);
// exit;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Helper;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (file_exists($vendorDirPath . '/autoload.php')) {
    require $vendorDirPath . '/autoload.php';
} else {
    throw new Exception(
        sprintf(
            'Could not find file \'%s\'. It is generated by Composer. Use \'install --prefer-source\' or \'update --prefer-source\' Composer commands to move forward.',
            $vendorDirPath . '/autoload.php'
        )
    );
}


// Create new Spreadsheet object
$objPHPExcel = new Spreadsheet();




$objPHPExcel->getProperties()->setCreator("Desarrollos .csv")
                            ->setLastModifiedBy("Desarrollos .csv")
                            ->setTitle("Office 2007 XLSX Test Document")
                            ->setSubject("Office 2007 XLSX Test Document")
                            ->setDescription("Listado Alumnos Jornada.")
                            ->setKeywords("office 2007 openxml php")
                            ->setCategory("Test result file");





$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Verdana');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(17);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(18);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('AG1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getBorders()->getBottom()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1')
            ->setCellValue('A1', strtoupper($PruebasInformeProfesor['nombre_titulo']));
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(40);

$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('AI1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->getStartColor()->setRGB('0073BE');
// $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
// $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getBorders()->getBottom()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                            
 
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getBorders()->applyFromArray(
     array(
         'left'     => array(
             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),
         'right'     => array(
             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),
         'top'     => array(
             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),
         'button'     => array(
             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),

     )
); 

$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray(
    array(

       'font'  => array(
           'bold'  => true,
           'color' => array('rgb' => 'FFFFFF'),
           'size'  => 16,
           'name'  => 'Calibri'
       )
    )
); 



$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:G2')
            ->setCellValue('A2', 'Prueba  '.strtoupper($PruebasInformeProfesor['nombre_prueba']));
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setSize(16);
$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(40);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('AI1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getFill()->getStartColor()->setRGB('0073BE');
// $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
// $objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getBorders()->getBottom()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->getBorders()->applyFromArray(
     array(
         'left'     => array(
             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),
         'right'     => array(
             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),
         'top'     => array(
             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),
         'button'     => array(
             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFFFFF'
             )
         ),

     )
);

$objPHPExcel->getActiveSheet()->getStyle('A2:G2')->applyFromArray(
    array(

       'font'  => array(
           'bold'  => true,
           'color' => array('rgb' => 'FFFFFF'),
           'italic' => true,
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

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:A3')
            ->setCellValue('A3', 'Tema');
$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(33);
$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

$objPHPExcel->getActiveSheet()->getStyle('A3')->applyFromArray($arreglo_estilo_letras); 


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B3:B3')
            ->setCellValue('B3', 'Sub - Tema');
$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(33);
$objPHPExcel->getActiveSheet()->getStyle('B3')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

$objPHPExcel->getActiveSheet()->getStyle('B3')->applyFromArray($arreglo_estilo_letras); 


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C3:C3')
            ->setCellValue('C3', 'Pregunta');
$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(33);
$objPHPExcel->getActiveSheet()->getStyle('C3')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

$objPHPExcel->getActiveSheet()->getStyle('C3')->applyFromArray($arreglo_estilo_letras); 


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D3:D3')
            ->setCellValue('D3', 'Pauta');
$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(33);
$objPHPExcel->getActiveSheet()->getStyle('D3')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

$objPHPExcel->getActiveSheet()->getStyle('D3')->applyFromArray($arreglo_estilo_letras); 


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('E3:E3')
            ->setCellValue('E3', 'Buenas');
$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(33);
$objPHPExcel->getActiveSheet()->getStyle('E3')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

$objPHPExcel->getActiveSheet()->getStyle('E3')->applyFromArray($arreglo_estilo_letras); 


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('F3:F3')
            ->setCellValue('F3', 'Malas');
$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(33);
$objPHPExcel->getActiveSheet()->getStyle('F3')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

$objPHPExcel->getActiveSheet()->getStyle('F3')->applyFromArray($arreglo_estilo_letras); 


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G3:G3')
            ->setCellValue('G3', 'Omitidas');
$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setName('Calibri');
$objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getRowDimension(3)->setRowHeight(33);
$objPHPExcel->getActiveSheet()->getStyle('G3')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

$objPHPExcel->getActiveSheet()->getStyle('G3')->applyFromArray($arreglo_estilo_letras); 


$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getFill()->getStartColor()->setRGB('005085');
$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getBorders()->getBottom()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);







$objPHPExcel->getActiveSheet()->getStyle('A3:G3')->getBorders()->applyFromArray(
     array(
         'left'     => array(
             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFCC00'
             )
         ),
         'right'     => array(
             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFCC00'
             )
         ),
         'top'     => array(
             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFCC00'
             )
         ),
         'button'     => array(
             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             'color' => array(
                 'rgb' => 'FFCC00'
             )
         ),

     )
);


// indice para los ejes
$i = 4;
// este es el indice para la columna B donde se desplegarán las habilidades
$ibh = 4;
// indice para ver donde terminan los ejes
$ih = $i + (count($PruebasInformeProfesor['Habilidades']) - 1);

$indice = 1;
$total = 0 ;

$cantidad_ejes = 0;
foreach($PruebasInformeProfesor['Ejes'] as $eje){
    $eje_tematico_id = $eje[0]["eje_tematico"];
    $eje_tematico_nombre = $eje[0]["nombre_eje_tematico"];


    foreach ($PruebasInformeProfesor['Habilidades'] as $habilidad) {
        $habilidad_id = $habilidad[0]["sub_eje_tematico"];
        $habilidad_nombre = $habilidad[0]["nombre_sub_eje"];

        // este es el indice para las preguntas ya que es de uno en uno
        $inormal = $ibh;

        $ibh_final = ($ibh - 1);

        $ibh_inicio = ($ibh - 1);

        $cantidad_coincidencias = 0;

        foreach ($eje as $key => $value_eje) {
            $numero_pregunta_eje = $value_eje["numero_pregunta"];
            


            foreach ($habilidad as $key => $value_habilidad) {




                $numero_pregunta_habilidad = $value_habilidad["numero_pregunta"];

                if ($numero_pregunta_habilidad == $numero_pregunta_eje) {



                    $objPHPExcel->getActiveSheet()->setCellValue('C' . $inormal, $numero_pregunta_habilidad);
                    if ($value_habilidad["correcta"] == "") {
                        $objPHPExcel->getActiveSheet()->setCellValue('D' . $inormal, 'PILOTO');
                    }else{
                        $objPHPExcel->getActiveSheet()->setCellValue('D' . $inormal, $value_habilidad["correcta"]);
                    }
                    
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $inormal, $value_habilidad["buenas"]);
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $inormal, $value_habilidad["malas"]);
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $inormal, $value_habilidad["omitidas"]);

                    $inormal++;
                    $ibh_final++;
                    $cantidad_coincidencias++;



                }
            }

            

        }

        // if(!($habilidad_id == 36 || $habilidad_id == 38 || $habilidad_id == 39 || $habilidad_id == 37)){
        //     var_dump($habilidad_id);
        //     echo "<br><br>";
        //     var_dump($habilidad_nombre);
        //     echo "<br><br>";
        //     var_dump($cantidad_coincidencias);
        //     echo "<br><br>";
        //     exit;
        // }



        

        if ($cantidad_coincidencias == 0) {
            $ibh_final = $ibh;
            
        }else{
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $ibh, $habilidad_nombre)->mergeCells('B' . $ibh . ':B'.$ibh_final);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $ibh)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $ibh)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('B' . $ibh)->getFill()->getStartColor()->setRGB('c0c0c0');
            // $objPHPExcel->getActiveSheet()->getStyle('B' . $ibh)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
            // $objPHPExcel->getActiveSheet()->getStyle('B' . $ibh)->getBorders()->getBottom()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
    


    
            $objPHPExcel->getActiveSheet()->getStyle('B' . $ibh . ':G'.$ibh_final)->getBorders()->applyFromArray(
                 array(
                     'left'     => array(
                         'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                         'color' => array(
                             'rgb' => '000000'
                         )
                     ),
                     'right'     => array(
                         'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                         'color' => array(
                             'rgb' => '000000'
                         )
                     ),
                     'top'     => array(
                         'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                         'color' => array(
                             'rgb' => '000000'
                         )
                     ),
                     'button'     => array(
                         'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                         'color' => array(
                             'rgb' => '000000'
                         )
                     ),
    
                 )
            );

    
            $ibh = $ibh_final + 1;
        }



        // if(!($habilidad_id == 36 || $habilidad_id == 38 || $habilidad_id == 39 || $habilidad_id == 37 || $habilidad_id == 40)){
        //     var_dump($habilidad_id);
        //     echo "<br><br>";
        //     var_dump($habilidad_nombre);
        //     echo "<br><br>";
        //     var_dump($cantidad_coincidencias);
        //     echo "<br><br>";
        //     var_dump($ibh_final);
        //     echo "<br><br>";
        //     var_dump($ibh);
        //     echo "<br><br>";
        //     exit;
        // }

        // cruzo los ejes con las habilidades para ver que pregunta corresponde a cual


    }




    if(count($PruebasInformeProfesor['Ejes']) != $indice){
        $ibh_final  = $ibh_final - 1;
    }
    

        // var_dump($eje_tematico_id);
        // echo "<br><br>";
        // var_dump($habilidad_nombre);
        // echo "<br><br>";
        // var_dump($cantidad_coincidencias);
        // echo "<br><br>";
        // echo "ibh_final : ";
        // var_dump($ibh_final);
        // echo "<br><br>";
        // echo "ibh : ";
        // var_dump($ibh);
        // echo "<br><br>";
        // exit;





    $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $eje_tematico_nombre)->mergeCells('A' . $i . ':A'.$ibh_final);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFill()->getStartColor()->setRGB('c0c0c0');
    // $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK);
    // $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getBorders()->getBottom()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);



    $objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':A'.$ibh_final)->getBorders()->applyFromArray(
         array(
             'left'     => array(
                 'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                 'color' => array(
                     'rgb' => '000000'
                 )
             ),
             'right'     => array(
                 'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                 'color' => array(
                     'rgb' => '000000'
                 )
             ),
             'top'     => array(
                 'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                 'color' => array(
                     'rgb' => '000000'
                 )
             ),
             'button'     => array(
                 'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                 'color' => array(
                     'rgb' => '000000'
                 )
             ),

         )
    );




   

    $i = $ibh_final + 1;

    $indice++;
}

$objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':G'.$i)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
// $objPHPExcel->getActiveSheet()->getStyle('A' . $i)->getFill()->getStartColor()->setRGB('FFCC00');

$objPHPExcel->getActiveSheet()->getStyle('A' . $i . ':G'.$i)->getBorders()->applyFromArray(
     array(
         // 'left'     => array(
         //     'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
         //     'color' => array(
         //         'rgb' => '000000'
         //     )
         // ),
         // 'right'     => array(
         //     'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
         //     'color' => array(
         //         'rgb' => '000000'
         //     )
         // ),
         'top'     => array(
             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             'color' => array(
                 'rgb' => '000000'
             )
         ),
         'button'     => array(
             'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
             'color' => array(
                 'rgb' => '000000'
             )
         ),

     )
);






// Redirect output to a client's web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Estadisticas_por_pregunta_'.strtoupper($PruebasInformeProfesor['nombre_titulo']).'_'.strtoupper($PruebasInformeProfesor['nombre_prueba']).'.Xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0


//old PhpExcel code:
//$writer = PHPExcel_IOFactory::createWriter($spreadsheet, 'Excel2007');
//$writer->save('php://output');

//new code:
$writer = IOFactory::createWriter($objPHPExcel, 'Xlsx');
$writer->save('php://output');
exit;