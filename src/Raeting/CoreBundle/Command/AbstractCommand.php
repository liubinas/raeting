<?php
namespace Raeting\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class AbstractCommand  extends ContainerAwareCommand
{
    protected $output;

    public function setOutput($output)
    {
        $this->output = $output;
    }

    public function getOutput()
    {
        return $this->output;
    }

    protected function _e($msg)
    {
        $this->getOutput()->writeln('<error>' . $msg .'</error>');
    }

    protected function _c($msg)
    {
        $this->getOutput()->writeln('<comment>' . $msg .'</comment>');
    }

    protected function _i($msg)
    {
        $this->getOutput()->writeln('<info>' . $msg .'</info>');
    }

    protected function _q($msg)
    {
        $this->getOutput()->writeln('<question>' . $msg .'</question>');
    }
}
