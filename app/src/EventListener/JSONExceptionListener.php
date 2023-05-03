<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class JSONExceptionListener implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 200],
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        $httpCode = match (get_class($exception)) {
            AccessDeniedException::class => 401,
            default => 500
        };

        if ($exception instanceof HttpExceptionInterface) {
            $httpCode = $exception->getStatusCode();
        }

        $content = [
            'message' => $exception->getMessage()
        ];

        $event->setResponse(
            new JsonResponse($content, $httpCode)
        );
    }
}