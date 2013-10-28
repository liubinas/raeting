<?php
namespace Raeting\RaetingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use Raeting\RaetingBundle\Entity\Signals as SignalsEntity;
use Raeting\RaetingBundle\Form\SignalsType;

/**
 * Signals controller.
 *
 */
class SignalsController extends Controller
{
    public $resultsPerPage = 10;
    /**
     * Lists all Signals entities.
     *
     */
    public function indexAction()
    {
        $request = $this->get('request');
        $page = $request->query->get('page');
        if(empty($page)){
            $page = 1;
        }
        $query = $request->query->get('signal-search');
        if ($request->getMethod() == 'GET' && !empty($query)) {
            $entities = $this->get('raetingraeting.service.signals')->getAllByQuery($query, $this->resultsPerPage, $page);
            $totalSignals = $this->get('raetingraeting.service.signals')->countByQuery($query);
        }else{
            $entities = $this->get('raetingraeting.service.signals')->getAllWithPaging($this->resultsPerPage, $page);
            $totalSignals = $this->get('raetingraeting.service.signals')->countAll();
        }
        
        return $this->render('RaetingRaetingBundle:Signals:index.html.php', array(
            'entities' => $entities,
            'query' => $query,
            'showForm' => false,
            'form' => null,
            'entity' => null,
            'totalSignals' => $totalSignals,
            'perPage' => $this->resultsPerPage,
            'page' => $page
        ));
    }
    
    /**
     * Lists all user Signals entities.
     *
     */
    public function mysignalsAction()
    {
        $request = $this->get('request');
        $page = $request->query->get('page');
        if(empty($page)){
            $page = 1;
        }
        $query = $request->query->get('signal-search');
        $token = $this->get('security.context')->getToken();

        if ($request->getMethod() == 'GET' && !empty($query)) {
            $entities = $this->get('raetingraeting.service.signals')->getAllByQueryAndUser($query, $token->getUser()->getId(), $this->resultsPerPage, $page);
            $totalSignals = $this->get('raetingraeting.service.signals')->countByQueryAndUser($query, $token->getUser()->getId());
        }else{
            $entities = $this->get('raetingraeting.service.signals')->getAllByTrader($token->getUser()->getId(), $this->resultsPerPage, $page);
            $totalSignals = $this->get('raetingraeting.service.signals')->countByTrader($token->getUser()->getId());
        }
        
        return $this->render('RaetingRaetingBundle:Signals:my_signals.html.php', array(
            'entities' => $entities,
            'query' => $query,
            'showForm' => false,
            'form' => null,
            'entity' => null,
            'totalSignals' => $totalSignals,
            'perPage' => $this->resultsPerPage,
            'page' => $page
        ));
    }

    /**
     * Creates a new Signals entity.
     *
     */
    public function createAction(Request $request)
    {
        $request = $this->get('request');
        $createLink = $request->query->get('link');
        if(empty($createLink)){
            $createLink = 'signals';
        }
        
        $entity = $this->get('raetingraeting.service.signals')->getNew();
        $form = $this->get('raetingraeting.form.signals');
        $form->setData($entity);
        $form->bind($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $token = $this->get('security.context')->getToken();

            $id = $token->getUser()->getId();
            $user = $this->get('doctrine')
            ->getRepository('RaetingUserBundle:User')
            ->find($id);

            $this->get('raetingraeting.service.signals')->createEntity($entity, $user, $id);

            $this->get('session')->getFlashBag()->add('success', 'Your changes were saved!');

            return $this->redirect($this->generateUrl($createLink, array('id' => $entity->getId())));
        }else{
            $query = $request->query->get('signal-search');
            $page = $request->query->get('page');
            if(empty($page)){
                $page = 1;
            }
            if ($request->getMethod() == 'GET' && !empty($query)) {
                $entities = $this->get('raetingraeting.service.signals')->getAllByQuery($query, $this->resultsPerPage, $page);
                $totalSignals = $this->get('raetingraeting.service.signals')->countByQuery($query);
            }else{
                $entities = $this->get('raetingraeting.service.signals')->getAllWithPaging($this->resultsPerPage, $page);
                $totalSignals = $this->get('raetingraeting.service.signals')->countAll();
            }
            if($createLink == 'my_signals'){
                $template = 'RaetingRaetingBundle:Signals:my_signals.html.php';
            }else{
                $template = 'RaetingRaetingBundle:Signals:index.html.php';
            }
            return $this->render($template, array(
                'entities' => $entities,
                'query' => $query,
                'showForm' => true,
                'form' => $form,
                'entity' => $entity,
                'totalSignals' => $totalSignals,
                'perPage' => $this->resultsPerPage,
                'page' => $page
            ));
        }
        
        return $this->render('RaetingRaetingBundle:Signals:new.html.php', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Signals entity.
     *
     */
    public function newAction($entity = null, $form = null, $createLink = 'signals')
    {
        if($entity == null && $form == null){
            $entity = $this->get('raetingraeting.service.signals')->getNew();
            $form = $this->get('raetingraeting.form.signals');
            $form->setData($entity);
        }

        return $this->render('RaetingRaetingBundle:Signals:new.html.php', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'createLink' => $createLink
        ));
    }

    /**
     * Finds and displays a Signals entity.
     *
     */
    public function showAction($id)
    {
        $entity = $this->get('raetingraeting.service.signals')->get($id);
        $tickerRateService = $this->get('raetingraeting.service.ticker_rate');
        $rates = $tickerRateService->findAllBySymbol($entity->getSymbol()->getSymbol());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Signal entity.');
        }

        return $this->render('RaetingRaetingBundle:Signals:show.html.php', array(
            'entity'      => $entity,
            'rates'       => $rates,
        ));
    }

    /**
     * Displays a form to edit an existing Signals entity.
     *
     */
    public function editAction($id)
    {
        $entity = $this->get('raetingraeting.service.signals')->get($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Signals entity.');
        }

        $form = $this->get('raetingraeting.form.signals');
        $form->setData($entity);

        return $this->render('RaetingRaetingBundle:Signals:edit.html.php', array(
            'entity'      => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Edits an existing Signals entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->get('raetingraeting.service.signals')->get($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Signals entity.');
        }

        $form = $this->get('raetingraeting.form.signals');
        $form->setData($entity);
        $form->bind($request);

        if ($form->isValid()) {
            $this->get('raetingraeting.service.signals')->save($entity);

            $this->get('session')->getFlashBag()->add('success', 'Your changes were saved!');

            return $this->redirect($this->generateUrl('signals'));
        }

        return $this->render('RaetingRaetingBundle:Signals:edit.html.php', array(
            'entity'      => $entity,
            'form'   => $form->createView(),
        ));
    }
    
    public function ajaxGetAllSymbolsJsonAction(Request $request)
    {
        $symbols = $this->get('raetingraeting.service.symbol')->findSymbolsByKeyword($request->query->get('search'), $request->query->get('maxRows'));
        $serializer = $this->container->get('serializer');
        $symbols = $serializer->serialize($symbols, 'json');
        
        $response = new JsonResponse();
        $response->setContent($symbols);
        
        return $response;
    }
}
