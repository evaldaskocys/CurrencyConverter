<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ConversionController extends Controller
{
    /**
     * Converts currencies and outputs result in json format
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     *
     * @Route("/convert_currency/ECB/", name="convertCurrency", options={"expose"=true})
     */
    public function convertECBAction(Request $request)
    {
        $date = $request->request->get('date');
        $amount = $request->request->get('amount');
        $currencySell = $request->request->get('currencySell');
        $currencyBuy = $request->request->get('currencyBuy');

        $result = $this->get('converter_ecb')->convert($date, $amount, $currencySell, $currencyBuy);

        $response = new JsonResponse();
        $response->setData($result);
        return $response;
    }
}
