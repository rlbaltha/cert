<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Source;
use AppBundle\Form\SourceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Source controller.
 *
 * @Route("/source")
 */
class SourceController extends Controller
{

    /**
     * Lists all Source entities.
     *
     * @Route("/{section}/list", name="source", defaults={"section" = "capstone"}, methods={"GET"})
     */
    public function indexAction($section)
    {
        $em = $this->getDoctrine()->getManager();
        $section = ucfirst($section);
        $entities = $em->getRepository('AppBundle:Source')->findSourcesSorted();
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle($section);
        $tags = $em->getRepository('AppBundle:Tag')->findByType('resource');

        return $this->render('AppBundle:Source:index.html.twig', array(
            'entities' => $entities,
            'section' => $section,
            'tags' => $tags,
        ));
    }

    /**
     * Lists Content Source entities.
     *
     * @Route("/content", name="content_source", methods={"GET"})
     * @Template()
     */
    public function content_indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Source')->findContentSorted();
        $tags = $em->getRepository('AppBundle:Tag')->findByType('content');

        return array(
            'entities' => $entities,
            'tags' => $tags,
        );
    }


    /**
     * Creates a new Source entity.
     *
     * @Route("/create/{type}", name="source_create", methods={"POST"})
     */
    public function createAction(Request $request, $type)
    {
        $entity = new Source();
        $form = $this->createCreateForm($entity, $type);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            if ($type == 'content') {
                return $this->redirect($this->generateUrl('content_source', array('id' => $entity->getId())));
            } else {
                return $this->redirect($this->generateUrl('source_show', array('id' => $entity->getId())));
            }

        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Source entity.
     *
     * @param Source $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Source $entity, $type)
    {
        if ($type != 'content') {
            $form = $this->createForm(SourceType::class, $entity, array(
                'action' => $this->generateUrl('source_create', array('type' => 'default')),
                'method' => 'POST',
            ));
        } else {
            $form = $this->createForm(SourceType::class, $entity, array(
                'action' => $this->generateUrl('source_create', array('type' => 'content')),
                'method' => 'POST',
            ));
        }


        $form->add('submit', SubmitType::class, array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Source entity.
     *
     * @Route("/new/{type}", name="source_new", defaults={"type" = "default"}, methods={"GET"})
     */
    public function newAction($type)
    {
        $entity = new Source();
        $form = $this->createCreateForm($entity, $type);

        return array(
            'entity' => $entity,
            'type' => $type,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Source entity.
     *
     * @Route("/{section}/{id}/detail", name="source_show", defaults={"section" = "capstone"}, methods={"GET"})
     * @Template()
     */
    public function showAction($id, $section)
    {
        $em = $this->getDoctrine()->getManager();
        $section = ucfirst($section);
        $entity = $em->getRepository('AppBundle:Source')->find($id);
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle($section);
        $tags = $em->getRepository('AppBundle:Tag')->findByType('resource');

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Source entity.');
        }


        return $this->render('AppBundle:Source:show.html.twig', array(
            'entity' => $entity,
            'section' => $section,
            'tags' => $tags,
        ));
    }

    /**
     * Displays a form to edit an existing Source entity.
     *
     * @Route("/{id}/edit", name="source_edit", methods={"GET"})
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Source')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Source entity.');
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
     * Creates a form to edit a Source entity.
     *
     * @param Source $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Source $entity)
    {
        $form = $this->createForm(SourceType::class, $entity, array(
            'action' => $this->generateUrl('source_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }

    /**
     * Edits an existing Source entity.
     *
     * @Route("/{id}", name="source_update", methods={"PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Source')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Source entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('source_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Source entity.
     *
     * @Route("/{id}", name="source_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Source')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Source entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('source'));
    }

    /**
     * Creates a form to delete a Source entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('source_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Confirm Delete', 'attr' => array('class' => 'btn btn-danger'),))
            ->getForm();
    }
}
