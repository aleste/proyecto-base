<?php

namespace Aleste\DemoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lexik\Bundle\FormFilterBundle\Filter\ORM\Expr;
use Doctrine\ORM\QueryBuilder;


class PostFilterType extends AbstractType
{    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'filter_text', array(
            'apply_filter' => function (QueryBuilder $filterBuilder, Expr $expr, $field, array $values) {

            if ('' !== $values['value'] && null !== $values['value']) {
                $pattern = empty($values['condition_pattern']) ? FilterOperands::STRING_EQUALS : $values['condition_pattern'];
                $filterBuilder->andWhere($expr->stringBoth($field, $values['value'], $pattern));
            }

            }));        

        $builder->add('description', 'filter_text', array(
            'apply_filter' => function (QueryBuilder $filterBuilder, Expr $expr, $field, array $values) {

            if ('' !== $values['value'] && null !== $values['value']) {
                $pattern = empty($values['condition_pattern']) ? FilterOperands::STRING_EQUALS : $values['condition_pattern'];
                $filterBuilder->andWhere($expr->stringBoth($field, $values['value'], $pattern));
            }

            }));                
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