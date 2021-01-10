<?php

declare(strict_types=1);

namespace App\Api;

use Symfony\Component\HttpFoundation\Response;

/**
 * @author Karol Gancarczyk
 */
class BadRequestResponse extends AbstractResponse
{
    public function __construct(string $message, string $errors = '')
    {
        parent::__construct('Error', $message, $errors, Response::HTTP_BAD_REQUEST);
    }
}
