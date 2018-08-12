<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CustomConstraintsValidator extends ConstraintValidator
{
    const MIN_COST = 5;
    const MIN_STOCK = 10;

    /**
     * @param mixed $protocol
     * @param Constraint $constraint
     */
    public function validate($protocol, Constraint $constraint)
    {
        if (($protocol->getCostInUSA() < self::MIN_COST) && ($protocol->getStock() < self::MIN_STOCK)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}