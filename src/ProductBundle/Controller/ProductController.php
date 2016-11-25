<?php

namespace ProductBundle\Controller;

use ProductBundle\Entity\Product;
use ProductBundle\Entity\ProductNote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 */
class ProductController extends Controller
{
    /**
     * Lists all product entities.
     *
     */
    public function indexAction()
    {
        //$res = $this->get('elastica_search_service')->test1();

        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('ProductBundle:Product')->findAll();

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new product entity.
     *
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('ProductBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a product entity.
     *
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $noteForm = $this->createNoteForm($product);

        return $this->render('product/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
            'note_form' => $noteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     */
    public function editAction(Request $request, Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('ProductBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
        }

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Add note to product.
     */
    public function noteAction(Request $request, Product $product)
    {
        $noteForm = $this->createNoteForm($product);
        $noteForm->handleRequest($request);
        if ($noteForm->isSubmitted() && $noteForm->isValid()) {
            $note = $noteForm->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();
        }
        $objectSerializer = $this->get('fos_elastica.object_persister.workshop.shop');
        $objectSerializer->replaceOne($product);

        return $this->redirectToRoute('product_show', array('id' => $product->getId()));
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a form to add a product note.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createNoteForm(Product $product)
    {
        $productNote = new ProductNote();
        $productNote->addProduct($product);
        $noteForm = $this->createForm('ProductBundle\Form\NoteType', $productNote, [
            'action' => $this->generateUrl('product_note', array('id' => $product->getId())),
            'method' => 'POST',
        ]);

        return $noteForm;
    }
}
