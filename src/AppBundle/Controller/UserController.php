<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use AppBundle\Form\AdminType;
use AppBundle\Form\ProfileType;


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
     * @Security("has_role('ROLE_USER')")
     */
    public function profileAction()
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $entity = $em->getRepository('AppBundle:User')->find($user);
        $notifications = $em->getRepository('AppBundle:Notification')->findCurrent($user);

        $status = $em->getRepository('AppBundle:Status')->findAllSorted();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        if ($entity->getFacultylisting()) {
            return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));
        }
        if ($entity->getLastname() == '') {
            return $this->redirect($this->generateUrl('user_edit', array('id' => $entity->getId())));
        }
        elseif (is_null($entity->getProgram()) or $entity->getProgram()->getStatus()!='Approved') {
            return $this->redirect($this->generateUrl('program_show', array('id' => $entity->getId())));
        }
        else {
            return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'mentees' => $mentees,
            'notifications' => $notifications,
            'status' => $status,
        );
    }

    /**
     * Lists all User entities.
     *
     * @Route("/list/{tag}/{term}/{date}/{view}", name="user", defaults={"tag" = "students", "term" = "All", "date" = "All", "view" = "index"})
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction($tag, $term, $date, $view)
    {
        $em = $this->getDoctrine()->getManager();
        if ($tag == 'all') {
            $entities = $em->getRepository('AppBundle:User')->findAccounts();
        } elseif ($tag == 'students') {
            $currenttag = $em->getRepository('AppBundle:Tag')->findOneByTitle('Active');
            $entities = $em->getRepository('AppBundle:User')->findByTag($currenttag->getId());
        } elseif ($tag == 'term') {
            $entities = $em->getRepository('AppBundle:User')->findUsersByTerm($term, $date);
        } else {
            $currenttag = $em->getRepository('AppBundle:Tag')->findOneByTitle($tag);
            $entities = $em->getRepository('AppBundle:User')->findByTag($currenttag->getId());
        }

        if ($view == 'index') {
            $template = 'AppBundle:User:index.html.twig';
        } else {
            $template = 'AppBundle:User:grad.html.twig';
        }

        $tags = $em->getRepository('AppBundle:Tag')->findByType('user');

            return $this->render($template, array(
                'entities' => $entities,
                'tags' => $tags,
                'view' => $view,
            ));

    }



    /**
     * Lists all User entities.
     *
     * @Route("/updateactive/{tag}/{term}/{date}/{view}", name="user_updateactive", defaults={"tag" = "students", "term" = "All", "date" = "All", "view" = "index"})
     * @Method("GET")
     * @Template("AppBundle:User:index.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function updateactiveAction($tag, $term, $date, $view)
    {
        $em = $this->getDoctrine()->getManager();

        $tag = $em->getRepository('AppBundle:Tag')->findOneByTitle("Active");
        $tag1 = $em->getRepository('AppBundle:Tag')->findOneByTitle("Alumni");
        $tag2 = $em->getRepository('AppBundle:Tag')->findOneByTitle("Faculty");
        $tag3 = $em->getRepository('AppBundle:Tag')->findOneByTitle("Account Created");
        $tag4 = $em->getRepository('AppBundle:Tag')->findOneByTitle("Administration");
        $tag5 = $em->getRepository('AppBundle:Tag')->findOneByTitle("Inactive");
        $entities = $em->getRepository('AppBundle:User')->findAccounts();
        foreach($entities as $entity)
        {
            $entity->addTag($tag);
            if (!$entity->hasProgram() or $entity->hasTag($tag1) or $entity->hasTag($tag2) or $entity->hasTag($tag3)
                or $entity->hasTag($tag4) or $entity->hasTag($tag5)) {
                $entity->removeTag($tag);
            }
            $em->persist($entity);
        }

        $em->flush();

        $tags = $em->getRepository('AppBundle:Tag')->findByType('user');
        if ($view == 'index') {
            $template = 'AppBundle:User:index.html.twig';
        } else {
            $template = 'AppBundle:User:grad.html.twig';
        }
        $entities = $em->getRepository('AppBundle:User')->findByTag($tag->getId());

        return $this->render($template, array(
            'entities' => $entities,
            'tags' => $tags,
            'view' => $view,
        ));

    }

    /**
     * Lists all User entities.
     *
     * @Route("/toggle_grad/{id}/{term}/{date}", name="user_toggle_grad", defaults={"tag" = "students", "term" = "All", "date" = "All", "view" = "index"})
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function toggleGradAction($id, $term, $date, $view)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:User')->find($id);
        $checklist = $entity->getChecklist();
        $checklist->setAppliedtograd('Yes');
        $em->persist($checklist);
        $em->flush();
        $entities = $em->getRepository('AppBundle:User')->findUsersByTerm($term, $date);
        $template = 'AppBundle:User:grad.html.twig';

        $tags = $em->getRepository('AppBundle:Tag')->findByType('user');

        return $this->render($template, array(
            'entities' => $entities,
            'tags' => $tags,
            'view' => $view,
        ));

    }


    /**
     * Lists all User entities.
     *
     * @Route("/table/{tag}", name="user_table", defaults={"tag" = "Checklist"})
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function tableAction($tag)
    {
        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository('AppBundle:Tag')->findByType('user');
        $tag = $em->getRepository('AppBundle:Tag')->findOneByTitle($tag);
        $entities = $em->getRepository('AppBundle:User')->findByTag($tag->getId());

        return array(
            'entities' => $entities,
            'tags' => $tags,
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
     * @Route("/show/{id}/{tag}/{term}/{date}", name="user_show", defaults={"tag" = "students", "term" = "All", "date" = "All", "view" = "index"})
     * @Method("GET")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function showAction($id,$tag, $term, $date,$view)
    {
        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository('AppBundle:Tag')->findByType('user');
        $entity = $em->getRepository('AppBundle:User')->find($id);
        if ($tag == 'all') {
            $entities = $em->getRepository('AppBundle:User')->findAccounts();
        } elseif ($tag == 'students') {
            $entities = $em->getRepository('AppBundle:User')->findStudents();
        } elseif ($tag == 'term') {
            $entities = $em->getRepository('AppBundle:User')->findUsersByTerm($term, $date);
        } else {
            $currenttag = $em->getRepository('AppBundle:Tag')->findOneByTitle($tag);
            $entities = $em->getRepository('AppBundle:User')->findByTag($currenttag->getId());
        }
        $notifications = $em->getRepository('AppBundle:Notification')->findCurrent($entity);
        $status = $em->getRepository('AppBundle:Status')->findAllSorted();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }


        return array(
            'entity' => $entity,
            'notifications' => $notifications,
            'status' => $status,
            'tags' => $tags,
            'view' => $view,
        );
    }


    /**
     * Creates a pdf of users work
     *
     * @Route("/{id}/pdf", name="pdf")
     * @Security("has_role('ROLE_USER')")
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
     * @Route("/{id}/{return}/edit", name="user_edit" , defaults={"return" = "show"})
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction($id, $return)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity, $return);
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
    private function createEditForm(User $entity, $return)
    {

        if ($this->isGranted('ROLE_ADMIN')) {
            $form = $this->createForm(new AdminType(), $entity, array(
                'action' => $this->generateUrl('user_update', array('id' => $entity->getId(), 'return' => $return)),
                'method' => 'PUT',
            ));
        } else {
            $form = $this->createForm(new ProfileType(), $entity, array(
                'action' => $this->generateUrl('user_update', array('id' => $entity->getId(), 'return' => $return)),
                'method' => 'PUT',
            ));
        }


        $form->add('submit', 'submit', array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}/{return}", name="user_update")
     * @Method("PUT")
     * @Template("AppBundle:Shared:edit.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function updateAction(Request $request, $id, $return)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity, $return);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            if ($return == 'mentor') {
                return $this->redirect($this->generateUrl('user_mentor_mapping'));
            }
            else {
                return $this->redirect($this->generateUrl('user_show', array('id' => $id)));
            }

        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/inactive/{id}", name="user_inactive")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function inactiveAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $status = $em->getRepository('AppBundle:Status')->findByName('Inactive');
        $entity->setProgress($status);
        $entity->removeAllTags();
        $tag = $em->getRepository('AppBundle:Tag')->findOneByTitle("Inactive");
        $entity->addTag($tag);
        $timestamp = date('m/d/Y h:i:s A');
        $notes = $entity->getNotes();
        $entity->setNotes($notes . '<p>Student marked inactive. ' . $timestamp . '</p>');
        $em->persist($entity);
        $em->flush();

        $name = $entity->getFirstname() . ' ' . $entity->getLastname();
        $email = $entity->getEmail();
        $text = '<p>' . $name . ', it looks as if you are not planning to complete the Sustainability Certificate.  We have listed you as inactive.  Please let us know if we are
        mistaken and you plan to continue.  We wish you well in all you undertake.</p>
        <p>The Sustainability Certificate Staff</p>
        <p><a href="https://www.sustain.uga.edu" target="_blank">https://www.sustain.uga.edu</a></p>';

        $message = \Swift_Message::newInstance()
            ->setSubject('Sustainability Certificate')
            ->setFrom('scdirector@uga.edu')
            ->setTo($email)
            ->setBcc('scdirector@uga.edu')
            ->setBody(
                $this->renderView(

                    'AppBundle:Email:apply.html.twig',
                    array('name' => $name,
                        'text' => $text)
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);


        return $this->redirect($this->generateUrl('user_show', array('id' => $id)));

    }


    /**
     * Application Ready for review and send email.
     *
     * @Route("/mentee/{id}", name="user_mentee")
     * @Method("GET")
     * @Template("AppBundle:User:show.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function menteeAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);
        $tag1 = $em->getRepository('AppBundle:Tag')->find(102);
        $tag2 = $em->getRepository('AppBundle:Tag')->find(104);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $tags = $entity->getTags();

        if (!in_array($tag1, $tags->toArray(), TRUE)) {
            $entity->addTag($tag1);
        }

        $entity->addTag($tag2);
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));
    }

    /**
     *
     * @Route("/mentor/{id}", name="user_mentor")
     * @Method("GET")
     * @Template("AppBundle:User:show.html.twig")
     * @Security("has_role('ROLE_USER')")
     */
    public function mentorAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);
        $tag1 = $em->getRepository('AppBundle:Tag')->find(102);
        $tag2 = $em->getRepository('AppBundle:Tag')->find(103);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Program entity.');
        }

        $tags = $entity->getTags();

        if (!in_array($tag1, $tags->toArray(), TRUE)) {
            $entity->addTag($tag1);
        }

        $entity->addTag($tag2);
        $em->persist($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/pair/mentors", name="user_pairmentors")
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function pairMentorsAction()
    {
        $limit = 2;
        $em = $this->getDoctrine()->getManager();

        $mentees = $em->getRepository('AppBundle:User')->findMentees();

        foreach ($mentees as $key => $mentee) {
                $mentor = $em->getRepository('AppBundle:User')->findMentorWithNoMentees($limit);
                $mentees[$key]->setPeermentor($mentor);
                $em->persist($mentee);
                unset($mentor);
            }

        $em->flush();

        return $this->redirect($this->generateUrl('user_mentor_mapping'));

    }

    /**
     * Lists all User entities.
     *
     * @Route("/mapping/mentor", name="user_mentor_mapping")
     * @Method("GET")
     * @Template("AppBundle:User:mentormapping.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function mappingAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tag1 = $em->getRepository('AppBundle:Tag')->findOneByTitle('Mentor');
        $tag2 = $em->getRepository('AppBundle:Tag')->findOneByTitle('Mentee');
        $mentors = $em->getRepository('AppBundle:User')->findByTag($tag1);
        $mentees = $em->getRepository('AppBundle:User')->findByTag($tag2);
        $status = $em->getRepository('AppBundle:Status')->findAllSorted();
        return array(
            'mentors' => $mentors,
            'mentees' => $mentees,
            'status' => $status,
        );
    }


    /**
     * Add User Tags to Users
     *
     * @Route("/addtags/{type}/{tagid}", name="addtags")
     * @Method("GET")
     * @Template("AppBundle:User:index.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function addtagsAction($type,$tagid)
    {
        $em = $this->getDoctrine()->getManager();
        $status = $em->getRepository('AppBundle:Status')->findAllSorted();
        $tags = $em->getRepository('AppBundle:Tag')->findByType('user');
        if ($type == 'all') {
            $entities = $em->getRepository('AppBundle:User')->findAccounts();
        } elseif ($type == 'students') {
            $entities = $em->getRepository('AppBundle:User')->findStudents();
        } elseif ($type == '17') {
            $entities = $em->getRepository('AppBundle:User')->findCapstones();
        } elseif ($type == 'mentors') {
            $entities = $em->getRepository('AppBundle:User')->findMentors();
        } elseif ($type == 'mentees') {
            $entities = $em->getRepository('AppBundle:User')->findMentees();
        } elseif ($type == 'peermentors') {
            $entities = $em->getRepository('AppBundle:User')->findPeerMentors();
        } elseif ($type == '15') {
            $entities = $em->getRepository('AppBundle:User')->findFaculty();
        } else {
            $type = $em->getRepository('AppBundle:Status')->find($type);
            $entities = $em->getRepository('AppBundle:User')->findUsersByType($type);
        }
        $tag = $em->getRepository('AppBundle:Tag')->find($tagid);

        foreach ($entities as &$user) {
            $user->addTag($tag);
            $em->persist($user);
        };
        $em->flush();

        return array(
            'entities' => $entities,
            'status' => $status,
            'tags' => $tags,
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
