<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Upload;
use AppBundle\Form\UploadType;
use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\Writer\DoctrineWriter;

/**
 * Upload controller.
 *
 * @Route("/upload")
 */
class UploadController extends Controller {

  /**
   * Lists all Upload entities.
   *
   * @Route("/", name="upload")
   * @Method("GET")
   * @Template()
   */
  public function indexAction() {
    $em = $this->getDoctrine()->getManager();

    $entities = $em->getRepository('AppBundle:Upload')->findAll();

    return array(
      'entities' => $entities,
    );
  }

  /**
   * Creates a new Upload entity.
   *
   * @Route("/", name="upload_create")
   * @Method("POST")
   * @Template("AppBundle:Shared:new.html.twig")
   */
  public function createAction(Request $request) {
    $entity = new Upload();
    $form = $this->createCreateForm($entity);
    $form->handleRequest($request);
    $headerText = 'Upload New';

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($entity);
      $em->flush();

      return $this->redirect($this->generateUrl('upload', array('id' => $entity->getId())));
    }

    return array(
      'entity' => $entity,
      'headerText' => $headerText,
      'form' => $form->createView(),
    );
  }

  /**
   * Creates a form to create a Upload entity.
   *
   * @param Upload $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createCreateForm(Upload $entity) {
    $form = $this->createForm(new UploadType(), $entity, array(
      'action' => $this->generateUrl('upload_create'),
      'method' => 'POST',
    ));

    $form->add('submit', 'submit', array(
      'label' => 'Upload',
      'attr' =>
        array('class' => 'btn btn-default')
    ));

    return $form;
  }

  /**
   * Displays a form to create a new Upload entity.
   *
   * @Route("/new", name="upload_new")
   * @Method("GET")
   * @Template("AppBundle:Shared:new.html.twig")
   */
  public function newAction() {
    $entity = new Upload();
    $form = $this->createCreateForm($entity);
    $headerText = 'Upload New';

    return array(
      'entity' => $entity,
      'headerText' => $headerText,
      'form' => $form->createView(),
    );
  }


  /**
   * Displays a form to edit an existing Upload entity.
   *
   * @Route("/{id}/edit", name="upload_edit")
   * @Method("GET")
   * @Template("AppBundle:Shared:edit.html.twig")
   */
  public function editAction($id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:Upload')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Upload entity.');
    }

    $headerText = 'Upload Edit';
    $editForm = $this->createEditForm($entity);
    $deleteForm = $this->createDeleteForm($id);

    return array(
      'entity' => $entity,
      'headerText' => $headerText,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Creates a form to edit a Upload entity.
   *
   * @param Upload $entity The entity
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createEditForm(Upload $entity) {
    $form = $this->createForm(new UploadType(), $entity, array(
      'action' => $this->generateUrl('upload_update', array('id' => $entity->getId())),
      'method' => 'PUT',
    ));

    $form->add('submit', 'submit', array(
      'label' => 'Update',
      'attr' =>
        array('class' => 'btn btn-default')
    ));

    return $form;
  }

  /**
   * Edits an existing Upload entity.
   *
   * @Route("/{id}", name="upload_update")
   * @Method("PUT")
   * @Template("AppBundle:Shared:edit.html.twig")
   */
  public function updateAction(Request $request, $id) {
    $em = $this->getDoctrine()->getManager();

    $entity = $em->getRepository('AppBundle:Upload')->find($id);

    if (!$entity) {
      throw $this->createNotFoundException('Unable to find Upload entity.');
    }

    $deleteForm = $this->createDeleteForm($id);
    $headerText = 'Upload Edit';
    $editForm = $this->createEditForm($entity);
    $editForm->handleRequest($request);

    if ($editForm->isValid()) {
      $em->flush();

      return $this->redirect($this->generateUrl('upload_edit', array('id' => $id)));
    }

    return array(
      'entity' => $entity,
      'headerText' => $headerText,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    );
  }

  /**
   * Deletes a Upload entity.
   *
   * @Route("/{id}", name="upload_delete")
   * @Method("DELETE")
   */
  public function deleteAction(Request $request, $id) {
    $form = $this->createDeleteForm($id);
    $form->handleRequest($request);

    if ($form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $entity = $em->getRepository('AppBundle:Upload')->find($id);

      if (!$entity) {
        throw $this->createNotFoundException('Unable to find Upload entity.');
      }

      $em->remove($entity);
      $em->flush();
    }

    return $this->redirect($this->generateUrl('upload'));
  }

  /**
   * Creates a form to delete a Upload entity by id.
   *
   * @param mixed $id The entity id
   *
   * @return \Symfony\Component\Form\Form The form
   */
  private function createDeleteForm($id) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('upload_delete', array('id' => $id)))
      ->setMethod('DELETE')
      ->add('submit', 'submit', array(
        'label' => 'Delete',
        'attr' =>
          array('class' => 'btn btn-danger')
      ))
      ->getForm();
  }

  /**
   * Import  from csv
   * using https://github.com/ddeboer/data-import
   *
   * @Route("/import/{filetype}/{entity}/{id}", name="import_upload")
   */
  public function importAction($id, $filetype, $entity) {
    $em = $this->getDoctrine()->getManager();
    // Create and configure the reader
    $upload = $em->getRepository('AppBundle:Upload')->find($id);
    $path = $this->get('kernel')->getRootDir() . '/../uploads/'
      . $upload->getName();
    $entity_namespace = 'AppBundle:' . $entity;
    $entity_redirect = $entity;
    $file = new \SplFileObject($path);
    $csvReader = new CsvReader($file);

    // Tell the reader that the first row in the CSV file contains column headers
    $csvReader->setHeaderRowNumber(0);
    $csvReader->setStrict(FALSE);

    // Create the workflow from the reader
    $workflow = new Workflow($csvReader);

    // Create a writer: you need Doctrine’s EntityManager.
    $doctrineWriter = new DoctrineWriter($em, $entity_namespace);
    $doctrineWriter->disableTruncate();
    $workflow->addWriter($doctrineWriter);


    // Process the workflow
    $workflow->process();

    return $this->redirect($this->generateUrl(strtolower($entity_redirect)));
  }
}
