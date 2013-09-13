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
     * Creates a new Signals entity.
     *
     */
    public function createAction(Request $request)
    {
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
            $entity->setClose(0);
            $now = new \DateTime('now');
            $entity->setCreated($now);
            $entity->setOpened($now);
            $entity->setOpenExpire($now);
            $entity->setClosed($now);
            $entity->setCloseExpire($now);
            
            $this->get('raetingraeting.service.signals')->save($entity);

            $this->get('session')->getFlashBag()->add('success', 'Your changes were saved!');

            return $this->redirect($this->generateUrl('signals', array('id' => $entity->getId())));
        }else{
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
    public function newAction($entity = null, $form = null)
    {
        if($entity == null && $form == null){
            $entity = $this->get('raetingraeting.service.signals')->getNew();
            $form = $this->get('raetingraeting.form.signals');
            $form->setData($entity);
        }

        return $this->render('RaetingRaetingBundle:Signals:new.html.php', array(
            'entity' => $entity,
            'form'   => $form->createView(),
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

    /**
     * Deletes a Signals entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $entity = $this->get('raetingraeting.service.signals')->get($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Signals entity.');
        }

        $this->get('raetingraeting.service.signals')->delete($entity);

        $this->get('session')->setFlash(
            'success',
            'Your changes were saved!'
        );

        return $this->redirect($this->generateUrl('signals'));
    }
    
    public function ajaxGetAllQuotesJsonAction(Request $request)
    {
        $quotes = $this->get('raetingraeting.service.quote')->findByKeyword($request->query->get('search'), $request->query->get('maxRows'));
        $serializer = $this->container->get('serializer');
        $quotes = $serializer->serialize($quotes, 'json');
        echo $quotes;
        die;
    }
    
    public function ajaxGetAllTickersJsonAction(Request $request)
    {
        $tickers = $this->get('raetingraeting.service.ticker')->findByKeyword($request->query->get('search'), $request->query->get('maxRows'));
        $serializer = $this->container->get('serializer');
        $tickers = $serializer->serialize($tickers, 'json');
        echo $tickers;
        die;
    }
}
