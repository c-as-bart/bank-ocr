<?php

declare(strict_types=1);

namespace App\Application\AccountNumberValidator;

use App\Application\AccountNumberValidator\Dto\AccountNumberValidatorResultDto;

final class AccountNumberValidator implements AccountNumberValidatorInterface
{
    public const STATUS_IS_VALID = 1;
    public const STATUS_NOT_VALID = 2;
    public const STATUS_READING_ERROR = 3;

    /**
     * @inheritDoc
     */
    public function validate(array $digits): AccountNumberValidatorResultDto
    {
        return new AccountNumberValidatorResultDto(
            $this->getStatus($digits),
            $this->format($digits)
        );
    }

    /**
     * @param array $digits
     *
     * @return bool
     */
    private function isCorrectRead(array $digits): bool
    {
        foreach ($digits as $digit) {
            if ($digit === null) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $digits
     *
     * @return string
     */
    private function format(array $digits): string
    {
        $result = '';

        foreach ($digits as $digit) {
            $result .= $digit === null ? '?' : $digit;
        }

        return $result;
    }

    /**
     * @param array $digits
     *
     * @return bool
     */
    private function validateChecksum(array $digits): bool
    {
        $result = ($digits[8] + 2 * $digits[7] + 3 * $digits[6] + 4 * $digits[5] + 5 * $digits[4] + 6 * $digits[3] + 7 * $digits[2] + 8 * $digits[1] +9 * $digits[0]);

        return ($result % 11) === 0;
    }

    private function getStatus(array $digits): int
    {
        if (!$this->isCorrectRead($digits)) {
            return self::STATUS_READING_ERROR;
        }

        if (!$this->validateChecksum($digits)) {
            return self::STATUS_NOT_VALID;
        }

        return self::STATUS_IS_VALID;
    }
}
