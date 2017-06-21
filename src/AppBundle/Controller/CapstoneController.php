<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Capstone;
use AppBundle\Form\CapstoneType;
use AppBundle\Entity\Project;
use AppBundle\Entity\Checkpoint;

/**
 * Capstone controller.
 *
 * @Route("/capstone")
 */
class CapstoneController extends Controller
{

    /**
     * Lists all Page entities.
     *
     * @Route("/list/{type}", name="capstone")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($type)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Capstone')->findByType($type);

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Lists all Page entities.
     *
     * @Route("/completed", name="capstones_completed")
     * @Method("GET")
     * @Template("AppBundle:Capstone:completed.html.twig")
     */
    public function completedAction()
    {
        $em = $this->getDoctrine()->getManager();
        $type = 'Completed';
        $entities = $em->getRepository('AppBundle:Capstone')->findByType($type);
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle('Capstone');
        $tags = $em->getRepository('AppBundle:Tag')->findAll();

        return array(
            'entities' => $entities,
            'section' => $section,
            'tags' => $tags,
        );
    }


    /**
     * Creates a new Capstone entity.
     *
     * @Route("/", name="capstone_create")
     * @Method("POST")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Capstone();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user=$this->getUser();
            $entity->setUser($user);

            $user_entity = $em->getRepository('AppBundle:User')->find($user);
            $status = $em->getRepository('AppBundle:Status')->findByName('Capstone Created');
            $user_entity->setProgress($status);
            $em->persist($entity);
            $em->persist($user_entity);

            $project = new Project();
            $project->setName('Checkpoints');
            $project->setUser($user_entity);
            $project->setType('Capstone');
            $project->setCapstone($entity);
            $project->setDescription('Please offer a desccription of your project.');
            $em->persist($project);

            $checkpoint1 = new Checkpoint();
            $checkpoint1->setProject($project);
            $checkpoint1->setName('Design Process');
            $checkpoint1->setDescription('Create the checkpoints for your capstone.');
            $em->persist($checkpoint1);

            $checkpoint2 = new Checkpoint();
            $checkpoint2->setProject($project);
            $checkpoint2->setName('Project Underway');
            $checkpoint2->setDescription('Create the list of initial events to be completed in the first month of the term.');
            $em->persist($checkpoint2);

            $checkpoint3 = new Checkpoint();
            $checkpoint3->setProject($project);
            $checkpoint3->setName('Midpoint');
            $checkpoint3->setDescription('Create the list of events that should be completed or underway by midpoint.');
            $em->persist($checkpoint3);

            $checkpoint4 = new Checkpoint();
            $checkpoint4->setProject($project);
            $checkpoint4->setName('End of term');
            $checkpoint4->setDescription('Create the list of events for completing your capstone.');
            $em->persist($checkpoint4);

            $em->flush();

            return $this->redirect($this->generateUrl('user_profile'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Capstone entity.
     *
     * @param Capstone $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Capstone $entity)
    {
        $form = $this->createForm(new CapstoneType(), $entity, array(
            'action' => $this->generateUrl('capstone_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }

    /**
     * Displays a form to create a new Capstone entity.
     *
     * @Route("/new", name="capstone_new")
     * @Method("GET")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Capstone();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * Displays a form to edit an existing Capstone entity.
     *
     * @Route("/{id}/edit", name="capstone_edit")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Capstone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capstone entity.');
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
    * Creates a form to edit a Capstone entity.
    *
    * @param Capstone $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Capstone $entity)
    {
        $form = $this->createForm(new CapstoneType(), $entity, array(
            'action' => $this->generateUrl('capstone_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Capstone entity.
     *
     * @Route("/{id}", name="capstone_update")
     * @Method("PUT")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Capstone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capstone entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('user_profile'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Finds and displays a Page entity.
     *
     * @Route("/{id}", name="capstone_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Capstone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capstone entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Capstone Ready for review and send email.
     *
     * @Route("/ready/{type}/{id}", name="capstone_ready")
     * @Method("GET")
     * @Template("AppBundle:User:show.html.twig")
     */
    public function readyAction($id, $type)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Capstone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capstone entity.');
        }

        $user = $entity->getUser();
        $user_entity = $em->getRepository('AppBundle:User')->find($user);
        $timestamp = date('m/d/Y h:i:s A');

        if ($type == 'Director') {
            $status = $em->getRepository('AppBundle:Status')->findByName('Ready for Director Review');
            $entity->setStatus('Ready for Director Review');
            $note = '<p> Capstone ready for '.$type. ' review. '.$timestamp.'</p>';
        }
        elseif ($type == 'Completed') {
            $status = $em->getRepository('AppBundle:Status')->findByName('Capstone Completed');
            $entity->setStatus('Completed');
            $note = '<p> Capstone completed. '.$timestamp.'</p>';
        }
        else {
            $status = $em->getRepository('AppBundle:Status')->findByName('Ready for Peer Review');
            $entity->setStatus('Ready for Peer Review');
            $note = '<p> Capstone ready for '.$type. ' review. '.$timestamp.'</p>';
        }
        $user_entity->setProgress($status);

        $notes = $user_entity->getNotes();
        $user_entity->setNotes($notes.$note);


        $em->persist($entity);
        $em->persist($user_entity);
        $em->flush();

     if ($type != 'Completed') {
         $name = $user_entity->getFirstname() . ' ' . $user_entity->getLastname();
         $email = 'scdirector@uga.edu';
         $text = $name . ' has submitted an capstone that is ready for ' . $type . 'review.';

         $message = \Swift_Message::newInstance()
             ->setSubject('Certificate Capstone Ready for ' . $type . ' Review')
             ->setFrom('scdirector@uga.edu')
             ->setTo($email)
             ->setBody(
                 $this->renderView(

                     'AppBundle:Email:apply.html.twig',
                     array('text' => $text)
                 ),
                 'text/html'
             );
         $this->get('mailer')->send($message);
     }

        return $this->redirect($this->generateUrl('user_show', array('id' => $user_entity->getId())));
    }

    /**
     * Approve Application and send email.
     *
     * @Route("/approve/{id}", name="capstone_approve")
     * @Method("GET")
     * @Template("AppBundle:User:show.html.twig")
     */
    public function approveAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Capstone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capstone entity.');
        }

        $user = $entity->getUser();
        $user_entity = $em->getRepository('AppBundle:User')->find($user);
        $status = $em->getRepository('AppBundle:Status')->findByName('Capstone Approved');
        $user_entity->setProgress($status);
        $timestamp = date('m/d/Y h:i:s A');
        $notes = $user_entity->getNotes();
        $user_entity->setNotes($notes.'<p> Capstone approved '.$timestamp.'</p>');
        $entity->setStatus('Approved');

        $em->persist($entity);
        $em->persist($user_entity);
        $em->flush();

        $name = $user_entity->getFirstname().' '.$user_entity->getLastname();
        $email = $user_entity->getEmail();
        $text = $name.', your capstone workplan for the Sustainability Certificate has been approved.  Congrats.';

        $message = \Swift_Message::newInstance()
            ->setSubject('Certificate Capstone Approved')
            ->setFrom('scdirector@uga.edu')
            ->setTo($email)
            ->setBcc('scdirector@uga.edu')
            ->setBody(
                $this->renderView(

                    'AppBundle:Email:apply.html.twig',
                    array('text' => $text)
                ),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);

        return $this->redirect($this->generateUrl('user_show', array('id' => $user_entity->getId())));
    }



    /**
     * Deletes a Capstone entity.
     *
     * @Route("/{id}", name="capstone_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Capstone')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Capstone entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user_profile'));
    }

    /**
     * Creates a form to delete a Capstone entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('capstone_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
