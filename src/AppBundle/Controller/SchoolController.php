<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\School;
use AppBundle\Form\SchoolType;

/**
 * School controller.
 *
 * @Route("/school")
 */
class SchoolController extends Controller
{

    /**
     * Lists all School entities.
     *
     * @Route("/", name="school")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:School')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new School entity.
     *
     * @Route("/", name="school_create")
     * @Method("POST")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new School();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('school'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a School entity.
     *
     * @param School $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(School $entity)
    {
        $form = $this->createForm(new SchoolType(), $entity, array(
            'action' => $this->generateUrl('school_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new School entity.
     *
     * @Route("/new", name="school_new")
     * @Method("GET")
     * * @Template("AppBundle:Shared:new.html.twig")
     */
    public function newAction()
    {
        $entity = new School();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing School entity.
     *
     * @Route("/{id}/edit", name="school_edit")
     * @Method("GET")
     * * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:School')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find School entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a School entity.
    *
    * @param School $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(School $entity)
    {
        $form = $this->createForm(new SchoolType(), $entity, array(
            'action' => $this->generateUrl('school_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing School entity.
     *
     * @Route("/{id}", name="school_update")
     * @Method("PUT")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:School')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find School entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('school'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Finds and displays a School entity with report.
     *
     * @Route("/show/{id}", name="school_show")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $schools = $em->getRepository('AppBundle:School')->findAll();
        $school = $em->getRepository('AppBundle:School')->find($id);
        $tag = $em->getRepository('AppBundle:Tag')->findOneByTitle("Alumni");
        $alumni = $em->getRepository('AppBundle:User')->findByTagSchool($tag->getId() ,$school);
        $tag = $em->getRepository('AppBundle:Tag')->findOneByTitle("Active");
        $active = $em->getRepository('AppBundle:User')->findByTagSchool($tag->getId() ,$school);
        $anchors = $em->getRepository('AppBundle:Checklist')->findAnchorData();
        $social = $em->getRepository('AppBundle:Checklist')->findSphere3Data();
        $economic = $em->getRepository('AppBundle:Checklist')->findSphere2Data();
        $ecological = $em->getRepository('AppBundle:Checklist')->findSphere1Data();

        if (!$school) {
            throw $this->createNotFoundException('Unable to find Capstone entity.');
        }

        return array(
            'entity' => $school,
            'alumni' => $alumni,
            'active' => $active,
            'schools' => $schools,
            'anchors' => $anchors,
            'social' => $social,
            'economic' => $economic,
            'ecological' => $ecological,
        );
    }


    /**
     * Deletes a School entity.
     *
     * @Route("/{id}", name="school_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:School')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find School entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('school'));
    }

    /**
     * Creates a form to delete a School entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('school_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
