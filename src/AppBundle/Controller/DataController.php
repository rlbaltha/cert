<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("/index", name="data_index", methods={"GET"})
     */
    public function indexAction()
    {

        return $this->render('AppBundle:Data:index.html.twig', array());
    }

    /**
     * Lists all School entities.
     *
     * @Route("/school.json", name="data_school", methods={"GET"})
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
     * Lists all Major entities.
     *
     * @Route("/major.json", name="data_major", methods={"GET"})
     */
    public function majorAction()
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:Major')->findMajorData();
        $response = new JsonResponse();
        $response->setData($data);
        return $response;
    }

    /**
     * Lists all Anchor entities.
     *
     * @Route("/anchor.json", name="data_anchor", methods={"GET"})
     */
    public function anchorAction()
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:Checklist')->findAnchorData();
        $response = new JsonResponse();
        $response->setData($data);
        return $response;
    }

    /**
     * Lists all Anchor entities.
     *
     * @Route("/sphere1.json", name="data_sphere1", methods={"GET"})
     */
    public function sphere1Action()
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:Checklist')->findSphere1Data();
        $response = new JsonResponse();
        $response->setData($data);
        return $response;
    }

    /**
     * Lists all Anchor entities.
     *
     * @Route("/sphere2.json", name="data_sphere2", methods={"GET"})
     */
    public function sphere2Action()
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:Checklist')->findSphere2Data();
        $response = new JsonResponse();
        $response->setData($data);
        return $response;
    }

    /**
     * Lists all Anchor entities.
     *
     * @Route("/sphere3.json", name="data_sphere3", methods={"GET"})
     */
    public function sphere3Action()
    {
        $em = $this->getDoctrine()->getManager();
        $data = $em->getRepository('AppBundle:Checklist')->findSphere3Data();
        $response = new JsonResponse();
        $response->setData($data);
        return $response;
    }



    /**
     * Lists all School entities.
     *
     * @Route("/graddate.json", name="data_graddate", methods={"GET"})
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