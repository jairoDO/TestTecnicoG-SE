<?php

namespace  gse\BlogBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use gse\BlogBundle\Entity\Post;

class LoadPostData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $array_img_ur = array();
        $array_img_ur = 'http://aberturas.com.ar/images/prod_aluminio/miniaturas/mini_aluminios_1.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_aluminio/aluminios_2.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_aluminio/aluminios_3.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_aluminio/aluminios_4.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_aluminio/aluminios_5.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_aluminio/aluminios_6.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_aluminio/aluminios_7.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_aluminio/aluminios_8.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_aluminio/miniaturas/mini_aluminios_9.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_aluminio/aluminios_10.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_aluminio/aluminios_11.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_aluminio/aluminios_12.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_aluminio/aluminios_13.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_aluminio/aluminios_14.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_aluminio/aluminios_15.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_aluminio/aluminios_16.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_chapa/miniaturas/mini_chapa_1.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_chapa/miniaturas/mini_chapa_2.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_chapa/miniaturas/mini_chapa_3.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_chapa/chapa_4.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_chapa/chapa_5.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_chapa/miniaturas/mini_chapa_6.jpg';
        $array_img_url[]
        = 'http://aberturas.com.ar/images/prod_chapa/chapa_7.jpg';
        $array_img_url[] = 'http://aberturas.com.ar/images/prod_chapa/chapa_8.jpg';

        for ($i=0; $i< 20; $i++) {
            $post = new Post();
            $post->setTitulo("Titulo de prueba $i");
            $post->setCuerpo("El cuerpo de un post de prueba, para poder experimentar");
            $post->setUrlImg($array_img_url[$i]);
            $manager->persist($post);


        }
        $manager->flush();

    }

    public function getOrder()
    {
        return 2; // el orden en el cual serán cargados los accesorios
    }
}

?>