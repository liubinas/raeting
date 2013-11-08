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
        return $this->render('RaetingRaetingBundle:Raeting:index.html.php', array('hideSidebar' => true,
            'showTopMenu' => true));
    }
}
