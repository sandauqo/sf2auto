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



    public function readValues($string, $values){

        //test
        $return = array();
        $count = 1;
        foreach($values as $value){
            if ($count < 10){


            $substring1 = strstr($string, $value);

            $substring2 = strstr($substring1, 'Value: ');

            $end = strpos($substring2, '(');

            $return[] = substr($substring2, 7, $end-7);
            }else{

                if ($value === 'DLP'){
                    $sub_array = array();
                    $string2 = strstr($string, 'File Meta');
                    $kiek = substr_count($string2, 'CTDIvol');
                    $substring = strstr($string2, $value);
                    for ($i=0;$i<$kiek;$i++){
                        $substring = strstr($substring, $value);
                        $substring = substr($substring, 1);
                        //$return[] = $substring;
                        $a = strstr($substring, $value);
                        $end = strpos($a, 'E');
                        if ($end == false){
                            $sub_array[] = substr($a, 4);
                        }else{
                            $sub_array[] = substr($a, 4, $end-4);
                        }
                    }
                    $return[] = $sub_array;

                    break;
                }

                $string2 = strstr($string, 'File Meta');
                $kiek = substr_count($string2, 'CTDIvol');
                $position = strpos($string2, 'CTDIvol'); //pirmo CTDIvol vieta
                $position_from_end = strlen($string2)-$position;
                $start = strrpos($string2, 'Group Length', -$position_from_end);
                $string2 = substr($string2, $start);

                $sub_array = array();
                for ($i=0;$i<$kiek;$i++){

                    $substring = strstr($string2, $value);

                    $string2 = strstr($substring, 'Value: '); //

                    $end = strpos($string2, '(');

                    $sub_array[] = substr($string2, 7, $end-7);

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