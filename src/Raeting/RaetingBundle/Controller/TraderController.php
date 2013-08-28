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
        $traderService = $this->get('user.service.userem');
        $entities = $traderService->getAll();

        return $this->render('RaetingRaetingBundle:Trader:index.html.php', array('entities'=>$entities));
    }

    /**
     * Finds and displays a Trader profile.
     *
     */
    public function showAction($id)
    {
        $entity = $this->get('user.service.userem')->get($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find trader .');
        }

        return $this->render('RaetingRaetingBundle:Trader:show.html.php', array(
            'entity'      => $entity,
        ));
    }
}
