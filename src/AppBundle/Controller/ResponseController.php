<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Response;
use AppBundle\Form\ResponseType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Response controller.
 *
 * @Route("/response")
 */
class ResponseController extends Controller
{

    /**
     * Lists all Response entities.
     *
     * @Route("/", name="response", methods={"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Response')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Response entity.
     *
     * @Route("/", name="response_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $entity = new Response();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('response_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Response entity.
     *
     * @param Response $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Response $entity)
    {
        $form = $this->createForm(ResponseType::class, $entity, array(
            'action' => $this->generateUrl('response_create'),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Response entity.
     *
     * @Route("/new", name="response_new", methods={"GET"})
     */
    public function newAction()
    {
        $entity = new Response();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Response entity.
     *
     * @Route("/{id}", name="response_show", methods={"GET"})
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Response')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Response entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Response entity.
     *
     * @Route("/{id}/edit", name="response_edit", methods={"GET"})
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Response')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Response entity.');
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
    * Creates a form to edit a Response entity.
    *
    * @param Response $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Response $entity)
    {
        $form = $this->createForm(ResponseType::class, $entity, array(
            'action' => $this->generateUrl('response_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Response entity.
     *
     * @Route("/{id}", name="response_update", methods={"PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Response')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Response entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('response_edit', array('id' => $id)));
        }

        return $this->render('AppBundle:Shared:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Response entity.
     *
     * @Route("/{id}", name="response_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Response')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Response entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('response'));
    }

    /**
     * Creates a form to delete a Response entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('response_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
