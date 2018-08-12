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

    const METHOD_NAME = "set%s";
    const DATE_FORMAT = "d-m-Y";
    const CODE = "Product Code: %s";
    const NAME = "Product Name: %s";
    const STOCK = "Stock: %d";
    const COST = "Cost: %g";
    const DISC =  "Discontinued: %s";
    const PRODUCT = "\n %s \n %s \n %s \n %s \n %s";


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
     * @return null|string
     */
    public function getDiscontinued():?string
    {
        return $this->discontinued ? $this->discontinued->format(self::DATE_FORMAT) : null;
    }

    /**
     * @return \DateTime|null
     */
    public function getAdded():?\DateTime
    {
        return $this->added;
    }

    /**
     * @return \DateTime|null
     */
    public function getTimestamp():?\DateTime
    {
        return $this->timestamp;
    }

    // SETTERS

    /**
     * @param string $productCode
     */
    public function setProductCode(string $productCode):void
    {
        $this->productCode = $productCode;
    }

    /**
     * @param string $productName
     */
    public function setProductName(string $productName):void
    {
        $this->productName = $productName;
    }

    /**
     * @param string $productDescription
     */
    public function setProductDescription(string $productDescription):void
    {
        $this->productDescription = $productDescription;
    }

    /**
     * @param $costInUSA
     */
    public function setCostInUSA($costInUSA):void
    {
        $this->costInUSA = (float) $costInUSA;
    }

    /**
     * @param $stock
     */
    public function setStock($stock):void
    {
        $this->stock = (int) $stock;
    }

    /**
     * @param string|null $discontinued
     */
    public function setDiscontinued(string $discontinued = null):void
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
            $methodName = sprintf(self::METHOD_NAME, ucfirst($key));
            $this->$methodName($value);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString():string
    {
        $code = sprintf(self::CODE, $this->getProductCode());
        $name = sprintf(self::NAME, $this->getProductName());
        $stock = sprintf(self::STOCK, $this->getStock());
        $costInUSA = sprintf(self::COST, $this->getCostInUSA());
        $disc = sprintf(self::DISC, $this->getDiscontinued());

        return sprintf(self::PRODUCT, $code,$name, $stock, $costInUSA, $disc);
    }
}