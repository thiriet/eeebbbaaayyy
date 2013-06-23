<?php

namespace Raph\EbayparserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Raph\EbayparserBundle\Entity\Keyword;
use Raph\EbayparserBundle\Form\KeywordType;

/**
 * Keyword controller.
 *
 * @Route("/keyword")
 */
class KeywordController extends Controller
{
    /**
     * Lists all Keyword entities.
     *
     * @Route("/", name="keyword")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RaphEbayparserBundle:Keyword')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Keyword entity.
     *
     * @Route("/", name="keyword_create")
     * @Method("POST")
     * @Template("RaphEbayparserBundle:Keyword:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Keyword();
        $form = $this->createForm(new KeywordType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('keyword_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Keyword entity.
     *
     * @Route("/new", name="keyword_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Keyword();
        $form   = $this->createForm(new KeywordType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Keyword entity.
     *
     * @Route("/{id}", name="keyword_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RaphEbayparserBundle:Keyword')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Keyword entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Keyword entity.
     *
     * @Route("/{id}/edit", name="keyword_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RaphEbayparserBundle:Keyword')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Keyword entity.');
        }

        $editForm = $this->createForm(new KeywordType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Keyword entity.
     *
     * @Route("/{id}", name="keyword_update")
     * @Method("PUT")
     * @Template("RaphEbayparserBundle:Keyword:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RaphEbayparserBundle:Keyword')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Keyword entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new KeywordType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('keyword_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Keyword entity.
     *
     * @Route("/{id}", name="keyword_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('RaphEbayparserBundle:Keyword')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Keyword entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('keyword'));
    }

    /**
     * Creates a form to delete a Keyword entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
