<?php

declare(strict_types=1);

namespace App\Application\AccountNumberValidator\Dto;

final class AccountNumberValidatorResultDto
{
    /**
     * @var int
     */
    private int $validationStatus;

    /**
     * @var string
     */
    private string $accountNumber;

    /**
     * AccountNumberValidatorResultDto constructor.
     *
     * @param int $validationStatus
     * @param string $accountNumber
     */
    public function __construct(
        int $validationStatus,
        string $accountNumber
    ) {
        $this->validationStatus = $validationStatus;
        $this->accountNumber = $accountNumber;
    }

    /**
     * @return string
     */
    public function getValidationStatus(): int
    {
        return $this->validationStatus;
    }

    /**
     * @return string
     */
    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }
}
