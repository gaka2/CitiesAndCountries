<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\CityService;
use Symfony\Component\HttpFoundation\Exception\JsonException;
use App\Api\Exception\InvalidRequestException;
use App\Api\ResponseFactory;

/**
 * @author Karol Gancarczyk
 * @Route("/api/cities", name="api.cities.")
 */
class CityController extends RestApiController
{
    private CityService $cityService;
    private ResponseFactory $responseFactory;

    public function __construct(CityService $cityService, ResponseFactory $responseFactory)
    {
        $this->cityService = $cityService;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @Route("/", name="add", methods={"POST"})
     */
    public function addCity(Request $request): Response
    {
        try {
            $cityData = $request->toArray();
            $city = $this->cityService->create($cityData);
            return $this->responseFactory->responseForCreate($city);
        } catch (JsonException $e) {
            throw new InvalidRequestException('Request data is not valid JSON', 0, $e);
        }
    }
}
