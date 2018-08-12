<?php

namespace AppBundle\Command;

use AppBundle\ImportCSV\ImportCSV;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CSVImportCommand extends Command
{
    const SUCCESS = "Success: %d";
    const FAILS = "Fails: %d";
    const TOTAL = "Total: %d";

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
        $test = (bool) $input->getOption("test");
        $path = $input->getArgument("file");
        $file = new \SplFileObject($path);

        $this->csv->import($file, $test);

        $success = $this->csv->getTotalSuccess();
        $fails = $this->csv->getTotalFails();
        $total = $this->csv->getTotalItems();

        $output->writeln(sprintf(self::SUCCESS, $success));
        $output->writeln(sprintf(self::FAILS, $fails));
        $output->writeln(sprintf(self::TOTAL, $total));
    }
}