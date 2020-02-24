<?php

namespace AppBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Faculty;
use AppBundle\Form\FacultyType;
use AppBundle\Entity\Section;
use FOS\UserBundle\Util\TokenGenerator;

/**
 * Faculty controller.
 *
 * @Route("/faculty")
 */
class FacultyController extends Controller
{

    /**
     * Lists all Faculty entities.
     *
     * @Route("/{section}/{status}/list", name="faculty", defaults={"section" = "faculty"}, methods={"GET"})
     * @Template()
     */
    public function indexAction($status, $section)
    {
        $em = $this->getDoctrine()->getManager();
        $section = ucfirst($section);
        $entities = $em->getRepository('AppBundle:Faculty')->findAllSorted($status);
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle($section);
        $tags = $em->getRepository('AppBundle:Tag')->findByType('resource');


        return $this->render('AppBundle:Faculty:index.html.twig', array(
            'entities' => $entities,
            'tags' => $tags,
            'section' => $section
        ));
    }

    /**
     * Creates a new Faculty entity.
     *
     * @Route("/", name="faculty_create", methods={"POST"})
     */
    public function createAction(Request $request)
    {
        $entity = new Faculty();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('faculty', array('status' => 'all')));
        }

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Faculty entity.
     *
     * @Route("/{id}/account", name="faculty_account", methods={"GET"})
     */
    public function accountAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Faculty')->find($id);
        $user = $em->getRepository('AppBundle:User')->findOneByEmail($entity->getEmail());

        if (!$user) {
            $userManager = $this->get('fos_user.user_manager');
            $tokengenerator = $this->get('fos_user.util.token_generator');
            $username = strtok($entity->getEmail(), '@');
            $email = $entity->getEmail();
            $password = substr($tokengenerator->generateToken(), 0, 12);

            $user = $userManager->createUser();
            $user->setUsername($username);
            $user->setUsernameCanonical($username);
            $user->setEmail($email);
            $user->setEmailCanonical($email);
            $user->setEnabled(true);
            $user->setPlainPassword($password);
            $userManager->updateUser($user);

            $entity->setUser($user);
            $userentity = $em->getRepository('AppBundle:User')->findOneByEmail($entity->getEmail());
            $status = $em->getRepository('AppBundle:Status')->findOneByName('Faculty');
            $userentity->setLastname($entity->getLastname());
            $userentity->setFirstname($entity->getFirstname());
            $userentity->setProgress($status);
            $tag = $em->getRepository('AppBundle:Tag')->findOneByTitle("Faculty");
            $userentity->addTag($tag);

            $em->persist($entity);
            $em->persist($userentity);
            $em->flush();
        }
        else {
            $entity->setUser($user);
            $em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('faculty_show', array('id' => $entity->getId(), 'section' => 'faculty')));
    }

    /**
     * Creates a form to create a Faculty entity.
     *
     * @param Faculty $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Faculty $entity)
    {
        $form = $this->createForm(FacultyType::class, $entity, array(
            'action' => $this->generateUrl('faculty_create'),
            'method' => 'POST',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Create', 'attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }

    /**
     * Displays a form to create a new Faculty entity.
     *
     * @Route("/new", name="faculty_new", methods={"GET"})
     */
    public function newAction()
    {
        $entity = new Faculty();
        $form = $this->createCreateForm($entity);

        return $this->render('AppBundle:Shared:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Faculty entity.
     *
     * @Route("/{section}/{id}/detail", name="faculty_show", defaults={"section" = "faculty"}, methods={"GET"})
     * @Template()
     */
    public function showAction($id, $section)
    {
        $em = $this->getDoctrine()->getManager();
        $section = ucfirst($section);
        $entity = $em->getRepository('AppBundle:Faculty')->find($id);
        $section = $em->getRepository('AppBundle:Section')->findOneByTitle($section);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faculty entity.');
        }


        return $this->render('AppBundle:Faculty:show.html.twig', array(
            'entity' => $entity,
            'section' => $section,
        ));
    }

    /**
     * Displays a form to edit an existing Faculty entity.
     *
     * @Route("/{id}/edit", name="faculty_edit", methods={"GET"})
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Faculty')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faculty entity.');
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
     * Creates a form to edit a Faculty entity.
     *
     * @param Faculty $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Faculty $entity)
    {
        $form = $this->createForm(FacultyType::class, $entity, array(
            'action' => $this->generateUrl('faculty_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', SubmitType::class, array('label' => 'Update', 'attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }

    /**
     * Edits an existing Faculty entity.
     *
     * @Route("/{id}", name="faculty_update", methods={"PUT"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Faculty')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Faculty entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('faculty_show', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Faculty entity.
     *
     * @Route("/{id}", name="faculty_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Faculty')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Faculty entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('faculty', array('status' => 'all')));
    }

    /**
     * Creates a form to delete a Faculty entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('faculty_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, array('label' => 'Confirm Delete', 'attr' => array('class' => 'btn btn-danger'),))
            ->getForm();
    }
}
