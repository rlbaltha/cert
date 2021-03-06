<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Checkpoint;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Project;
use AppBundle\Form\ProjectType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Project controller.
 *
 * @Route("/project")
 */
class ProjectController extends Controller
{

    /**
     * Lists all Project entities.
     *
     * @Route("/{status}/list", name="project", defaults={"status" = "Active"}, methods={"GET"})
     */
    public function indexAction($status)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Project')->findAdmin($status);

        return $this->render('AppBundle:Project:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Project entity.
     *
     * @Route("/", name="project_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $entity = new Project();
        $user = $this->getUser();
        $entity->setUser($user);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $checkpoint = new Checkpoint();
            $checkpoint->setProject($entity);
            $em->persist($checkpoint);
            $em->flush();

            return $this->redirect($this->generateUrl('project_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }


    /**
     * Creates a new Project entity.
     *
     * @Route("/duplicate/{id}", name="project_duplicate", methods={"GET"})
     */
    public function duplicateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Project')->find($id);
        $checkpoints = $entity->getCheckpoints();
        $entity->setStatus('Active');
        $em->persist($entity);
        foreach ($checkpoints as $checkpoint) {
            if ($checkpoint->getStatus() != 'Archived') {
                $checkpoint->setStatus('Archived');
                $new_checkpoint = new Checkpoint();
                $new_checkpoint->setName($checkpoint->getName());
                $new_checkpoint->setDescription($checkpoint->getDescription());
                $new_checkpoint->setLead($checkpoint->getLead());
                $new_checkpoint->setProject($entity);
                foreach ($checkpoint->getPosts() as $post) {
                    $new_checkpoint->addPost($post);
                }
                $em->persist($new_checkpoint);
                $em->persist($checkpoint);
            }
        }
        $em->flush();

        return $this->redirect($this->generateUrl('project_show', array('id' => $entity->getId())));

    }

    /**
     * Mark an existing Checkpoint entity complete.
     *
     * @Route("/{id}/complete", name="project_complete", methods={"GET"})
     */
    public function completeAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $project = $em->getRepository('AppBundle:Project')->find($id);
        $project->setStatus('Complete');
        $em->persist($project);
        $em->flush();

        return $this->redirect($this->generateUrl('project_show', array('id' => $project->getId())));

    }

    /**
     * Creates a form to create a Project entity.
     *
     * @param Project $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Project $entity)
    {
        $form = $this->createForm(ProjectType::class, $entity, array(
            'action' => $this->generateUrl('project_create'),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Project entity.
     *
     * @Route("/new", name="project_new", methods={"GET"})
     */
    public function newAction()
    {
        $entity = new Project();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Project entity.
     *
     * @Route("/{id}", name="project_show", methods={"GET"})
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AppBundle:Project:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Project entity.
     *
     * @Route("/{id}/edit", name="project_edit", methods={"GET"})
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
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
    * Creates a form to edit a Project entity.
    *
    * @param Project $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Project $entity)
    {
        $form = $this->createForm(ProjectType::class, $entity, array(
            'action' => $this->generateUrl('project_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Project entity.
     *
     * @Route("/{id}", name="project_update", methods={"PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Project')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Project entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('project_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Shared:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Project entity.
     *
     * @Route("/{id}", name="project_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Project')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Project entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('project'));
    }

    /**
     * Creates a form to delete a Project entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('project_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
