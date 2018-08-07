<?php

namespace AppBundle\Parser;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;


class CSVParser
{
    const NOT_FOUND = "File not found!";

    public function parse($path):array
    {
        if (!file_exists($path)){
            throw new \Exception(self::NOT_FOUND);
        }

        $content = file_get_contents($path);
        var_dump($content);
        $serializer = new Serializer([new ObjectNormalizer(), new ArrayDenormalizer()], [new CsvEncoder()]);
        $result = $serializer->deserialize($content, "AppBundle\Entity\Product[]", 'csv');

        return $result;
    }
}