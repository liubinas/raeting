<?php

namespace EstinaCMF\UserBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use EstinaCMF\UserBundle\Event\UserRegisteredEvent;

/**
 * RegistrationListener
 *
 */
class UserRegistrationListener implements EventSubscriberInterface
{
    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * @TODO inject mailer instance
     * @param Mailer $mailer
     */
    public function __construct($mailer = null)
    {
        $this->mailer = $mailer;
    }

    /**
     * get subscribed events
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            UserRegisteredEvent::NAME => array('onUserRegistered', 0)
        );
    }

    /**
     * @param UserRegisteredEvent $event
     */
    public function onUserRegistered(UserRegisteredEvent $event)
    {
        $user = $event->getUser();

        // @TODO registration mail
        // $this->mailer->sendTemplate(
        //     array($user->getEmail()),
        //     'user.register',
        //     $data
        // );
    }
}
