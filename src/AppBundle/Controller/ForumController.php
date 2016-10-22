<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Forum;
use AppBundle\Form\ForumType;

/**
 * Forum controller.
 *
 * @Route("/forum")
 */
class ForumController extends Controller
{

    /**
     * Lists all Forum entities.
     *
     * @Route("/", name="forum")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Forum')->findTopLevel();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Forum entity.
     *
     * @Route("/", name="forum_create")
     * @Method("POST")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $currentuser = $this->getUser();
        $user = $em->getRepository('AppBundle:User')->findOneById($currentuser);
        $entity = new Forum();
        $entity->setUser($user);
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($entity->getParent()->getParent()) {
                $returnid = $entity->getParent()->getParent()->getId();
            }
            elseif ($entity->getParent()) {
                $returnid = $entity->getParent()->getId();
            }
            else {
                $returnid = $entity->getId();
            }

                return $this->redirect($this->generateUrl('forum_show', array('id' => $returnid)));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Forum entity.
     *
     * @param Forum $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Forum $entity)
    {
        $form = $this->createForm(new ForumType(), $entity, array(
            'action' => $this->generateUrl('forum_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Forum entity.
     *
     * @Route("/new/{id}", name="forum_new" , defaults={"id" = 1})
     * @Method("GET")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function newAction($id)
    {
        $entity = new Forum();
        $em = $this->getDoctrine()->getManager();
        $parent = $em->getRepository('AppBundle:Forum')->find($id);
        $entity->setParent($parent);
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Forum entity.
     *
     * @Route("/{id}", name="forum_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Forum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Forum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Forum entity.
     *
     * @Route("/{id}/edit", name="forum_edit")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Forum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Forum entity.');
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
    * Creates a form to edit a Forum entity.
    *
    * @param Forum $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Forum $entity)
    {
        $form = $this->createForm(new ForumType(), $entity, array(
            'action' => $this->generateUrl('forum_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Forum entity.
     *
     * @Route("/{id}", name="forum_update")
     * @Method("PUT")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Forum')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Forum entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('forum_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Forum entity.
     *
     * @Route("/{id}", name="forum_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Forum')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Forum entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('forum'));
    }

    /**
     * Creates a form to delete a Forum entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('forum_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
