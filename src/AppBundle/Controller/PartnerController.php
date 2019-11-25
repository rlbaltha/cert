<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Partner;
use AppBundle\Form\PartnerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Partner controller.
 *
 * @Route("/partner")
 */
class PartnerController extends Controller
{

    /**
     * Lists all Partner entities.
     *
     * @Route("/{section}/{status}/list", name="partner", defaults={"status" = "current", "section" = "capstone"})
     * @Method("GET")
     * @Template()
     */
    public function indexAction($status, $section)
    {
        $em = $this->getDoctrine()->getManager();
        $section = ucfirst($section);
        $entities = $em->getRepository('AppBundle:Partner')->findByStatus($status);
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle($section);
        $tags = $em->getRepository('AppBundle:Tag')->findByType('resource');

        return array(
            'entities' => $entities,
            'section' => $section,
            'tags' => $tags,
        );
    }
    /**
     * Creates a new Partner entity.
     *
     * @Route("/", name="partner_create")
     * @Method("POST")

     */
    public function createAction(Request $request)
    {
        $entity = new Partner();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('partner_show', array('id' => $entity->getId())));
        }

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Partner entity.
     *
     * @param Partner $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Partner $entity)
    {
        $form = $this->createForm(new PartnerType(), $entity, array(
            'action' => $this->generateUrl('partner_create'),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Partner entity.
     *
     * @Route("/new", name="partner_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $entity = new Partner();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Partner entity.
     *
     * @Route("/{section}/{id}/detail", name="partner_show", defaults={"section" = "capstone"})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id, $section)
    {
        $em = $this->getDoctrine()->getManager();

        $section = ucfirst($section);
        $entity = $em->getRepository('AppBundle:Partner')->find($id);
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle($section);
        $sources = $em->getRepository('AppBundle:Source')->findSourcesByIdea($id);
        $tags = $em->getRepository('AppBundle:Tag')->findByType('resource');

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partner entity.');
        }


        return array(
            'entity'       => $entity,
            'sources'      => $sources,
            'section'      => $section,
            'tags'         => $tags,
        );
    }

    /**
     * Displays a form to edit an existing Partner entity.
     *
     * @Route("/{id}/edit", name="partner_edit")
     * @Method("GET")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Partner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partner entity.');
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
    * Creates a form to edit a Partner entity.
    *
    * @param Partner $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Partner $entity)
    {
        $form = $this->createForm(new PartnerType(), $entity, array(
            'action' => $this->generateUrl('partner_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Partner entity.
     *
     * @Route("/{id}", name="partner_update")
     * @Method("PUT")

     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Partner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('partner_show', array('id' => $id)));
        }

        return $this->render('AppBundle:Shared:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Mark an existing Idea entity approved.
     *
     * @Route("/{id}/{status}", name="partner_status")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function statusAction($id, $status)
    {
        $em = $this->getDoctrine()->getManager();

        $idea = $em->getRepository('AppBundle:Partner')->find($id);
        $idea->setStatus(lcfirst($status));
        $em->persist($idea);
        $em->flush();

        return $this->redirect($this->generateUrl('partner'));

    }


    /**
     * Deletes a Partner entity.
     *
     * @Route("/{id}", name="partner_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Partner')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Partner entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('partner'));
    }

    /**
     * Creates a form to delete a Partner entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partner_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
