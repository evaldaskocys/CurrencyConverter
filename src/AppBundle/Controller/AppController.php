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
        $dateChoices = $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Currency')->findAllDatesForChoiceField();

        $form = $this->createForm(new ConverterType($dateChoices));

        return $this->render('pages/index.html.twig', array (
                'form' => $form->createView(),
            )
        );
    }
}
