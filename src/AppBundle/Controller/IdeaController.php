<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Idea;
use AppBundle\Form\IdeaType;

/**
 * Idea controller.
 *
 * @Route("/idea")
 */
class IdeaController extends Controller
{

    /**
     * Lists all Idea entities.
     *
     * @Route("/list/{status}", name="idea", defaults={"status":"approved"})
     * @Method("GET")
     * @Template()
     */
    public function indexAction($status)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Idea')->findByStatus($status);
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle('Capstone');
        $tags = $em->getRepository('AppBundle:Tag')->findAll();

        return array(
            'entities' => $entities,
            'section' => $section,
            'tags' => $tags,
        );
    }

    /**
     * Creates a new Idea entity.
     *
     * @Route("/", name="idea_create")
     * @Method("POST")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Idea();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->addFlash(
                'notice',
                'Thanks for your idea.  We will review it for posting soon.'
            );

            return $this->redirect($this->generateUrl('idea', array('status' => 'approved')));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Idea entity.
     *
     * @param Idea $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Idea $entity)
    {
        $form = $this->createForm(new IdeaType(), $entity, array(
            'action' => $this->generateUrl('idea_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Idea entity.
     *
     * @Route("/new", name="idea_new")
     * @Method("GET")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Idea();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Idea entity.
     *
     * @Route("/{id}", name="idea_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Idea')->find($id);
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle('Capstone');
        $sources = $em->getRepository('AppBundle:Source')->findSourcesByIdea($id);
        $tags = $em->getRepository('AppBundle:Tag')->findAll();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Idea entity.');
        }


        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'       => $entity,
            'sources'      => $sources,
            'section'      => $section,
            'tags'         => $tags,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Idea entity.
     *
     * @Route("/{id}/edit", name="idea_edit")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Idea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Idea entity.');
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
    * Creates a form to edit a Idea entity.
    *
    * @param Idea $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Idea $entity)
    {
        $form = $this->createForm(new IdeaType(), $entity, array(
            'action' => $this->generateUrl('idea_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Idea entity.
     *
     * @Route("/{id}", name="idea_update")
     * @Method("PUT")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Idea')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Idea entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('idea_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Mark an existing Idea entity apptoved.
     *
     * @Route("/{id}/approve", name="idea_approve")
     * @Method("GET")
     * @Template()
     */
    public function approveAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $idea = $em->getRepository('AppBundle:Idea')->find($id);
        $idea->setStatus('Approved');
        $em->persist($idea);
        $em->flush();

        return $this->redirect($this->generateUrl('idea'));

    }

    /**
     * Deletes a Idea entity.
     *
     * @Route("/{id}", name="idea_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Idea')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Idea entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('idea'));
    }

    /**
     * Creates a form to delete a Idea entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('idea_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
