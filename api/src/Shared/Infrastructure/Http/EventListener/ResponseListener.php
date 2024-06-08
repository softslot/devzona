<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\EventListener;

use App\Shared\Infrastructure\Http\Response\ErrorsBag;
use App\Shared\Infrastructure\Http\Response\ResponseBody;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Serializer\SerializerInterface;

#[AsEventListener(event: ViewEvent::class)]
readonly class ResponseListener
{
    public function __construct(
        private SerializerInterface $serializer,
        private ErrorsBag           $errorBag,
    ) {
    }

    public function onKernelView(ViewEvent $event): void
    {
        if ($event->getControllerResult() instanceof ResponseBody) {
            $data = $event->getControllerResult();
        } else {
            $data = new ResponseBody($this->errorBag);
            $data->setBody($event->getControllerResult());
        }

        $response = new Response();
        $response->setContent($this->serializer->serialize($data->jsonSerialize(), 'json'));
        $response->headers->set('Content-Type', 'application/json; charset=UTF-8');

        $event->setResponse($response);
    }
}
