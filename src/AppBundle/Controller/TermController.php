<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Term;
use AppBundle\Form\TermType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Term controller.
 *
 * @Route("/term")
 */
class TermController extends Controller
{

    /**
     * Lists all Term entities.
     *
     * @Route("/", name="term", methods={"GET"})
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Term')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Term entity.
     *
     * @Route("/", name="term_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $entity = new Term();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('term'));
        }

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Term entity.
     *
     * @param Term $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Term $entity)
    {
        $form = $this->createForm(TermType::class, $entity, array(
            'action' => $this->generateUrl('term_create'),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Term entity.
     *
     * @Route("/new", name="term_new", methods={"GET"})
     */
    public function newAction()
    {
        $entity = new Term();
        $form   = $this->createCreateForm($entity);

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays the current Term entity.
     *
     * @Route("/current", name="term_current", methods={"GET"})
     * @Template("AppBundle:Term:show.html.twig")
     */
    public function currentAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Term')->findCurrent();
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle('Course');

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Term entity.');
        }


        return array(
            'entity'      => $entity,
            'section'      => $section,
        );
    }

    /**
     * Finds and displays a Term entity.
     *
     * @Route("/{id}", name="term_show", methods={"GET"})
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Term')->find($id);
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle('Course');

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Term entity.');
        }


        return array(
            'entity'      => $entity,
            'section'      => $section,
        );
    }


    /**
     * Displays a form to edit an existing Term entity.
     *
     * @Route("/{id}/edit", name="term_edit", methods={"GET"})
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Term')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Term entity.');
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
    * Creates a form to edit a Term entity.
    *
    * @param Term $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Term $entity)
    {
        $form = $this->createForm(TermType::class, $entity, array(
            'action' => $this->generateUrl('term_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Term entity.
     *
     * @Route("/{id}", name="term_update", methods={"PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Term')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Term entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('term'));
        }

        return $this->render('AppBundle:Shared:edit.html.twig', array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Term entity.
     *
     * @Route("/{termid}/{courseid}/remove", name="term_removecourse", methods={"GET"})
     * @Template("AppBundle:Term:show.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function removecourseAction($termid, $courseid)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Term')->find($termid);
        $course = $em->getRepository('AppBundle:Course')->find($courseid);
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle('Course');

        $entity->removeCourse($course);
        $em->persist($entity);
        $em->flush();

        return array(
            'entity'      => $entity,
            'section'      => $section,
        );
    }

    /**
     * Edits an existing Term entity.
     *
     * @Route("/{courseid}/add", name="term_addcourse", methods={"GET"})
     * @Template("AppBundle:Term:show.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addcourseAction($courseid)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Term')->findCurrent();
        $course = $em->getRepository('AppBundle:Course')->find($courseid);
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle('Course');

        $entity->addCourse($course);
        $em->persist($entity);
        $em->flush();

        return array(
            'entity'      => $entity,
            'section'      => $section,
        );
    }


    /**
     * Deletes a Term entity.
     *
     * @Route("/{id}", name="term_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Term')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Term entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('term'));
    }

    /**
     * Creates a form to delete a Term entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('term_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
