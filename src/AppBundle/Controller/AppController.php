<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ConverterType;
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
        $form = $this->createForm(new ConverterType($this->getDoctrine()->getEntityManager()));
        $this->get('converter_ecb')->convert('2015-07-06', 13.35, 'EUR', 'USD');
        return $this->render('pages/index.html.twig', array(
                'form' => $form->createView(),
            )
        );
    }
}
