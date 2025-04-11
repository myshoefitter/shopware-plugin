<?php

namespace MyShoeFitter\Subscriber;

use Enlight\Event\SubscriberInterface;

class TemplateRegistrationSubscriber implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginDirectory;

    /**
     * @param string $pluginDirectory
     */
    public function __construct($pluginDirectory)
    {
        $this->pluginDirectory = $pluginDirectory;
    }

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'onPreDispatch'
        ];
    }

    public function onPreDispatch(\Enlight_Controller_ActionEventArgs $args)
    {
        // Get the template from the DI container to avoid direct access to the global Shopware object
        $template = Shopware()->Container()->get('template');
        
        // Register template directory
        $template->addTemplateDir($this->pluginDirectory . '/Resources/views/');
    }
}