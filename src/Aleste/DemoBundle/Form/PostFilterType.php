<?php

namespace Aleste\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Doctrine\ORM\QueryBuilder;


class PostFilterType extends AbstractType
{    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder->add('id', 'filter_number');

        $builder->add('title', 'filter_text', array('condition_pattern' => FilterOperands::OPERAND_SELECTOR) );        

        $builder->add('description', 'filter_text', array('condition_pattern' => FilterOperands::STRING_EQUALS));                
    }

    public function getName()
    {
        return 'criteria';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}