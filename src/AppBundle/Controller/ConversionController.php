<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConversionController extends Controller
{
    /**
     * Converts currencies and outputs result in json format
     *
     * @Route("/currency/convert", name="currencyConvert")
     */
    public function convetAction()
    {

    }
}
