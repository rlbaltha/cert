<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Questionset;
use AppBundle\Form\QuestionsetType;

/**
 * Questionset controller.
 *
 * @Route("/questionset")
 */
class QuestionsetController extends Controller
{

    /**
     * Lists all Questionset entities.
     *
     * @Route("/", name="questionset")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Questionset')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Questionset entity.
     *
     * @Route("/", name="questionset_create")
     * @Method("POST")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Questionset();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('questionset'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Questionset entity.
     *
     * @param Questionset $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Questionset $entity)
    {
        $form = $this->createForm(new QuestionsetType(), $entity, array(
            'action' => $this->generateUrl('questionset_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Questionset entity.
     *
     * @Route("/new", name="questionset_new")
     * @Method("GET")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Questionset();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Questionset entity.
     *
     * @Route("/{id}", name="questionset_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Questionset')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Questionset entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Questionset entity.
     *
     * @Route("/{id}/edit", name="questionset_edit")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Questionset')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Questionset entity.');
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
    * Creates a form to edit a Questionset entity.
    *
    * @param Questionset $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Questionset $entity)
    {
        $form = $this->createForm(new QuestionsetType(), $entity, array(
            'action' => $this->generateUrl('questionset_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Questionset entity.
     *
     * @Route("/{id}", name="questionset_update")
     * @Method("PUT")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Questionset')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Questionset entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('questionset'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Questionset entity.
     *
     * @Route("/{id}", name="questionset_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Questionset')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Questionset entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('questionset'));
    }

    /**
     * Creates a form to delete a Questionset entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('questionset_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
