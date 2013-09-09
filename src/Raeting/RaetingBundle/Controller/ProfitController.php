<?php

namespace Raeting\RaetingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProfitController extends Controller
{
    public function pipsAction()
    {
        $signalService = $this->get('raetingraeting.service.signals');
        $signals = $signalService->getAllNew();
        if(!empty($signals)){
            foreach($signals as $signal){
                $signalService->countPipsAndSave($signal);
            }
        }
        echo 'done';
        die;
        
    }
}
