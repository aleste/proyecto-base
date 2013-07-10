<?php

namespace Aleste\DemoBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ContainsCuitValidoValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$this->verificarCuit($value)) {
            $this->context->addViolation($constraint->message, array('%string%' => $value));
        }
    }

    public static function verificarCuit($cuit)
    {
		$esCuit        =false;
		$cuit_rearmado ="";
	     	//separo cualquier caracter que no tenga que ver con numeros
	    for ($i=0; $i < strlen($cuit); $i++) {   
	        if ((ord(substr($cuit, $i, 1)) >= 48) && (ord(substr($cuit, $i, 1)) <= 57))     {
	           $cuit_rearmado = $cuit_rearmado . substr($cuit, $i, 1);
	        }
	    }
	    $cuit=$cuit_rearmado;
	    if (strlen($cuit_rearmado) <> 11) {  // si to estan todos los digitos
	        $esCuit=false;
	    }else{
	        $x=$i=$dv=0;
	   // Multiplico los dígitos.
	   $vec[0] = (substr($cuit, 0, 1)) * 5;
	   $vec[1] = (substr($cuit, 1, 1)) * 4;
	   $vec[2] = (substr($cuit, 2, 1)) * 3;
	   $vec[3] = (substr($cuit, 3, 1)) * 2;
	   $vec[4] = (substr($cuit, 4, 1)) * 7;
	   $vec[5] = (substr($cuit, 5, 1)) * 6;
	   $vec[6] = (substr($cuit, 6, 1)) * 5;
	   $vec[7] = (substr($cuit, 7, 1)) * 4;
	   $vec[8] = (substr($cuit, 8, 1)) * 3;
	   $vec[9] = (substr($cuit, 9, 1)) * 2;
	               
	   // Suma cada uno de los resultado.
	   for( $i = 0;$i<=9; $i++) {
	       $x += $vec[$i];
	   }
	   $dv = (11 - ($x % 11)) % 11;
	   if ($dv == (substr($cuit, 10, 1)) ) { 
	       $esCuit=true;
	   } 
	    }

	    return $esCuit;
	    }
}

