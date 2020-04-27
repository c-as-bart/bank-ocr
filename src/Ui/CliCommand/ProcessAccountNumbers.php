<?php

declare(strict_types=1);

namespace App\Ui\CliCommand;

use App\Application\AccountNumberReader\AccountNumberReaderInterface;
use App\Application\AccountNumberReader\Dto\AccountNumberReaderDto;
use App\Application\AccountNumberValidator\AccountNumberValidatorInterface;
use App\Application\AccountNumberValidator\Dto\AccountNumberValidatorResultDto;
use App\Application\AccountNumberWriter\AccountNumberWriterInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessAccountNumbers extends Command
{
    /**
     * @var AccountNumberReaderInterface
     */
    private AccountNumberReaderInterface $accountNumberReader;

    /**
     * @var AccountNumberValidatorInterface
     */
    private AccountNumberValidatorInterface $accountNumberValidator;

    /**
     * @var AccountNumberWriterInterface
     */
    private AccountNumberWriterInterface $accountNumberWriter;

    /**
     * ProcessAccountNumbers constructor.
     *
     * @param AccountNumberReaderInterface    $accountNumberReader
     * @param AccountNumberValidatorInterface $accountNumberValidator
     * @param AccountNumberWriterInterface    $accountNumberWriter
     */
    public function __construct(
        AccountNumberReaderInterface $accountNumberReader,
        AccountNumberValidatorInterface $accountNumberValidator,
        AccountNumberWriterInterface $accountNumberWriter
    ) {
        parent::__construct();
        $this->accountNumberReader = $accountNumberReader;
        $this->accountNumberValidator = $accountNumberValidator;
        $this->accountNumberWriter = $accountNumberWriter;
    }

    public function configure()
    {
        $this->setName('bank-ocr:account-numbers:process');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $validateResult = [];
            $accountNumbers = $this->accountNumberReader->read();

            /** @var AccountNumberReaderDto $item */
            foreach ($accountNumbers as $item) {
                $validateResult[] = $this->accountNumberValidator->validate($item->getDigits());
            }

            /** @var AccountNumberValidatorResultDto $item */
            foreach ($validateResult as $item) {
                $this->accountNumberWriter->save(
                    $item->getValidationStatus(),
                    $item->getAccountNumber()
                );
            }

            $output->writeln('Process ended');

            return 0;
        } catch (Exception $exception) {
            $output->writeln('Process completed with error');

            return 1;
        }
    }
}
