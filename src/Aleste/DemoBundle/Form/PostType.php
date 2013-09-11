<?php

namespace Aleste\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Aleste\DemoBundle\Form\TagType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('tags', 'collection', array('type' => new TagType(), 'allow_add' => true, 'by_reference' => false, 'allow_delete' => true))
            //->add('tags', 'entity', array('class' => 'AlesteDemoBundle:Tag'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Aleste\DemoBundle\Entity\Post'
        ));
    }

    public function getName()
    {
        return 'aleste_demobundle_posttype';
    }
}
