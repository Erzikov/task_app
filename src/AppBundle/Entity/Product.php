<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Product
{
    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $productCode;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $productName;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     */
    private $productDescription;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     */
    private $stock;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("float")
     */
    private $costInUSA;

    /**
     * @Assert\DateTime()
     */
    private $discontinued;


    /**
     * @return mixed
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * @return mixed
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @return mixed
     */
    public function getProductDescription()
    {
        return $this->productDescription;
    }

    /**
     * @return mixed
     */
    public function getCostInUSA()
    {
        return $this->costInUSA;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @return mixed
     */
    public function getDiscontinued()
    {
        return $this->discontinued;
    }

    /**
     * @param mixed $productCode
     */
    public function setProductCode($productCode)
    {
        $this->productCode = (string) $productCode;
    }

    /**
     * @param mixed $productName
     */
    public function setProductName($productName)
    {
        $this->productName = (string) $productName;
    }

    /**
     * @param mixed $productDescription
     */
    public function setProductDescription($productDescription)
    {
        $this->productDescription = (string) $productDescription;
    }

    /**
     * @param mixed $costInUSA
     */
    public function setCostInUSA($costInUSA)
    {
        $this->costInUSA = (float) $costInUSA;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock)
    {
        $this->stock = (int) $stock;
    }

    /**
     * @param mixed $discontinued
     */
    public function setDiscontinued($discontinued)
    {
        if ($discontinued === "yes") {
            $date = new \DateTime();
            $this->discontinued = $date->format('d-m-Y');
        } else {
            $this->discontinued = null;
        }

    }
}