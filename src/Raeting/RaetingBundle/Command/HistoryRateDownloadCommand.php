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
                'date',
                InputArgument::REQUIRED,
                'Date from ex. 2013-10-30'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Downloading Files...</info>');
        
        $container = $this->getContainer();
        $dir = $container->get('kernel')->getRootDir().'/../uploads/history_currency_rates/';
        
        $date = date('Y-m-d', strtotime($input->getArgument('date')));
        $filesDownloaded = 0;
        while($date != date('Y-m-d')){
            $filename = date('d', strtotime($date)).date('m', strtotime($date)).date('y', strtotime($date));
            $data = file_get_contents('http://www.forexite.com/free_forex_quotes/'.date('Y', strtotime($date)).'/'.date('m', strtotime($date)).'/'.$filename.'.zip');
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
            $date = date('Y-m-d', strtotime($date.' + 1 DAY'));
        }
        
        $output->writeln('<info>Files downloaded: '.$filesDownloaded.'</info>');
    }
}