<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Term;
use AppBundle\Form\TermType;

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
     * @Route("/", name="term")
     * @Method("GET")
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
     * @Route("/", name="term_create")
     * @Method("POST")

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
        $form = $this->createForm(new TermType(), $entity, array(
            'action' => $this->generateUrl('term_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Term entity.
     *
     * @Route("/new", name="term_new")
     * @Method("GET")
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
     * @Route("/current", name="term_current")
     * @Method("GET")
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
     * @Route("/{id}", name="term_show")
     * @Method("GET")
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
     * @Route("/{id}/edit", name="term_edit")
     * @Method("GET")
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
        $form = $this->createForm(new TermType(), $entity, array(
            'action' => $this->generateUrl('term_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Term entity.
     *
     * @Route("/{id}", name="term_update")
     * @Method("PUT")

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
     * @Route("/{termid}/{courseid}/remove", name="term_removecourse")
     * @Method("GET")
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
     * @Route("/{courseid}/add", name="term_addcourse")
     * @Method("GET")
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
     * @Route("/{id}", name="term_delete")
     * @Method("DELETE")
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
            ->add('submit', 'submit', array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
