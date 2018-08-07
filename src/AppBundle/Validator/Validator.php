<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface;

class Validator
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate($item)
    {
        $errors = $this->validator->validate($item);
        $cost = $item->getCostInUSA();
        $stock = $item->getStock();

        if ((($cost > 5 || $stock > 10) && $stock < 1000) && (count($errors) === 0)) {
            return true;
        } else {
            return false;
        }
    }
}