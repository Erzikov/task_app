<?php

namespace AppBundle\ImportCSV;

use AppBundle\Parser\CSVParser;
use AppBundle\Validator\Validator;


class ImportCSV
{
    protected $validator;
    protected $parser;
    protected $isTest = false;
    protected $fails = 0;
    protected $success = 0 ;
    protected $failsItems = [];

    public function __construct(
        CSVParser $parser,
        Validator $validator
    )
    {
        $this->validator = $validator;
        $this->parser = $parser;
    }

    public function import($path, $test)
    {
        $this->isTest = $test;
        $items = $this->parser->parse($path);
        foreach ($items as $item) {
            if ($this->isValid($item) && !$this->isTest) {
                $this->save($item);
            }
        }

        $result = ['success' => $this->success, 'fails' => $this->fails];
        return $result;

    }

    private function isValid($item)
    {
        $isValid = $this->validator->validate($item);
        if ($isValid) {
            $this->success++;
            return true;
        } else {
            $this->fails++;
            $this->failsItems[] = $item;
            return false;
        }
    }

    private function save($item)
    {
        //
    }

    public function getFailsItems()
    {
        return $this->failsItems;
    }
}