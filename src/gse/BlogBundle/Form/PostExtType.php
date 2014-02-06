<?php

namespace gse\BlogBundle\Form;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gse\BlogBundle\Entity\Post;


class PostExtType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $post = new Post();
        $builder
            ->add($post)
            ->add('tags', 'collection', array(
                    // each item in the array will be an "email" field
                    'type'   => new Type\TagType(),
                    // these options are passed to each "email" type
                    'options'  => array(
                        'required'  => false,
                        'attr'      => array('class' => 'email-box')
                    ),
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'gse\BlogBundle\Entity\Post'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gse_blogbundle_postext';
    }
}
