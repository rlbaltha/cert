<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use AppBundle\Form\AdminType;
use AppBundle\Form\ProfileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * User controller.
 *
 *
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * Finds and displays a User entity.
     *
     * @Route("/profile", name="user_profile")
     * @Method("GET")
     * @Template("AppBundle:User:show.html.twig")
     */
    public function profileAction()
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $entity = $em->getRepository('AppBundle:User')->find($user);
        $notifications = $em->getRepository('AppBundle:Notification')->findCurrent($user);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        if ($entity->getLastname() == '') {
            return $this->redirect($this->generateUrl('user_edit', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'notifications' => $notifications,
        );
    }

    /**
     * Lists all User entities.
     *
     * @Route("/list/{type}", name="user", defaults={"type" = "all"})
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction($type)
    {
        $em = $this->getDoctrine()->getManager();
        if ($type == 'all') {
            $entities = $em->getRepository('AppBundle:User')->findAll();
        } elseif ($type == 'students') {
            $entities = $em->getRepository('AppBundle:User')->findStudents();
        } elseif ($type == 'mentors') {
            $entities = $em->getRepository('AppBundle:User')->findMentors();
        } elseif ($type == 'mentees') {
            $entities = $em->getRepository('AppBundle:User')->findMentees();
        } else {
            $type = $em->getRepository('AppBundle:Status')->find($type);
            $entities = $em->getRepository('AppBundle:User')->findUsersByType($type);
        }
        $status = $em->getRepository('AppBundle:Status')->findAll();
        return array(
            'entities' => $entities,
            'status' => $status,
        );
    }

    /**
     * Lists all User entities.
     *
     * @Route("/{section}/{type}/network", name="network", defaults={"type" = "students", "section" = "capstone"})
     * @Method("GET")
     * @Template("AppBundle:User:network.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function networkAction($type, $section)
    {
        $em = $this->getDoctrine()->getManager();
        $section = ucfirst($section);
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle($section);
        if ($type == 'all') {
            $entities = $em->getRepository('AppBundle:User')->findAll();
        } else {
            $entities = $em->getRepository('AppBundle:User')->findStudents();
        }
        return array(
            'entities' => $entities,
            'section' => $section,
        );
    }

    /**
     * Lists all User entities.
     *
     * @Route("/table/{type}", name="user_table", defaults={"type" = "all"})
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function tableAction($type)
    {
        $em = $this->getDoctrine()->getManager();
        if ($type == 'all') {
            $entities = $em->getRepository('AppBundle:User')->findAll();
        } elseif ($type == 'students') {
            $entities = $em->getRepository('AppBundle:User')->findStudents();
        } else {
            $type = $em->getRepository('AppBundle:Status')->find($type);
            $entities = $em->getRepository('AppBundle:User')->findUsersByType($type);
        }
        $status = $em->getRepository('AppBundle:Status')->findAll();
        return array(
            'entities' => $entities,
            'status' => $status,
        );
    }

    /**
     * Lists  User entities.
     *
     * @Route("/list/{date}/{term}", name="user_graddate")
     * @Method("GET")
     * @Template("AppBundle:User:index.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexByTermAction($term, $date)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:User')->findUsersByTerm($term, $date);

        $status = $em->getRepository('AppBundle:Status')->findAll();
        return array(
            'entities' => $entities,
            'status' => $status,
        );
    }


    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);
        $notifications = $em->getRepository('AppBundle:Notification')->findCurrent($entity);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'notifications' => $notifications,
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Creates a pdf of users work
     *
     * @Route("/{id}/pdf", name="pdf")
     */
    public function createPdfAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        $name = $entity->getLastname();
        $filename = 'attachment; filename="' . $name . '.pdf"';


        $html = $this->renderView('AppBundle:User:pdf.html.twig', array(
            'entity' => $entity,
        ));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => $filename
            )
        );

    }


    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $entity)
    {

        if ($this->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(new AdminType(), $entity, array(
                'action' => $this->generateUrl('user_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            ));
        } else {
            $form = $this->createForm(new ProfileType(), $entity, array(
                'action' => $this->generateUrl('user_update', array('id' => $entity->getId())),
                'method' => 'PUT',
            ));
        }


        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}", name="user_update")
     * @Method("PUT")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('user_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a User entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Confirm Delete', 'attr' => array('class' => 'btn btn-danger'),))
            ->getForm();
    }
}
