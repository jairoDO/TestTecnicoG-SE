<?php

namespace gse\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kitpages\DataGridBundle\Model\GridConfig;
use Kitpages\DataGridBundle\Model\Field;
use Symfony\Component\HttpFoundation\Request;
use gse\BlogBundle\Form\PostExtType;

class PostGSEController extends Controller
{	

	public function indexAction()
	{
		 $data = array();
         $defaultData = array();
         $form = $this->createFormBuilder($defaultData,array('attr' =>array('id' => 'fitro', 'class' => 'filtro')))
             ->setAction($this->getRequest()->getRequestUri())
             ->setMethod('GET')
             ->add('cat', 'text', array('required' => false, 'label' =>false))
             ->add('Filtrar', 'submit')
             ->getForm();

         $form->handleRequest($this->getRequest());

         if ($form->isValid()) {
             // data is an array with "cat" keys
             $data = $form->getData();
         }

		$em = $this->getDoctrine()->getManager();
		$posts = $em->getRepository('gseBlogBundle:Post')->findAll();

        foreach($posts as $post)
        {
            echo(count($post->getTags()));
        }
	    // Añadimos el paginador (En este caso el parámetro "1" es la página actual, y parámetro "10" es el número de páginas a mostrar)
		$paginator  = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$posts,
	    	$this->get('request')->query->get('page', 1),5
	    	);

		// Añadimos el parámetro a la plantilla
		return $this->render('gseBlogBundle:PostGSE:postgse.html.twig', array('pagination' => $pagination,'form'=>$form->createView()));
	}

    public function newAction()
    {

        $form   = $this->createCreateForm();

        return array(
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Tag entity.
     *
     *
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm()
    {
        $form = $this->createForm(new PostExtType(), array(
            'action' => $this->generateUrl('gse_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
    /**
     * Creates a form to create a Post entity.
     * * @Method("POST")
     */
    public function createAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                // realiza alguna acción, tal como guardar la tarea en la base de datos

                return $this->redirect($this->generateUrl('task_success'));
            }
        }

        $form = $this->createForm(new PostType(), array(
            'action' => $this->generateUrl('post_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

}
?> 