<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Event;

class DefaultController extends Controller
{

    /**
     * Displays the app homepage
     *
     * @Route("/", name="homepage")
     * @Method("GET")
     * @Template(":default:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Event')->findAll();
        $features = $em->getRepository('AppBundle:Feature')->findAll();

        return array(
            'entities' => $entities,
            'features' => $features,
        );
    }
}
