<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http\EventListener;

use App\Shared\Infrastructure\Http\Exception\BaseHttpException;
use App\Shared\Infrastructure\Http\Exception\ValidationPropertiesException;
use App\Shared\Infrastructure\Http\Response\ErrorsBag;
use App\Shared\Infrastructure\Http\Response\ResponseBody;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\HttpException as SymfonyHttpException;

#[AsEventListener(event: ExceptionEvent::class)]
class ExceptionListener implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ErrorsBag           $errorBag,
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $event->allowCustomResponseCode();

        if ($this->logger instanceof LoggerInterface) {
            $this->logger->warning($event->getThrowable()->getMessage(), [
                'error' => $event->getThrowable(),
            ]);
        }

        $data = new ResponseBody($this->errorBag);

        $response = $event->getResponse();
        if (!$response instanceof Response) {
            $response = new Response();
        }

        if ($event->getThrowable() instanceof BaseHttpException) {
            $data->getErrorBag()->addFrontError($event->getThrowable()->getCode(), null, $event->getThrowable()->getMessage());
            $response->setStatusCode($event->getThrowable()->getCode());

            if ($event->getThrowable() instanceof ValidationPropertiesException) {
                foreach ($event->getThrowable()->getViolations() as $violation) {
                    $data->getErrorBag()->addViolation($violation);
                }
            }
        }  else {
            if ($this->logger instanceof LoggerInterface && !($event->getThrowable() instanceof SymfonyHttpException)) {
                $this->logger->error($event->getThrowable()->getMessage(), [
                    'error' => $event->getThrowable(),
                ]);
            }

            $data->getErrorBag()->addFrontError(500, null, 'Something went wrong, but we already fixing it.');
            $response->setStatusCode(500);
        }

        $response->setContent($this->serializer->serialize($data, 'json'));
        $response->headers->set('Content-Type', 'application/json; charset=UTF-8');

        $event->setResponse($response);
    }
}
