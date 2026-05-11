<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class BookShelfSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        // Only add header for main requests (not sub-requests)
        if (!$event->isMainRequest()) {
            return;
        }
        
        // Add custom header X-BookShelf-Version: 1.0
        $event->getResponse()->headers->set('X-BookShelf-Version', '1.0');
    }
}
