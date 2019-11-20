<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Notification;
use AppBundle\Form\NotificationType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Notification controller.
 *
 * @Route("/notification")
 */
class NotificationController extends Controller
{

    /**
     * Lists all Notification entities.
     *
     * @Route("/list/{status}", name="notification", defaults={"status" = "Shared"})
     * @Method("GET")
     * @Template()
     */
    public function indexAction($status)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Notification')->findByStatus($status);
        $tags = $em->getRepository('AppBundle:Tag')->findByType('user');

        return array(
            'entities' => $entities,
            'tags' => $tags
        );
    }

    /**
     * Creates a new Notification entity.
     *
     * @Route("/", name="notification_create")
     * @Method("POST")

     */
    public function createAction(Request $request)
    {
        $entity = new Notification();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('notification_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }


    /**
     * Creates a new Notification entity.
     *
     * @Route("/post/{post_id}/{checkpoint_id}", name="checkpoint_notification_create")
     * @Method("GET")
     */
    public function createFromProjectAction($post_id, $checkpoint_id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AppBundle:Post')->find($post_id);
        $entity = new Notification();
        $now = date_create();
        $entity->setDate($now);
        $entity->setDisplayStart($now);
        $entity->setDisplayEnd($now);
        $entity->setPost($post);
        $entity->setStatus('Shared');


        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('notification_edit', array('id' => $entity->getId(), 'checkpoint_id' => $checkpoint_id)));

    }

    /**
     * Creates a form to create a Notification entity.
     *
     * @param Notification $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Notification $entity)
    {
        $form = $this->createForm(NotificationType::class, $entity, array(
            'action' => $this->generateUrl('notification_create'),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Notification entity.
     *
     * @Route("/new", name="notification_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $entity = new Notification();
        $now = date_create();
        $entity->setDate($now);
        $entity->setDisplayStart($now);
        $entity->setDisplayEnd($now);
        $form = $this->createCreateForm($entity);


        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Notification entity.
     *
     * @Route("/{id}", name="notification_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Notification')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Notification entity.');
        }


        return array(
            'entity' => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Notification entity.
     *
     * @Route("/{id}/{checkpoint_id}/edit", name="notification_edit", defaults={"checkpoint_id" = 0})
     * @Method("GET")
     */
    public function editAction($id, $checkpoint_id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Notification')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Notification entity.');
        }

        $editForm = $this->createEditForm($entity, $checkpoint_id);
        $deleteForm = $this->createDeleteForm($id, $checkpoint_id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Notification entity.
     *
     * @param Notification $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Notification $entity, $checkpoint_id)
    {
        $form = $this->createForm(NotificationType::class, $entity, array(
            'action' => $this->generateUrl('notification_update', array('id' => $entity->getId(), 'checkpoint_id' => $checkpoint_id)),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }

    /**
     * Edits an existing Notification entity.
     *
     * @Route("/{id}/{checkpoint_id}", name="notification_update")
     * @Method("PUT")

     */
    public function updateAction(Request $request, $id, $checkpoint_id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Notification')->find($id);


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Notification entity.');
        }

        $deleteForm = $this->createDeleteForm($id, $checkpoint_id);
        $editForm = $this->createEditForm($entity, $checkpoint_id);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            if ($checkpoint_id!=0) {
                $checkpoint = $em->getRepository('AppBundle:Checkpoint')->find($checkpoint_id);
                return $this->redirect($this->generateUrl('project_show', array('id' => $checkpoint->getProject()->getId())));
            }
            else {
                return $this->redirect($this->generateUrl('notification_show', array('id' => $id)));
            }


        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Dismiss an existing Notification entity.
     *
     * @Route("/{id}/dismiss", name="notification_dismiss")
     * @Method("GET")
     * @Template()
     */
    public function dismissAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $notification = $em->getRepository('AppBundle:Notification')->find($id);
        $notification->setStatus('Dismissed');
        $em->persist($notification);
        $em->flush();

        return $this->redirect($this->generateUrl('user_profile'));

    }


    /**
     * Deletes a Notification entity.
     *
     * @Route("/{id}/{checkpoint_id}", name="notification_delete", defaults={"checkpoint_id" = 0})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id, $checkpoint_id)
    {
        $form = $this->createDeleteForm($id, $checkpoint_id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Notification')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Notification entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        if ($checkpoint_id!=0) {
            $checkpoint = $em->getRepository('AppBundle:Checkpoint')->find($checkpoint_id);
            return $this->redirect($this->generateUrl('project_show', array('id' => $checkpoint->getProject()->getId())));
        }
        else {
            return $this->redirect($this->generateUrl('notification'));
        }

    }

    /**
     * Creates a form to delete a Notification entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id, $checkpoint_id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notification_delete', array('id' => $id, 'checkpoint_id' => $checkpoint_id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Confirm Delete', 'attr' => array('class' => 'btn btn-danger'),))
            ->getForm();
    }
}
