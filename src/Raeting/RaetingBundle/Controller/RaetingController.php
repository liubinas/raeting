<?php

namespace Raeting\RaetingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RaetingController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        $latestSignal = $this->get('raetingraeting.service.signals')->getLatest();
        //$latestTrader = $this->get('user.service.user')->getLatest();
        $topAnalyst = $this->get('raetingraeting.service.analyst')->getTopAnalyst();
        $latestRecommendation = $this->get('raetingraeting.service.analysis')->getLatest();
        return $this->render('RaetingRaetingBundle:Raeting:index.html.php', array(
            'hideSidebar' => true,
            'showTopMenu' => true,
            'latestSignal' => $latestSignal,
            'latestTrader' => null,
            'topAnalyst' => $topAnalyst,
            'latestRecommendation' => $latestRecommendation,
            ));
    }
}
