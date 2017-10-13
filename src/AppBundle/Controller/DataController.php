<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Data controller.
 *
 * @Route("/data")
 */
class DataController extends Controller
{
    /**
     * @Route("/index", name="data_index")
     */
    public function indexAction()
    {

        return $this->render('AppBundle:Data:index.html.twig', array());
    }

    /**
     * Lists all School entities.
     *
     * @Route("/school.json", name="data_school")
     * @Method("GET")
     */
    public function schoolAction()
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:School')->findSchoolData();
        $response = new JsonResponse();
        $response->setData($data);
        return $response;
    }


    /**
     * Lists all School entities.
     *
     * @Route("/graddate.json", name="data_graddate")
     * @Method("GET")
     */
    public function graddateAction()
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:User')->findGraddateData();
        $response = new JsonResponse();
        $response->setData($data);
        return $response;
    }

}