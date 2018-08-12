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
    )
    {
        $this->validator = $validator;
        $this->em = $em;
    }

    public function import(\SplFileObject $file, bool $test)
    {
        $this->test = $test;
        $this->reader = new CsvReader($file);
        $this->reader->setHeaderRowNumber(0);
        $this->reader->setStrict(false);
        $this->reader->setColumnHeaders(self::HEADERS);

        $this->createObjects();
        $this->validateObjects();

        if (!$this->test) {
            $this->saveObjects();
        }
    }

    private function createObjects()
    {
        foreach ($this->reader as $row) {
            $prod = new Product();
            $prod->createFromArray($row);
            $this->objects[] = $prod;
        }
    }

    private function validateObjects()
    {
        foreach ($this->objects as $prod) {
            $errors = $this->validator->validate($prod);

            if (count($errors) === 0) {
                $this->successItems[] = $prod;
            } else {
                $this->failsItems[] = $prod;
            }
        }
    }

    private function saveObjects()
    {
        foreach ($this->successItems as $prod) {
            $errors = $this->validator->validate($prod);

            if (count($errors) === 0) {
                $this->em->persist($prod);
                $this->em->flush();
            }
        }

    }

    /**
     * @return int
     */
    public function getTotalSuccess()
    {
        return count($this->successItems);
    }

    /**
     * @return int
     */
    public function getTotalFails()
    {
        return count($this->failsItems);
    }

    /**
     * @return int
     */
    public function getTotalItems()
    {
        return count($this->objects);
    }

    /**
     * @return array
     */
    public function getFailsItems()
    {
        return $this->failsItems;
    }
}