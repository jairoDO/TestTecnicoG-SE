<?php

namespace  gse\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager; 
use gse\BlogBundle\Entity\Post;
use gse\BlogBundle\Entity\Tag;
use gse\BlogBundle\Entity\PostTag;

class LoadPostTagData extends  AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        
        for ($i=0; $i< 20; $i++) {
            for($j=0; $j < rand(1,8); $j++){
                $post_tag = new PostTag();
                $post_tag->setTag($this->getReference("tag$j"));
                $post_tag->setPost($this->getReference("post$i"));
                $manager->persist($post_tag);
            }
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3; // el orden en el cual serán cargados los accesorios
    }
}

?>