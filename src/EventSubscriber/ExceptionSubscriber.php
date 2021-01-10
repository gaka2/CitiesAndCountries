<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use App\Api\ResponseFactory;
use App\Service\Exception\FormValidationException;
use App\Api\Exception\InvalidRequestException;
use App\Service\Exception\InvalidArgumentException;
use App\Service\Exception\InternalErrorException;

/**
 * @author Karol Gancarczyk
 */
class ExceptionSubscriber implements EventSubscriberInterface
{
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }
    
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = $this->createResponse($exception);
        
        if ($response === null) {
            return;
        }
        
        $event->setResponse($response);
    }

    private function createResponse(\Throwable $exception) : ?Response
    {
        if ($exception instanceof FormValidationException) {
            return $this->responseFactory->invalidRequestResponse($exception->getMessage(), $exception->getErrors());
        }

        if ($exception instanceof InvalidRequestException || $exception instanceof InvalidArgumentException) {
            return $this->responseFactory->invalidRequestResponse($exception->getMessage());
        }

        if ($exception instanceof InternalErrorException) {
            return $this->responseFactory->serviceUnavailableResponse();
        }

        return null;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ExceptionEvent::class => 'onKernelException',
        ];
    }
}
