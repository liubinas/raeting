<?php
namespace Raeting\RaetingBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SymbolsTableUpdateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('raeting:symboltables:update')
            ->setDescription('Update symbols tables')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();

        $output->writeln('<info>Updating tables...</info>');

        $symbolService = $container->get('raetingraeting.service.symbol');
        
        $symbols = $symbolService->getAll();
        
        $tables = $symbolService->getSymbolTables();
        $tablesCreated = 0;
        $tablesDeleted = 0;
        
        if(!empty($symbols)){
            foreach($symbols as $symbol){
                $tableName = 'symbol_'.strtolower($symbol->getSymbol());
                if(!in_array($tableName, $tables)){
                    $symbolService->createTable($symbol->getSymbol());
                    $tablesCreated++;
                }
                unset($tables[$tableName]);
            }
        }
        if(!empty($tables)){
            foreach($tables as $table){
                $symbolService->deleteTable($table);
                $tablesDeleted++;
            }
        }
        
        $output->writeln('<info>Tables created: '.$tablesCreated.'.Tables deleted: '.$tablesDeleted.'</info>');
    }
}