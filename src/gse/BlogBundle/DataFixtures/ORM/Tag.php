<?php
namespace  gse\BlogBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use gse\BlogBundle\Entity\Tag;

class LoadTagData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i<51; $i++) {
            $tag = new Tag();
            $tag->setNombre('tag '.$i);
            $manager->persist($tag);
        }
        $manager->flush();

    }
    
    public function getOrder()
    {
        return 1; // el orden en el cual serán cargados los accesorios
    }
}
?>  