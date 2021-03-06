<?php

namespace AppBundle\ImportCSV;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Port\Csv\CsvReader;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImportCSV
{
    const HEADERS = [
        "productCode",
        "productName",
        "productDescription",
        "stock",
        "costInUSA",
        "discontinued",
    ];

    private $em;
    private $validator;
    private $reader;
    private $test;
    private $objects = [];
    private $successItems = [];
    private $failsItems = [];

    public function __construct(
        ValidatorInterface $validator,
        EntityManagerInterface $em
    ) {
        $this->validator = $validator;
        $this->em = $em;
    }

    /**
     * @param \SplFileObject $file
     * @param bool $test
     */
    public function import(\SplFileObject $file, bool $test):void
    {
        $this->test = $test;
        $this->reader = new CsvReader($file);
        $this->reader->setHeaderRowNumber(0);
        $this->reader->setStrict(false);
        $this->reader->setColumnHeaders(self::HEADERS);
        $this->createObjects();

        foreach ($this->objects as $prod) {
            if ($this->isValid($prod) && !$this->test) {
                $this->saveObject($prod);
            }
        }
    }

    private function createObjects():void
    {
        foreach ($this->reader as $row) {
            $prod = new Product();
            $prod->createFromArray($row);
            $this->objects[] = $prod;
        }
    }

    /**
     * @param Product $prod
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    private function validateObject(Product $prod)
    {
        $errors = $this->validator->validate($prod);

        if (count($errors) === 0) {
            $this->successItems[] = $prod;
        } else {
            $this->failsItems[] = $prod;
        }

        return $errors;
    }

    /**
     * @param Product $prod
     * @return bool
     */
    private function isValid(Product $prod):bool
    {
        $errors = $this->validateObject($prod);

        return count($errors) === 0;
    }

    /**
     * @param Product $prod
     */
    private function saveObject(Product $prod):void
    {
        $this->em->persist($prod);
        $this->em->flush();
    }

    /**
     * @return int
     */
    public function getTotalSuccess():int
    {
        return count($this->successItems);
    }

    /**
     * @return int
     */
    public function getTotalFails():int
    {
        return count($this->failsItems);
    }

    /**
     * @return int
     */
    public function getTotalItems():int
    {
        return count($this->objects);
    }

    /**
     * @return array
     */
    public function getFailsItems():array
    {
        return $this->failsItems;
    }
}