<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Service\Exception\InvalidArgumentException;
use App\Service\Exception\InternalErrorException;
use Doctrine\DBAL\Exception as DoctrineException;

/**
 * @author Karol Gancarczyk
 */
class CountryService
{
    private CountryRepository $countryRepository;
    private ValidatorInterface $validator;

    public function __construct(CountryRepository $countryRepository, ValidatorInterface $validator)
    {
        $this->countryRepository = $countryRepository;
        $this->validator = $validator;
    }

    public function createFromName(string $name): Country
    {
        try {
            $country = new Country();
            $country->setName($name);
            
            $errors = $this->validator->validate($country);
            if (count($errors) > 0) {
                throw new InvalidArgumentException((string) $errors);
            }

            $this->countryRepository->save($country);
            return $country;
        } catch (DoctrineException $e) {
            throw new InternalErrorException('Doctrine exception ocurred', 0, $e);
        }
    }
}
