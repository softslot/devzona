<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http;

use App\Shared\Application\Service\UuidGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseController extends AbstractController
{
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            'validator' => '?' . ValidatorInterface::class,
        ]);
    }

    protected function createCommandFromRequest(Request $request, string $dtoClass, ?string $id = null): object
    {
        $dto = $this->createDto($request, $dtoClass, $id);

        $this->getValidator()->validate($dto);

        return $dto;
    }

    private function createDto(Request $request, string $dtoClass, ?string $id = null): object
    {
        $serializer = $this->container->get('serializer');
        $content = json_decode($request->getContent());
        if (!($content instanceof \stdClass)) {
            throw new \Exception('Неверные данные');
        }
        if (!isset($content->id)) {
            $content->id = UuidGenerator::generate();
        }

        return $serializer->denormalize($content, $dtoClass);
    }

    protected function getValidator(): ValidatorInterface
    {
        return $this->container->get('validator');
    }

    protected function jsonSuccess(array $body = []): JsonResponse
    {
        return $this->buildJsonResponse(success: true, body: $body);
    }

    protected function jsonError(array $error = [], array $violations = []): JsonResponse
    {
        return $this->buildJsonResponse(success: false, error: $error, violations: $violations);
    }

    private function buildJsonResponse(
        bool $success,
        array $error = [],
        array $violations = [],
        array $body = [],
    ): JsonResponse {
        return $this->json([
            'success' => $success,
            'error' => $error,
            'violations' => $violations,
            'body' => $body,
        ]);
    }
}
