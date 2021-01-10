<?php

declare(strict_types=1);

namespace App\Api;

use JMS\Serializer\SerializerInterface;

/**
 * @author Karol Gancarczyk
 */
class ResponseFactory
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function responseForCreate($dataToSerialize) : CreatedResponse
    {
        $jsonString = $this->serializer->serialize($dataToSerialize, 'json');
        return new CreatedResponse($jsonString);
    }

    public function invalidRequestResponse(string $message, array $errors = []) : BadRequestResponse
    {
        $jsonErrors = $this->serializer->serialize($errors, 'json');
        return new BadRequestResponse($message, $jsonErrors);
    }

    public function serviceUnavailableResponse() : ServiceUnavailableResponse
    {
        return new ServiceUnavailableResponse();
    }
}
