<?php

namespace ProductBundle\Controller;

use ProductBundle\Entity\Status;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Status controller.
 *
 */
class StatusController extends Controller
{
    /**
     * Lists all status entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $statuses = $em->getRepository('ProductBundle:Status')->findAll();

        return $this->render('status/index.html.twig', array(
            'statuses' => $statuses,
        ));
    }

    /**
     * Creates a new status entity.
     *
     */
    public function newAction(Request $request)
    {
        $status = new Status();
        $form = $this->createForm('ProductBundle\Form\StatusType', $status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($status);
            $em->flush($status);

            return $this->redirectToRoute('status_show', array('id' => $status->getId()));
        }

        return $this->render('status/new.html.twig', array(
            'status' => $status,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a status entity.
     *
     */
    public function showAction(Status $status)
    {
        $deleteForm = $this->createDeleteForm($status);

        return $this->render('status/show.html.twig', array(
            'status' => $status,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing status entity.
     *
     */
    public function editAction(Request $request, Status $status)
    {
        $deleteForm = $this->createDeleteForm($status);
        $editForm = $this->createForm('ProductBundle\Form\StatusType', $status);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('status_edit', array('id' => $status->getId()));
        }

        return $this->render('status/edit.html.twig', array(
            'status' => $status,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a status entity.
     *
     */
    public function deleteAction(Request $request, Status $status)
    {
        $form = $this->createDeleteForm($status);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($status);
            $em->flush($status);
        }

        return $this->redirectToRoute('status_index');
    }

    /**
     * Creates a form to delete a status entity.
     *
     * @param Status $status The status entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Status $status)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('status_delete', array('id' => $status->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
