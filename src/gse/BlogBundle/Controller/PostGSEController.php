<?php

namespace gse\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Kitpages\DataGridBundle\Model\GridConfig;
use Kitpages\DataGridBundle\Model\Field;
use Symfony\Component\HttpFoundation\Request;
use gse\BlogBundle\Form\PostExtType;
use gse\BlogBundle\Form\PostType;
use gse\BlogBundle\Entity\Post;
use gse\BlogBundle\Entity\Tag;

class PostGSEController extends Controller
{	

	public function indexAction()
	{

		 $data = array();
         $form = $this->createFormBuilder()
             ->setAction($this->generateUrl('gse'))
             ->add('tag', 'entity', array(
                 'class' => 'gseBlogBundle:Tag',
                 'property' => 'nombre',
                 'multiple' => true,
                 'label' => 'tags'
             ))
             ->add('titulo', 'search', array('required' => false, 'label' =>'titulo'))
             ->add('cuerpo', 'search', array('required' => false, 'label' =>'cuerpo'))
             ->add('Filtrar', 'submit')
             ->getForm();

         $form->handleRequest($this->getRequest());

         if ($form->isValid()) {
             // data is an array with "cat" keys
             $data = $form->getData();
         }
		$em = $this->getDoctrine()->getManager();
		$posts = $em->getRepository('gseBlogBundle:Post')->findWithFilter($data);
	    // Añadimos el paginador (En este caso el parámetro "1" es la página actual, y parámetro "5" es el número de páginas a mostrar)
		$paginator  = $this->get('knp_paginator');
		$pagination = $paginator->paginate(
			$posts,
	    	$this->get('request')->query->get('page', 1),5
	    	);

		// Añadimos el parámetro a la plantilla
		return $this->render('gseBlogBundle:PostGSE:postgse.html.twig', array('pagination' => $pagination,'form'=>$form->createView()));
	}

    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('gseBlogBundle:Post')->find($id);



        return $this->render('gseBlogBundle:PostGSE:show.html.twig', array('post'=>$post));
    }


}
?> 