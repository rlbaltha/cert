<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Course;
use AppBundle\Form\CourseType;

/**
 * Course controller.
 *
 * @Route("/course")
 */
class CourseController extends Controller
{

    /**
     * Lists all Course entities.
     *
     * @Route("/list/{level}/{pillar}/{status}", name="course", defaults={"pillar" = "all", "level" = "all", "status" =
     *     "approved"})
     * @Method("GET")
     * @Template()
     */
    public function indexAction($pillar, $level, $status)
    {
        $em = $this->getDoctrine()->getManager();
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle('Course');

        if ($pillar=='all') {
            $entities = '';
        }
        else {
            $entities = $em->getRepository('AppBundle:Course')->findByPillar($pillar, $level, $status);
        }


        return array(
            'entities' => $entities,
            'section' => $section,
        );
    }

    /**
     * Lists all Course entities.
     *
     * @Route("/listbystatus/{status}", name="course_listbystatus")
     * @Method("GET")
     * @Template("AppBundle:Course:index.html.twig")
     */
    public function listbystatusAction($status)
    {
        $em = $this->getDoctrine()->getManager();
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle('Course');

            $entities = $em->getRepository('AppBundle:Course')->findByStatus($status);


        return array(
            'entities' => $entities,
            'section' => $section,
        );
    }

    /**
     * Lists all Course entities.
     *
     * @Route("/listbylocation/{location}/{status}", name="course_listbylocation")
     * @Method("GET")
     * @Template("AppBundle:Course:index.html.twig")
     */
    public function listbylocationAction($location, $status)
    {
        $em = $this->getDoctrine()->getManager();
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle('Course');

        $entities = $em->getRepository('AppBundle:Course')->findByLocation($location, $status);


        return array(
            'entities' => $entities,
            'section' => $section,
        );
    }


    /**
     * Lists all Course entities.
     *
     * @Route("/listall", name="course_listall")
     * @Method("GET")
     * @Template("AppBundle:Course:index.html.twig")
     */
    public function listallAction()
    {
        $em = $this->getDoctrine()->getManager();
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle('Course');

        $entities = $em->getRepository('AppBundle:Course')->findAllSorted();


        return array(
            'entities' => $entities,
            'section' => $section,
        );
    }


    /**
     * Creates a new Course entity.
     *
     * @Route("/", name="course_create")
     * @Method("POST")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Course();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('course_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Course entity.
     *
     * @param Course $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Course $entity)
    {
        $form = $this->createForm(new CourseType(), $entity, array(
            'action' => $this->generateUrl('course_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }

    /**
     * Displays a form to create a new Course entity.
     *
     * @Route("/new", name="course_new")
     * @Method("GET")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function newAction()
    {
        $entity = new Course();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Course entity.
     *
     * @Route("/{id}", name="course_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Course')->find($id);
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle('Course');

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'section' => $section,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Course entity.
     *
     * @Route("/{id}/edit", name="course_edit")
     * @Method("GET")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Course')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Course entity.');
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
    * Creates a form to edit a Course entity.
    *
    * @param Course $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Course $entity)
    {
        $form = $this->createForm(new CourseType(), $entity, array(
            'action' => $this->generateUrl('course_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Course entity.
     *
     * @Route("/{id}", name="course_update")
     * @Method("PUT")
     * @Template("AppBundle:Shared:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Course')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('course_show', array('id' => $entity->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Course entity.
     *
     * @Route("/{id}", name="course_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Course')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Course entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('course'));
    }

    /**
     * Creates a form to delete a Course entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('course_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete','attr' => array('class' => 'btn btn-default pull-right'),))
            ->getForm()
        ;
    }

    /**
     * Approve Application and send email.
     *
     * @Route("/approval/{state}/{id}", name="course_approval")
     * @Method("GET")
     * @Template("AppBundle:Course:index.html.twig")
     */
    public function approveAction($id, $state)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Course')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }

        $timestamp = date('m/d/Y h:i:s A');
        $notes = $entity->getNotes();
        $entity->setNotes($notes.'<p> Course '.$state.' '.$timestamp.'</p>');
        $entity->setStatus($state);

        $em->persist($entity);
        $em->flush();

        $name = $entity->getContact();
        $email = $entity->getContactEmail();
        $course = $entity->getName();
        if ($state=='approved') {
            $text =  '<p>'.$name.', '.$course.'  has been approved for the Sustainability Certificate. 
            Thanks much for being part of the certificate and for all you do for sustainability at UGA.</p>
            <p>You should be able to see your course listed now on the website:  
            <a href="https://www.sustain.uga.edu">https://www.sustain.uga.edu</a>. 
             <p>Please contact us if you have questions: scdirector@uga.edu.</p>
             <p>The Cert Staff</p>
             ';
        }
        else {
            $text =  '<p>'.$name.', thank you for proposing a course for the Sustainability Certificate.  The Review Committee does 
             not feel that '.$course.' meets our criteria for inclusion.  As a baseline for our sustainability spheres, we would like to see
              at least 50% of the course directly focused on sustainability and would like to see sustainability in the description 
              and course objectives. For more details, please read the criteria for including a course on our website: 
              <a href="https://www.sustain.uga.edu/page/29">https://www.sustain.uga.edu/page/29</a>
            </p>
            <p>Please contact us if you have questions: scdirector@uga.edu.</p>
            <p>The Cert Staff</p>';
        }

        $message = \Swift_Message::newInstance()
            ->setSubject('Course Proposed for Sustainability Certificate')
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
            )
        ;
        $this->get('mailer')->send($message);

        return $this->redirect($this->generateUrl('course_listbystatus', array('status' => 'pending')));
    }


}
