<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\CountryService;
use App\Service\Exception\InvalidArgumentException;
use App\Service\Exception\InternalErrorException;

/**
 * @author Karol Gancarczyk
 */
class AddCountryCommand extends Command
{
    private const SUCCESS_MESSAGE = 'Country successfully added';
    private const ERROR_MESSAGE = 'Unexpected error occurred while running the application';

    private CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        parent::__construct();
        $this->countryService = $countryService;
    }

    protected static $defaultName = 'app:add-country';

    protected function configure(): void
    {
        $this
            ->setDescription('Adding country')
            ->addArgument('name', InputArgument::REQUIRED, 'Country name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $countryName = $input->getArgument('name');

        try {
            $this->countryService->createFromName($countryName);
            $io->success(self::SUCCESS_MESSAGE);
            return Command::SUCCESS;
        } catch (InvalidArgumentException $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        } catch (InternalErrorException $e) {
            $io->error(self::ERROR_MESSAGE);
            return Command::FAILURE;
        }
    }
}
