<?php

namespace Raeting\RaetingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TraderController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        $traderService = $this->get('user.service.user');
        $entities = $traderService->getAll();

        return $this->render('RaetingRaetingBundle:Trader:index.html.php', array('entities'=>$entities));
    }

    /**
     * Finds and displays a Trader profile.
     *
     */
    public function showAction($slug)
    {
        $entity = $this->get('user.service.user')->getBySlug($slug);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find trader .');
        }

        $signals = $this->get('raetingraeting.service.signals')->getByTrader($entity->getId());
        
        return $this->render('RaetingRaetingBundle:Trader:show.html.php', array(
            'entity'      => $entity,
            'signals'     => $signals
        ));
    }
}
