<?php
namespace Raeting\RaetingBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Raeting\RaetingBundle\Entity\Signals as SignalsEntity;
use Raeting\RaetingBundle\Form\SignalsType;

/**
 * Signals controller.
 *
 */
class SignalsController extends Controller
{
    /**
     * Lists all Signals entities.
     *
     */
    public function indexAction()
    {
        $request = $this->get('request');
        $query = $request->query->get('signal-search');
        if ($request->getMethod() == 'GET' && !empty($query)) {
            $entities = $this->get('raetingraeting.service.signals')->getBy($query);
        }else{
            $entities = $this->get('raetingraeting.service.signals')->getAll();
        }
        
        return $this->render('RaetingRaetingBundle:Signals:index.html.php', array(
            'entities' => $entities,
            'query' => $query,
            'showForm' => false,
            'form' => null,
            'entity' => null
        ));
    }
    
    /**
     * Lists all user Signals entities.
     *
     */
    public function mysignalsAction()
    {
        $request = $this->get('request');
        $query = $request->query->get('signal-search');
        $token = $this->get('security.context')->getToken();

        if ($request->getMethod() == 'GET' && !empty($query)) {
            $entities = $this->get('raetingraeting.service.signals')->getByQueryAndUser($query, $token->getUser()->getId());
        }else{
            $entities = $this->get('raetingraeting.service.signals')->getByTrader($token->getUser()->getId());
        }
        
        return $this->render('RaetingRaetingBundle:Signals:my_signals.html.php', array(
            'entities' => $entities,
            'query' => $query,
            'showForm' => false,
            'form' => null,
            'entity' => null
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

            $entity->setUser($user);
            $entity->setUuid(md5($id.$id));
            $now = new \DateTime('now');
            $entity->setCreated($now);
            $entity->setOpened($now);
            $entity->setOpenExpire($now);
            $entity->setClosed($now);
            $entity->setCloseExpire($now);
            
            $this->get('raetingraeting.service.signals')->save($entity);

            $this->get('session')->getFlashBag()->add('success', 'Your changes were saved!');

            return $this->redirect($this->generateUrl($createLink, array('id' => $entity->getId())));
        }else{
            $query = $request->query->get('signal-search');
            if ($request->getMethod() == 'GET' && !empty($query)) {
                $entities = $this->get('raetingraeting.service.signals')->getBy($query);
            }else{
                $entities = $this->get('raetingraeting.service.signals')->getAll();
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
                'entity' => $entity
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
    public function showAction($uid)
    {
        $entity = $this->get('raetingraeting.service.signals')->getByUuid($uid);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Signal entity.');
        }

        return $this->render('RaetingRaetingBundle:Signals:show.html.php', array(
            'entity'      => $entity,
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
    
    public function ajaxGetAllQuotesJsonAction(Request $request)
    {
        $quotes = $this->get('raetingraeting.service.symbol')->findQuotesByKeyword($request->query->get('search'), $request->query->get('maxRows'));
        $serializer = $this->container->get('serializer');
        $quotes = $serializer->serialize($quotes, 'json');
        echo $quotes;
        die;
    }
    
    public function ajaxGetAllTickersJsonAction(Request $request)
    {
        $tickers = $this->get('raetingraeting.service.symbol')->findTickersByKeyword($request->query->get('search'), $request->query->get('maxRows'));
        $serializer = $this->container->get('serializer');
        $tickers = $serializer->serialize($tickers, 'json');
        echo $tickers;
        die;
    }
}
