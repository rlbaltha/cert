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

            $user_entity = $em->getRepository('AppBundle:User')->find($user);
            $status = $em->getRepository('AppBundle:Status')->findByName('Application Created');
            $user_entity->setProgress($status);

            $em->persist($entity);
            $em->persist($user_entity);
            $em->flush();

            $user = $em->getRepository('AppBundle:User')->find($user);
            $name = $user->getFirstname().' '.$user->getLastname();
            $text = $name.' has created an application.';

            $message = \Swift_Message::newInstance()
                ->setSubject('Certificate Application')
                ->setFrom('scdirector@uga.edu')
                ->setTo('scdirector@uga.edu')
                ->setBody(
                    $this->renderView(

                        'AppBundle:Email:apply.html.twig',
                        array('name' => $name,
                            'text' => $text)
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
            $text = $name.' has updated an application.';

            $message = \Swift_Message::newInstance()
                ->setSubject('Certificate Application')
                ->setFrom('scdirector@uga.edu')
                ->setTo('scdirector@uga.edu')
                ->setBody(
                    $this->renderView(

                        'AppBundle:Email:apply.html.twig',
                        array('name' => $name,
                              'text' => $text)
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
     * Application Ready for review and send email.
     *
     * @Route("/ready/{id}", name="program_ready")
     * @Method("GET")
     * @Template("AppBundle:User:show.html.twig")
     */
    public function readyAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Program')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Program entity.');
        }

        $user = $entity->getUser();
        $user_entity = $em->getRepository('AppBundle:User')->find($user);
        $status = $em->getRepository('AppBundle:Status')->findByName('Ready for Review');
        $user_entity->setProgress($status);
        $timestamp = date('m/d/Y h:i:s A');
        $notes = $user_entity->getNotes();
        $user_entity->setNotes($notes.'<p> Application ready for review '.$timestamp.'</p>');
        $entity->setStatus('Ready for Review');

        $em->persist($entity);
        $em->persist($user_entity);
        $em->flush();

        $name = $user_entity->getFirstname().' '.$user_entity->getLastname();
        $email = 'scdirector@uga.edu';
        $text = $name.' has submitted an application that is ready for review.';

        $message = \Swift_Message::newInstance()
            ->setSubject('Certificate Application Ready for Review')
            ->setFrom('scdirector@uga.edu')
            ->setTo($email)
            ->setBody(
                $this->renderView(

                    'AppBundle:Email:apply.html.twig',
                    array('name' => $name,
                        'text' => $text)
                ),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);

        return $this->redirect($this->generateUrl('user_show', array('id' => $user_entity->getId())));
    }

    /**
     * Approve Application and send email.
     *
     * @Route("/approve/{id}", name="program_approve")
     * @Method("GET")
     * @Template("AppBundle:User:show.html.twig")
     */
    public function approveAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Program')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Program entity.');
        }

        $user = $entity->getUser();
        $user_entity = $em->getRepository('AppBundle:User')->find($user);
        $status = $em->getRepository('AppBundle:Status')->findByName('Application Approved');
        $user_entity->setProgress($status);
        $timestamp = date('m/d/Y h:i:s A');
        $notes = $user_entity->getNotes();
        $user_entity->setNotes($notes.'<p> Application approved '.$timestamp.'</p>');
        $entity->setStatus('Approved');

        $em->persist($entity);
        $em->persist($user_entity);
        $em->flush();

        $name = $user_entity->getFirstname().' '.$user_entity->getLastname();
        $email = $user_entity->getEmail();
        $text =  '<p>'.$name.', your application for the Sustainability Certificate has been approved. Congrats and welcome! </p>
                 <p>Continue by filling in the <a href="https://www.sustain.uga.edu/user/profile" target="_blank">Checklist</a>.</p>
                 <p>Now that your application has been approved, you may add the Sustainability Certificate to your active curricula program via the MyPrograms option in Athena.</p>
                 <p>We would also like for you to take a survey as part of our assessment of the certificate program: 
                 <a href="https://ugeorgia.qualtrics.com/SE/?SID=SV_eQWZLWcQhfLEb0V" target="_blank">Pre-Certificate Survey</a></p>
                 <p>We will have an orientation at the beginning of each semester, but you are welcome to contact the director at any time: scdirector@uga.edu.</p>';

            $message = \Swift_Message::newInstance()
                ->setSubject('Certificate Application Approved')
                ->setFrom('scdirector@uga.edu')
                ->setTo($email)
                ->setBody(
                    $this->renderView(

                        'AppBundle:Email:apply.html.twig',
                        array('name' => $name,
                            'text' => $text)
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);

        return $this->redirect($this->generateUrl('user_show', array('id' => $user_entity->getId())));
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
            ->add('submit', 'submit', array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
