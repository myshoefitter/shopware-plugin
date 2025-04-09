<?php

/**
 * MyShoeFitter Shopware 5 Plugin
 */
class Shopware_Plugins_Frontend_MyShoeFitter_Bootstrap extends Shopware_Components_Plugin_Bootstrap
{
    /**
     * Install the plugin
     *
     * @return bool
     */
    public function install()
    {
        $this->subscribeEvents();
        $this->createConfig();

        return true;
    }
    
    /**
     * Update the plugin
     *
     * @param string $version
     * @return bool
     */
    public function update($version)
    {
        return $this->install();
    }
    
    /**
     * Uninstall the plugin
     *
     * @return bool
     */
    public function uninstall()
    {
        return true;
    }

    /**
     * Activate the plugin
     *
     * @return array
     */
    public function enable()
    {
        return [
            'success' => true,
            'invalidateCache' => ['template', 'frontend']
        ];
    }

    /**
     * Deactivate the plugin
     *
     * @return array
     */
    public function disable()
    {
        return [
            'success' => true,
            'invalidateCache' => ['template', 'frontend']
        ];
    }

    /**
     * Get plugin version
     */
    public function getVersion()
    {
        return '1.0.0';
    }
    
    /**
     * Get plugin information
     */
    public function getInfo()
    {
        return [
            'label' => 'MyShoeFitter Integration',
            'description' => 'Integrates MyShoeFitter sizing script into your Shopware 5 store',
            'version' => $this->getVersion(),
            'author' => 'Your Name',
            'link' => 'https://www.myshoefitter.com'
        ];
    }

    /**
     * Subscribe to events
     */
    private function subscribeEvents()
    {
        $this->subscribeEvent(
            'Enlight_Controller_Action_PostDispatchSecure_Frontend',
            'onFrontendPostDispatch'
        );
        
        return true;
    }

    /**
     * Create plugin configuration
     */
    private function createConfig()
    {
        $this->Form()->setElement(
            'checkbox',
            'enabled',
            [
                'label' => 'Enable MyShoeFitter',
                'value' => true,
                'scope' => \Shopware\Models\Config\Element::SCOPE_SHOP
            ]
        );

        $this->Form()->setElement(
            'text',
            'scriptUrl',
            [
                'label' => 'Script URL',
                'value' => 'https://js.myshoefitter.com/v1/script.js',
                'scope' => \Shopware\Models\Config\Element::SCOPE_SHOP
            ]
        );
        
        return true;
    }

    /**
     * On Frontend PostDispatch event
     *
     * @param \Enlight_Event_EventArgs $args
     */
    public function onFrontendPostDispatch(\Enlight_Event_EventArgs $args)
    {
        try {
            /** @var \Enlight_Controller_Action $controller */
            $controller = $args->getSubject();
            $view = $controller->View();
            
            // Check if the plugin is enabled
            $enabled = $this->Config()->get('enabled');
            if (!$enabled) {
                return;
            }

            // Get script URL from config
            $scriptUrl = $this->Config()->get('scriptUrl');
            if (empty($scriptUrl)) {
                $scriptUrl = 'https://js.myshoefitter.com/v1/script.js';
            }

            // Assign variables to the view
            $view->assign('myshoefitterEnabled', true);
            $view->assign('myshoefitterScriptUrl', $scriptUrl);
            $view->assign('myshoefitterShopSystem', 'shopware');
            
            // Register template directory
            $this->registerTemplateDir();
        } catch (\Exception $e) {
            // Log error but don't disrupt normal operation
            Shopware()->Container()->get('pluginlogger')->error(
                'MyShoeFitter Plugin Error: ' . $e->getMessage(),
                ['exception' => $e]
            );
        }
    }

    /**
     * Register template directory
     */
    private function registerTemplateDir()
    {
        Shopware()->Template()->addTemplateDir(
            $this->Path() . 'Resources/views/'
        );
        
        return true;
    }
}