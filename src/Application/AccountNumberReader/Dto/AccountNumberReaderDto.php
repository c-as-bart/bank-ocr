<?php

declare(strict_types=1);

namespace App\Application\AccountNumberReader\Dto;

final class AccountNumberReaderDto
{
    /**
     * @var array
     */
    private array $digits;

    /**
     * AccountNumberReaderDto constructor.
     *
     * @param array $digits
     */
    public function __construct(array $digits)
    {
        $this->digits = $digits;
    }

    /**
     * @return array
     */
    public function getDigits(): array
    {
        return $this->digits;
    }
}
