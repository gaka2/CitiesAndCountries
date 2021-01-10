<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Controller\RestApiController;
use App\Api\Exception\InvalidRequestException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

/**
 * @author Karol Gancarczyk
 */
class RequestSubscriber implements EventSubscriberInterface
{
    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if ($controller instanceof RestApiController) {
            if (strpos($event->getRequest()->headers->get('Content-Type'), 'application/json') !== 0) {
                throw new InvalidRequestException('Invalid Content-Type in request header');
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ControllerEvent::class => 'onKernelController',
        ];
    }
}
