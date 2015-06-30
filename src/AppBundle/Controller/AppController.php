<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    /**
     * Converter form page
     *
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('pages/index.html.twig');
    }
}
