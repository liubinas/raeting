<?php
namespace Raeting\RaetingBundle\Command;

use Raeting\RaetingBundle\Service\Rate;
use Raeting\RaetingBundle\Service\Symbol;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportStockPriceCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('raeting:import:stock:prices')
            ->setDescription('Imports historical stock prices');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Rate */
        $rateService = $this->getContainer()->get('raetingraeting.service.rate');
        /** @var Symbol */
        $symbolService = $this->getContainer()->get('raetingraeting.service.symbol');

        $symbols = $symbolService->getSymbolsForStockImport();
        if (!$symbols) {
            $output->writeln('<error>No symbols to import</error>');
            return;
        }

        $output->writeln('<info>Importing prices...</info>');

        $url = 'http://real-chart.finance.yahoo.com/table.csv?s=%s&a=00&b=1&c=2003&d=00&e=1&f=2020&g=d&ignore=.csv';

        $totalInsertsDone = 0;
        $totalUpdatesDone = 0;
        $filesInserted = 0;

        foreach ($symbols as $symbol) {
            $csv = file_get_contents(sprintf($url, $symbol->getSymbol()));
            $rows = explode("\n", $csv);

            if (empty($rows)) {
                continue;
            }

            $insertsFromFile = 0;
            $updatesFromFile = 0;

            $query = '';

            $key = 0;
            foreach ($rows as $row) {
                $row = explode(",", $row);
                if (!empty($row[0])) {
                    if ($key > 0 && $row[0] >= '2003-01-01') {
                        $data['symbol'] = $symbol->getSymbol();
                        $data['date'] = $row[0];
                        // adjusted stock price after stock split
                        if (isset($row[6])) {
                            $rate = $row[6];
                            $data['high'] = $rate;
                            $data['low'] = $rate;
                        } else {
                            $rate = ($row[1]+$row[2]+$row[3]+$row[4])/4;
                            $data['high'] = $row[2];
                            $data['low'] = $row[3];
                        }

                        $data['bid'] = $rate;
                        $data['ask'] = $rate;


                        $query .= $rateService->getInsertDataQuery($data);
                        if ($query != null && strpos($query, 'INSERT INTO') !== false) {
                            $insertsFromFile++;
                        } elseif ($query != null && strpos($query, 'UPDATE') !== false) {
                            $updatesFromFile++;
                        }
                    }
                }
                $key++;
            }

            if (!empty($query)) {
                $rateService->executeQuery($query);
            }
            $totalInsertsDone += $insertsFromFile;
            $totalUpdatesDone += $updatesFromFile;
            if ($insertsFromFile > 0 || $updatesFromFile > 0) {
                $filesInserted++;
            }
        }

        $output->writeln('<info>Files inserted: '.$filesInserted.'</info>');
        $output->writeln('<info>Inserts done: '.$totalInsertsDone.'</info>');
        $output->writeln('<info>Updates done: '.$totalUpdatesDone.'</info>');
    }
}