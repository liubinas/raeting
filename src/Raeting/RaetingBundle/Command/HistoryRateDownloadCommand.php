<?php
namespace Raeting\RaetingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class HistoryRateDownloadCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('raeting:downloadrates:forexite')
            ->setDescription('Imports currency rates from fxcm.com')
            ->addArgument(
                'dateFrom',
                InputArgument::REQUIRED,
                'Date from ex. 2013-10-30'
            )
            ->addArgument(
                'dateTo',
                InputArgument::REQUIRED,
                'Date from ex. 2013-10-31'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Downloading Files...</info>');
        
        $container = $this->getContainer();
        $dir = $container->get('kernel')->getRootDir().'/../uploads/history_currency_rates/';
        
        $dateFrom = date('Y-m-d', strtotime($input->getArgument('dateFrom')));
        $dateTo = date('Y-m-d', strtotime($input->getArgument('dateTo')));
        $filesDownloaded = 0;
        while($dateFrom != $dateTo){
            $filename = date('d', strtotime($dateFrom)).date('m', strtotime($date)).date('y', strtotime($dateFrom));
            $data = file_get_contents('http://www.forexite.com/free_forex_quotes/'.date('Y', strtotime($dateFrom)).'/'.date('m', strtotime($dateFrom)).'/'.$filename.'.zip');
            $file = $dir.$filename.'.zip';
            $zip = file_put_contents($file, $data);
            if(!empty($data)){
                $zip = new \ZipArchive;
                $res = $zip->open($file);
                if ($res === TRUE) {
                    $zip->extractTo($dir);
                    $zip->close();
                    $filesDownloaded++;
                }
            }
            unlink($file);
            $dateFrom = date('Y-m-d', strtotime($dateFrom.' + 1 DAY'));
        }
        
        $output->writeln('<info>Files downloaded: '.$filesDownloaded.'</info>');
    }
}