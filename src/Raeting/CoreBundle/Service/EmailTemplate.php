<?php

namespace Raeting\CoreBundle\Service;


use Symfony\Component\DependencyInjection\Container;
use RuntimeException;

class EmailTemplate {

    protected $emailTemplateModel;
    /**
     * Constructor
     * 
     * @param Raeting\CoreBundle\Model\EmailTemplate $emailTemplateModel 
     */
    public function __construct($emailTemplateModel)
    {
        $this->emailTemplateModel = $emailTemplateModel;
    }
    
    public function processEmailTemplate($slug, $data)
    {
        $template = $this->emailTemplateModel->getBySlug($slug);

        if (empty($template)) {
            throw new RuntimeException(sprintf('Template by slug %s can not be found', $slug));
        }

        $content = $this->prepareTemplate($template['content'], $data);
        $subject = $this->prepareTemplate($template['subject'], $data);
        
        return array(
            'subject' => $subject,
            'content' => $content,
        );
    }
    
    public function prepareTemplate($content, $data)
    {
        foreach($data as $key => $value) {
            $content = str_replace("{".$key."}", $value, $content);
        }
        
        return $content;
    }
}