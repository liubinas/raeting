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

        $tickerRateService = $container->get('raetingraeting.service.ticker_rate');
        $symbolService = $container->get('raetingraeting.service.symbol');
        
        $symbols = $symbolService->getSymbolsForStockImport();
        $symbolIds = array();
        if(!empty($symbols)){
            foreach($symbols as $symbol){
                $symbolIds[] = $symbol->getSymbol();
            }
        }
        
        $objPHPExcel = new \PHPExcel();
        
        $files = $container->get('raetingraeting.service.file_management')->scanDir($container->get('kernel')->getRootDir().'/../uploads/history_ticker_rates');
        
        $totalInsertsDone = 0;
        $totalUpdatesDone = 0;
        $filesInserted = 0;
        
        if(!empty($files)){
            foreach($files as $file){
                try {
                    $insertsFromFile = 0;
                    $updatesFromFile = 0;
                    $inputFileType = \PHPExcel_IOFactory::identify($file);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($file);
                    
                    $fullFileName = basename($file);
                    $fileName = substr($fullFileName, 0, strpos($fullFileName, '.'));
                    
                    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
                    $query = '';
                    if(!empty($sheetData)){
                        foreach($sheetData as $key => $row){
                            if($key > 1 && $row['A'] >= '2003-01-01'){
                                
                                $data = array('ticker'=>$fileName);
                                $rate = ($row['B']+$row['C']+$row['D']+$row['E'])/4;
                                $data['bid'] = $rate;
                                $data['ask'] = $rate;
                                $data['high'] = $row['C'];
                                $data['low'] = $row['D'];
                                $data['date'] = $row['A'];
                                $query .= $tickerRateService->getInsertDataQuery($data);
                                if($query != null && strpos($query, 'INSERT INTO') !== false){
                                    $insertsFromFile++;
                                }elseif($query != null && strpos($query, 'UPDATE') !== false){
                                    $updatesFromFile++;
                                }
                            }
                        }
                    }
                    if(!empty($query)){
                        $tickerRateService->executeQuery($query);
                    }
                    $totalInsertsDone += $insertsFromFile;
                    $totalUpdatesDone += $updatesFromFile;
                    if($insertsFromFile > 0 || $updatesFromFile > 0){
                        $container->get('raetingraeting.service.file_management')->moveFile($file, $container->get('kernel')->getRootDir().'/../uploads/imported_history_ticker_rates/'.$fullFileName);
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