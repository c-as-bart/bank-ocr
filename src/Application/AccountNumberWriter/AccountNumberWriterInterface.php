<?php

declare(strict_types=1);

namespace App\Application\AccountNumberWriter;

interface AccountNumberWriterInterface
{
    /**
     * @param int    $status
     * @param string $accountNumber
     */
    public function save(int $status, string $accountNumber): void;
}
