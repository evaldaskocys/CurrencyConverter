<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ConversionController extends Controller
{
    /**
     * Converts currencies and outputs result in json format
     *
     * @Route("/currency/convert/ECB", name="currencyConvert")
     */
    public function convetECBAction($date, $amount, $currencySell, $currencyBuy)
    {
        $result = $this->get('converter_ecb')->convert($date, $amount, $currencySell, $currencyBuy);

        $response = new JsonResponse();
        $response->setData($result);
        return $response;
    }
}
