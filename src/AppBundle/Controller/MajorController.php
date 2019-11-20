<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Major;
use AppBundle\Form\MajorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Major controller.
 *
 * @Route("/major")
 */
class MajorController extends Controller
{

    /**
     * Lists all Major entities.
     *
     * @Route("/", name="major")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Major')->findAll();

        return $this->render('AppBundle:Major:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Major entity.
     *
     * @Route("/", name="major_create")
     * @Method("POST")

     */
    public function createAction(Request $request)
    {
        $entity = new Major();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('major_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Major entity.
     *
     * @param Major $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Major $entity)
    {
        $form = $this->createForm(MajorType::class, $entity, array(
            'action' => $this->generateUrl('major_create'),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Major entity.
     *
     * @Route("/new", name="major_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Major();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Major entity.
     *
     * @Route("/{id}", name="major_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Major')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Major entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Major entity.
     *
     * @Route("/{id}/edit", name="major_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Major')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Major entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Shared:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Major entity.
    *
    * @param Major $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Major $entity)
    {
        $form = $this->createForm(MajorType::class, $entity, array(
            'action' => $this->generateUrl('major_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Major entity.
     *
     * @Route("/{id}", name="major_update")
     * @Method("PUT")

     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Major')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Major entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('major_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Shared:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Major entity.
     *
     * @Route("/{id}", name="major_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Major')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Major entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('major'));
    }

    /**
     * Creates a form to delete a Major entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('major_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
