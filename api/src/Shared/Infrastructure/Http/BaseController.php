<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Http;

use App\Shared\Application\Service\UuidGenerator;
use App\Shared\Infrastructure\Http\Exception\IncorrectTypesException;
use App\Shared\Infrastructure\Http\Exception\MissingArgumentsException;
use App\Shared\Infrastructure\Http\Exception\ValidationPropertiesException;
use App\Shared\Infrastructure\Http\Response\Violation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseController extends AbstractController
{
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            'validator' => '?' . ValidatorInterface::class,
        ]);
    }

    /**
     * @throws MissingArgumentsException
     * @throws IncorrectTypesException
     * @throws ValidationPropertiesException
     */
    protected function createCommandFromRequest(Request $request, string $dtoClass, ?string $id = null): object
    {
        $dto = $this->createDto($request, $dtoClass, $id);

        $violations = $this->getValidator()->validate($dto);
        if ($violations->count() > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[] = new Violation($violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ValidationPropertiesException(400, $errors);
        }

        return $dto;
    }

    /**
     * @throws MissingArgumentsException
     * @throws IncorrectTypesException
     */
    private function createDto(Request $request, string $dtoClass, ?string $id = null): object
    {
        $serializer = $this->container->get('serializer');
        $content = json_decode($request->getContent());
        if ($content === null) {
            $content = (object)[];
        }
        if (!isset($content->id)) {
            $content->id = $id ?? UuidGenerator::generate();
        }

        try {
            return $serializer->denormalize($content, $dtoClass);
        } catch (MissingConstructorArgumentsException $e) {
            throw new MissingArgumentsException(400, $e->getMissingConstructorArguments());
        } catch (NotNormalizableValueException $e) {
            throw new IncorrectTypesException(400, $e->getPath(), $e->getCurrentType(), $e->getExpectedTypes());
        }
    }

    protected function getValidator(): ValidatorInterface
    {
        return $this->container->get('validator');
    }
}
