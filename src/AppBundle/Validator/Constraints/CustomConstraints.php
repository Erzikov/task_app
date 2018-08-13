<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CustomConstraints extends Constraint
{
    public $message = "The cost is not less than 5 and the quantity is not less than 10!";

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}