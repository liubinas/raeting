<?php
namespace Raeting\RaetingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class YahooImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('raeting:importrates:yahoo')
            ->setDescription('Imports currency rates from yahoo.com')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $output->writeln('<info>Importing rates...</info>');

        $rateService = $container->get('raetingraeting.service.rate');
        $symbolService = $container->get('raetingraeting.service.symbol');
        
        $symbols = $symbolService->getSymbolsForStockImport();
        $symbolIds = array();
        if(!empty($symbols)){
            foreach($symbols as $symbol){
                $symbolIds[] = $symbol->getSymbol();
            }
        }
        $chunkedSymbols = array_chunk($symbols, 150);
        $result = 0;
        if(!empty($chunkedSymbols)){
            foreach($chunkedSymbols as $symbols){
                $result += $rateService->importCsvFromYahoo('http://finance.yahoo.com/d/quotes.csv?s='.implode('+', $symbolIds).'&f=sl1&e=.csv');
            }
        }

        $output->writeln('<info>Inserts done: '.$result.'</info>');
    }
}