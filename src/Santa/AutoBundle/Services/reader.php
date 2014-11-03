<?php
/**
 * Created by PhpStorm.
 * User: MDSKLLZ
 * Date: 10/29/14
 * Time: 12:46 PM
 */

namespace Santa\AutoBundle\Services;

use Doctrine\ORM\EntityManager;


class Reader {



    public function readValues($string, $values, $number){


        $return[] = $number;
        $count = 1;
        $kiek_check = false;
        $kmi_check = false;
        foreach($values as $value){
            if ($count < 10){

            $substring1 = strstr($string, $value.': ');

            $start = strpos($substring1, ':');
            $end = strpos($substring1, PHP_EOL);

            $return[] = trim(substr($substring1, $start+2, $end-$start));
            }else{
                if ($kmi_check === false){
                    $return[] = round($return[9]/($return[8]*$return[8]),2);
                    $kmi_check = true;
                }

                if ($value === 'DLP'){
                    $sub_array = array();
                    $string2 = strstr($string, 'Media Storage');
                    $kiek = substr_count($string2, '0018,9345');
                    $substring = strstr($string2, $value);
                    for ($i=0;$i<$kiek;$i++){
                        $substring = strstr($substring, $value);
                        $substring = substr($substring, 1);
                        $a = strstr($substring, $value);
                        $end = strpos($a, PHP_EOL);
                        if ($end == false){
                            $sub_array[] = substr($a, 4);
                        }else{
                            $sub_array[] = substr($a, 4, $end-4);
                        }
                    }
                    $return[] = $sub_array;

                    $sumret18 = 0;
                    foreach($return[18] as $ret18){
                        $sumret18+=$ret18;
                    }
                    $return[] = $sumret18;

                    $vidret19=0;
                    foreach($return[19] as $ret19){
                        $vidret19+=$ret19;
                    }
                    $return[] = round($vidret19/$kiek,2);
                    break;
                }

                $string2 = strstr($string, 'Media Storage');
                $kiek = substr_count($string2, '0018,9345');
                $position = strpos($string2, '0018,9345'); //pirmo CTDIvol vieta
                $position_from_end = strlen($string2)-$position;
                $start = strrpos($string2, 'Code Value', -$position_from_end);
                $string2 = substr($string2, $start);


                if ($kiek_check === false){
                    array_splice($return, 3, 0, array($kiek));
                    $kiek_check = true;
                }


                $sub_array = array();
                for ($i=0;$i<$kiek;$i++){

                    $substring = strstr($string2, $value);
                    $string2 = strstr($substring, ': ');


                    $start = strpos($string2, ':');

                    $end = strpos($string2, PHP_EOL);
                    $sub_array[] = trim(substr($string2, $start+2, $end-$start));

                }$return[] = $sub_array;
            }
            $count++;
        }

        return $return;

    }

    private function strpos2($haystack, $needle){
        $pos1 = strpos($haystack, $needle);
        $pos2 = strpos($haystack, $needle, $pos1 + strlen($needle));
        return $pos2;
    }






}