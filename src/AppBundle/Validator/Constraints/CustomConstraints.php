<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CustomConstraints extends Constraint
{
    public $message = "Custom Error!";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}