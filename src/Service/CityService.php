<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\City;
use App\Repository\CityRepository;
use Symfony\Component\Form\FormFactoryInterface;
use App\Form\CityFormType;
use App\Service\Exception\FormValidationException;
use App\Service\Exception\InternalErrorException;
use Doctrine\DBAL\Exception as DoctrineException;

/**
 * @author Karol Gancarczyk
 */
class CityService
{
    private FormFactoryInterface $formFactory;
    private CityRepository $cityRepository;

    public function __construct(FormFactoryInterface $formFactory, CityRepository $cityRepository)
    {
        $this->formFactory = $formFactory;
        $this->cityRepository = $cityRepository;
    }

    public function create(array $cityData): City
    {
        try {
            $form = $this->formFactory->create(CityFormType::class, new City());
            $form->submit($cityData);
            
            if (!$form->isValid()) {
                throw new FormValidationException($form);
            }

            $city = $form->getData();
            $this->cityRepository->save($city);
            return $city;
        } catch (DoctrineException $e) {
            throw new InternalErrorException('Doctrine exception ocurred', 0, $e);
        }
    }
}
