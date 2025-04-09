<?php declare(strict_types=1);

namespace MyShoeFitter\Service;

use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Event\StorefrontRenderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Psr\Log\LoggerInterface;

class ScriptInjectionService implements EventSubscriberInterface
{
    /**
     * @var SystemConfigService
     */
    private $systemConfigService;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        SystemConfigService $systemConfigService,
        ?LoggerInterface $logger = null
    ) {
        $this->systemConfigService = $systemConfigService;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            StorefrontRenderEvent::class => 'onStorefrontRender',
        ];
    }

    public function onStorefrontRender(StorefrontRenderEvent $event): void
    {
        try {
            // Check if the plugin is enabled
            $enabled = $this->systemConfigService->get('MyShoeFitter.config.enabled');
            if (!$enabled) {
                return;
            }

            // Get script URL from config or use default
            $scriptUrl = $this->systemConfigService->get('MyShoeFitter.config.scriptUrl');
            if (empty($scriptUrl)) {
                $scriptUrl = 'https://js.myshoefitter.com/v1/script.js';
            }

            // Get the current template data
            $data = $event->getData();

            // Add our script data
            $data['myshoefitter'] = [
                'scriptUrl' => $scriptUrl,
                'shopSystem' => 'shopware'
            ];

            // Update the template data
            $event->setData($data);
            
            // No longer manually registering templates - now using TemplateRegistrationSubscriber
        } catch (\Exception $e) {
            // Log error but don't disrupt the storefront rendering
            if ($this->logger) {
                $this->logger->error('MyShoeFitter Plugin Error: ' . $e->getMessage(), ['exception' => $e]);
            } else {
                // Fallback logging to error_log
                error_log('MyShoeFitter Plugin Error: ' . $e->getMessage());
            }
        }
    }
}