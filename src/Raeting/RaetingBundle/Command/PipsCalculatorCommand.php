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

        $output->writeln('<info>Updating pips...</info>');

        $signalService = $container->get('raetingraeting.service.signals');
        $signals = $signalService->getAllNew();
        if(!empty($signals)){
            foreach($signals as $signal){
                $signalService->countPipsAndSave($signal);
            }
        }

        $output->writeln('<info>Done!</info>');
    }
}