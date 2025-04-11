<?php

namespace MyShoeFitter\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Components\Plugin\ConfigReader;

class ScriptInjectionSubscriber implements SubscriberInterface
{
    /**
     * @var ConfigReader
     */
    private $configReader;
    
    /**
     * @var string
     */
    private $pluginName;
    
    /**
     * @var string
     */
    private $pluginDirectory;

    /**
     * @param string $pluginName
     * @param string $pluginDirectory
     * @param ConfigReader $configReader
     */
    public function __construct(
        $pluginName,
        $pluginDirectory,
        ConfigReader $configReader
    ) {
        $this->pluginName = $pluginName;
        $this->pluginDirectory = $pluginDirectory;
        $this->configReader = $configReader;
    }

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onFrontendPostDispatch'
        ];
    }

    public function onFrontendPostDispatch(\Enlight_Controller_ActionEventArgs $args)
    {
        try {
            /** @var \Enlight_Controller_Action $controller */
            $controller = $args->getSubject();
            $view = $controller->View();
            
            // Check if the plugin is enabled
            $config = $this->configReader->getByPluginName($this->pluginName);
            $enabled = $config['enabled'] ?? true;
            if (!$enabled) {
                return;
            }

            // Get script URL from config
            $scriptUrl = $config['scriptUrl'] ?? 'https://js.myshoefitter.com/v1/script.js';

            // Assign variables to the view
            $view->assign('myshoefitterEnabled', true);
            $view->assign('myshoefitterScriptUrl', $scriptUrl);
            $view->assign('myshoefitterShopSystem', 'shopware');
            
            // Register template directory
            $view->addTemplateDir($this->pluginDirectory . '/Resources/views/');
        } catch (\Exception $e) {
            // Log error but don't disrupt normal operation
            Shopware()->Container()->get('pluginlogger')->error(
                'MyShoeFitter Plugin Error: ' . $e->getMessage(),
                ['exception' => $e]
            );
        }
    }
}