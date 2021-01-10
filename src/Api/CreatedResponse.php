<?php

declare(strict_types=1);

namespace App\Api;

use Symfony\Component\HttpFoundation\Response;

/**
 * @author Karol Gancarczyk
 */
class CreatedResponse extends AbstractResponse
{
    public function __construct(string $jsonData)
    {
        parent::__construct('OK', 'Resource succesfully created', $jsonData, Response::HTTP_CREATED);
    }
}
