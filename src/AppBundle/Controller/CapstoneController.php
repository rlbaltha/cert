<?php

namespace AppBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Capstone;
use AppBundle\Form\CapstoneType;
use AppBundle\Form\WorkplanType;
use AppBundle\Entity\Project;
use AppBundle\Entity\Checkpoint;
use Dompdf\Dompdf;


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
     * @Route("/list/{tag}", name="capstone", methods={"GET"})
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction($tag)
    {
        $em = $this->getDoctrine()->getManager();

        $tag = $em->getRepository('AppBundle:Tag')->findOneByTitle($tag);
        $entities = $em->getRepository('AppBundle:User')->findByTag($tag->getId());

        return $this->render('AppBundle:Capstone:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Lists all Page entities.
     *
     * @Route("/adminindex/{status}", name="capstone_admin", defaults = {"status" = "Current"}, methods={"GET"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function adminindexAction($status)
    {
        $em = $this->getDoctrine()->getManager();
        if ($status == 'all') {
            $entities = $em->getRepository('AppBundle:Capstone')->findAll();
        }
        elseif ($status == 'Current') {
            $entities = $em->getRepository('AppBundle:Capstone')->findCurrent($status);
        }
        else {
            $entities = $em->getRepository('AppBundle:Capstone')->findByStatus($status);
        }

        return $this->render('AppBundle:Capstone:admin.html.twig', array(
            'entities' => $entities,
        ));
    }


    /**
     * Creates a new Capstone entity.
     *
     * @Route("/", name="capstone_create", methods={"POST"})
     * @Security("has_role('ROLE_USER')")
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
            $tag1 = $em->getRepository('AppBundle:Tag')->find(95);
            $tag2 = $em->getRepository('AppBundle:Tag')->find(101);
            $user_entity->addTag($tag1);
            $user_entity->addTag($tag2);
            $em->persist($entity);
            $em->persist($user_entity);

            $project = new Project();
            $project->setName('Checkpoints');
            $project->setUser($user_entity);
            $project->setType('Capstone');
            $project->setCapstone($entity);
            $project->setDescription('Please offer a desccription of your project.');
            $em->persist($project);

            $checkpoint1a = new Checkpoint();
            $checkpoint1a->setProject($project);
            $checkpoint1a->setType('Capstone');
            $checkpoint1a->setName('Contact Project Partner');
            $checkpoint1a->setDescription('<p></p>
                                            <ul>
                                            <li>Using the boilerplate offered, make initial contact with project partner(s).</li>
                                            </ul>');
            $em->persist($checkpoint1a);

            $checkpoint1b = new Checkpoint();
            $checkpoint1b->setProject($project);
            $checkpoint1b->setType('Capstone');
            $checkpoint1b->setName('Meet with Project Partner');
            $checkpoint1b->setDescription('<p></p>
                                            <ul>
                                            <li>Meet with project partner to continue planning and develop the project.</li>
                                            </ul>');
            $em->persist($checkpoint1b);

            $checkpoint1c = new Checkpoint();
            $checkpoint1c->setProject($project);
            $checkpoint1c->setType('Capstone');
            $checkpoint1c->setName('Identify Faculty Mentor');
            $checkpoint1c->setDescription('<p></p>
                                            <ul>
                                            <li>Identify and contact possible faculty mentor(s).</li>
                                            </ul>');
            $em->persist($checkpoint1c);

            $checkpoint1 = new Checkpoint();
            $checkpoint1->setProject($project);
            $checkpoint1->setType('Capstone');
            $checkpoint1->setName('Project Workplan and Timeline draft');
            $checkpoint1->setDescription('<p></p>
                                            <ul>
                                            <li>Complete project description and work plan, including specific tasks with due dates.</li>
                                            </ul>');
            $em->persist($checkpoint1);

            $checkpoint2 = new Checkpoint();
            $checkpoint2->setProject($project);
            $checkpoint2->setType('Capstone');
            $checkpoint2->setName('Project Workplan and Timeline final');
            $checkpoint2->setDescription('<ul>
                                            <li>Complete work plan and timeline.</li>
                                            <li>Review with sustainability rep and faculty mentor and revise as needed.</li>
                                            </ul>');
            $em->persist($checkpoint2);

            $checkpoint3 = new Checkpoint();
            $checkpoint3->setProject($project);
            $checkpoint3->setType('Capstone');
            $checkpoint3->setName('Team Role Contract');
            $checkpoint3->setDescription('<ul>
                                            <li>Complete Team Role contract</li>
                                            </ul>');
            $em->persist($checkpoint3);

            $checkpoint4 = new Checkpoint();
            $checkpoint4->setProject($project);
            $checkpoint4->setType('Capstone');
            $checkpoint4->setName('Team Project Update Presentation');
            $checkpoint4->setDescription('<ul>
                                            <li>Prepare a 5 minute presentation with progress, output or deliverables, and any challenges or celebration</li>
                                            </ul>');
            $em->persist($checkpoint4);

            $checkpoint5 = new Checkpoint();
            $checkpoint5->setProject($project);
            $checkpoint5->setType('Capstone');
            $checkpoint5->setName('Practice Final Team Project Presentation');
            $checkpoint5->setDescription('<ul>
                                            <li>Be ready to practice the final presentation for the seminar</li>
                                            </ul>');
            $em->persist($checkpoint5);

            $checkpoint7 = new Checkpoint();
            $checkpoint7->setProject($project);
            $checkpoint7->setType('Capstone');
            $checkpoint7->setName('Present Team Project to Seminar');
            $checkpoint7->setDescription('<ul>
                                            <li>Be ready to offer your final presentation</li>
                                            </ul>');
            $em->persist($checkpoint7);

            $checkpoint6 = new Checkpoint();
            $checkpoint6->setProject($project);
            $checkpoint6->setType('Capstone');
            $checkpoint6->setName('Capstone Completion');
            $checkpoint6->setDescription('<ul>
                                            <li>Capstone project is complete</li>
                                            <li>Reflection is complete</li>
                                            <li>Presentation is complete or scheduled</li>
                                            </ul>');
            $em->persist($checkpoint6);

            $em->flush();

            return $this->redirect($this->generateUrl('capstone_show', array('id' => $entity->getUser()->getId())));
        }

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
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
        $form = $this->createForm(CapstoneType::class, $entity, array(
            'action' => $this->generateUrl('capstone_create'),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Create','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }

    /**
     * Displays a form to create a new Capstone entity.
     *
     * @Route("/new", name="capstone_new", methods={"GET"})
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction()
    {
        $entity = new Capstone();
        $form   = $this->createCreateForm($entity);


        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing Capstone entity.
     *
     * @Route("/{id}/{part}/edit", name="capstone_edit", methods={"GET"})
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction($id, $part)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Capstone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capstone entity.');
        }

        $editForm = $this->createEditForm($entity, $part);
        $deleteForm = $this->createDeleteForm($id);


        return $this->render('AppBundle:Shared:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Capstone entity.
    *
    * @param Capstone $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Capstone $entity, $part)
    {
        if ($part == 'project') {
            $form = $this->createForm(CapstoneType::class, $entity, array(
                'action' => $this->generateUrl('capstone_update', array('id' => $entity->getId(), 'part'=> $part)),
                'method' => 'PUT',
            ));
        }
        else {
            $form = $this->createForm(WorkplanType::class, $entity, array(
                'action' => $this->generateUrl('capstone_update', array('id' => $entity->getId(), 'part'=> $part)),
                'method' => 'PUT',
            ));
        }

        $form->add('submit', SubmitType::class, array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Capstone entity.
     *
     * @Route("/{part}/{id}", name="capstone_update", methods={"PUT"})
     * @Security("has_role('ROLE_USER')")
     */
    public function updateAction(Request $request, $id, $part)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $entity = $em->getRepository('AppBundle:Capstone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capstone entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $part);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('capstone_show', array('id' => $user->getId())));
        }

        return $this->render('AppBundle:Shared:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a Page entity.
     *
     * @Route("/show/{id}", name="capstone_show", methods={"GET"})
     * @Security("has_role('ROLE_USER')")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository('AppBundle:Tag')->findByType('user');

        $entity = $em->getRepository('AppBundle:User')->find($id);
        $capstones = $em->getRepository('AppBundle:Capstone')->findByGroup($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Capstone entity.');
        }


        return $this->render('AppBundle:Capstone:show.html.twig', array(
            'entity' => $entity,
            'capstones' => $capstones,
            'tags' => $tags,
        ));
    }

    /**
     * Creates a pdf of capstone work plan
     *
     * @Route("/{id}/capstone_pdf", name="capstone_pdf")
     * @Security("has_role('ROLE_USER')")
     */
    public function createPdfAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Capstone')->find($id);

        $filename = 'attachment; filename="capstone.pdf"';


        $html = $this->renderView('AppBundle:Capstone:pdf.html.twig', array(
            'entity' => $entity,
        ));

        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        //        $dompdf->stream($name);
        return new Response(
            $dompdf->output(),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => $filename
            )
        );

    }


    /**
     * Capstone Ready for review and send email.
     *
     * @Route("/ready/{type}/{id}", name="capstone_ready", methods={"GET"})
     * @Security("has_role('ROLE_USER')")
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
            $tag1 = $em->getRepository('AppBundle:Tag')->find(97);
            $user_entity->addTag($tag1);
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
            $tag1 = $em->getRepository('AppBundle:Tag')->find(96);
            $user_entity->addTag($tag1);
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
         $text = $name . ' has submitted an capstone that is ready for ' . $type . ' review.';

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

        return $this->redirect($this->generateUrl('capstone_show', array('id' => $entity->getUser()->getId())));
    }

    /**
     * Approve Application and send email.
     *
     * @Route("/approve/{id}", name="capstone_approve", methods={"GET"})
     * @Security("has_role('ROLE_ADMIN')")
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

        //add and remove tags
        $tag = $em->getRepository('AppBundle:Tag')->find(108);
        $removetag = $em->getRepository('AppBundle:Tag')->find(97);
        $user_entity->addTag($tag);
        $user_entity->removeTag($removetag);


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

        return $this->redirect($this->generateUrl('capstone_show', array('id' => $entity->getUser()->getId())));
    }



    /**
     * Deletes a Capstone entity.
     *
     * @Route("/{id}", name="capstone_delete", methods={"DELETE"})
     * @Security("has_role('ROLE_ADMIN)")
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
            ->add('submit', SubmitType::class, array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
