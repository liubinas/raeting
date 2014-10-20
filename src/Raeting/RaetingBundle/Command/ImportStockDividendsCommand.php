<?php
namespace Raeting\RaetingBundle\Command;

use Raeting\RaetingBundle\Service\Dividend;
use Raeting\RaetingBundle\Service\Symbol;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportStockDividendsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('raeting:import:stock:dividends')
            ->setDescription('Imports historical stock dividends');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Dividend */
        $dividendService = $this->getContainer()->get('raetingraeting.service.dividend');
        /** @var Symbol */
        $symbolService = $this->getContainer()->get('raetingraeting.service.symbol');

        $symbols = $symbolService->getSymbolsForStockImport();
        if (!$symbols) {
            $output->writeln('<error>No symbols to import</error>');
            return;
        }

        $output->writeln('<info>Importing dividends...</info>');

        $url = 'http://real-chart.finance.yahoo.com/table.csv?s=%s&a=00&b=1&c=2003&d=00&e=1&f=2020&g=v&ignore=.csv';

        $totalInsertsDone = 0;
        $filesInserted = 0;

        foreach ($symbols as $symbol) {
            $csv = file_get_contents(sprintf($url, $symbol->getSymbol()));
            $rows = explode("\n", $csv);

            if (empty($rows)) {
                continue;
            }

            $insertsFromFile = 0;
            $updatesFromFile = 0;

            $data = array();
            foreach ($rows as $rowNum => $row) {
                // skip the first row
                if (0 == $rowNum) {
                    continue;
                }
                $row = explode(",", $row);
                if (!empty($row[0])) {
                    $data[] = array(
                        'ticker_id' => $symbol->getId(),
                        'date' => $row[0],
                        'amount' => $row[1]
                    );
                }
            }

            if ($data) {
                $totalInsertsDone += $dividendService->import($data);
            }

            $totalInsertsDone += $insertsFromFile;
            if ($insertsFromFile > 0) {
                $filesInserted++;
            }
        }

        $output->writeln('<info>Files inserted: '.$filesInserted.'</info>');
        $output->writeln('<info>Inserts done: '.$totalInsertsDone.'</info>');
    }
}