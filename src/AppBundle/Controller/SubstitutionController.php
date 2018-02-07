<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Substitution;
use AppBundle\Form\SubstitutionType;

/**
 * Substitution controller.
 *
 * @Route("/substitution")
 */
class SubstitutionController extends Controller
{

    /**
     * Lists all Substitution entities.
     *
     * @Route("/", name="substitution")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Substitution')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Substitution entity.
     *
     * @Route("/", name="substitution_create")
     * @Method("POST")
     * @Template("AppBundle:Shared:new.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function createAction(Request $request)
    {
        $entity = new Substitution();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $useranme = $this->getUser()->getUsername();
            $user = $em->getRepository('AppBundle:User')->findOneByUsername($useranme);
            $checklist = $user->getChecklist();
            $entity->setChecklist($checklist);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('checklist_show', array('id' => $user->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Substitution entity.
     *
     * @param Substitution $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Substitution $entity)
    {
        $form = $this->createForm(new SubstitutionType(), $entity, array(
            'action' => $this->generateUrl('substitution_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Substitution entity.
     *
     * @Route("/new", name="substitution_new")
     * @Method("GET")
     * @Template("AppBundle:Shared:new.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction()
    {
        $entity = new Substitution();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Substitution entity.
     *
     * @Route("/{id}", name="substitution_show")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Substitution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundSubstitution('Unable to find Substitution entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Substitution entity.
     *
     * @Route("/{id}/edit", name="substitution_edit")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Substitution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundSubstitution('Unable to find Substitution entity.');
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
    * Creates a form to edit a Substitution entity.
    *
    * @param Substitution $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Substitution $entity)
    {
        $form = $this->createForm(new SubstitutionType(), $entity, array(
            'action' => $this->generateUrl('substitution_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Substitution entity.
     *
     * @Route("/{id}", name="substitution_update")
     * @Method("PUT")
     * @Template("AppBundle:Shared:edit.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Substitution')->find($id);
        $user = $entity->getChecklist()->getUser();

        if (!$entity) {
            throw $this->createNotFoundSubstitution('Unable to find Substitution entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('checklist_show', array('id' => $user->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Edits an existing Substitution entity.
     *
     * @Route("/approve/{id}", name="substitution_approve")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function approveAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Substitution')->find($id);
        $user = $entity->getChecklist()->getUser();
        $entity->setStatus('Approved');
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('checklist_show', array('id' => $user->getId())));

    }

    /**
     * Edits an existing Substitution entity.
     *
     * @Route("/deny/{id}", name="substitution_deny")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function denyAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Substitution')->find($id);
        $user = $entity->getChecklist()->getUser();
        $entity->setStatus('Denied');
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('checklist_show', array('id' => $user->getId())));

    }

    /**
     * Deletes a Substitution entity.
     *
     * @Route("/{id}", name="substitution_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Substitution')->find($id);
            $user = $entity->getChecklist()->getUser();

            if (!$entity) {
                throw $this->createNotFoundSubstitution('Unable to find Substitution entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('checklist_show', array('id' => $user->getId())));
    }

    /**
     * Creates a form to delete a Substitution entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('substitution_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}