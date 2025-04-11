<?php declare(strict_types=1);

namespace MyShoeFitter;

use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\ActivateContext;
use Shopware\Core\Framework\Plugin\Context\DeactivateContext;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\Plugin\Context\UpdateContext;

class MyShoeFitter extends Plugin
{
    public function install(InstallContext $context): void
    {
        // Check for minimum Shopware version
        if (version_compare($context->getShopwareVersion(), '6.1.0', '<')) {
            throw new \RuntimeException('This plugin requires Shopware 6.1.0 or higher');
        }
        
        parent::install($context);
    }

    public function uninstall(UninstallContext $context): void
    {
        parent::uninstall($context);
        
        if ($context->keepUserData()) {
            return;
        }
        
        // Clean up if needed - perhaps remove plugin config
        // This is already handled by parent::uninstall() for most cases
    }

    public function activate(ActivateContext $context): void
    {
        parent::activate($context);
    }

    public function deactivate(DeactivateContext $context): void
    {
        parent::deactivate($context);
    }

    public function update(UpdateContext $context): void
    {
        // Check if update requires special handling
        if (version_compare($context->getUpdateVersion(), '1.1.0', '<=')) {
            // Handle specific update logic for version 1.1.0 or lower
        }
        
        parent::update($context);
    }
}