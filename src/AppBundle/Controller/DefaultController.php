<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Event;

class DefaultController extends Controller
{

    /**
     * Displays the app homepage
     *
     * @Route("/", name="homepage")
     * @Template(":default:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $features = $em->getRepository('AppBundle:Feature')->findAllSorted();

        return array(
            'features' => $features,
        );
    }
}
