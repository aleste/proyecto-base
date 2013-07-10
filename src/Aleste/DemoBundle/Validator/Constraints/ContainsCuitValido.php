<?php
namespace Aleste\DemoBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsCuitValido extends Constraint
{
    public $message = '"%string%" No es un cuit valido';
}