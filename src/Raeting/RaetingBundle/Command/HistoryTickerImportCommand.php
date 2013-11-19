<?php
namespace Raeting\RaetingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class HistoryTickerImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('raeting:importhistory:ticker')
            ->setDescription('Imports history data of tickers')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $output->writeln('<info>Importing rates...</info>');

        $rateService = $container->get('raetingraeting.service.rate');
        $symbolService = $container->get('raetingraeting.service.symbol');
        
        $symbols = $symbolService->getSymbolsForStockImport();
        
        $totalInsertsDone = 0;
        $totalUpdatesDone = 0;
        $filesInserted = 0;
        
        if(!empty($symbols)){
            foreach($symbols as $symbol){
                $url = "http://ichart.yahoo.com/table.csv?s=".$symbol->getSymbol()."&a=0&b=1&c=2003%20&d=8&e=30&f=2099&g=d&ignore=.csv";
                $csv = file_get_contents($url);
                $insertsFromFile = 0;
                $updatesFromFile = 0;
                
                $query = '';
                
                $rows = explode("\n", $csv);
                $key = 0;
                if(!empty($rows)){
                    foreach($rows as $row){
                        $row = explode(",", $row);
                        if(!empty($row[0])){
                            if($key > 0 && $row[0] >= '2003-01-01'){
                                $data = array('symbol'=>$symbol->getSymbol());
                                $rate = ($row[1]+$row[2]+$row[3]+$row[4])/4;
                                $data['bid'] = $rate;
                                $data['ask'] = $rate;
                                $data['high'] = $row[2];
                                $data['low'] = $row[3];
                                $data['date'] = $row[0];
                                $query .= $rateService->getInsertDataQuery($data);
                                if($query != null && strpos($query, 'INSERT INTO') !== false){
                                    $insertsFromFile++;
                                }elseif($query != null && strpos($query, 'UPDATE') !== false){
                                    $updatesFromFile++;
                                }
                            }
                        }
                        $key++;
                    }
                }
                if(!empty($query)){
                    $rateService->executeQuery($query);
                }
                $totalInsertsDone += $insertsFromFile;
                $totalUpdatesDone += $updatesFromFile;
                if($insertsFromFile > 0 || $updatesFromFile > 0){
                    $filesInserted++;
                }
            }
        }
        

        $output->writeln('<info>Files inserted: '.$filesInserted.'</info>');
        $output->writeln('<info>Inserts done: '.$totalInsertsDone.'</info>');
        $output->writeln('<info>Updates done: '.$totalUpdatesDone.'</info>');
    }
}