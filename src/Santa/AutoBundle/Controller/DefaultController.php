<?php

namespace Santa\AutoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    private $num;

    public function indexAction(REQUEST $request)
    {

        $form = $this->createFormBuilder(array())
            ->add('sort', 'choice', array(
                'choices' => array(
                    0 => 'Nr',
                    1 => 'Study Description',
                    2 => 'Protocol Name',
                    3 => 'Number of events',
                    4 => "Study Date",
                    7 => "Patient's Age",
                    8 => "Patient's Sex",
                    9 => "Patient's Size",
                    10 => "Patient's Weight",
                    11 => "KMI",
                    20 => "Mean CTDI",
                    21 => "Total DLP"
                ),
                'preferred_choices' => array(0)
            ))
            ->add('submit', 'submit')
            ->getForm();

        $form->handleRequest($request);


        $values = array("Study Description",
                        "Protocol Name",
                        "Study Date",
                        "Patient's Birth Date",
                        "Patient ID",
                        "Patient's Age",
                        "Patient's Sex",
                        "Patient's Size",
                        "Patient's Weight",
                        "0018,9306", //"Single Collimation Width"
                        "0018,9307", //"Total Collimation Width"
                        "0018,9311", //"Spiral Pitch Factor"
                        "kVp",
                        "0018,8151", //"X-Ray Tube Current in"
                        "Exposure Time",
                        "0018,9345", // "CTDIvol"
                        "DLP"
                        );

        $kernel = $this->get('kernel');
        $path = $kernel->locateResource('@SantaAutoBundle/Resources/data');

        $finder = new Finder();
        $finder->files()->in($path);

        foreach($finder as $file){
            $id = $this->getFileNr($file->getRealpath());
            $contents[$id] = $file->getContents();
        }

        for ($i=1; $i<(count($contents)/2)+1; $i++){
            $arejus[$i] = $contents[$i] . $contents[$i.'a'];
            $data[] = $this->get("reader")->readValues($arejus[$i], $values, $i);
        }

        if ($form->isValid()){
            $this->num = $form->get('sort')->getData();
            usort($data, function($a, $b) { return $a[$this->num]*100 - $b[$this->num]*100; });
            $this->get('excel')->write($data);
        }

        return $this->render('SantaAutoBundle:Default:index.html.twig', array ('form'=>$form->createView()));
    }

    public function excelAction(){

        $this->get('excel')->write();

        return $this->render('SantaAutoBundle:Default:excel.html.twig');
    }


    private function getFileNr($string){
        $start = strrpos($string, '\\') + 1;
        $end = strrpos($string, '.');
        return substr($string, $start, $end-$start);
    }


    private function my_sort($a, $b, $key){
        return $a[$key]-$b[$key];
    }



}
