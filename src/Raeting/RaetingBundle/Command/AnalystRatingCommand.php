<?php
namespace Raeting\RaetingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AnalystRatingCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('raeting:analysts:rating')
            ->setDescription('Update analysts ratings')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $output->writeln('<info>Updating ratings...</info>');

        $analystService = $container->get('raetingraeting.service.analyst');
        
        $analysts = $analystService->getAll();
        
        $totalReturnArr = array();
        if(!empty($analysts)){
            foreach($analysts as $analyst){
                $analystTotalReturn = $analystService->calculateTotalReturnByAnalyst($analyst);
                $totalReturnArr[$analyst->getId()] = $analystTotalReturn;
            }
        }
        $analystService->saveRatings($totalReturnArr);
        
        $analystService->updateRanks();
        
        $output->writeln('<info>Updates done: '.count($totalReturnArr).'</info>');
    }
}