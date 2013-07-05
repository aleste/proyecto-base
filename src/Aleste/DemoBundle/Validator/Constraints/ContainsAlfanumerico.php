<?php
namespace Aleste\DemoBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsAlfanumerico extends Constraint
{
    public $message = 'El texto "%string%" contiene caracteres no validos: Solo puede contener letras o numeros';
}