<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Responseset;
use AppBundle\Form\ResponsesetType;
use AppBundle\Entity\Response;


/**
 * Responseset controller.
 *
 * @Route("/responseset")
 */
class ResponsesetController extends Controller
{

    /**
     * Lists all Responseset entities.
     *
     * @Route("/", name="responseset")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Responseset')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a form to create a Responseset entity.
     *
     * @param Responseset $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Responseset $entity)
    {
        $form = $this->createForm(new ResponsesetType(), $entity, array(
            'action' => $this->generateUrl('responseset_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }

    /**
     * Displays a form to create a new Responseset entity.
     *
     * @Route("/new/{id}/{questionsetid}", name="responseset_new")
     * @Method("GET")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function newAction($id, $questionsetid)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user_entity = $em->getRepository('AppBundle:User')->find($user);

        $capstone = $em->getRepository('AppBundle:Capstone')->find($id);
        $questions = $em->getRepository('AppBundle:Question')->findQuestions($questionsetid);

        $responseset = new Responseset();
        $responseset->setCapstone($capstone);
        $responseset->setUser($user_entity);
        $cnt = count($questions);

        for ($i = 0; $i < $cnt; $i++) {
            $question = $questions[$i];
            $response = new Response();
            $response->setResponse('<p></p>');
            $response->setQuestion($question);
            $response->setResponseset($responseset);
            $em->persist($response);
        }

        $em->persist($responseset);
        $em->flush();

        $email = $user_entity->getEmail();
        $text = 'The Certificate Director has reviewed your work plan.  Login and check
         Reviews under the Capstone tab.';

        $message = \Swift_Message::newInstance()
            ->setSubject('Director Review')
            ->setFrom('scdirector@uga.edu')
            ->setTo($email)
            ->setBcc('scdirector@uga.edu')
            ->setBody(
                $this->renderView(

                    'AppBundle:Email:apply.html.twig',
                    array('text' => $text)
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);

        return $this->redirect($this->generateUrl('responseset_edit', array('id' => $responseset->getId())));

    }

    /**
     * Finds and displays a Responseset entity.
     *
     * @Route("/{id}", name="responseset_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Responseset')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Responseset entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Responseset entity.
     *
     * @Route("/{id}/edit", name="responseset_edit")
     * @Method("GET")
     * @Template("AppBundle:Responseset:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Responseset')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Responseset entity.');
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
    * Creates a form to edit a Responseset entity.
    *
    * @param Responseset $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Responseset $entity)
    {
        $form = $this->createForm(new ResponsesetType(), $entity, array(
            'action' => $this->generateUrl('responseset_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update','attr' => array('class' => 'btn btn-primary'),));

        return $form;
    }
    /**
     * Edits an existing Responseset entity.
     *
     * @Route("/{id}", name="responseset_update")
     * @Method("PUT")
     * @Template("AppBundle:Responseset:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Responseset')->find($id);
        $capstone = $entity->getCapstone();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Responseset entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('user_show', array('id' => $capstone->getUser()->getId())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Responseset entity.
     *
     * @Route("/{id}", name="responseset_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Responseset')->find($id);
            $capstoneid = $entity->getCapstone()->getUser()->getId();


            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Responseset entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user_show', array('id' => $capstoneid)));
    }

    /**
     * Creates a form to delete a Responseset entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('responseset_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Confirm Delete','attr' => array('class' => 'btn btn-danger'),))
            ->getForm()
        ;
    }
}
