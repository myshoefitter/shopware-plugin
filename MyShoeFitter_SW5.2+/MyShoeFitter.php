<?php

namespace MyShoeFitter;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\ActivateContext;
use Shopware\Components\Plugin\Context\DeactivateContext;
use Shopware\Components\Plugin\Context\InstallContext;
use Shopware\Components\Plugin\Context\UninstallContext;
use Shopware\Components\Plugin\Context\UpdateContext;

class MyShoeFitter extends Plugin
{
    public function install(InstallContext $context)
    {
        return true;
    }

    public function uninstall(UninstallContext $context)
    {
        if (!$context->keepUserData()) {
            // Clean up if needed
        }
        
        return true;
    }

    public function activate(ActivateContext $context)
    {
        $context->scheduleClearCache(ActivateContext::CACHE_LIST_DEFAULT);
        return true;
    }

    public function deactivate(DeactivateContext $context)
    {
        $context->scheduleClearCache(DeactivateContext::CACHE_LIST_DEFAULT);
        return true;
    }

    public function update(UpdateContext $context)
    {
        return true;
    }
}