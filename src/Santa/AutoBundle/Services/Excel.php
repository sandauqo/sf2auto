<?php
/**
 * Created by PhpStorm.
 * User: MDSKLLZ
 * Date: 10/30/14
 * Time: 1:59 PM
 */

namespace Santa\AutoBundle\Services;


use PHPExcel_IOFactory;

class Excel {

    public function write ($data){
        $excel = new \PHPExcel();
        $excel->getProperties()->setCreator("Kristina Kristinaityte");
        $excel->getProperties()->setLastModifiedBy("Kristina Kristinaityte");
        $excel->getProperties()->setTitle("Duomenys");
        $excel->getProperties()->setSubject("Duomenys");
        $excel->getProperties()->setDescription("Duomenys");

        $excel->setActiveSheetIndex(0);
        $excel->getActiveSheet()->SetCellValue('B3', 'Tyrimas');
        $excel->getActiveSheet()->SetCellValue('C3', 'Protokolas');
        $excel->getActiveSheet()->SetCellValue('D3', 'Tyrimo data');
        $excel->getActiveSheet()->SetCellValue('E3', 'Gimimo metai');
        $excel->getActiveSheet()->SetCellValue('F3', 'Paciento ID');
        $excel->getActiveSheet()->SetCellValue('G3', 'Amžius');
        $excel->getActiveSheet()->SetCellValue('H3', 'Lytis');
        $excel->getActiveSheet()->SetCellValue('I3', 'Ūgis');
        $excel->getActiveSheet()->SetCellValue('J3', 'Svoris');
        $excel->getActiveSheet()->SetCellValue('K3', 'KMI');
        $excel->getActiveSheet()->SetCellValue('L3', 't, ms');
        $excel->getActiveSheet()->SetCellValue('M3', 'U, kV');
        $excel->getActiveSheet()->SetCellValue('N3', 'CTDI');
        $excel->getActiveSheet()->SetCellValue('O3', 'DLP');
        $excel->getActiveSheet()->SetCellValue('P3', 'Eff');

        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $excel->getActiveSheet()->getColumnDimension('P')->setWidth(20);

        $i = 4;
        foreach ($data as $dat){

            $tyrimo_data = substr($dat[2],0,4).'-'.substr($dat[2],4,2).'-'.substr($dat[2], 6,2);

            $gimimo_metai = substr($dat[3],0,4).'-'.substr($dat[3],4,2).'-'.substr($dat[3], 6,2);

            if (substr($dat[5],0,2) == "00"){
                $amzius = substr($dat[5],2,1);
            }else if (substr($dat[5],0,1) == "0"){
                $amzius = substr($dat[5],1,2);
            }else{
                $amzius = substr($dat[5],0,3);
            }

            if ($dat[7] !== false and $dat[8]!== false){
                $KMI = round($dat[8]/($dat[7]*$dat[7]),1);
            }else{
                $KMI = false;
            }
            $excel->getActiveSheet()->SetCellValue('B'.$i, $dat[0]);
            $excel->getActiveSheet()->SetCellValue('C'.$i, $dat[1]);
            $excel->getActiveSheet()->SetCellValue('D'.$i, $tyrimo_data);
            $excel->getActiveSheet()->SetCellValue('E'.$i, $gimimo_metai);
            $excel->getActiveSheet()->SetCellValue('F'.$i, $dat[4]);
            $excel->getActiveSheet()->SetCellValue('G'.$i, $amzius);
            $excel->getActiveSheet()->SetCellValue('H'.$i, $dat[6]);
            $excel->getActiveSheet()->SetCellValue('I'.$i, $dat[7]);
            $excel->getActiveSheet()->SetCellValue('J'.$i, $dat[8]);
            $excel->getActiveSheet()->SetCellValue('K'.$i, $KMI);

//            $excel->getActiveSheet()->SetCellValue('L'.$i, $dat[0]);
//            $excel->getActiveSheet()->SetCellValue('M'.$i, $dat[0]);
//            $excel->getActiveSheet()->SetCellValue('N'.$i, $dat[0]);
//            $excel->getActiveSheet()->SetCellValue('O'.$i, $dat[0]);
//            $excel->getActiveSheet()->SetCellValue('P'.$i, $dat[0]);
            $i++;
        }







        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . 'Duomenys' . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $objWriter->save('php://output');


    }


} 