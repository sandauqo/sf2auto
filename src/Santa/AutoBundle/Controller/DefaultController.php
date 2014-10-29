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
                        "Patient's Weight"
                        );

        $kernel = $this->get('kernel');
        $path = $kernel->locateResource('@SantaAutoBundle/Resources/data');

        $finder = new Finder();
        $finder->files()->in($path);

        foreach($finder as $file){
            $contents = $file->getContents();
            $data = $this->get("reader")->readValues($contents, $values);
            break;

        }

        return $this->render('SantaAutoBundle:Default:index.html.twig', array('data' => $data));
    }
}
