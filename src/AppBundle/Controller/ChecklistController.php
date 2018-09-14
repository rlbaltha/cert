<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Checklist;
use AppBundle\Form\ChecklistType;

/**
 * Checklist controller.
 *
 * @Route("/checklist")
 */
class ChecklistController extends Controller
{

    /**
     * Finds and displays a Checklist entity.
     *
     * @Route("/show/{id}", name="checklist_show")
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capstone entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a new Checklist entity.
     *
     * @Route("/", name="checklist_create")
     * @Method("POST")
     * @Template("AppBundle:Shared:new.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function createAction(Request $request)
    {
        $entity = new Checklist();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $entity->setUser($user);
            $user_entity = $em->getRepository('AppBundle:User')->find($user);
            $status = $em->getRepository('AppBundle:Status')->findByName('Checklist Created');
            $user_entity->setProgress($status);
            $portfolio = 'https://ctlsites.uga.edu/sustainability-' . $user_entity->getFirstname() . $user_entity->getLastname();
            $entity->setPortfolio(strtolower($portfolio));
            $em->persist($entity);
            $em->persist($user_entity);
            $em->flush();

            return $this->redirect($this->generateUrl('checklist_show', array('id' => $entity->getUser()->getId())));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Checklist entity.
     *
     * @param Checklist $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Checklist $entity)
    {
        $form = $this->createForm(new ChecklistType(), $entity, array(
            'action' => $this->generateUrl('checklist_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }

    /**
     * Displays a form to create a new Checklist entity.
     *
     * @Route("/new", name="checklist_new")
     * @Method("GET")
     * @Template("AppBundle:Shared:new.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction()
    {
        $entity = new Checklist();

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $entity->setUser($user);
        $program = $em->getRepository('AppBundle:Program')->findOneByUser($user);
        $entity->setCapstonedate($program->getGraddate());
        $entity->setCapstoneterm($program->getGradterm());
        $entity->setGraddate($program->getGraddate());
        $entity->setGradterm($program->getGradterm());
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }


    /**
     * Displays a form to edit an existing Checklist entity.
     *
     * @Route("/{id}/edit", name="checklist_edit")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Checklist')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Checklist entity.');
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
     * Creates a form to edit a Checklist entity.
     *
     * @param Checklist $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Checklist $entity)
    {
        $form = $this->createForm(new ChecklistType(), $entity, array(
            'action' => $this->generateUrl('checklist_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }

    /**
     * Edits an existing Checklist entity.
     *
     * @Route("/{id}", name="checklist_update")
     * @Method("PUT")
     * @Template("AppBundle:Shared:edit.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Checklist')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Checklist entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('checklist_show', array('id' => $entity->getUser()->getId())));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Edits an existing Checklist entity.
     *
     * @Route("/{id}/portcomplete", name="checklist_portcomplete")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function portcompleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Checklist')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Checklist entity.');
        }
        $user = $entity->getUser();
        $user_entity = $em->getRepository('AppBundle:User')->find($user);
        $name = $user_entity->getFirstname() . ' ' . $user_entity->getLastname();
        $text = $name. 'has complete her or his portfolio.';
        $message = \Swift_Message::newInstance()
            ->setSubject('Portfolio Complete')
            ->setFrom('scdirector@uga.edu')
            ->setTo('scdirector@uga.edu')
            ->setBody(
                $this->renderView(

                    'AppBundle:Email:apply.html.twig',
                    array('name' => $name,
                        'text' => $text)
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);


        $this->addFlash(
            'notice',
            'Your portfolio has been marked Completed.'
        );
        $today = new \DateTime();
        $entity->setPortDate($today);
        $em->flush();

        return $this->redirect($this->generateUrl('checklist_show', array('id' => $entity->getUser()->getId())));

    }

    /**
     * Edits an existing Checklist entity.
     *
     * @Route("/{id}/certcomplete", name="checklist_certcomplete")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function certcompleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Checklist')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Checklist entity.');
        }
        $user = $entity->getUser();
        $user_entity = $em->getRepository('AppBundle:User')->find($user);
        $name = $user_entity->getFirstname() . ' ' . $user_entity->getLastname();
        $text = $name. 'has complete her or his certificate.';
        $message = \Swift_Message::newInstance()
            ->setSubject('Certificate Complete')
            ->setFrom('scdirector@uga.edu')
            ->setTo('scdirector@uga.edu')
            ->setBody(
                $this->renderView(

                    'AppBundle:Email:apply.html.twig',
                    array('name' => $name,
                        'text' => $text)
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);


        $this->addFlash(
            'notice',
            'We will review your work for graduation.'
        );

        $tags = $user_entity->getTags();
        foreach ($tags as &$tag) {
            $user_entity->removeTag($tag);
        }
        $tag1 = $em->getRepository('AppBundle:Tag')->find(112);
        $user_entity->addTag($tag1);
        $em->flush();

        return $this->redirect($this->generateUrl('checklist_show', array('id' => $entity->getUser()->getId())));

    }


    /**
     * Deletes a Checklist entity.
     *
     * @Route("/{id}", name="checklist_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Checklist')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Checklist entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user_profile'));
    }

    /**
     * Creates a form to delete a Checklist entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('checklist_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Confirm Delete', 'attr' => array('class' => 'btn btn-danger'),))
            ->getForm();
    }
}
