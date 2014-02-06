<?php

namespace gse\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kitpages\DataGridBundle\Model\GridConfig;
use Kitpages\DataGridBundle\Model\Field;

class PostGSEController extends Controller
{	
	/**
	 * @Method("GET")
     * @Template()
     */
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
		$mi_query = $em->getRepository('gseBlogBundle:PostTag')->findAll();
	    // Añadimos el paginador (En este caso el parámetro "1" es la página actual, y parámetro "10" es el número de páginas a mostrar)
		$paginator  = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$mi_query,
	    	$this->get('request')->query->get('page', 1),5
	    	);

		// Añadimos el parámetro a la plantilla
		return $this->render('gseBlogBundle:PostGSE:postgse.html.twig', array('pagination' => $pagination,'form'=>$form->createView()));
	}

	/**
    * Creates a form to create a Post entity.
    *
    * @param Post $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    **/
    private function createForm(Post $entity)
    {
        $form = $this->createForm(new PostType(), $entity, array(
            'action' => $this->generateUrl('post_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

	/**
    * Creates a form to create a Post entity.
    *
    * @param Post $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    **/

    public function newAction()
    {
        $entity = new PostExType();
        $form   = $this->createCreateForm($entity);

        return array('form'=>form);
    }


	public function listarAction()
	{
		 // create query builder
        $em = $this->get('doctrine')->getEntityManager();
        $queryBuilder = $em->createQuery( 'select
                                            p
                                        from 
                                            gseBlogBundle:Post as p 
                                         where 1');
            
        #var_dump($queryBuilder);
        $gridConfig = new GridConfig();
        $gridConfig          ->setCountFieldName("id")
            ->addField(new Field('titulo', array('label' => 'title', 'filterable' => true)))
            ->addField(new Field('cuerpo', array('filterable' => true)));
            //->addField(new Field('tag_id.nombre', array('filterable' => true)));
            //->addField(new Field('employee.lastname', array('filterable' => true)))
            //->addField(new Field('employee.email', array('filterable' => true)))
        //;
         echo("aca no paso nada");
        $gridManager = $this->get('kitpages_data_grid.manager');
        $grid = $gridManager->getGrid($queryBuilder, $gridConfig, $this->getRequest());

        return $this->render('KitappMissionBundle:Admin:list.html.twig', array(
            'grid' => $grid
        ));
	}
}
?> 