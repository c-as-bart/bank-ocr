<?php

declare(strict_types=1);

namespace App\Application\AccountNumberValidator;

use App\Application\AccountNumberValidator\Dto\AccountNumberValidatorResultDto;

interface AccountNumberValidatorInterface
{
    /**
     * @param array $digits
     *
     * @return AccountNumberValidatorResultDto
     */
    public function validate(array $digits): AccountNumberValidatorResultDto;
}
