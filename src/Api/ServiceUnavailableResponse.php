<?php

declare(strict_types=1);

namespace App\Api;

use Symfony\Component\HttpFoundation\Response;

/**
 * @author Karol Gancarczyk
 */
class ServiceUnavailableResponse extends AbstractResponse
{
    public function __construct()
    {
        parent::__construct('Error', 'Service unavailable', '', Response::HTTP_SERVICE_UNAVAILABLE);
    }
}
