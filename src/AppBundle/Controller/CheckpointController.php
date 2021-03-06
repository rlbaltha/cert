<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notification;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Checkpoint;
use AppBundle\Form\CheckpointType;
use AppBundle\Form\CheckpointAdminType;
use AppBundle\Notifier\NotifierManager;

/**
 * Checkpoint controller.
 *
 * @Route("/checkpoint")
 */
class CheckpointController extends Controller
{

    /**
     * Lists all Checkpoint entities.
     *
     * @Route("/", name="checkpoint", methods={"GET"})
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Checkpoint')->findAdminCurrent();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Checkpoint entity.
     *
     * @Route("/{id}/create", name="checkpoint_create", methods={"POST"})
     */
    public function createAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();


        $entity = new Checkpoint();
        $project = $em->getRepository('AppBundle:Project')->find($id);
        $entity->setProject($project);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {

            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('capstone_show', array('id' => $user->getId())));

        }

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Mark an existing Checkpoint entity complete.
     *
     * @Route("/{id}/complete", name="checkpoint_complete", methods={"GET"})
     */
    public function completeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $checkpoint = $em->getRepository('AppBundle:Checkpoint')->find($id);
        $dt = new \DateTime();
        $checkpoint->setCompleted($dt);
        $checkpoint->setStatus('Complete');
        $em->persist($checkpoint);
        $em->flush();

        return $this->redirect($this->generateUrl('capstone_show', array('id' => $user->getId())));


    }

    /**
     * Creates a form to create a Checkpoint entity.
     *
     * @param Checkpoint $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Checkpoint $entity)
    {

            $form = $this->createForm(CheckpointType::class, $entity, array(
                'action' => $this->generateUrl('checkpoint_create', array('id'=>$entity->getProject()->getId())),
                'method' => 'POST',
            ));

        $form->add('submit', SubmitType::class, array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Checkpoint entity.
     *
     * @Route("/{id}/new", name="checkpoint_new", methods={"GET"})
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $project = $em->getRepository('AppBundle:Project')->find($id);
        $count = count($project->getCheckpoints()) + 1;
        $name = 'Checkpoint '.$count;
        $entity = new Checkpoint();
        $entity->setProject($project);
        $deadline =  date_create();
        $entity->setDeadline($deadline);
        $entity->setName($name);
        if ($project->getCapstone()) {
            $entity->setType('Capstone');
            $mentors = $project->getCapstone()->getCapstoneMentor();
            foreach ($mentors as $mentor) {
                $entity->addReviewer($mentor);
            }
        }
        else {
            $entity->setType('Admin');
        }
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Checkpoint entity.
     *
     * @Route("/{id}", name="checkpoint_show", methods={"GET"})
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Checkpoint')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Checkpoint entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Checkpoint entity.
     *
     * @Route("/{id}/edit", name="checkpoint_edit", methods={"GET"})
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Checkpoint')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Checkpoint entity.');
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
    * Creates a form to edit a Checkpoint entity.
    *
    * @param Checkpoint $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Checkpoint $entity)
    {
        $form = $this->createForm(CheckpointType::class, $entity, array(
                'action' => $this->generateUrl('checkpoint_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            ));

        $form->add('submit', SubmitType::class, array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Checkpoint entity.
     *
     * @Route("/{id}", name="checkpoint_update", methods={"PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $entity = $em->getRepository('AppBundle:Checkpoint')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Checkpoint entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('capstone_show', array('id' => $user->getId())));

        }

        return $this->render('AppBundle:Shared:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Checkpoint entity.
     *
     * @Route("/{id}", name="checkpoint_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Checkpoint')->find($id);
            $project = $entity->getProject();


            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Checkpoint entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        if ($project->getCapstone()) {
            return $this->redirect($this->generateUrl('user_profile'));
        }
        else {
            return $this->redirect($this->generateUrl('project_show', array('id' => $project->getId())));
        }
    }

    /**
     * Creates a form to delete a Checkpoint entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('checkpoint_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
