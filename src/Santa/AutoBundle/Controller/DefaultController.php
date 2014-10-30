<?php

namespace Santa\AutoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $values = array("Study Description",
                        "Protocol Name",
                        "Study Date",
                        "Patient's Birth Date",
                        "Patient ID",
                        "Patient's Age",
                        "Patient's Sex",
                        "Patient's Size",
                        "Patient's Weight",
                        "Exposure Time"
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
            $data[] = $this->get("reader")->readValues($arejus[$i], $values);
        }



        $this->get('excel')->write($data);


        return $this->render('SantaAutoBundle:Default:index.html.twig', array('data' => $data));
    }

    public function excelAction(){

        $this->get('excel')->write();

        return $this->render('SantaAutoBundle:Default:excel.html.twig');
    }


    private function getFileNr($string){
        $start = strrpos($string, '\\') + 1;
        $end = strrpos($string, '-');
        return substr($string, $start, $end-$start);
    }



}
