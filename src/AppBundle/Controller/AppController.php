<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ConverterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;



class AppController extends Controller
{
    /**
     * Converter form page
     *
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new ConverterType());
        $form->handleRequest($request);
        if ($form->isValid()) {

        }

        return $this->render('pages/index.html.twig', array (
                'form' => $form->createView(),
            )
        );
    }
}
