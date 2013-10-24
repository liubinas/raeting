<?php
namespace Raeting\RaetingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TickerAggregateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('raeting:aggregate:ticker')
            ->setDescription('Aggregate ticker rates')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $output->writeln('<info>Aggregating ticker rates...</info>');

        $aggregationService = $container->get('raetingraeting.service.aggregation');
        $symbolsAggregated = $aggregationService->aggregateTickerRates();
        

        $output->writeln('<info>Symbols aggregated: '.$symbolsAggregated.'.</info>');
    }
}