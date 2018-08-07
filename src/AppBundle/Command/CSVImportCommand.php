<?php

namespace AppBundle\Command;

use AppBundle\ImportCSV\ImportCSV;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CSVImportCommand extends Command
{
    private $csv;

    public function __construct(ImportCSV $csv)
    {
        $this->csv = $csv;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName("csv:import")
            ->addArgument("file", InputArgument::REQUIRED)
            ->addOption('test');

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument("file");
        $test = (bool) $input->getOption("test");
        $result = $this->csv->import($path, $test);


        $output->writeln("Success: ".$result["success"]);
        $output->writeln("Fails: ".$result["fails"]);
        $output->writeln("Total: ".($result["fails"] + $result["success"]));
    }
}