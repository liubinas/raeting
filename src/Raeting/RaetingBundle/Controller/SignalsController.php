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
        $entities = $this->get('raetingraeting.service.signals')->getAll();

        return $this->render('RaetingRaetingBundle:Signals:index.html.php', array(
            'entities' => $entities,
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
            $token = $this->get('security.context')->getToken();

            $id = $token->getUser()->getId();
            $entity->setUser($id);
            
            $this->get('raetingraeting.service.signals')->save($entity);

            $this->get('session')->getFlashBag()->add('success', 'Your changes were saved!');

            return $this->redirect($this->generateUrl('signals_show', array('id' => $entity->getId())));
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
    public function newAction()
    {
        $entity = $this->get('raetingraeting.service.signals')->getNew();
        $form = $this->get('raetingraeting.form.signals');
        $form->setData($entity);

        return $this->render('RaetingRaetingBundle:Signals:new.html.php', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Signals entity.
     *
     */
    public function showAction($id)
    {
        $entity = $this->get('raetingraeting.service.signals')->get($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Signals entity.');
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
}
