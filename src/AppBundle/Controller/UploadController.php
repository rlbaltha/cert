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
use Symfony\Component\HttpFoundation\Response;

/**
 * Upload controller.
 *
 * @Route("/upload")
 */
class UploadController extends Controller
{

    /**
     * Lists all Upload entities.
     *
     * @Route("/", name="upload")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
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
    public function createAction(Request $request)
    {
        $entity = new Upload();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $headerText = 'Upload New';

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($entity->getType()=='Image') {
                return $this->redirect($this->generateUrl('upload'));
            }
            else {
                return $this->redirect($this->generateUrl('course_show', array('id' => $entity->getCourse()->getId())));
            }

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
    private function createCreateForm(Upload $entity)
    {
        $form = $this->createForm(new UploadType(), $entity, array(
            'action' => $this->generateUrl('upload_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Upload',
            'attr' =>
                array('class' => 'btn btn-primary')
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Upload entity.
     *
     * @Route("/new/{courseid}", name="upload_new" , defaults={"courseid" = 0}))
     * @Method("GET")
     * @Template("AppBundle:Shared:new.html.twig")
     */
    public function newAction($courseid)
    {
        $entity = new Upload();
        $em = $this->getDoctrine()->getManager();

        $course = $em->getRepository('AppBundle:Course')->find($courseid);
        $entity->setCourse($course);
        if ($courseid==0) {
            $entity->setType('Image');
        }
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
    public function editAction($id)
    {
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
    private function createEditForm(Upload $entity)
    {
        $form = $this->createForm(new UploadType(), $entity, array(
            'action' => $this->generateUrl('upload_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array(
            'label' => 'Update',
            'attr' =>
                array('class' => 'btn btn-primary')
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
    public function updateAction(Request $request, $id)
    {
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
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Upload')->find($id);

        if ($form->isValid()) {

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
    private function createDeleteForm($id)
    {
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
     * Finds and displays a File.
     *
     * @Route("/{id}/get", name="upload_get")
     *
     */
    public function getAction($id) {

        $em = $this->getDoctrine()->getManager();
        $file = $em->getRepository('AppBundle:Upload')->find($id);

        $name = $file->getName();

        $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');
        $path = $helper->asset($file, 'file');
        $ext = strtolower($file->getExt());
        $filename = $name . '.' . $ext;


        $response = new Response();

        $response->setStatusCode(200);
        switch ($ext) {
            case "png":
                $response->headers->set('Content-Type', 'image/png');
                $response->headers->set('Content-Disposition', 'filename="' . $filename . '"');
                break;
            case "gif":
                $response->headers->set('Content-Type', 'image/gif');
                $response->headers->set('Content-Disposition', 'filename="' . $filename . '"');
                break;
            case "jpeg":
                $response->headers->set('Content-Type', 'image/jpeg');
                $response->headers->set('Content-Disposition', 'filename="' . $filename . '"');
                break;
            case "jpg":
                $response->headers->set('Content-Type', 'image/jpeg');
                $response->headers->set('Content-Disposition', 'filename="' . $filename . '"');
                break;
            case "mpeg":
                $response->headers->set('Content-Type', 'audio/mpeg');
                $response->headers->set('Content-Disposition', 'filename="' . $filename . '"');
                break;
            case "mp3":
                $response->headers->set('Content-Type', 'audio/mp3');
                $response->headers->set('Content-Disposition', 'filename="' . $filename . '"');
                break;
            case "odt":
                $response->headers->set('Content-Type', 'application/vnd.oasis.opendocument.text');
                $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
                break;
            case "ods":
                $response->headers->set('Content-Type', 'application/vnd.oasis.opendocument.spreadsheet');
                $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
                break;
            case "odp":
                $response->headers->set('Content-Type', 'application/vnd.oasis.opendocument.presentation');
                $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
                break;
            case "doc":
                $response->headers->set('Content-Type', 'application/vnd.msword');
                $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
                break;
            case "docx":
                $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
                break;
            case "ppt":
                $response->headers->set('Content-Type', 'application/vnd.mspowerpoint');
                $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
                break;
            case "pptx":
                $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.presentationml.presentation');
                $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
                break;
            case "xls":
                $response->headers->set('Content-Type', 'application/vnd.ms-excel');
                $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
                break;
            case "xlsx":
                $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
                break;
            case "pdf":
                $response->headers->set('Content-Type', 'application/pdf');
                $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
                break;
            default:
                $response->headers->set('Content-Type', 'application/octet-stream');
        }
        $response->setContent(file_get_contents($path));

        return $response;
    }
}
