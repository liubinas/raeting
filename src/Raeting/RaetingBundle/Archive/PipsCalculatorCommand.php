<?php
namespace Raeting\RaetingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PipsCalculatorCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('raeting:pips:update')
            ->setDescription('Calculate pips')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $signalService = $container->get('raetingraeting.service.signals');
        
        $output->writeln('<info>Updating new signals statuses...</info>');
        
        $newSignals = $signalService->getAllNew();
        if(!empty($newSignals)){
            foreach($newSignals as $signal){
                $signalService->updateNewStatusesAndPrices($signal);
            }
        }
        
        $output->writeln('<info>Updating opened signals statuses...</info>');
        
        $openedSignals = $signalService->getAllOpened();
        if(!empty($openedSignals)){
            foreach($openedSignals as $signal){
                $signalService->updateOpenedStatusesAndPrices($signal);
            }
        }
        
        $output->writeln('<info>Updating pips...</info>');

        $notCalculatedSignals = $signalService->getAllNotCalculated();
        if(!empty($notCalculatedSignals)){
            foreach($notCalculatedSignals as $signal){
                $signalService->countPipsAndSave($signal);
            }
        }

        $output->writeln('<info>Done!</info>');
    }
}