<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class ProductTest extends TestCase
{
    private $prod;

    protected function setUp()
    {
        $this->prod = new Product();
    }

    protected function tearDown()
    {
        $this->prod = null;
    }

    /**
     * @dataProvider setProvider
     */
    public function testSetDiscontinued($value, $expected)
    {
        $this->prod->setDiscontinued($value);
        $this->assertAttributeInternalType($expected, "discontinued", $this->prod);
    }

    /**
     * @dataProvider getProvider
     */
    public function testGetDiscontinued($value, $expected)
    {
        $this->prod->setDiscontinued($value);
        $this->assertEquals($expected, $this->prod->getDiscontinued());
    }

    public function testCreateFromArray()
    {
        $arr = [
            "productName" => "TestName",
            "productCode" => "TestCode",
            "productDescription" => "TestDesc",
            "Discontinued" => "",
            "CostInUSA" => "12",
            "Stock" => "231",
        ];

        $this->prod->createFromArray($arr);

        $this->assertAttributeEquals("TestName", "productName", $this->prod);
        $this->assertAttributeEquals("TestCode", "productCode", $this->prod);
        $this->assertAttributeEquals("TestDesc", "productDescription", $this->prod);
        $this->assertAttributeEquals(null, "discontinued", $this->prod);
        $this->assertAttributeEquals("12.00", "costInUSA", $this->prod);
        $this->assertAttributeEquals("231", "stock", $this->prod);

        $this->assertAttributeInternalType("int", "stock", $this->prod);
        $this->assertAttributeInternalType("float", "costInUSA", $this->prod);
    }

    public function setProvider()
    {
        return [
            ["yes", "object"],
            ["test", "null"],
            [null, "null"],
            ["", "null"],
        ];
    }

    public function getProvider()
    {
        return [
            ["yes", date(Product::DATE_FORMAT)],
            ["test", null],
            ["", null],
            [null, null],
        ];
    }
}