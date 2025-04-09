<?php declare(strict_types=1);

namespace MyShoeFitter\Subscriber;

use Shopware\Storefront\Event\ThemeCompilerEnrichScssVariablesEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TemplateRegistrationSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ThemeCompilerEnrichScssVariablesEvent::class => 'onThemeCompile'
        ];
    }

    public function onThemeCompile(ThemeCompilerEnrichScssVariablesEvent $event): void
    {
        $bundles = $event->getContext()->getApp()->getKernel()->getBundles();
        
        if (isset($bundles['MyShoeFitter'])) {
            $viewsDir = $bundles['MyShoeFitter']->getPath() . '/Resources/views';
            $event->addViewDir($viewsDir);
        }
    }
}