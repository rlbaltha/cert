<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Capstone;
use AppBundle\Form\CapstoneType;

/**
 * Capstone controller.
 *
 * @Route("/capstone")
 */
class CapstoneController extends Controller
{


    /**
     * Creates a new Capstone entity.
     *
     * @Route("/", name="capstone_create")
     * @Method("POST")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Capstone();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user=$this->getUser();
            $entity->setUser($user);

            $user_entity = $em->getRepository('AppBundle:User')->find($user);
            $status = $em->getRepository('AppBundle:Status')->findByName('Capstone Created');
            $user_entity->setProgress($status);

            $em->persist($entity);
            $em->persist($user_entity);
            $em->flush();

            return $this->redirect($this->generateUrl('user_profile'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Capstone entity.
     *
     * @param Capstone $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Capstone $entity)
    {
        $form = $this->createForm(new CapstoneType(), $entity, array(
            'action' => $this->generateUrl('capstone_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }

    /**
     * Displays a form to create a new Capstone entity.
     *
     * @Route("/new", name="capstone_new")
     * @Method("GET")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Capstone();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * Displays a form to edit an existing Capstone entity.
     *
     * @Route("/{id}/edit", name="capstone_edit")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Capstone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capstone entity.');
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
    * Creates a form to edit a Capstone entity.
    *
    * @param Capstone $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Capstone $entity)
    {
        $form = $this->createForm(new CapstoneType(), $entity, array(
            'action' => $this->generateUrl('capstone_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Capstone entity.
     *
     * @Route("/{id}", name="capstone_update")
     * @Method("PUT")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Capstone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capstone entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('user_profile'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Capstone entity.
     *
     * @Route("/{id}", name="capstone_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Capstone')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Capstone entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user_profile'));
    }

    /**
     * Creates a form to delete a Capstone entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('capstone_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
