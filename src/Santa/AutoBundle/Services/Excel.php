<?php
/**
 * Created by PhpStorm.
 * User: MDSKLLZ
 * Date: 10/30/14
 * Time: 1:59 PM
 */

namespace Santa\AutoBundle\Services;


use PHPExcel_IOFactory;
use PHPExcel_Style_Alignment;
use PHPExcel_Style_Border;

class Excel {

    public function write ($data){
        $excel = new \PHPExcel();
        $excel->getProperties()->setCreator("Kristina Kristinaityte");
        $excel->getProperties()->setLastModifiedBy("Kristina Kristinaityte");
        $excel->getProperties()->setTitle("Duomenys");
        $excel->getProperties()->setSubject("Duomenys");
        $excel->getProperties()->setDescription("Duomenys");

        $excel->setActiveSheetIndex(0);

        $excel->getDefaultStyle()
            ->getAlignment()
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);



        $excel->getActiveSheet()->getStyle(
            'B3:X3'
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

        $excel->getActiveSheet()->getStyle('B3:X3')->getFont()->setSize(12)->setBold(true);

        $excel->getActiveSheet()->SetCellValue('B3', 'Nr.');
        $excel->getActiveSheet()->SetCellValue('C3', 'Tyrimas');
        $excel->getActiveSheet()->SetCellValue('D3', 'Protokolas');
        $excel->getActiveSheet()->SetCellValue('E3', 'S');
        $excel->getActiveSheet()->SetCellValue('F3', 'Tyrimo data');
        $excel->getActiveSheet()->SetCellValue('G3', 'Gimimo metai');
        $excel->getActiveSheet()->SetCellValue('H3', 'Paciento ID');
        $excel->getActiveSheet()->SetCellValue('I3', 'Amžius');
        $excel->getActiveSheet()->SetCellValue('J3', 'Lytis');
        $excel->getActiveSheet()->SetCellValue('K3', 'Ūgis, m');
        $excel->getActiveSheet()->SetCellValue('L3', 'Svoris, kg');
        $excel->getActiveSheet()->SetCellValue('M3', 'KMI, kg/m^2');
        $excel->getActiveSheet()->SetCellValue('N3', 'n, mm');
        $excel->getActiveSheet()->SetCellValue('O3', 'N, mm');
        $excel->getActiveSheet()->SetCellValue('P3', 'p');
        $excel->getActiveSheet()->SetCellValue('Q3', 'U, V');
        $excel->getActiveSheet()->SetCellValue('R3', 'I, mA');
        $excel->getActiveSheet()->SetCellValue('S3', 't, s');
        $excel->getActiveSheet()->SetCellValue('T3', 'CTDI');
        $excel->getActiveSheet()->SetCellValue('U3', 'DLP');
        $excel->getActiveSheet()->SetCellValue('V3', 'Mean CTDI');
        $excel->getActiveSheet()->SetCellValue('W3', 'Total DLP');
        $excel->getActiveSheet()->SetCellValue('X3', 'Eff');

        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(5);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(11);
        $excel->getActiveSheet()->getColumnDimension('M')->setWidth(14);
        $excel->getActiveSheet()->getColumnDimension('N')->setWidth(8);
        $excel->getActiveSheet()->getColumnDimension('O')->setWidth(8);
        $excel->getActiveSheet()->getColumnDimension('P')->setWidth(8);
        $excel->getActiveSheet()->getColumnDimension('Q')->setWidth(8);
        $excel->getActiveSheet()->getColumnDimension('R')->setWidth(8);
        $excel->getActiveSheet()->getColumnDimension('S')->setWidth(8);
        $excel->getActiveSheet()->getColumnDimension('T')->setWidth(14);
        $excel->getActiveSheet()->getColumnDimension('U')->setWidth(14);
        $excel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
        $excel->getActiveSheet()->getColumnDimension('W')->setWidth(15);

        $i=4;
        foreach ($data as $dat){

            $tyrimo_data = substr($dat[4],0,4).'-'.substr($dat[4],4,2).'-'.substr($dat[4], 6,2);

            $gimimo_metai = substr($dat[5],0,4).'-'.substr($dat[5],4,2).'-'.substr($dat[5], 6,2);

            if (substr($dat[7],0,2) == "00"){
                $amzius = substr($dat[7],2,1);
            }else if (substr($dat[7],0,1) == "0"){
                $amzius = substr($dat[7],1,2);
            }else{
                $amzius = substr($dat[7],0,3);
            }

            $excel->getActiveSheet()->SetCellValue('B'.$i, $dat[0]);
            $excel->getActiveSheet()->SetCellValue('C'.$i, $dat[1]);
            $excel->getActiveSheet()->SetCellValue('D'.$i, $dat[2]);
            $excel->getActiveSheet()->SetCellValue('E'.$i, $dat[3]);
            $excel->getActiveSheet()->SetCellValue('F'.$i, $tyrimo_data);
            $excel->getActiveSheet()->SetCellValue('G'.$i, $gimimo_metai);
            $excel->getActiveSheet()->SetCellValue('H'.$i, $dat[6]);
            $excel->getActiveSheet()->SetCellValue('I'.$i, $amzius);
            $excel->getActiveSheet()->SetCellValue('J'.$i, $dat[8]);
            $excel->getActiveSheet()->SetCellValue('K'.$i, $dat[9]);
            $excel->getActiveSheet()->SetCellValue('L'.$i, $dat[10]);
            $excel->getActiveSheet()->SetCellValue('M'.$i, $dat[11]);
            //cia array vertes
            $j=0;
            foreach($dat[12] as $da){
                $excel->getActiveSheet()->SetCellValue('N'.($i+$j), round($da,2));
                $j++;
            }
            $j=0;
            foreach($dat[13] as $da){
                $excel->getActiveSheet()->SetCellValue('O'.($i+$j), round($da,2));
                $j++;
            }
            $j=0;
            foreach($dat[14] as $da){
                $excel->getActiveSheet()->SetCellValue('P'.($i+$j), round($da,2));
                $j++;
            }
            $j=0;
            foreach($dat[15] as $da){
                $excel->getActiveSheet()->SetCellValue('Q'.($i+$j), round($da,2));
                $j++;
            }
            $j=0;
            foreach($dat[16] as $da){
                $excel->getActiveSheet()->SetCellValue('R'.($i+$j), round($da/1000,2));
                $j++;
            }
            $j=0;
            foreach($dat[17] as $da){
                $excel->getActiveSheet()->SetCellValue('S'.($i+$j), round($da/1000,2));
                $j++;
            }
            $j=0;
            foreach($dat[18] as $da){
                $excel->getActiveSheet()->SetCellValue('T'.($i+$j), round($da,2));
                $j++;
            }
            $j=0;
            foreach($dat[19] as $da){
                $excel->getActiveSheet()->SetCellValue('U'.($i+$j), round($da,2));
                $j++;
            }

            $excel->getActiveSheet()->SetCellValue('V'.$i, $dat[20]);
            $excel->getActiveSheet()->SetCellValue('W'.$i, $dat[21]);


            //laikinas

            for ($k=1;$k<$dat[3];$k++){
                $excel->getActiveSheet()->SetCellValue('C'.($i+$k), $dat[1]);
            }


            //laikinas


            $styleArray = array(
                'borders' => array(
                    'outline' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    ),
                )
            );

            $excel->getActiveSheet()->getStyle('B'.$i.':X'.($i+$dat[3]-1))->applyFromArray($styleArray);
            unset($styleArray);

            $i += $dat[3];


        }

        $sheetId = 1;
        $excel->createSheet(NULL, 1);
        $excel->setActiveSheetIndex(1);
        $excel->getActiveSheet()->setTitle('CTDI ir DLP');

        $excel->getActiveSheet()->getStyle(
            'B3:D3'
        )->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);

        $excel->getActiveSheet()->getStyle('B3:D3')->getFont()->setSize(12)->setBold(true);

        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);

        $excel->getActiveSheet()->SetCellValue('B3', 'Nr.');
        $excel->getActiveSheet()->SetCellValue('C3', 'Mean CTDI');
        $excel->getActiveSheet()->SetCellValue('D3', 'Total DLP');

        $i=4;
        foreach ($data as $dat){
            $excel->getActiveSheet()->SetCellValue('B'.$i, $dat[0]);
            $excel->getActiveSheet()->SetCellValue('C'.$i, $dat[20]);
            $excel->getActiveSheet()->SetCellValue('D'.$i, $dat[21]);
            $i++;
        }

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ),
            )
        );

        $excel->getActiveSheet()->getStyle('B4:D'.($i-1))->applyFromArray($styleArray);
        unset($styleArray);

        $excel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . 'Duomenys' . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $objWriter->save('php://output');


    }


} 