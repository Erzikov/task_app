<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CustomConstraintsValidator extends ConstraintValidator
{
    public function validate($protocol, Constraint $constraint)
    {
        if (($protocol->getCostInUSA() < 5) && ($protocol->getStock() < 10)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}