<?php

namespace gse\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gse\BlogBundle\Form\PostType;
use gse\BlogBundle\Form\PosExtType;
use gse\BlogBundle\Form\TagType;

class PostExtType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $post = new PostType();
        $builder
            ->add(
                'tags', 'collection', array(
                    // each item in the array will be an "email" field
                    'type'   => new TagType(),
                    // these options are passed to each "email" type
                    'options'  => array(
                        'required'  => false,
                        'attr'      => array('class' => 'tag')
                       )
                )
            );
            //->add($builder->create($post));
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
