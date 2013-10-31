<?php
namespace Raeting\RaetingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class HistoryCurrencyImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('raeting:importhistory:currency')
            ->setDescription('Imports history data of currency')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $output->writeln('<info>Importing rates...</info>');

        $rateService = $container->get('raetingraeting.service.rate');
        $symbolService = $container->get('raetingraeting.service.symbol');
        
        $symbols = $symbolService->getSymbolsForCurrencyImport();
        $symbolIds = array();
        if(!empty($symbols)){
            foreach($symbols as $symbol){
                $symbolIds[] = $symbol->getSymbol();
            }
        }
        
        
        $files = $container->get('raetingraeting.service.file_management')->scanDir($container->get('kernel')->getRootDir().'/../uploads/history_currency_rates');
        
        $totalInsertsDone = 0;
        $totalUpdatesDone = 0;
        $filesInserted = 0;
        
        if(!empty($files)){
            foreach($files as $file){
                try {
                    $insertsFromFile = 0;
                    $updatesFromFile = 0;
                    $fileString = file_get_contents($file);
                    $fileData = explode("\n", $fileString);
                    if(isset($fileData[0])){
                        unset($fileData[0]);
                    }
                    $fullFileName = basename($file);
                    $fileName = substr($fullFileName, 0, strpos($fullFileName, '.'));
                    
                    $query = '';
                    $inserts = 0;
                    if(!empty($fileData)){
                        foreach($fileData as $key => $row){
                            $row = explode(',', $row);
                            if(in_array($row[0], $symbolIds)){
                                $data = array('symbol'=>$row[0]);
                                $data['bid'] = $row[4];
                                $data['ask'] = $row[5];
                                $data['high'] = $row[4];
                                $data['low'] = $row[5];
                                $data['date'] = substr($row[1], 0, 4).'-'.substr($row[1], 4, 2).'-'.substr($row[1], 6, 2).' '.substr($row[2], 0, 2).':'.substr($row[2], 2, 2);
                                $query .= $rateService->getInsertDataQuery($data);
                                if($query != null && strpos($query, 'INSERT INTO') !== false){
                                    $insertsFromFile++;
                                }elseif($query != null && strpos($query, 'UPDATE') !== false){
                                    $updatesFromFile++;
                                }
                                if($inserts > 0 && $inserts % 100 == 0){
                                    $rateService->executeQuery($query);
                                    $query = '';
                                }
                                $inserts++;
                            }
                        }
                    }
                    if(!empty($query)){
                        $rateService->executeQuery($query);
                    }
                    $totalInsertsDone += $insertsFromFile;
                    $totalUpdatesDone += $updatesFromFile;
                    if($insertsFromFile > 0 || $updatesFromFile > 0){
                        $container->get('raetingraeting.service.file_management')->moveFile($file, $container->get('kernel')->getRootDir().'/../uploads/imported_history_currency_rates/'.$fullFileName);
                        $filesInserted++;
                    }
                } catch(Exception $e) {
                    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
                }
            }
        }
        

        $output->writeln('<info>Files inserted: '.$filesInserted.'</info>');
        $output->writeln('<info>Inserts done: '.$totalInsertsDone.'</info>');
        $output->writeln('<info>Updates done: '.$totalUpdatesDone.'</info>');
    }
}