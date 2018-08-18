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
    const ITEM = "---FAIL ITEM--- %s \n";

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

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $test = (bool) $input->getOption("test");
        $path = $input->getArgument("file");

        try {
            $file = new \SplFileObject($path);
        } catch (\RuntimeException $e) {
            $output->writeln($e->getMessage());
            exit;
        }

        $this->csv->import($file, $test);

        $success = $this->csv->getTotalSuccess();
        $fails = $this->csv->getTotalFails();
        $total = $this->csv->getTotalItems();
        $failsItems = $this->csv->getFailsItems();

        $output->writeln(sprintf(self::TOTAL, $total));
        $output->writeln(sprintf(self::SUCCESS, $success));
        $output->writeln(sprintf(self::FAILS, $fails));

        foreach ($failsItems as $item) {
            $output->writeln(sprintf(self::ITEM, $item));
        }
    }
}