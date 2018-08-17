<?php

namespace Tests\AppBundle\ImportCSV;

use AppBundle\Entity\Product;
use AppBundle\ImportCSV\ImportCSV;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ImportCSVTest extends KernelTestCase
{
    const TEST_FILE_PATH = "tests/AppBundle/Resources/csv/test.csv";

    static $container;
    static $em;
    static $val;

    private $import;

    public static function setUpBeforeClass()
    {
        self::bootKernel();
        self::$container = self::$kernel->getContainer();
        self::$em = self::$container ->get('doctrine')->getManager();
        self::$val = self::$container ->get('validator');
    }

    public function setUp()
    {
        $this->import = new ImportCSV(self::$val, self::$em);
    }

    public function tearDown()
    {
        $this->import = null;
    }

    public function testImport()
    {
        $file = new \SplFileObject(self::TEST_FILE_PATH);
        $this->import->import($file, true);

        $this->assertAttributeCount(3, 'successItems', $this->import);
        $this->assertAttributeCount(5, 'failsItems', $this->import);
        $this->assertAttributeCount(8, 'objects', $this->import);

        $this->assertEquals(8, $this->import->getTotalItems());
        $this->assertEquals(3, $this->import->getTotalSuccess());
        $this->assertEquals(5, $this->import->getTotalFails());

        foreach ($this->import->getFailsItems() as $item) {
            $this->assertInstanceOf(Product::class, $item);
        }
    }
}