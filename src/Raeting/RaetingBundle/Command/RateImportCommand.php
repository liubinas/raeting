<?php
namespace Raeting\RaetingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RateImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('raeting:importrates:fxcm')
            ->setDescription('Imports currency rates from fxcm.com')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $output->writeln('<info>Importing rates...</info>');

        $rateService = $container->get('raetingraeting.service.rate');
        $result = $rateService->importXmlFromFXCM('http://rates.fxcm.com/RatesXML3');

        $output->writeln('<info>Inserts done: '.$result.'</info>');
    }
}