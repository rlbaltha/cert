<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Program;
use AppBundle\Form\ProgramType;

/**
 * Program controller.
 *
 * @Route("/program")
 */
class ProgramController extends Controller
{

    /**
     * Lists all Program entities.
     *
     * @Route("/", name="program")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Program')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Program entity.
     *
     * @Route("/", name="program_create")
     * @Method("POST")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Program();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $user=$this->getUser();
            $entity->setUser($user);
            $em->persist($entity);
            $em->flush();

            $user = $em->getRepository('AppBundle:User')->find($user);
            $name = $user->getFirstname().' '.$user->getLastname();

            $message = \Swift_Message::newInstance()
                ->setSubject('Certfiicate Application')
                ->setFrom('scdirector@uga.edu')
                ->setTo('scdirector@uga.edu')
                ->setBody(
                    $this->renderView(

                        'AppBundle:Email:apply.html.twig',
                        array('name' => $name)
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);

            return $this->redirect($this->generateUrl('user_profile'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Program entity.
     *
     * @param Program $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Program $entity)
    {
        $form = $this->createForm(new ProgramType(), $entity, array(
            'action' => $this->generateUrl('program_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Submit Application','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }

    /**
     * Displays a form to create a new Program entity.
     *
     * @Route("/new", name="program_new")
     * @Method("GET")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Program();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Program entity.
     *
     * @Route("/{id}", name="program_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Program')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Program entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Program entity.
     *
     * @Route("/{id}/edit", name="program_edit")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Program')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Program entity.');
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
    * Creates a form to edit a Program entity.
    *
    * @param Program $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Program $entity)
    {
        $form = $this->createForm(new ProgramType(), $entity, array(
            'action' => $this->generateUrl('program_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Program entity.
     *
     * @Route("/{id}", name="program_update")
     * @Method("PUT")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Program')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Program entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $user=$this->getUser();
            $user = $em->getRepository('AppBundle:User')->find($user);
            $name = $user->getFirstname().' '.$user->getLastname();

            $message = \Swift_Message::newInstance()
                ->setSubject('Certfiicate Application')
                ->setFrom('scdirector@uga.edu')
                ->setTo('scdirector@uga.edu')
                ->setBody(
                    $this->renderView(

                        'AppBundle:Email:apply.html.twig',
                        array('name' => $name)
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);

            return $this->redirect($this->generateUrl('user_profile'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Program entity.
     *
     * @Route("/{id}", name="program_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Program')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Program entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user_profile'));
    }

    /**
     * Creates a form to delete a Program entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('program_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete','attr' => array('class' => 'btn btn-default pull-right'),))
            ->getForm()
        ;
    }
}
