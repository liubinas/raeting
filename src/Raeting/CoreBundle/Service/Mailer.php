<?php

namespace Raeting\CoreBundle\Service;

use InvalidArgumentException;
use Swift_Mailer;
use Swift_Attachment;
use Swift_Message;
use Raeting\LocalizationBundle\Service\EmailTemplate;

/**
 * Mailer service
 */
class Mailer
{
    protected $parameters;
    protected $requiredParameters = array('from', 'email');
    protected $emailTemplateService;
    protected $mailer;

    /**
     * Constructor.
     * 
     * @param array $parameters Required parameters: email, from.
     */
    public function __construct(array $parameters, Swift_Mailer $mailer, EmailTemplate $emailTemplateService)
    {
        $this->parameters = $parameters;

        //Check if all required parameters were provided.
        foreach ($this->requiredParameters as $name) {
            if (!isset($this->parameters[$name])) {
                throw new InvalidArgumentException(sprinf('Parameter %s must be defined.', $name));
            }
        }

        $this->mailer = $mailer;
        $this->emailTemplateService = $emailTemplateService;
    }
    
    /**
     * Return new instance of Swift_Message object. Preset required attributes.
     * 
     * @param string $name 
     *
     * @return Swift_Message
     */
    public function newMessage($subject)
    {
        $message = Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom(array($this->parameters['email'] => $this->parameters['from']));

        return $message;
    }

    public function send($to, $subject, $content)
    {
        if (is_string($to)) {
            $to = explode(',', $to);
        }

        $message = $this->newMessage($subject)
                        ->setTo($to)
                        ->setBody(
                            $content,
                            'text/html'
                        )
                        ->addPart(strip_tags($content), 'text/plain')
        ;

        return $this->mailer->send($message);
    }

    /**
     * Send preprared template to user
     * 
     * @param array $sendToEmails
     * @param string $slug
     * @param array $data
     * @param array $files list of files paths to be attached
     *
     * @return bool
     */
    public function sendTemplate(array $sendToEmails, $slug, array $data, array $files = array())
    {
        $data = $this->emailTemplateService->processEmailTemplate($slug, $data);
        $content = $data['content'];
        $subject = $data['subject'];

        $message = $this->newMessage($subject)
                        ->setTo($sendToEmails)
                        ->setBody(
                            $content,
                            'text/html'
                        )
                        ->addPart(strip_tags($content), 'text/plain')
        ;

        foreach ($files AS $file) {
            $message->attach(Swift_Attachment::fromPath($file));
        }

        return $this->mailer->send($message);
    }
}
