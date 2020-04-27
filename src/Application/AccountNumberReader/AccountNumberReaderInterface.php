<?php

declare(strict_types=1);

namespace App\Application\AccountNumberReader;

use App\Application\AccountNumberReader\Dto\AccountNumberReaderDto;

interface AccountNumberReaderInterface
{
    /**
     * @return AccountNumberReaderDto[]
     */
    public function read(): array;
}
