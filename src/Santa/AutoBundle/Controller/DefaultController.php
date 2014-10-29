<?php

namespace Santa\AutoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;

class DefaultController extends Controller
{
    public function indexAction()
    {

        $kernel = $this->get('kernel');
        $path = $kernel->locateResource('@SantaAutoBundle/Resources/data');

        $finder = new Finder();
        $finder->files()->in($path);

        foreach($finder as $file){
            $contents[] = $file->getContents();
        }
        \Doctrine\Common\Util\Debug::dump($contents);

        return $this->render('SantaAutoBundle:Default:index.html.twig');
    }
}
