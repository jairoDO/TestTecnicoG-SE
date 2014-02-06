<?php

namespace gse\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use gse\BlogBundle\Entity\PostTag;
use gse\BlogBundle\Form\PostTagType;

/**
 * PostTag controller.
 *
 * @Route("/posttag")
 */
class PostTagController extends Controller
{

    /**
     * Lists all PostTag entities.
     *
     * @Route("/", name="posttag")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('gseBlogBundle:PostTag')->findAll();
        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new PostTag entity.
     *
     * @Route("/", name="posttag_create")
     * @Method("POST")
     * @Template("gseBlogBundle:PostTag:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PostTag();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('posttag_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a PostTag entity.
    *
    * @param PostTag $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PostTag $entity)
    {
        $form = $this->createForm(new PostTagType(), $entity, array(
            'action' => $this->generateUrl('posttag_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PostTag entity.
     *
     * @Route("/new", name="posttag_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PostTag();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PostTag entity.
     *
     * @Route("/{id}", name="posttag_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('gseBlogBundle:PostTag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PostTag entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PostTag entity.
     *
     * @Route("/{id}/edit", name="posttag_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('gseBlogBundle:PostTag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PostTag entity.');
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
    * Creates a form to edit a PostTag entity.
    *
    * @param PostTag $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PostTag $entity)
    {
        $form = $this->createForm(new PostTagType(), $entity, array(
            'action' => $this->generateUrl('posttag_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PostTag entity.
     *
     * @Route("/{id}", name="posttag_update")
     * @Method("PUT")
     * @Template("gseBlogBundle:PostTag:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('gseBlogBundle:PostTag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PostTag entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('posttag_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PostTag entity.
     *
     * @Route("/{id}", name="posttag_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('gseBlogBundle:PostTag')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PostTag entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('posttag'));
    }

    /**
     * Creates a form to delete a PostTag entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('posttag_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
