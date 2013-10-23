<?php
namespace Raeting\RaetingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AnalysisImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('raeting:analysis:import')
            ->setDescription('Imports analysis')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $output->writeln('<info>Importing analysis...</info>');

        $objPHPExcel = new \PHPExcel();
        
        $files = $container->get('raetingraeting.service.file_management')->scanDir($container->get('kernel')->getRootDir().'/../uploads/analysis');
        
        $analysisService = $container->get('raetingraeting.service.analysis');
        
        $totalInsertsDone = 0;
        $filesInserted = 0;
        
        if(!empty($files)){
            foreach($files as $file){
                try {
                    $insertsFromFile = 0;
                    $inputFileType = \PHPExcel_IOFactory::identify($file);
                    $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                    $objReader->setLoadAllSheets();
                    $objPHPExcel = $objReader->load($file);
                    
                    $fullFileName = basename($file);
                    $fileName = substr($fullFileName, 0, strpos($fullFileName, '.'));
                    
                    $loadedSheetNames = $objPHPExcel->getSheetNames();
                    foreach($loadedSheetNames as $sheetIndex => $loadedSheetName) {
                        $sheetData = $objPHPExcel->getSheet($sheetIndex)->toArray(null,true,true,true);
                        if(!empty($sheetData)){
                            foreach($sheetData as $key => $row){
                                if($key > 1){
                                    $data = array('analyst'=>$loadedSheetName, 'ticker'=>$fileName);
                                    $data['estimation'] = $row['C'];
                                    $data['period'] = $row['D'];
                                    $data['date'] = $row['B'];
                                    $data['recommendation'] = $row['A'];
                                    $insertsFromFile += $analysisService->insertData($data);
                                }
                            }
                        }
                    }
                    $totalInsertsDone += $insertsFromFile;
                    if($insertsFromFile > 0){
                        $container->get('raetingraeting.service.file_management')->moveFile($file, $container->get('kernel')->getRootDir().'/../uploads/imported_analysis/'.$fullFileName);
                        $filesInserted++;
                    }
                } catch(Exception $e) {
                    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
                }
            }
        }
        

        $output->writeln('<info>Files inserted: '.$filesInserted.'.Inserts done: '.$totalInsertsDone.'</info>');
    }
}