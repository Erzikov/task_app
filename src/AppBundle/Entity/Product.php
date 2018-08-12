<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Validator\Constraints as CustomAssert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="tblProductData")
 * @UniqueEntity("productCode")
 * @CustomAssert\CustomConstraints()
 */
class Product
{
    /**
     * @ORM\Column(name="intProductDataId", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @ORM\Column(name="strProductCode", unique=true)
     */
    private $productCode;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @ORM\Column(name="strProductName")
     */
    private $productName;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @ORM\Column(name="strProductDesc")
     */
    private $productDescription;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     * @ORM\Column(name="stock", type="integer")
     */
    private $stock;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("float")
     * @Assert\LessThan(1000)
     * @ORM\Column(name="cost", type="float")
     */
    private $costInUSA;

    /**
     * @Assert\DateTime()
     * @ORM\Column(name="dtmDiscontinued", type="date", nullable=true)
     */
    private $discontinued;

    /**
     * @ORM\Column(name="dtmAdded", type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     * @ORM\Version()
     */

    private $added;


    /**
     * @ORM\Column(name="stmTimestamp", type="datetime", columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     * @ORM\Version()
     */
    private $timestamp;

    // GETTERS

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getProductCode():string
    {
        return $this->productCode;
    }

    /**
     * @return string
     */
    public function getProductName():string
    {
        return $this->productName;
    }

    /**
     * @return string
     */
    public function getProductDescription():string
    {
        return $this->productDescription;
    }

    /**
     * @return float
     */
    public function getCostInUSA():float
    {
        return $this->costInUSA;
    }

    /**
     * @return int
     */
    public function getStock():int
    {
        return $this->stock;
    }

    /**
     * @return \DateTime
     */
    public function getDiscontinued():\DateTime
    {
        return $this->discontinued;
    }

    /**
     * @return \DateTime
     */
    public function getAdded():\DateTime
    {
        return $this->added;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp():\DateTime
    {
        return $this->timestamp;
    }

    // SETTERS

    /**
     * @param string $productCode
     */
    public function setProductCode(string $productCode)
    {
        $this->productCode = $productCode;
    }

    /**
     * @param string $productName
     */
    public function setProductName(string $productName)
    {
        $this->productName = $productName;
    }

    /**
     * @param string $productDescription
     */
    public function setProductDescription(string $productDescription)
    {
        $this->productDescription = $productDescription;
    }

    /**
     * @param float $costInUSA
     */
    public function setCostInUSA($costInUSA)
    {
        $this->costInUSA = (float) $costInUSA;
    }

    /**
     * @param int $stock
     */
    public function setStock($stock)
    {
        $this->stock = (int) $stock;
    }

    /**
     * @param string $discontinued
     */
    public function setDiscontinued($discontinued)
    {
        $this->discontinued = $discontinued === "yes" ? new \DateTime() : null;
    }

    /**
     * @param array $data
     * @return Product
     */
    public function createFromArray(array $data):Product
    {
        foreach ($data as $key => $value) {
            $methodName = "set".ucfirst($key);
            $this->$methodName($value);
        }

        return $this;
    }

}