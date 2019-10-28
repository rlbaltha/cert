<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Review;
use AppBundle\Form\ReviewType;

/**
 * Review controller.
 *
 * @Route("/review")
 */
class ReviewController extends Controller
{

    /**
     * Lists all Review entities.
     *
     * @Route("/", name="review")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Review')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Review entity.
     *
     * @Route("/{checkpointid}/{reviewerid}", name="review_create")
     * @Method("POST")

     */
    public function createAction(Request $request, $checkpointid, $reviewerid)
    {
        $em = $this->getDoctrine()->getManager();
        $reviewer = $em->getRepository('AppBundle:User')->find($reviewerid);
        $checkpoint = $em->getRepository('AppBundle:Checkpoint')->find($checkpointid);

        $entity = new Review();
        $entity->setCheckpoint($checkpoint);
        $entity->setReviewer($reviewer);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($entity->getCheckpoint()->getProject()->getCapstone()) {
                return $this->redirect($this->generateUrl('capstone_show', array('id' => $entity->getCheckpoint()->getProject()->getUser()->getId())));
            }
            else {
                return $this->redirect($this->generateUrl('project_show', array('id' => $entity->getCheckpoint()->getProject()->getId())));
            }


        }

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Review entity.
     *
     * @param Review $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Review $entity)
    {
        $form = $this->createForm(new ReviewType(), $entity, array(
            'action' => $this->generateUrl('review_create', array('checkpointid' => $entity->getCheckpoint()->getId(), 'reviewerid' => $entity->getReviewer()->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Review entity.
     *
     * @Route("/new/{checkpointid}/{reviewerid}", name="review_new", defaults = {"checkpointid" = 0, "reviewerid" = 0})
     * @Method("GET")
     */
    public function newAction($checkpointid, $reviewerid)
    {
        $entity = new Review();

        $em = $this->getDoctrine()->getManager();
        $reviewer = $em->getRepository('AppBundle:User')->find($reviewerid);
        $checkpoint = $em->getRepository('AppBundle:Checkpoint')->find($checkpointid);
        $entity->setCheckpoint($checkpoint);
        $entity->setReviewer($reviewer);

        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Review entity.
     *
     * @Route("/{id}", name="review_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Review')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Review entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Review entity.
     *
     * @Route("/{id}/edit", name="review_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Review')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Review entity.');
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
    * Creates a form to edit a Review entity.
    *
    * @param Review $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Review $entity)
    {
        $form = $this->createForm(new ReviewType(), $entity, array(
            'action' => $this->generateUrl('review_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Review entity.
     *
     * @Route("/{id}", name="review_update")
     * @Method("PUT")

     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Review')->find($id);


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Review entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            if ($entity->getCheckpoint()->getProject()->getCapstone()) {
                return $this->redirect($this->generateUrl('capstone_show', array('id' => $entity->getCheckpoint()->getProject()->getUser()->getId())));
            }
            else {
                return $this->redirect($this->generateUrl('project_show', array('id' => $entity->getCheckpoint()->getProject()->getId())));
            }
        }

        return $this->render('AppBundle:Shared:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Review entity.
     *
     * @Route("/{id}", name="review_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Review')->find($id);
            $projectid = $entity->getCheckpoint()->getProject()->getId();

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Review entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('project_show', array('id' => $projectid)));
    }

    /**
     * Creates a form to delete a Review entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('review_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
